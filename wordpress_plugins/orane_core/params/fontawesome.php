<?php  
// fontawesome param type for visual composer
add_shortcode_param( 'orane_fontawesome_param', 'orane_fontawesome_param_define' );

function orane_fontawesome_param_define( $settings, $value ) {


	$wish_fa_list = array(
					        'adjust', 'adn', 'align-center', 'align-justify', 'align-left', 'align-right', 'ambulance',
					        'anchor', 'android', 'angle-double-down', 'angle-double-left', 'angle-double-right', 'angle-double-up',
					        'angle-down', 'angle-left', 'angle-right', 'angle-up', 'apple', 'archive', 'arrow-circle-down',
					        'arrow-circle-left', 'arrow-circle-o-down', 'arrow-circle-o-left', 'arrow-circle-o-right',
					        'arrow-circle-o-up', 'arrow-circle-right', 'arrow-circle-up', 'arrow-down', 'arrow-left',
					        'arrow-right', 'arrow-up', 'arrows', 'arrows-alt', 'arrows-h', 'arrows-v', 'asterisk',
					        'automobile', 'backward', 'ban', 'bank', 'bar-chart-o', 'barcode', 'bars', 'beer',
					        'behance', 'behance-square', 'bell', 'bell-o', 'bitbucket', 'bitbucket-square', 'bitcoin',
					        'bold', 'bolt', 'bomb', 'book', 'bookmark', 'bookmark-o', 'briefcase', 'btc',
					        'bug', 'building', 'building-o', 'bullhorn', 'bullseye', 'cab', 'calendar', 'calendar-o',
					        'camera', 'camera-retro', 'car', 'caret-down', 'caret-left', 'caret-right',
					        'caret-square-o-down', 'caret-square-o-left', 'caret-square-o-right', 'caret-square-o-up',
					        'caret-up', 'certificate', 'chain', 'chain-broken', 'check', 'check-circle', 'check-circle-o',
					        'check-square', 'check-square-o', 'chevron-circle-down', 'chevron-circle-left',
					        'chevron-circle-right', 'chevron-circle-up', 'chevron-down', 'chevron-left',
					        'chevron-right', 'chevron-up', 'child', 'circle', 'circle-o', 'circle-o-notch',
					        'circle-thin', 'clipboard', 'clock-o', 'cloud', 'cloud-download', 'cloud-upload',
					        'cny', 'code', 'code-fork', 'codepen', 'coffee', 'cog', 'cogs', 'columns',
					        'comment', 'comment-o', 'comments', 'comments-o', 'compass', 'compress', 'copy',
					        'credit-card', 'crop', 'crosshairs', 'css3', 'cube', 'cubes', 'cut', 'cutlery',
					        'dashboard', 'database', 'dedent', 'delicious', 'desktop', 'deviantart', 'digg',
					        'dollar', 'dot-circle-o', 'download', 'dribbble', 'dropbox', 'drupal', 'edit', 'eject',
					        'ellipsis-h', 'ellipsis-v', 'empire', 'envelope', 'envelope-o', 'envelope-square',
					        'eraser', 'eur', 'euro', 'exchange', 'exclamation', 'exclamation-circle',
					        'exclamation-triangle', 'expand', 'external-link', 'external-link-square', 'eye',
					        'eye-slash', 'facebook', 'facebook-square', 'fast-backward', 'fast-forward', 'fax',
					        'female', 'fighter-jet', 'file', 'file-archive-o', 'file-audio-o', 'file-code-o',
					        'file-excel-o', 'file-image-o', 'file-movie-o', 'file-o', 'file-pdf-o', 'file-photo-o',
					        'file-picture-o', 'file-powerpoint-o', 'file-sound-o', 'file-text', 'file-text-o',
					        'file-video-o', 'file-word-o', 'file-zip-o', 'files-o', 'film', 'filter', 'fire',
					        'fire-extinguisher', 'flag', 'flag-checkered', 'flag-o', 'flash', 'flask', 'flickr',
					        'floppy-o', 'folder', 'folder-o', 'folder-open', 'folder-open-o', 'font', 'forward',
					        'foursquare', 'frown-o', 'gamepad', 'gavel', 'gbp', 'ge', 'gear', 'gears', 'gift',
					        'git', 'git-square', 'github', 'github-alt', 'github-square', 'gittip', 'glass', 'globe',
					        'google', 'google-plus', 'google-plus-square', 'graduation-cap', 'group', 'h-square', 'hacker-news',
					        'hand-o-down', 'hand-o-left', 'hand-o-right', 'hand-o-up', 'hdd-o', 'header', 'headphones',
					        'heart', 'heart-o', 'history', 'home', 'hospital-o', 'html5', 'image', 'inbox', 'indent',
					        'info', 'info-circle', 'inr', 'instagram', 'institution', 'italic', 'joomla', 'jpy',
					        'jsfiddle', 'key', 'keyboard-o', 'krw', 'language', 'laptop', 'leaf', 'legal', 'lemon-o',
					        'level-down', 'level-up', 'life-bouy', 'life-ring', 'life-saver', 'lightbulb-o', 'link',
					        'linkedin', 'linkedin-square', 'linux', 'list', 'list-alt', 'list-ol', 'list-ul', 'location-arrow',
					        'lock', 'long-arrow-down', 'long-arrow-left', 'long-arrow-right', 'long-arrow-up', 'magic',
					        'magnet', 'mail-forward', 'mail-reply', 'mail-reply-all', 'male', 'map-marker', 'maxcdn',
					        'medkit', 'meh-o', 'microphone', 'microphone-slash', 'minus', 'minus-circle', 'minus-square',
					        'minus-square-o', 'mobile', 'mobile-phone', 'money', 'moon-o', 'mortar-board', 'music',
					        'navicon', 'openid', 'outdent', 'pagelines', 'paper-plane', 'paper-plane-o', 'paperclip',
					        'paragraph', 'paste', 'pause', 'paw', 'pencil', 'pencil-square', 'pencil-square-o', 'phone',
					        'phone-square', 'photo', 'picture-o', 'pied-piper', 'pied-piper-alt', 'pied-piper-square',
					        'pinterest', 'pinterest-square', 'plane', 'play', 'play-circle', 'play-circle-o', 'plus',
					        'plus-circle', 'plus-square', 'plus-square-o', 'power-off', 'print', 'puzzle-piece', 'qq',
					        'qrcode', 'question', 'question-circle', 'quote-left', 'quote-right', 'ra', 'random',
					        'rebel', 'recycle', 'reddit', 'reddit-square', 'refresh', 'renren', 'reorder', 'repeat',
					        'reply', 'reply-all', 'retweet', 'rmb', 'road', 'rocket', 'rotate-left', 'rotate-right',
					        'rouble', 'rss', 'rss-square', 'rub', 'ruble', 'rupee', 'save', 'scissors', 'search',
					        'search-minus', 'search-plus', 'send', 'send-o', 'share', 'share-alt', 'share-alt-square',
					        'share-square', 'share-square-o', 'shield', 'shopping-cart', 'sign-in', 'sign-out', 'signal',
					        'sitemap', 'skype', 'slack', 'sliders', 'smile-o', 'sort', 'sort-alpha-asc', 'sort-alpha-desc',
					        'sort-amount-asc', 'sort-amount-desc', 'sort-asc', 'sort-desc', 'sort-down', 'sort-numeric-asc',
					        'sort-numeric-desc', 'sort-up', 'soundcloud', 'space-shuttle', 'spinner', 'spoon', 'spotify',
					        'square', 'square-o', 'stack-exchange', 'stack-overflow', 'star', 'star-half', 'star-half-empty',
					        'star-half-full', 'star-half-o', 'star-o', 'steam', 'steam-square', 'step-backward', 'step-forward',
					        'stethoscope', 'stop', 'strikethrough', 'stumbleupon', 'stumbleupon-circle', 'subscript',
					        'suitcase', 'sun-o', 'superscript', 'support', 'table', 'tablet', 'tachometer', 'tag',
					        'tags', 'tasks', 'taxi', 'tencent-weibo', 'terminal', 'text-height', 'text-width', 'th',
					        'th-large', 'th-list', 'thumb-tack', 'thumbs-down', 'thumbs-o-down', 'thumbs-o-up', 'thumbs-up',
					        'ticket', 'times', 'times-circle', 'times-circle-o', 'tint', 'toggle-down', 'toggle-left',
					        'toggle-right', 'toggle-up', 'trash-o', 'tree', 'trello', 'trophy', 'truck', 'try', 'tumblr',
					        'tumblr-square', 'turkish-lira', 'twitter', 'twitter-square', 'umbrella', 'underline', 'undo',
					        'university', 'unlink', 'unlock', 'unlock-alt', 'unsorted', 'upload', 'usd', 'user', 'user-md',
					        'users', 'video-camera', 'vimeo-square', 'vine', 'vk', 'volume-down', 'volume-off', 'volume-up',
					        'warning', 'wechat', 'weibo', 'weixin', 'wheelchair', 'windows', 'won', 'wordpress', 'wrench',
					        'xing', 'xing-square', 'yahoo', 'yen', 'youtube', 'youtube-play', 'youtube-square'
					      );

	$list_markup = "";
	foreach ($wish_fa_list as $key => $value) {
		$list_markup .= "<a href='#'><i class='fa fa-{$value}'></i></a>";
	}

   return '<div class="wish_fa_param">'
             .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput wish_fa_input ' .
             esc_attr( $settings['param_name'] ) . ' ' .
             esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" /><div class="wish_fa_preview"><i class="fa fa-' . $value . '"></i></div>' .

             "<div class='clearfix'></div><div class='wish_fa_list'>" .
             $list_markup .
           '</div>
           </div>
			<script type="text/javascript">
					jQuery.noConflict();
					(function( $ ) {


				jQuery(document).ready(function(){


					jQuery(".'.esc_attr( $settings['param_name'] ).'").on("click", function(e){
						e.preventDefault();
						jQuery(this).siblings(".wish_fa_list").toggle();

					});

				
					jQuery(".wish_fa_list").on("click", "a", function(e){
						e.preventDefault();
						var cls = jQuery(this).find("i").attr("class").split(" ")[1];
						jQuery(this).closest(".wish_fa_param").find(".wish_fa_input").val(cls);
						jQuery(this).closest(".wish_fa_param").find(".wish_fa_preview i").removeClass().addClass("fa").addClass(cls);
					});


				});	

			})( jQuery );
			</script>
           '; // This is html markup that will be outputted in content elements edit form
}



function orane_fontawesome_admin_style() {
        wp_register_style( 'orane_fontawesome_admin_css', plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css'  );
        wp_register_style( 'orane_fontawesome_custom_admin_css', plugin_dir_url( __FILE__ ) . 'css/fontawesome-custom.css'  );
        wp_enqueue_style( 'orane_fontawesome_admin_css' );
        wp_enqueue_style( 'orane_fontawesome_custom_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'orane_fontawesome_admin_style' );



?>