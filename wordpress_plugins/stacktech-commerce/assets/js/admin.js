function sc_open_window( url) {
	window.open(url, '_blank');
	window.focus();
}
function sc_selected(realVal, currentVal) {
	if(realVal == currentVal){
		return 'selected';
	}
	return '';
}

function sc_display_money(money){
	//money = parseFloat(money);
	//money = money.toFixed(2);
	return '￥' + money;
}

function sc_get_period_options(realVal){
	realVal = realVal || 0;
	var default_month = 24;
	var str = '<select class="period">';
	for(var i = 1; i <=24; i ++){
		str += '<option value="' + i + '"';
		if (i == realVal ) {
			str += ' selected';
		}
		str += '>';
		str += i + '个月';
		str += '</option>';
	}
	str += '</select>';

	return str;
}

function sc_get_period_label(val){
	return val + '个月';
}


(function($){
	var stacktech_store = {};

	// ajax获取可使用的插件或主题
	stacktech_store.load_avaiable_modules = function (type) {
		$.post(
			ajaxurl,
			{
				action: 'load_avaiable_modules',
				type: type,
				current: $('#_current_plugin_name').val(),
			},
			function(data){
				var $ele = $('#_plugin_name');
				var current_plugin_name = $('#_current_plugin_name').val();
				$ele.empty();
				for ( var i in data ) {
					var sel = '';
					if ( i === current_plugin_name) {
						sel = ' selected ';
					}
					$ele.append( '<option ' + sel + ' value="' + i + '">' + data[i].Name + '</option>' );
				}
			},
			'json'
		);
	};

	stacktech_store.open_modal = function(html) {
		var m = $('#store_modal');
		m.find('#store_modal_content').html(html)
		var inst = m.remodal();
		inst.open();
		m.find('.remodal-close').click(function(e){
			e.preventDefault();
			inst.close();
			$(this).off('click');
		});
	};



	stacktech_store.load_product_by_popup = function(id) {
		window.sc.globalView.productPage(id);
	};

	stacktech_store.toggle_all_order_details = function(ele) {
		if($(ele).attr('status') == 'open'){
			$('.order_detail_row').hide();
			$(ele).attr('status', 'close');
		}else {
			$('.order_detail_row').show();
			$(ele).attr('status', 'open');
		}
	};

	stacktech_store.renew_order = function(ele, order_id) {

		if($(ele).hasClass('disabled')){
			return;
		}
		$(ele).isLoading();
		$.post(
			ajaxurl,
			{
				action: 'renew_order',
				order_id: order_id
			},
			function(data){
				//document.location.href = sc_page_url('admin.php?page=stacktech-store-plugin');
				sc.globalCart.fetch_remote().then(function(){
					$(ele).isLoading( "hide" );
				});
			},
			'json'
		);
	};

	stacktech_store.cancel_order = function(ele, order_id) {
		if($(ele).hasClass('disabled')){
			return;
		}
		$(ele).isLoading();
		$.post(
			ajaxurl,
			{
				action: 'cancel_order',
				order_id: order_id
			},
			function(data){
				$(ele).isLoading( "hide" );
				document.location.href = sc_page_url('admin.php?page=stacktech-store-order');
			},
			'json'
		);
	};

	stacktech_store.toggle_service = function(service_id, status){
		if(status == 1){
			var text = '正在停止服务...';
		}else{
			var text = '正在开启服务...';
		}
		sc.startLoading({
			'text': text
		});
		$.post(
			ajaxurl,
			{
				action: 'toggle_service',
				service_id: service_id,
				status: status
			},
			function(data){
				if(data.error){
					sc.addMessage(data.error);
				}else {
					sc.addMessage(data.message);
				}
				//sc.endLoading();
				document.location.reload();
			},
			'json'
		);
	};

	// 添加进购物车
	stacktech_store.add_to_cart = function (product_id) {

	};

	// 订单页面显示订单详情
	stacktech_store.show_order_detail = function (order_id){
		$('#order_detail_row_' + order_id).toggle();

	};

	stacktech_store.init_month_discount = function () {
		for(var i in window._month_discount){
		  stacktech_store.add_month_discount(i, window._month_discount[i]);
		}
	};

	stacktech_store.init_price_condition = function () {
		for(var i in window._price_condition){
		  stacktech_store.add_price_condition(i, window._price_condition[i]);
		}
	};

	stacktech_store.add_month_discount = function (k, v) {
		$('#month_discount_container').append(
			'<div class="month_discount_row">'
			+ '<select class="month_discount_select">'
			+ '<option value="3" ' + sc_selected(k, 3) +'>购买超过三个月</option>'
			+ '<option value="6" ' + sc_selected(k, 6) +'>购买超过六个月</option>'
			+ '<option value="9" ' + sc_selected(k, 9) +'>购买超过九个月</option>'
			+ '<option value="12" ' + sc_selected(k, 12) +'>购买超过一年</option>'
			+ '</select>&nbsp;&nbsp;&nbsp;&nbsp;'
			+ '每月销售价格(￥):<input type="text" class="month_discount_input" value="' + v + '" />'
			+ '<a href="javascript:void(0)" onclick="return stacktech_store.remove_month_discount(this);">删除</a>'
			+ '</div>'
		);
		return false;
	};

	stacktech_store.add_price_condition = function (label, price) {
		// Here we need to add default value
		if ( $('#price_condition_container').children().length == 0 && price === '' ) {
			$('#price_condition_container').append(
				'<div class="price_condition_row">'
				+ '标签:<input type="text" value="'+ label +'" class="price_condition_label" />&nbsp;&nbsp;&nbsp;&nbsp;每月销售价格变化(￥):'
				+ '<input type="text" disabled value="0" class="price_condition_price" />'
				+ '</div>'
			);
		}
		if( price === '0' ) {
		$('#price_condition_container').append(
			'<div class="price_condition_row">'
			+ '标签:<input type="text" value="'+ label +'" class="price_condition_label" />&nbsp;&nbsp;&nbsp;&nbsp;每月销售价格变化(￥):'
			+ '<input type="text" disabled value="'+ price +'" class="price_condition_price" />'
			+ '</div>'
		);
		}else {
		$('#price_condition_container').append(
			'<div class="price_condition_row">'
			+ '标签:<input type="text" value="'+ label +'" class="price_condition_label" />&nbsp;&nbsp;&nbsp;&nbsp;每月销售价格变化(￥):'
			+ '<input type="text" value="'+ price +'" class="price_condition_price" />'
			+ '<a href="javascript:void(0)" onclick="return stacktech_store.remove_price_condition(this);">删除</a>'
			+ '</div>'
		);
		}
		return false;
	};

	stacktech_store.remove_month_discount = function(ele){
	  	$(ele).parents('.month_discount_row').remove();
	};

	stacktech_store.remove_price_condition = function(ele){
	  	$(ele).parents('.price_condition_row').remove();

		if ( $('#price_condition_container').children().length == 1 ) {
			$('#price_condition_container').empty();
		}
	};

	stacktech_store.save_month_discount = function () {
		var data = {};
		$('.month_discount_row').each(function(){
			var key = parseInt($(this).find('.month_discount_select').val());
			var val = $(this).find('.month_discount_input').val();
			if(val == 0){
			  return;
			}
			data[key] = val;
		});
		$('input[name=_month_discount]').val(JSON.stringify(data));
	};

	stacktech_store.save_price_condition = function () {
		var data = {};
		$('.price_condition_row').each(function(){
			var key = $(this).find('.price_condition_label').val();
			var val = $(this).find('.price_condition_price').val();
			data[key] = val;
		});
		$('input[name=_price_condition]').val(JSON.stringify(data));
	};
	stacktech_store.show_or_hide_month_discount = function(){
		if ($('input[name=_allow_purchase_forever]:checked').val() == 0){
			$('.month_discount_field').show();
		}else if($('input[name=_allow_purchase_forever]:checked').val() == 1){
			$('.month_discount_field').hide();
		}else if($('input[name=_allow_purchase_forever]:checked').val() == 2){
			$('.sale_price_field').hide();
			$('.month_discount_field').hide();
			$('.allow_discount_price_field').hide();
			$('.discount_field').hide();
			$('.allow_trail_field').hide();
			$('.trail_field').hide();
		}

		if( $('input[name=_allow_purchase_forever]:checked').val() == 0 || $('input[name=_allow_purchase_forever]:checked').val() == 1){
			$('.sale_price_field').show();
			$('.allow_discount_price_field').show();
			stacktech_store.show_or_hide_discount();
			$('.allow_trail_field').show();
			stacktech_store.show_or_hide_trail();
		}
	};

	stacktech_store.show_or_hide_discount = function(){
		if ($('input[name=_allow_discount_price]:checked').val() == 0){
			$('.discount_field').hide();
		}else{
			$('.discount_field').show();
		}
	};

	stacktech_store.show_or_hide_trail = function(){
		if ($('input[name=_allow_trail]:checked').val() == 0){
			$('.trail_field').hide();
		}else{
			$('.trail_field').show();
		}
	};

	stacktech_store.show_or_hide_sale_type = function(){
		if ($('input[name=_product_sale_type]:checked').val() == 0 || $('input[name=_product_sale_type]:checked').val() == 2){
			// If it is single product or system product
			$('.single_sale_type_field').show();
			$('.package_sale_type_field').hide();
			if( $('input[name=_product_sale_type]:checked').val() == 2 ) {
				$('.repeat_sale_field').show();
			} else {
				$('.repeat_sale_field').hide();
			}
		}else{
			$('.package_sale_type_field').show();
			$('.single_sale_type_field').hide();
			$('.repeat_sale_field').hide();
		}
	};

	window.stacktech_store = stacktech_store;

	$(document).ready(function(){
		//$("#Slider2").dragval({ step: 50, min: 0, max: 50000, startValue: 45000 });
		if ( $('#is_edit_product').length > 0 )
		{

			// 产品相册

	// Product gallery file uploads
	var product_gallery_frame;
	var $image_gallery_ids = $( '#product_image_gallery' );
	var $product_images    = $( '#product_images_container ul.product_images' );

	jQuery( '.add_product_images' ).on( 'click', 'a', function( event ) {
		var $el = $( this );

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( product_gallery_frame ) {
			product_gallery_frame.open();
			return;
		}

		// Create the media frame.
		product_gallery_frame = wp.media.frames.product_gallery = wp.media({
			// Set the title of the modal.
			title: $el.data( 'choose' ),
			button: {
				text: $el.data( 'update' )
			},
			states: [
				new wp.media.controller.Library({
					title: $el.data( 'choose' ),
					filterable: 'all',
					multiple: true
				})
			]
		});

		// When an image is selected, run a callback.
		product_gallery_frame.on( 'select', function() {
			var selection = product_gallery_frame.state().get( 'selection' );
			var attachment_ids = $image_gallery_ids.val();

			selection.map( function( attachment ) {
				attachment = attachment.toJSON();

				if ( attachment.id ) {
					attachment_ids   = attachment_ids ? attachment_ids + ',' + attachment.id : attachment.id;
					var attachment_image = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

					$product_images.append( '<li class="image" data-attachment_id="' + attachment.id + '"><img src="' + attachment_image + '" /><ul class="actions"><li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li></ul></li>' );
				}
			});

			$image_gallery_ids.val( attachment_ids );
		});

		// Finally, open the modal.
		product_gallery_frame.open();
	});

	// Image ordering
	$product_images.sortable({
		items: 'li.image',
		cursor: 'move',
		scrollSensitivity: 40,
		forcePlaceholderSize: true,
		forceHelperSize: false,
		helper: 'clone',
		opacity: 0.65,
		placeholder: 'sc-metabox-sortable-placeholder',
		start: function( event, ui ) {
			ui.item.css( 'background-color', '#f6f6f6' );
		},
		stop: function( event, ui ) {
			ui.item.removeAttr( 'style' );
		},
		update: function() {
			var attachment_ids = '';

			$( '#product_images_container ul li.image' ).css( 'cursor', 'default' ).each( function() {
				var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
				attachment_ids = attachment_ids + attachment_id + ',';
			});

			$image_gallery_ids.val( attachment_ids );
		}
	});

	// Remove images
	$( '#product_images_container' ).on( 'click', 'a.delete', function() {
		$( this ).closest( 'li.image' ).remove();

		var attachment_ids = '';

		$( '#product_images_container ul li.image' ).css( 'cursor', 'default' ).each( function() {
			var attachment_id = jQuery( this ).attr( 'data-attachment_id' );
			attachment_ids = attachment_ids + attachment_id + ',';
		});

		$image_gallery_ids.val( attachment_ids );

		// remove any lingering tooltips
		$( '#tiptip_holder' ).removeAttr( 'style' );
		$( '#tiptip_arrow' ).removeAttr( 'style' );

		return false;
	});






			window.stacktech_store.load_avaiable_modules($('#product-type').val());
			$('#product-type').change(function() {
				window.stacktech_store.load_avaiable_modules( $(this).val() );
			});

			$('.stacktech-datepicker').datepicker();

			$('#publish').click(function(){
				stacktech_store.save_month_discount();
				stacktech_store.save_price_condition();
			});
		
			stacktech_store.init_month_discount();
			stacktech_store.init_price_condition();

			// 
			stacktech_store.show_or_hide_discount();
			$('input[name=_allow_discount_price]').change(stacktech_store.show_or_hide_discount);

			stacktech_store.show_or_hide_trail();
			$('input[name=_allow_trail]').change(stacktech_store.show_or_hide_trail);

			stacktech_store.show_or_hide_sale_type();
			$('input[name=_product_sale_type]').change(stacktech_store.show_or_hide_sale_type);

			stacktech_store.show_or_hide_month_discount();
			$('input[name=_allow_purchase_forever]').change(stacktech_store.show_or_hide_month_discount);

			// 启用搜索
			$( ':input.stacktech-product-search' ).filter( ':not(.enhanced)' ).each( function() {
				var select2_args = {
					allowClear:  $( this ).data( 'allow_clear' ) ? true : false,
					placeholder: $( this ).data( 'placeholder' ),
					minimumInputLength: $( this ).data( 'minimum_input_length' ) ? $( this ).data( 'minimum_input_length' ) : '2',
					escapeMarkup: function( m ) {
						return m;
					},
					ajax: {
				        url:         ajaxurl,
				        dataType:    'json',
				        quietMillis: 250,
				        data: function( term ) {
				            return {
								term:     term,
								action:   $( this ).data( 'action' ),
								exclude:  $( this ).data( 'exclude' )
				            };
				        },
				        results: function( data ) {
				        	var terms = [];
					        if ( data ) {
								$.each( data, function( id, text ) {
									terms.push( { id: id, text: text } );
								});
							}
				            return {
				            	results: terms
			            	};
				        },
				        cache: true
				    }
				};

				if ( $( this ).data( 'multiple' ) === true ) {
					select2_args.multiple = true;
					select2_args.initSelection = function( element, callback ) {
						var data     = $.parseJSON( element.attr( 'data-selected' ) );
						var selected = [];

						$( element.val().split( ',' ) ).each( function( i, val ) {
							selected.push({
								id: val,
								text: data[ val ]
							});
						});
						return callback( selected );
					};
					select2_args.formatSelection = function( data ) {
						return '<div class="selected-option" data-id="' + data.id + '">' + data.text + '</div>';
					};
				} else {
					select2_args.multiple = false;
					select2_args.initSelection = function( element, callback ) {
						var data = {
							id: element.val(),
							text: element.attr( 'data-selected' )
						};
						return callback( data );
					};
				}

				$( this ).select2( select2_args ).addClass( 'enhanced' );
			});

		}

		var tiptip_args = { 
			'attribute': 'data-tip',
			'fadeIn': 50, 
			'fadeOut': 50, 
			'delay': 200 
		};
		$( '.stacktech_help_tip' ).tipTip( tiptip_args );


		// 服务页面
		$('.load_history_btn').click(function(){
			if($(this).hasClass('disabled')){
				return;
			}
			var service_id = $(this).attr('data-service-id');
			var theme = $(this).attr('data-theme');
			var that = $(this);
			var parent_tr = $(this).parents('tr');
			if( parent_tr.next().attr('id') == 'tr_' + service_id ) {
				parent_tr.next().toggleClass('hide');
				return;
			}
			$( this ).isLoading();
			$.get(
				ajaxurl,
				{
					action: 'load_service_logs',
					service_id: service_id,
					theme: theme
				},
				function(data){
					var d = {service_id : service_id, logs: data};
					var html = (_.template($('#service-log-template').html()))(d);
					parent_tr.after(html);
					that.isLoading( "hide" );
				},
				'json'
			);
			
		});

		// Money History
		$('.load_account_history_btn').click(function(){
			if($(this).hasClass('disabled')){
				return;
			}
			var user_id = $(this).attr('data-user-id');
			var that = $(this);
			$( this ).isLoading();
			$.get(
				ajaxurl,
				{
					action: 'load_account_logs',
					user_id: user_id
				},
				function(data){
					var d = {user_id: user_id, logs: data};
					var html = (_.template($('#account-log-template').html()))(d);

					//that.siblings('.history_list').html(html);
					stacktech_store.open_modal(html);
					that.isLoading( "hide" );
				},
				'json'
			);
		});

		// Order Log
		$('.load_order_history_btn').click(function(){
			if($(this).hasClass('disabled')){
				return;
			}
			var order_id = $(this).attr('data-order-id');
			var that = $(this);
			$( this ).isLoading();
			$.get(
				ajaxurl,
				{
					action: 'load_order_logs',
					order_id: order_id
				},
				function(data){
					var d = {order_id: order_id, logs: data};
					var html = (_.template($('#order-log-template').html()))(d);

					//that.siblings('.history_list').html(html);
					stacktech_store.open_modal(html);
					that.isLoading( "hide" );
				},
				'json'
			);
		});


		// ticket插件里面加载我们的order，第三方
		$('.stacktech_load_order_btn').click(function(){
			if($(this).hasClass('disabled')){
				return;
			}
			var order_id = $(this).attr('data-order-id');
			var that = $(this);
			var parent_tr = $(this).parents('p');
			if( parent_tr.next().attr('id') == 'div_' + order_id ) {
				parent_tr.next().toggleClass('hide');
				return;
			}
			$( this ).isLoading();
			$.get(
				ajaxurl,
				{
					action: 'load_order_detail',
					order_id: order_id
				},
				function(data){
					var html = (_.template($('#order-detail-template').html()))(data);
					parent_tr.after(html);
					that.isLoading( "hide" );
				},
				'json'
			);
			
		});

		



	});
})(jQuery);
