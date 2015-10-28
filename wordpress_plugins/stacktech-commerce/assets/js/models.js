(function ($) {

	window.sc = window.sc || {};

	// 这里覆盖Backbone sync方法，使用WordPress内置的
	Backbone.sync = function(method, model, options) {
		var params = _.extend({
            type:         'POST',
            dataType:     'json',
            url: ajaxurl,
            contentType: 'application/x-www-form-urlencoded;charset=UTF-8'
        }, options);

        if (method == 'read') {
            params.type = 'GET';
			if( typeof model.id != 'undefined'){
				params.data = _.extend({id:model.id}, params.data);
			}
		}

        if (model && (method == 'create' || method == 'update' || method == 'patch')) {
            params.data = _.extend(model.toJSON(options), params.data);
        }

        return $.ajax(params);
	};

	// 商品模型
	sc.ProductModel = Backbone.Model.extend({
		defaults: {
			post_title: '',
			price: 0,
			allow_trail: 0,
			trail_days: 0,
			product_type: '',
			feature_image: '',
			post_excerpt: '',
			// 这个产品是否正在试用
			is_trailing: 0,
			// 这个产品是否已经被试用
			is_trailed: 0,
			// 这个产品是否已经购买
			is_purchased: 0,
			// 客户端生成
			is_in_cart: 0,
			// 是否永久出售
			// 是否试用特价
			allow_purchase_forever: 0,
			allow_discount_price: 0,
			sale_discount_price: 0,
			discount_start_date: '',
			discount_end_date: '',
			use_discount_price: 0,
			// 每月的特价
			month_discount: {},
			is_package: 0,
			package_products: [],
			dependence_ids: [],
			post_content: '',
			gallery:[],
		},

		requirePriceCondition: function() {
			var pc = this.get('price_condition');
			if( _.isObject( pc ) && !_.isEmpty(pc) ){
				return true;
			}

			return false;
		},



		// 获取当前的价格
		getCurrentPrice: function(period, price_condition_key){
			price_condition_key = price_condition_key || '';
			var price_change = 0;
			var pc = this.get('price_condition');
			if( price_condition_key != '' && _.isObject( pc ) && !_.isEmpty(pc) && !_.isUndefined(pc[price_condition_key]) ){
				price_change = parseFloat(pc[price_condition_key]);
			}
			period = period || 0;
			// 如果使用特价
			if(parseInt(this.get('use_discount_price')) > 0){
				return parseFloat(this.get('sale_discount_price')) + price_change;
			}
			// 检查购买越多越优惠
			if(period > 0){
				var m = this.get('month_discount');
				if(_.isObject(m) && !_.isEmpty(m)){
					var arr = [];
					for(var i in m){
						arr[i] = m[i];
					}
					var len = arr.length;
					for(var j = len -1; j >= 0; j--){
						if(_.isUndefined(arr[j])){continue;}
						if(period < j){continue;}
						return parseFloat(arr[j]) + price_change;
					}
				}
			}

			return parseFloat(this.get('price')) + price_change;
		},

		getWorkingPeriod: function(period){
			period = period || 0;
			// 如果使用特价
			if(this.get('use_discount_price')){
				return false;
			}
			if(period > 0){
				var m = this.get('month_discount');
				if(_.isObject(m) && !_.isEmpty(m)){
					var arr = [];
					for(var i in m){
						arr[i] = m[i];
					}
					var len = arr.length;
					for(var j = len -1; j >= 0; j--){
						if(_.isUndefined(arr[j])){continue;}
						if(period < j){continue;}
						return j;
					}
				}
			}
			return false;
		},

		// 计算价格
		calculateTotalPrice: function(period, price_condition_key ){
			period = period || 0;
			if(this.get('allow_purchase_forever') == 1){
				return this.getCurrentPrice(0, price_condition_key);
			}
		   return period * this.getCurrentPrice(period, price_condition_key);
		},
	});

	sc.OrderProductModel = sc.ProductModel.extend({
		defaults: {
			order_id: 0,
			product_id: 0,
			post_title: '',
			period: 0,
			price: '',
			total: '',
			allow_purchase_forever: 0,
			month_discount: '',
			product_type: '',
			sale_discount_price: 0,
			use_discount_price: 0,
		},
		resetTotal: function(){
			this.set('total', this.calculateTotalPrice(parseInt(this.get('period')), this.get('price_condition_key')      ));
		},
	});

	sc.OrderProductCollection = Backbone.Collection.extend({
		model: sc.OrderProductModel,
	});



	sc.OrderModel = Backbone.Model.extend({
		defaults: function(){
			var list = new sc.OrderProductCollection;
			return {
				//order_id: 0,
				site_id: 0,
				blog_id: 0,
				user_id: 0,
				order_type: '',
				order_no: '',
				order_status: 0,
				create_time: '',
				pay_time: '',
				total_price: 0,
				// 订单商品列表
				products: list,
			};
		},
		addProduct: function(orderProduct) {
			var products = this.get('products');
			products.add(orderProduct);
		},
		sync: function(method, model, options) {
			// 这里只是格式化数据并传到服务器，并不想触发任何客户端事件
			model.set({'products': model.get('products').toJSON()}, {silent: true});
			Backbone.sync.apply(this, arguments);
		},
		resetTotalPrice: function() {
			var total = 0;
			this.get('products').each(function(model){
				total += model.get('total');
			});
			this.set('total_price', parseInt(total));
		},
		parse: function(data){
			//this.set('products', new sc.OrderProductCollection(data.products));
			//delete data.products;
			return data;
		},
	});

	// 购物车模型是来自服务器的Session的，简化版订单
	sc.CartModel = Backbone.Model.extend({
		defaults: function(){
			var pl = new sc.OrderProductCollection;
			return {
				// 购物车商品列表
				products: pl,
				total: 0
			};
		},
		parse: function(data){
			this.get('products').reset(data.products);
			delete data.products;
			return data;
		},
		addProduct: function(orderProduct) {
			var products = this.get('products');
			products.add(orderProduct);
		},
		sync: function(method, model, options) {
			var data = model.toJSON();
			var products = data.products.toJSON();
			delete data.products;
			data.products = products;
			options.data = _.extend(data, options.data);
			return Backbone.sync.apply(this, arguments);
		},
		// 这里重写下购物车的删除，我们不需要执行它的默认的destroy方法
		empty: function(){
			// this.get('products').reset([],{slient:true});
			var that = this;
			while(this.get('products').length > 0){
				var model = this.get('products').pop();
				model.destroy({slient: true});
			}
		},
		fetch_remote: function(){

			return this.fetch({
				data: {
					action: 'get_cart_products'
				}
			});
		}
		
	});
	
	sc.ProductCollection = Backbone.Collection.extend({
		model: sc.ProductModel,
	});

	// 搜索模型，所有的商品列表搜索必须经过这里
	sc.SearchModel = Backbone.Model.extend({
		defaults: function() {
			var pl = new sc.ProductCollection();
			return {
				'product_list': pl,
				'product_type': 'plugin',
				'category': [],
				'allow_purchase_forever': 3,
				'keyword': '',
				'hide_trailing_products': 0,
				'hide_using_products': 0,
			};
		},
		parse: function(data) {
			this.get('product_list').reset(data.products);
			delete data.products;
			return data;
		},
		allow_add_to_cart: function(product_id) {
			this.get('product_list').get(product_id).set('is_in_cart', 0);
		},
		// 在抓取商品列表时，必须要将参数全部传过去
		sync: function(method, model, options) {
			/*
			model.get('product_list').each(function(model){
				model.destroy();
			});
		   */
			var data = model.toJSON();
			delete data.product_list;
			if(_.isArray(data.category) && !_.isEmpty(data.category)){
				data.category = data.category.join(',');
			}
			options.data = _.extend(data, options.data);
			Backbone.sync.apply(this, arguments);
		},
	});

})(window.jQuery);
