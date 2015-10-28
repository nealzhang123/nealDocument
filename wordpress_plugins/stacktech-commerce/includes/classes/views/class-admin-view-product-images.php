<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 */
class Stacktech_Commerce_Admin_View_Product_Images extends Stacktech_Commerce_View {

    public static function output() {
		global $post;
?>
		<div id="product_images_container">
			<ul class="product_images clearfix">
				<?php
					if ( metadata_exists( 'post', $post->ID, '_product_image_gallery' ) ) {
						$product_image_gallery = get_post_meta( $post->ID, '_product_image_gallery', true );
					} else {
						// Backwards compat
						$attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids' );
						$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
						$product_image_gallery = implode( ',', $attachment_ids );
					}

					$attachments = array_filter( explode( ',', $product_image_gallery ) );

					if ( ! empty( $attachments ) ) {
						foreach ( $attachments as $attachment_id ) {
							echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
								' . wp_get_attachment_image( $attachment_id, 'thumbnail' ) . '
								<ul class="actions">
									<li><a href="#" class="delete tips" data-tip="' . esc_attr__( '删除图片' ) . '">' . __( '删除' ) . '</a></li>
								</ul>
							</li>';
						}
					}
				?>
			</ul>

			<input type="hidden" id="product_image_gallery" name="product_image_gallery" value="<?php echo esc_attr( $product_image_gallery ); ?>" />

		</div>
		<p class="add_product_images hide-if-no-js">
			<a href="#" data-choose="<?php esc_attr_e( '添加图片到产品相册' ); ?>" data-update="<?php esc_attr_e( '添加到相册' ); ?>" data-delete="<?php esc_attr_e( '删除图片' ); ?>" data-text="<?php esc_attr_e( '删除' ); ?>"><?php _e( '添加到产品相册' ); ?></a>
		</p>
		<?php
    }

}


