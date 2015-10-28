(function ($) {
	window.sc = window.sc || {};

	sc.ModalView = Backbone.View.extend({
		el: '#store_modal',

		events: {
			'click .remodal-close': 'closeModal'
		},

		initialize: function(options){
		},

		// 加载某个视图
		openModal: function(view, options){
			var defaults = {
				closeOnOutsideClick: false,
				hashTracking: false,
			};
			var options = _.extend(defaults, options);

			this.currentView = view;
			this.$('#store_modal_content').html(view.$el);

			this.inst = this.$el.remodal(options);
			this.inst.open();

			this.setHeight();
		},
		closeModal: function(){
			if (typeof this.oldView != 'undefined') {
				this.currentView.undelegateEvents();
				this.currentView.remove();
				this.currentView = this.oldView;
				delete this.oldView;
				this.currentView.$el.css('display', 'block');
				return;
			}
			this.inst.close();
			this.currentView.undelegateEvents();
			this.currentView.remove();

			// 检查是否有绑定回调函数
			if (typeof this.closeAction == 'function'){
				this.closeAction();
				// after this action is called, I need to remove it.
				// Or next popup window will excute this function too.
				this.closeAction = '';
			}
		},
		reopenModal: function(view) {
			this.oldView = this.currentView;
			this.currentView = view;
			this.oldView.$el.css('display', 'none');
			this.$('#store_modal_content').append(view.$el);
		},
		setHeight: function(){
			this.$('#store_modal_content').css({'max-height':($(window).height() - 150) +'px', 'overflow':'auto'});
		},
		emptyModal: function(){
			
			if( !_.isUndefined(this.inst) ){
				this.inst.close();
			}
			if( !_.isUndefined(this.currentView) ){
				this.currentView.undelegateEvents();
				this.currentView.remove();
			}

		},

		installCloseAction: function(a) {
			this.closeAction = '';
			this.closeAction = a;
		}
	});

	// 商城的单页面
	sc.MainView = Backbone.View.extend({
		el: '#stacktech-store',
		initialize: function(options){

			// 加载全局的modal视图
			sc.globalModalView = new sc.ModalView();

			_.bindAll(this, 'switchView');
			// 绑定事件
			// 切换视图
			sc.Events.on('switchView', this.switchView);
			// 创建试用订单
			sc.Events.on('addTrailOrder', this.addTrailOrder);
			// 创建购买订单
			sc.Events.on('addOrder', this.addOrder);
			// 添加到购物车
			sc.Events.on('addToCart', this.addToCart);
			// 免费使用产品
			sc.Events.on('addFreeProduct', this.addFreeProduct);
		},
		checkoutPage: function() {
			this.switchView(new sc.CheckoutView({model: window.sc.globalCart}));
		},
		storePage: function() {
			var searchModel = new sc.SearchModel();
			searchModel.set('product_type', window.stacktech_product_type);
			this.switchView(new sc.ProductListView({model:searchModel}));
		},
		switchView: function(view){
			sc.globalModalView.emptyModal();
			if( typeof this.currentView != 'undefined' ) {
				this.currentView.undelegateEvents();
				this.currentView.remove();
			}
			this.currentView = view;
			this.render();
			sc.Events.trigger('closeCartPopup');
		},
		themePage: function(){
			var searchModel = new sc.SearchModel();
			searchModel.set('product_type', 'theme');
			this.switchView(new sc.ProductListView({model:searchModel}));
		},
		render: function(){
			this.$el.html(this.currentView.$el);
		},
		productPage: function(id, install) {
			install = install || '';
			var productModel = new sc.ProductModel();
			sc.startLoading({text: '正在加载产品...'});
			productModel.set('id', id);
			productModel.fetch({
				data: {
					action: 'get_product_detail',
				},
				success: function(model, response, options){
					sc.endLoading();
					var detailView = new sc.ProductDetailView({model: productModel});
					sc.globalModalView.openModal(detailView);
					detailView.initJcarousel();


					if ( install === 'install_close_action'　){
						sc.globalModalView.installCloseAction(function(){
							window.sc.globalRouter.navigate('', {trigger: true});
						});
					} else{
						sc.globalModalView.installCloseAction(function(){
							window.sc.globalRouter.navigate('', {trigger: false});
						});
					}

				},
			});

		},
		addFreeProduct: function(product){
			sc.startLoading({text: '正在开启使用...'});
			var order = new sc.OrderModel();
			var orderProduct = new sc.OrderProductModel({
				product_id: product.get('id')
			});
			order.addProduct(orderProduct);
			order.save({
				order_type: 'free',
			},{
				data:{
					action: 'add_order',
				},
				success: function(model, response, options){
					// 如果没有错误
					product.set('is_purchased', 1);
					product.set('product_service_status', 1);
					sc.endLoading();
					sc.addMessage('成功开启使用');
					sc_open_window(sc_page_url('admin.php?page=stacktech-store-manage'));
				}
			});

		},
		// 购买下单
		addOrder: function(cartModel) {
			var order = new sc.OrderModel();
			sc.startLoading({text: '正在生成订单...'});
			cartModel.get('products').each(function(model){
				order.addProduct(model);
			});
			order.resetTotalPrice();
			order.save({
				order_type: 'sale',
			},{
				data:{
					action: 'add_order',
				},
				success: function(model, response, options){
					// 如果没有错误
					sc.addMessage('订单保存成功');
					sc_open_window($('#stacktech_pay_url').val() + '&order_id=' + model.get('id') + '&gateway=alipay');
					sc.endLoading();
					sc.startLoading({text: '正在支付...'});
				}
			});
		},
		
		// 如果是试用订单则直接下单
		addTrailOrder: function(product){
			sc.startLoading({text: '正在开启试用...'});
			var order = new sc.OrderModel();
			var orderProduct = new sc.OrderProductModel({
				product_id: product.get('id')
			});
			order.addProduct(orderProduct);
			order.save({
				order_type: 'trail',
			},{
				data:{
					action: 'add_order',
				},
				success: function(model, response, options){
					// 如果没有错误
					product.set('is_trailing', 1);
					product.set('product_service_status', 1);
					sc.endLoading();
					sc.addMessage('成功开启试用');
					sc_open_window(sc_page_url('admin.php?page=stacktech-store-manage'));
				}
			});
		},

		// 直接加进购物车
		addToCart: function(product, params) {
			// 创建订单商品
			var orderProduct = new sc.OrderProductModel();
			orderProduct.set('product_id', product.get('id'));
			orderProduct.set('price_condition', product.get('price_condition'));
			orderProduct.set('month_discount', product.get('month_discount'));
			orderProduct.set('price', product.get('price'));
			orderProduct.set('product_type', product.get('product_type'));
			orderProduct.set('use_discount_price', product.get('use_discount_price'));
			orderProduct.set('sale_discount_price', product.get('sale_discount_price'));
			orderProduct.set('allow_purchase_forever', product.get('allow_purchase_forever'));
			if(product.get('allow_purchase_forever') == 0){
				orderProduct.set('period', params.period);
			}else{
				orderProduct.set('period', 0);
			}
			orderProduct.set('price_condition_key', params.price_condition_key);
			console.log(orderProduct);
			orderProduct.resetTotal();
			orderProduct.set('post_title', product.get('post_title'));
			window.sc.globalCart.addProduct(orderProduct);
			window.sc.globalCart.save({
			},{
				data:{
					action: 'add_to_cart',
				},
				success: function(model, response, options){
					sc.addMessage('产品已经加入购物车');
				}
			});
		},
	});

	sc.CheckoutView = Backbone.View.extend({
		initialize: function(options){
			console.log(this.model);
			this.listenTo(this.model, 'change', this.render);
			this.render();
		},
		events: {
			'click #goto_pay': 'gotoPay',
		},

		render: function(){
			var data = this.model.toJSON();
			if (!_.isUndefined(data.products) && data.products.length > 0){
				data.products = data.products.toJSON();
			}
			this.$el.html((_.template($('#checkout-page').html()))(data));
		},

		gotoPay: function() {
			// 这里我们会先生成一个订单
			sc.Events.trigger('addOrder', this.model);
		},
	});

	sc.CartView = Backbone.View.extend({
		el: '.stacktech-cart-menu',
		initialize: function(options){
			_.bindAll(this, 'removeCartProduct', 'closeCartPopup');
			// 如果购物车有任何改动
			this.listenTo(this.model, 'sync', this.render);

			// 所有从购物车移除商品，必须要触发这个事件
			sc.Events.on('removeCartProduct', this.removeCartProduct);
			sc.Events.on('closeCartPopup', this.closeCartPopup);

			this.render();
		},
		events: {
			'click #empty_cart_btn': 'emptyCart',
			'click #cart_close_btn': 'closeCartPopup',
			'click .ab-item': 'showOrHidePopup'
		},
		render: function() {
			// 如果购物车里面是空的
			if ( this.model.get('products').length > 0 ) {
				var target = this.$el.find('.ab-sub-wrapper');
				target.html(_.template($('#cart-template').html())({total: this.model.get('total')}));
				this.$('#stacktech-total-num').html(this.model.get('products').length);
				this.model.get('products').each(this.addOrderProductView, this);
			} else {
				this.$('#stacktech-total-num').html(0);
				this.addEmptyCart();
			}
		},

		showOrHidePopup: function(){
			var ele = this.$('.ab-sub-wrapper');
			if(ele.css('display') == 'block'){
				ele.css('display', 'none');
			}else {
				ele.css('display', 'block');
			}
			return false;
		},

		// Hide popup of cart
		closeCartPopup: function() {
			this.$('.ab-sub-wrapper').hide();
		},

		addEmptyCart: function() {
			this.$el.find('.ab-sub-wrapper').html($('#emtpy-cart-template').html());
		},

		addOrderProductView: function(product) {
			var target = this.$el.find('#cart-body');
			target.append((new sc.CartProductView({model: product})).$el);
		},

		removeCartProduct: function(model) {
			model.destroy();
			// 做出请求
			this.model.save({
			},{
				data:{
					action: 'add_to_cart',
				},
				success: function(model, response, options){
				}
			});
		},

		emptyCart: function(e) {
			sc.Events.trigger('emptyCart');
			e.preventDefault();
			var that = this;
			that.model.empty();
			that.model.save({
			},{
				data:{
					action: 'add_to_cart',
				},
				success: function(model, response, options){
					sc.addMessage('成功清空购物车');
				}
			});
			return false;

		},

	});

	sc.CartProductView = Backbone.View.extend({
		tagName: 'tr',
		className: '.cart-product',
		events: {
			'click .cart-delete-btn': 'deleteCartProduct',
			'change .period': 'setPeriod',
			'change .price_condition_seletor': 'changePriceCondition'
		},
		initialize: function(options){
			//this.listenTo(this.model, 'change', this.render);
			this.listenTo(this.model, 'destroy', this.rm);
			this.render();
		},
		render: function() {
			var data = this.model.toJSON();
			data.currentPrice = this.model.getCurrentPrice(this.model.get('period'), this.model.get('price_condition_key'));
			this.$el.html((_.template($('#cart-product-template').html()))(data));
		},
		rm: function(){
			this.undelegateEvents();
			this.remove();
		},
		deleteCartProduct: function(e){
			e.preventDefault();
			// 这里传个model参数是为了让下面的商品列表可以再此添加进购物车
			sc.Events.trigger('removeCartProduct', this.model);
		},
		setPeriod: function(e){
			var num = $(e.currentTarget).val();
			this.model.set('period', num);
			this.model.resetTotal();
			window.sc.globalCart.save({
			},{
				data:{
					action: 'add_to_cart',
				},
				success: function(model, response, options){
				}
			});
		},
		changePriceCondition: function(e) {
			this.model.set('price_condition_key', $(e.currentTarget).val());
			this.model.resetTotal();
			window.sc.globalCart.save({
			},{
				data:{
					action: 'add_to_cart',
				},
				success: function(model, response, options){
				}
			});
		}
	});

	sc.ProductListView = Backbone.View.extend({
		tagName: 'ul',
		initialize: function(options){
			_.bindAll(this, 'getProductList');
			// 重新抓取
			sc.Events.on('getProductList', this.getProductList);

			this.render();
			//sc.Events.trigger('getProductList');
			this.getProductList();
		},
		events: {
		  'click .product_term': 'searchByTerm',
		  'click .standard_term': 'searchByPurchase',
		  'click .trail_term': 'searchByTrail',
		  'click .filter_term': 'searchByFilter',
		  'keydown #stacktech-store-search': 'searchByKeyword'
		},
		render: function(){
			this.$el.html(_.template($('#product-list-template').html()));
		},

		getProductList: function() {
			sc.startLoading();
			var that = this;
			this.model.fetch({
				data: {
					action: 'search_products',
					taxonomy: window.stacktech_taxonomy,
				},
				success: function(model, response, options){
					that.renderProductList(model.get('product_list'));
					sc.endLoading();
				},
			});
		},

		renderProductList: function(product_list){
			var product_list_div = this.$('#product-list-container');
			product_list_div.empty();
			if(product_list.length > 0){
				product_list.each(function(product){
					var p = new sc.ProductView({model: product});
					product_list_div.append(p.$el);
				});
			}else{
					product_list_div.append('暂无商品');
			}
		},
		// 按分类搜索
		searchByTerm: function(e){
			this.$('.product_term').removeClass('selected');
			$(e.currentTarget).addClass('selected');
			var termId = $(e.currentTarget).attr('term-id');

			var temp = [];
			temp.push(termId);
			//var category = this.model.get('category');
			//category.push(termId);
			this.model.set('category', temp);
			//sc.Events.trigger('getProductList');
			this.getProductList();
		},
		searchByPurchase: function(e){
			this.$('.standard_term').removeClass('selected');
			$(e.currentTarget).addClass('selected');
			var allow_purchase_forever =$(e.currentTarget).attr('allow_purchase_forever');
			//var temp1 = [];
			//temp1.push(allow_purchase_forever);
			this.model.set('allow_purchase_forever', allow_purchase_forever);
			this.getProductList();
		},
		searchByTrail: function(e){
			this.$('.trail_term').removeClass('selected');
			$(e.currentTarget).addClass('selected');
			var allow_trail =$(e.currentTarget).attr('allow_trail');
			//var temp1 = [];
			//temp1.push(allow_purchase_forever);
			this.model.set('allow_trail', allow_trail);
			this.getProductList();
		},
		searchByFilter: function(e) {
			var val =$(e.currentTarget).attr('hide_product_type');
			if( val == '0' ){
				this.$('.filter_term').removeClass('selected');
				this.model.set('hide_trailing_products', 0);
				this.model.set('hide_using_products', 0);
			} else if(val == '1') {
				this.$('.filter_terms').find('a:first').removeClass('selected');
				if( $(e.currentTarget).hasClass('selected') ) {
					this.model.set('hide_trailing_products', 0);
				} else {
					this.model.set('hide_trailing_products', 1);
				}
			} else {
				this.$('.filter_terms').find('a:first').removeClass('selected');
				if( $(e.currentTarget).hasClass('selected') ) {
					this.model.set('hide_using_products', 0);
				} else {
					this.model.set('hide_using_products', 1);
				}
			}
			$(e.currentTarget).toggleClass('selected');
			this.getProductList();
		},
		searchByKeyword: function(event){
			var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
			if(keyCode != 13){return;}
			// 检查关键词是否为空
			var keyword = $.trim(this.$('#stacktech-store-search').val());
			/*
			if(keyword == ''){
				alert('请输入关键字');
				return;
			}
		   */
			this.model.set('keyword', keyword);
			this.getProductList();
		}
	});

	sc.ProductView = Backbone.View.extend({
		tagName: 'li',
		className: 'theme',
		initialize: function(options){
			_.bindAll(this, 'removeCartProduct', 'emptyCart');
			this.listenTo(this.model, 'change', this.render);
			this.listenTo(this.model, 'remove', this.rm);
			this.render();
			// 从购物车中删除商品，这个时候应该让商品能重新加进购物车
			sc.Events.on('removeCartProduct', this.removeCartProduct);
			sc.Events.on('emptyCart', this.emptyCart);
		},
		removeCartProduct: function(product){
			if(product.get('product_id') == this.model.id){
				this.model.set('is_in_cart', 0);
			}
		},
		emptyCart: function(){
			this.model.set('is_in_cart', 0);
		},
		events: {
			'click .trail_btn': 'trail',
			'click .add_to_cart_btn': 'addToCart',
			'change .period': 'setPeriod',
			'click .theme-screenshot': 'showDetail',
			'click .more-details': 'showDetail',
			'click .free_product_btn': 'free_product',
			'click .start_service_btn': 'startService',
			'click .stop_service_btn': 'stopService'
		},
		//template: _.template($('#product-template').html()),
		render: function(){
			var data = this.model.toJSON();
			data.dependence_ids = JSON.stringify(this.model.get('dependence_ids'));
			this.$el.html((_.template($('#product-template').html()))(data));
			return this;
		},
		// 试用这个产品
		trail: function(e){
			e.preventDefault();
			sc.Events.trigger('addTrailOrder', this.model);		
		},
		// 使用这个免费产品
		free_product: function(e){
			e.preventDefault();
			sc.Events.trigger('addFreeProduct', this.model);		
		},
		startService: function(e) {
			var service_id = this.model.get('service_id');
			var status = this.model.get('product_service_status');

			stacktech_store.toggle_service(service_id, status);
		},
		stopService: function(e) {
			var service_id = this.model.get('service_id');
			var status = this.model.get('product_service_status');

			stacktech_store.toggle_service(service_id, status);
		},
		setPeriod: function(e) {
			var num = $(e.currentTarget).val();
			//var price = parseInt(num) * this.model.getCurrentPrice();
			var price = this.model.getCurrentPrice(parseInt(num));
			this.$('.total-price').html(sc_display_money(price));



			// 如果有使用特价，那么同时也变更特价
			//if(this.model.get('use_discount_price')){
				//this.$('.original-price').html(parseInt(num) * this.model.get('price'));
			//}
		},
		addToCart: function(e) {
			e.preventDefault();
			var $sourceNode = this.$el.find('.theme-screenshot');
			var $targetNode = $('.stacktech-cart-menu .ab-item');
			var $cloneNode = $sourceNode.clone().hide().appendTo('body');
			$cloneNode.css({position: 'absolute', top: $sourceNode.offset().top, left: $sourceNode.offset().left, zIndex: 1000,
						               width: $sourceNode.width(), height: $sourceNode.height()});
			$cloneNode.show();
			$cloneNode.animate({top: $targetNode.offset().top, left: $targetNode.offset().left, width: $targetNode.width(), height: $targetNode.height()}, 1000, function () {
				$cloneNode.remove();
				$targetNode.jrumble({
					x: 0,
					y: 0,
					rotation: 8
				});
				$targetNode.addClass('hover');
				$targetNode.trigger('startRumble');
				setTimeout(function () {
					$targetNode.trigger('stopRumble');
					$targetNode.removeClass('hover');
				}, 1000);
			});
			// 加进本地购物车
			sc.Events.trigger('addToCart', this.model, {period:this.$('.period').val()});
			// 禁用添加购物车按钮
			this.model.set('is_in_cart', 1);
		},
		rm: function(){
			this.undelegateEvents();
			this.remove();
		},

		// 加载在
		showDetail: function() {
			sc.globalView.productPage(this.model.id);
			window.sc.globalRouter.navigate('product/'+this.model.id, {trigger: false});
			
		},
	});

	// 产品详情页面
	sc.ProductDetailView = Backbone.View.extend({
		initialize: function(options){
			_.bindAll(this, 'removeCartProduct', 'emptyCart');
			this.listenTo(this.model, 'change', this.render);
			this.listenTo(this.model, 'remove', this.rm);
			this.render();
			// 从购物车中删除商品，这个时候应该让商品能重新加进购物车
			sc.Events.on('removeCartProduct', this.removeCartProduct);
			sc.Events.on('emptyCart', this.emptyCart);
		},
		removeCartProduct: function(product){
			if(product.get('product_id') == this.model.id){
				this.model.set('is_in_cart', 0);
			}
		},
		emptyCart: function(){
			this.model.set('is_in_cart', 0);
		},
		events: {
			'click .trail_btn': 'trail',
			'click .free_product_btn': 'free_product',
			'click .add_to_cart_btn': 'addToCart',
			'change .period': 'setPeriod',
			'click .theme-screenshot': 'showDetail',
			//'mouseover .product_thumb_image': 'showBigImage',
			'click .product_thumb_image': 'showBigImage',
			'click .period-price-btn': 'changePeriodSelector',
			'click ._package_detail_popup': 'showProductDetailByPopup',
			'click .price-condition-btn': 'changePriceCondition',
		},
		// 使用这个免费产品
		free_product: function(e){
			e.preventDefault();
			sc.Events.trigger('addFreeProduct', this.model);		
		},
		changePriceCondition: function( e) {
			$(e.currentTarget).siblings().removeClass('selected');
			$(e.currentTarget).addClass('selected');
			
			var price_condition_key = $(e.currentTarget).attr('data-key');

			var num = this.$('select.period').val();
			var price = this.model.getCurrentPrice(parseInt(num), price_condition_key);

			this.setPrice(price);
		},
		changePeriodSelector: function(e){
			var num = $(e.currentTarget).attr('data-period');
			// 改变购买时间下拉框
			this.$('select.period option').attr('selected', false);
			this.$('select.period option[value='+ num +']').attr('selected', true);
			// 改变特价选择框
			$(e.currentTarget).siblings().removeClass('selected');
			$(e.currentTarget).addClass('selected');

			if( this.$('.price_condition_val.selected').length > 0 ) {
				var price_condition_key = this.$('.price_condition_val.selected').attr('data-key');
			} else {
				var price_condition_key = '';
			}

			// 改变产品价格
			var price = this.model.getCurrentPrice(parseInt(num), price_condition_key );
			this.setPrice(price);
		},
		//template: _.template($('#product-template').html()),
		render: function(){
			this.$el.html((_.template($('#product-detail-template').html()))(this.model.toJSON()));
			if ( this.model.requirePriceCondition() ) {
				this.initPriceCondition();
			}
			return this;
		},

		initPriceCondition: function(){
			var pc = this.model.get('price_condition');
			for( var key in pc ) {
				if(pc[key] == 0){
					this.$('.price_condition_val[data-key=' + key + ']').addClass('selected');
					return;
				}
			}
		},
		showProductDetailByPopup: function(e) {
			var product_id = $(e.currentTarget).attr('data-product-id');
			//
			var productModel = new sc.ProductModel();
			sc.startLoading({text: '正在加载产品...'});
			productModel.set('id', product_id);
			productModel.fetch({
				data: {
					action: 'get_product_detail',
				},
				success: function(model, response, options){
					sc.endLoading();
					var detailView = new sc.ProductDetailView({model: productModel});
					sc.globalModalView.reopenModal(detailView);
				},
			});
		},
		initJcarousel: function(){
			var jcarousel = this.$('.jcarousel');

			jcarousel.on('jcarousel:reload jcarousel:create', function () {
			})
			.jcarousel({
				wrap: 'circular'
			});
			$('.jcarousel-control-prev').jcarouselControl({
				target: '-=1'
			});
			$('.jcarousel-control-next').jcarouselControl({
				target: '+=1'
            });
			// 触发首个图片的点击
			this.$('.product_thumb_image').first().trigger('click');
		},
		showBigImage: function(e){
			e.preventDefault();
			$(e.currentTarget).siblings().removeClass('selected');
			$(e.currentTarget).addClass('selected');
			var src = $(e.currentTarget).attr('data-src');
			this.$('#product_big_image img').attr('src', src);

			return false;
		},
		// 试用这个产品
		trail: function(e){
			e.preventDefault();
			sc.Events.trigger('addTrailOrder', this.model);		
		},
		setPeriod: function(e) {

			var num = $(e.currentTarget).val();
			//var price = parseInt(num) * this.model.getCurrentPrice();
			var price = this.model.getCurrentPrice(parseInt(num));
			this.setPrice(price);

			var p = this.model.getWorkingPeriod(parseInt(num));
			this.$('.product-sale-type a').removeClass('selected');
			if(p !== false){
				var obj = this.$('.product-sale-type [data-period=' + p + ']');
				obj.addClass('selected');
				obj.siblings().removeClass('selected');
			}


			// 如果有使用特价，那么同时也变更特价
			//if(this.model.get('use_discount_price')){
				//this.$('.original-price').html(parseInt(num) * this.model.get('price'));
			//}
		},
		setPrice: function(price){
			this.$('.total-price').html(sc_display_money(price));
		},

		addToCart: function(e) {
			if( this.model.requirePriceCondition() ) {
				if( this.$('.price_condition_val.selected').length == 0 ) {
					alert('Please choose one');
					return false;
				}
			}

			e.preventDefault();
			var $sourceNode = this.$el.find('#product_big_image img');
			var $targetNode = $('.stacktech-cart-menu .ab-item');
			var $cloneNode = $sourceNode.clone().hide().appendTo('body');
			$cloneNode.css({position: 'absolute', top: $sourceNode.offset().top, left: $sourceNode.offset().left, zIndex: 1000,
						               width: $sourceNode.width(), height: $sourceNode.height()});
			$cloneNode.show();
			$cloneNode.animate({top: $targetNode.offset().top, left: $targetNode.offset().left, width: $targetNode.width(), height: $targetNode.height()}, 1000, function () {
				$cloneNode.remove();
				$targetNode.jrumble({
					x: 0,
					y: 0,
					rotation: 8
				});
				$targetNode.addClass('hover');
				$targetNode.trigger('startRumble');
				setTimeout(function () {
					$targetNode.trigger('stopRumble');
					$targetNode.removeClass('hover');
				}, 1000);
			});

			// 加进本地购物车
			if( this.model.requirePriceCondition() ) {
			sc.Events.trigger('addToCart', this.model, {period:this.$('.period').val(), price_condition_key: this.$('.price_condition_val.selected').attr('data-key') });
			} else {
			sc.Events.trigger('addToCart', this.model, {period:this.$('.period').val(), price_condition_key: ''});
			}
			// 禁用添加购物车按钮
			this.model.set('is_in_cart', 1);
		},
		rm: function(){
			this.undelegateEvents();
			this.remove();
		},
	});

})(window.jQuery);

