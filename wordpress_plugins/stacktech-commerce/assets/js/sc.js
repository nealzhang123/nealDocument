(function ($) {
	window.sc = window.sc || {};
	sc.Events = _.extend({}, sc.Events, Backbone.Events);

	// 提示消息都应该使用这个函数
	sc.addMessage = function(content){
		new jBox('Notice', {
			position: {x: 'center', y: 'bottom'},
			autoClose:3000,
			stack:false,
			animation:{open:'tada',close:'zoomIn'},
			content: content,
		});
	};

	// 这个是全屏加载，不让用户做其它操作
	sc.startLoading = function(options){
		var defaults = {
			text: '载入中...',
			tpl: '<span class="isloading-wrapper %wrapper%"><div><i class="%class% fa fa-spin"></i></div>%text%</span>',
		};
		var options = _.extend(defaults, options);
		$.isLoading(options);
	};

	sc.endLoading = function(){
		$.isLoading('hide');
	};


	// 路由
	sc.Router = Backbone.Router.extend({
		routes: {
			'theme': 'themePage',
			'checkout': 'checkoutPage',
			'product/:id': 'showProduct',
			'': 'storePage'
		},

		checkoutPage: function() {
		  	sc.globalView.checkoutPage();
		},

		storePage: function() {
			if($('#init_stacktech_store').val() == '1'){
				sc.globalView.storePage();
			}
		},

		showProduct: function(id) {
		  	sc.globalView.productPage(id, 'install_close_action');
		},

		themePage: function() {
		  	sc.globalView.themePage();
		}
	});

	$(document).ready(function(){

		//if($('#init_stacktech_store').val() == '1'){
			window.sc.globalView = new window.sc.MainView();
		//}

		// 购物车视图是需要在所有页面都加载的
		window.sc.globalCart = new window.sc.CartModel();
		var cartView = new sc.CartView({model: window.sc.globalCart});
		window.sc.globalCart.fetch_remote();

		// 加载路由
		window.sc.globalRouter = new window.sc.Router();
		Backbone.history.start();

	});

})(window.jQuery);
