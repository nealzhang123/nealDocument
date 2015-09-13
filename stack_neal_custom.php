<?php 
/*
Plugin Name: Stack neal post type
Version: 0.1
Plugin URI: http://stacktech.cn
Description: stash
Author: WPB
Author URI: http://stacktech.cn
*/
class Stack_stash {

	static $post_type = 'stack_stash';
	
	static function init(){
		global $wp;
		//register new post type
		self::register_stash_post_type();

		add_action( 'add_meta_boxes', array( 'Stack_stash', 'add_meta_boxes' ), 30 );
		
		add_action( 'save_post', array( 'Stack_stash', 'save_meta_boxes') ,3 ,2);
	}

	static function register_stash_post_type(){
		register_post_type( self::$post_type,
			array(
				'labels' => array(
					'name' => __( 'Stash', 'stack_stash' ),
					'menu_name'=> 'Stack Stash',
					'singular_name' => __( 'Stash ', 'stack_stash' ),
					'all_items' => __( 'All Stashs', 'stack_stash' ),
					'add_new' => __( 'Add Stash', 'stack_stash' ),
					'add_new_item' => __( 'Add New Stash', 'stack_stash' ),
					'edit' => __( 'Edit', 'stack_stash' ),
					'edit_item' => __( 'Edit Stash', 'stack_stash' ),
					'new_item' => __( 'New Stash', 'stack_stash' ),
					'view' => __( 'View Stash', 'stack_stash' ),
					'view_item' => __( 'View Stash', 'stack_stash' ),
					'search_items' => __( 'Search Stash', 'stack_stash' ),
					'not_found' => __( 'No Stash found', 'stack_stash' ),
					'not_found_in_trash' => __( 'No Stash found in Trash', 'stack_stash' ),
				),
				'public' => true,
				'exclude_from_search' => false,
				'publicly_queryable' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				//'taxonomies' => array('category'),
				'has_archive' => true,
				'menu_position' => 32,
				'hierarchical' => false,
				'query_var' => true,
				'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail' ),
				'rewrite' => array('slug' => self::$post_type),
				//'can_export' => true,
			)
		);
	}

	public function add_meta_boxes() {
		add_meta_box( 'stack-stash-images', __( 'Stash Gallery', 'stack_stash' ),  array('Stack_stash', 'out_put'), 'stack_stash', 'side', 'low' );

	}

	public function save_meta_boxes( $post_id, $post ){

		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves
		if ( is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}
		
		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		self::save_metas( $post_id, $post );
		
	}

	public function save_metas( $post_id, $post ){
		$attachment_ids = isset( $_POST['stash_image_gallery'] ) ? array_filter( explode( ',', $_POST['stash_image_gallery'] ) ) : array();

		update_post_meta( $post_id, 'stash_image_gallery', implode( ',', $attachment_ids ) );
	}

	public function out_put( $post ) {
		wp_register_script( 'stack-stash', plugins_url( 'meta-boxes-product-copy.js', __FILE__ ));
		wp_enqueue_script( 'stack-stash' );
?>
		<div id="product_images_container">
			<ul class="product_images">
				<?php
					if ( metadata_exists( 'post', $post->ID, 'stash_image_gallery' ) ) {
						$stash_image_gallery = get_post_meta( $post->ID, 'stash_image_gallery', true );
					} else {
						// Backwards compat
						$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_stack_exclude_image&meta_value=0' );
						$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
						$stash_image_gallery = implode( ',', $attachment_ids );
					}
					//echo 'test:'.$stash_image_gallery;
					$attachments = array_filter( explode( ',', $stash_image_gallery ) );

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( 'Delete image', 'stack_stash' ) . '">' . __( 'Delete', 'stack_stash' ) . '</a></li>
								</ul>
							</li>';
						}
					}
				?>
			</ul>

			<input type="hidden" id="product_image_gallery" name="stash_image_gallery" value="<?php echo esc_attr( $stash_image_gallery ); ?>" />

		</div>
		<p class="add_product_images hide-if-no-js">
			<a href="#" data-choose="<?php esc_attr_e( 'Add Images to Stash Gallery', 'stack_stash' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'stack_stash' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'stack_stash' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'stack_stash' ); ?>"><?php _e( 'Add Stash gallery images', 'stack_stash' ); ?></a>
		</p>
<?php
	}

	public function add_to_front_page( $content ){
		global $post;

		$stash_image_gallery = get_post_meta( $post->ID, 'stash_image_gallery', true );
		$attachments = array_filter( explode( ',', $stash_image_gallery ) );
		$extra_content = '';

		if ( ! empty( $attachments ) ) {
			foreach ( $attachments as $attachment_id ) {
				$extra_content .= '<li class="image">
					' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '</li>';
			}
		}
		return $content.$extra_content;
	} 
}
// it should be first loaded before VIPCLUB plugin
add_action('init', array('Stack_stash','init'), 1 );
add_filter('the_content', array('Stack_stash', 'add_to_front_page'), 11);
?>