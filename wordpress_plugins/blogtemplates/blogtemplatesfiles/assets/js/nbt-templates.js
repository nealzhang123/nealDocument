jQuery(document).ready(function($) {
	var nbt_settings = {
		init: function() {
			var postboxes = $('.postbox');

			var postboxes_checkboxes = postboxes.find('input[type=checkbox]');

			var all_selectors = postboxes.find('input.all-selector');
			
			
			all_selectors.each(function(i,selector) {
				selector = $(selector);
				if ( selector.attr('checked') ) {
					var list_items = nbt_settings.get_list(selector);
					list_items.attr('disabled',true);
				}	
			});

			postboxes_checkboxes.change(function() {
				var item = $(this);

				if ( item.hasClass('all-selector') ) {
					var list_items = nbt_settings.get_list(item);
					
					if ( item.attr('checked') ) {
						list_items.attr('checked', false);
						list_items.attr('disabled',  true);
					}
					else {
						list_items.attr('disabled',  false);
					}
				}
			});

			$('#public').change(function() {
				var pub = $(this);
				var list_items = nbt_settings.get_list(pub);;
				
				if (pub.attr('checked')) {
					list_items.attr('checked', true);
					list_items.attr('disabled',  true);			
				}else{
					list_items.attr('checked', false);
					list_items.attr('disabled',  false);
				}


			});

			$('.selectit_1').change(function() {
				var pub = $(this);
				var list_items = pub.closest('ul').find('input[type=checkbox]' );
				var result = '';
				
				list_items.each(function(i,selector){
					selector = $(selector);
					if(selector.attr('checked')){
						result = result+selector.val()+',';
					}
				})
				$('#hidden_1').val(result);
			});
			
		},
		get_list: function( item ) {
			return item
				.closest('ul')
				.find('input[type=checkbox]' )
				.not('#' + item.attr('id'));
		}
	}
	nbt_settings.init();
	

	var nbt_cache = {};
	$( "#search_for_blog" ).autocomplete({
	  minLength: 2,
	  source: function( request, response ) {
	    var term = request.term;
	    if ( term in nbt_cache ) {
	      response( nbt_cache[ term ] );
	      return;
	    }
		
		var data = {
			action: 'nbt_get_sites_search',
			term: request.term
		};


	    $.ajax({
			url: export_to_text_js.ajaxurl,
			data: data,
			type: 'post',
			dataType: 'json'
		}).done(function( data ) {
			nbt_cache[ term ] = data;
			response( data );
		});

	    //$.getJSON( export_to_text_js.ajaxurl, data ).done( function( data, status, xhr ) {
	    //	console.log(data);
		//	//nbt_cache[ term ] = data;
		//	//response( data );
	    //});
	  },
	  response: function( event, ui ) {
	  	for ( var i = 0; i < ui.content.length; i++ ) {
	  		ui.content[i].label = ui.content[i].path + ' [' + ui.content[i].blog_name + ']';
	  		ui.content[i].value = ui.content[i].blog_name;
	  	}
	  },
	  select: function ( event, ui ) {
	  	$( '#copy_blog_id' ).val( ui.item.blog_id );
	  }
	});
});
