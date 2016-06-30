<?php
/*
Plugin Name: Set Password on Multisite Blog Creation
Plugin URI: http://premium.wpmudev.org/project/set-password-on-wordpress-mu-blog-creation/
Description: Set Password on WordPress Multisite Blog Creation
Author: WPMU DEV
Version: 1.1.2.3
Author URI: http://premium.wpmudev.org/
Network: true
WDP ID: 35
Text Domain: signup_password
*/

/*
Copyright 2007-20014 Incsub (http://incsub.com)
Author - S H Mohanjith
Contributors - Andrew Billits

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

global $signup_password_form_printed;
//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//
$signup_password_use_encryption = 'yes'; //Either 'yes' OR 'no'
$signup_password_form_printed = 0;
//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('init', 'wpmu_signup_password_init');
add_action('template_redirect', 'wpmu_signup_password_init_sessions');
add_action('wp_footer', 'wpmu_signup_password_stylesheet');
add_action('signup_extra_fields', 'wpmu_signup_password_fields');
add_filter('wpmu_validate_user_signup', 'wpmu_signup_password_filter');
add_filter('signup_blogform', 'wpmu_signup_password_fields_pass_through');
add_filter('add_signup_meta', 'wpmu_signup_password_meta_filter',99);
add_filter('random_password', 'wpmu_signup_password_random_password_filter');

add_action('wp_ajax_stacktech-verify-blogname-ajax', 'stacktech_verify_blogname_ajax');
add_action('wp_ajax_nopriv_stacktech-verify-blogname-ajax', 'stacktech_verify_blogname_ajax');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//
function stacktech_verify_blogname_ajax(){
	global $wpdb, $domain;

	$blogname = $_POST['blogname'];
	$error = '';
	$current_site = get_current_site();
	$base = $current_site->path;
	$user = '';

	if ( is_user_logged_in() )
		$user = wp_get_current_user();

	if ( preg_match( '/[^a-z0-9]+/', $blogname ) )
		$error = __( 'Only lowercase letters (a-z) and numbers are allowed.' );

	if ( strlen( $blogname ) < 4 && !is_super_admin() )
		$error = __( 'Site name must be at least 4 characters.' );

	if ( strpos( $blogname, '_' ) !== false )
		$error = __( 'Sorry, site names may not contain the character &#8220;_&#8221;!' );
	if ( preg_match( '/^[0-9]*$/', $blogname ) )
		$error = __( 'Sorry, site names must have letters too!' );

	// Check if the domain/path has been used already.
	if ( is_subdomain_install() ) {
		$mydomain = $blogname . '.' . preg_replace( '|^www\.|', '', $domain );
		$path = $base;
	} else {
		$mydomain = "$domain";
		$path = $base.$blogname.'/';
	}
	if ( domain_exists($mydomain, $path, $current_site->id) )
		$error = __( 'Sorry, that site already exists!' );

	if ( username_exists( $blogname ) ) {
		if ( ! is_object( $user ) || ( is_object($user) && ( $user->user_login != $blogname ) ) )
			$error = __( 'Sorry, that site is reserved!' );
	}

	// Has someone already signed up for this domain?
	$signup = $wpdb->get_row( $wpdb->prepare("SELECT * FROM $wpdb->signups WHERE domain = %s AND path = %s", $mydomain, $path) ); // TODO: Check email too?
	if ( ! empty($signup) ) {
		$diff = current_time( 'timestamp', true ) - mysql2date('U', $signup->registered);
		// If registered more than two days ago, cancel registration and let this signup go through.
		if ( $diff > 2 * DAY_IN_SECONDS )
			$wpdb->delete( $wpdb->signups, array( 'domain' => $mydomain , 'path' => $path ) );
		else
			$error = __( 'That site is currently reserved but may be available in a couple days.' );
	}

	echo $error;
	exit();
}


//trigger error on activation
if ( !is_multisite() ) exit( 'The Signup Password plugin is only compatible with WordPress Multisite.' );

if ( ! function_exists( 'signup_password_init' ) ) {
	function signup_password_init() {
		return wpmu_signup_password_init();
	}
}

function wpmu_signup_password_init() {
	load_plugin_textdomain('signup_password', false, dirname(plugin_basename(__FILE__)).'/languages');
}

if ( ! function_exists( 'signup_password_encrypt' ) ) {
	function signup_password_encrypt() {
		return wpmu_signup_password_encrypt();
	}
}

function wpmu_signup_password_encrypt($data) {
	if(!isset($chars))
	{
	// 3 different symbols (or combinations) for obfuscation
	// these should not appear within the original text
	$sym = array('∂', '•xQ', '|');

	foreach(range('a','z') as $key=>$val)
	$chars[$val] = str_repeat($sym[0],($key + 1)).$sym[1];
	$chars[' '] = $sym[2];

	unset($sym);
	}

	// encrypt
	$data = base64_encode(strtr($data, $chars));
	return $data;

}

if ( ! function_exists( 'signup_password_decrypt' ) ) {
	function signup_password_decrypt() {
		return wpmu_signup_password_decrypt();
	}
}

function wpmu_signup_password_decrypt($data) {
	if(!isset($chars))
	{
	// 3 different symbols (or combinations) for obfuscation
	// these should not appear within the original text
	$sym = array('∂', '•xQ', '|');

	foreach(range('a','z') as $key=>$val)
	$chars[$val] = str_repeat($sym[0],($key + 1)).$sym[1];
	$chars[' '] = $sym[2];

	unset($sym);
	}

	// decrypt
	$charset = array_flip($chars);
	$charset = array_reverse($charset, true);

	$data = strtr(base64_decode($data), $charset);
	unset($charset);
	return $data;
}

if ( ! function_exists( 'signup_password_filter' ) ) {
	function signup_password_filter() {
		return wpmu_signup_password_filter();
	}
}

function wpmu_signup_password_filter($content) {
	$password_1 = isset($_POST['password_1'])?$_POST['password_1']:'';
	$password_2 = isset($_POST['password_2'])?$_POST['password_2']:'';
	if ( !empty( $password_1 )  && $_POST['stage'] == 'validate-user-signup' ) {
		if ( $password_1 != $password_2 ) {
			$content['errors']->add('password_1', __('Passwords do not match.', 'signup_password'));
		}
	}
	return $content;
}

if ( ! function_exists( 'signup_password_meta_filter' ) ) {
	function signup_password_meta_filter() {
		return wpmu_signup_password_meta_filter();
	}
}

function wpmu_signup_password_meta_filter($meta) {
	global $signup_password_use_encryption;

	$password_1 = isset($_POST['password_1'])?$_POST['password_1']:'';
	if ( !empty( $password_1 ) ) {
		if ( $signup_password_use_encryption == 'yes' ) {
			$password_1 = wpmu_signup_password_encrypt($password_1);
		}
		$add_meta = array('password' => $password_1 );
		$meta = array_merge($add_meta, $meta);
	}
	return $meta;
}

if ( ! function_exists( 'signup_password_random_password_filter' ) ) {
	function signup_password_random_password_filter() {
		return wpmu_signup_password_random_password_filter();
	}
}

function wpmu_signup_password_random_password_filter($password) {
	global $wpdb, $signup_password_use_encryption;

	if ( isset($_GET['key']) && ! empty($_GET['key']) ) {
		$key = $_GET['key'];
	} else if ( isset($_POST['key']) && ! empty($_POST['key']) ) {
		$key = $_POST['key'];
	}
	if ( !empty($_POST['password_1']) ) {
		$password = $_POST['password_1'];
	} else if ( !empty( $key ) ) {
		$signup = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM $wpdb->signups WHERE activation_key = '%s'",
				$key
			)
		);
		if ( ! ( empty($signup) || $signup->active ) ) {
			//check for password in signup meta
			$meta = maybe_unserialize($signup->meta);
			if ( !empty( $meta['password'] ) ) {
				if ( $signup_password_use_encryption == 'yes' ) {
					$password = wpmu_signup_password_decrypt($meta['password']);
				} else {
					$password = $meta['password'];
				}
				unset( $meta['password'] );
				$meta = maybe_serialize( $meta );
				$wpdb->update(
					$wpdb->signups,
					array( 'meta' => $meta ),
					array( 'activation_key' => $key ),
					array( '%s' ),
					array( '%s' )
				);
			}

		}
	}
	return $password;
}

//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

if ( ! function_exists( 'signup_password_stylesheet' ) ) {
	function signup_password_stylesheet() {
		return wpmu_signup_password_stylesheet();
	}
}

function wpmu_signup_password_stylesheet() {
	global $signup_password_form_printed;

	if ($signup_password_form_printed) {
?>
<style type="text/css">
	.mu_register #password_1,
	.mu_register #password_2 { width:100%; font-size: 24px; margin:5px 0; }
</style>
<?php
	}
}

if ( ! function_exists( 'signup_password_fields_pass_through' ) ) {
	function signup_password_fields_pass_through() {
		return wpmu_signup_password_fields_pass_through();
	}
}

function wpmu_signup_password_fields_pass_through() {
	global $signup_password_form_printed;

	wp_enqueue_script( 'stacktech-signup-verifyBlog-script', plugin_dir_url( __FILE__ ) . 'verify_signup_blog.js' );
	wp_localize_script( 'stacktech-signup-verifyBlog-script', 'stacktech_obj', array('admin_ajax' => admin_url( 'admin-ajax.php' ) ) );

	if ( !empty( $_POST['password_1'] ) && !empty( $_POST['password_2'] ) ) {
		$signup_password_form_printed = 1;
		?>
		<input type="hidden" name="password_1" value="<?php echo $_POST['password_1']; ?>" />
		<?php
		$_SESSION['password_1'] = $_POST['password_1'];
	} else if (isset($_SESSION['password_1']) && !empty($_SESSION['password_1'])) {
		$signup_password_form_printed = 1;
		?>
		<input type="hidden" name="password_1" value="<?php echo $_SESSION['password_1']; ?>" />
		<?php
	}
}

if ( ! function_exists( 'signup_password_fields' ) ) {
	function signup_password_fields() {
		return wpmu_signup_password_fields();
	}
}

function wpmu_signup_password_fields($errors) {
	global $signup_password_form_printed;

	wp_enqueue_script( 'stacktech-signup-verifyUser-script', plugin_dir_url( __FILE__ ) . 'verify_signup_user.js' );

	if ($errors && method_exists($errors, 'get_error_message')) {
		$error = $errors->get_error_message('password_1');
	} else {
		$error = false;
	}
	$signup_password_form_printed = 1;
	?>
    <label for="password"><?php _e('Password', 'signup_password'); ?>：</label>
		
		<input placeholder="<?php _e('Leave fields blank for a random password to be generated.', 'signup_password') ?>"name="password_1" type="password" id="password_1" value="" autocomplete="off" maxlength="20" /><br />
    <label for="password"><?php _e('Confirm Password', 'signup_password'); ?>：</label>
    <?php 
	if( $error ){
		$error_password = 'error_bg'; 
	}
    ?>
	<input name="password_2" class="<?php echo $error_password;?>" type="password" id="password_2" value="" autocomplete="off" maxlength="20" placeholder="<?php _e('Type your new password again.', 'signup_password') ?>"/><br />
	<?php
    if($error) {
		echo '<p class="error signup_password"><i class="fa fa-exclamation-triangle"></i>' . $error . '</p>';
    }
	?>
	<p class="error signup_password" style="display:none;"><i class="fa fa-exclamation-triangle"></i><?php _e('Passwords do not match.', 'signup_password'); ?></p>
	<?php
}

if ( ! function_exists( 'signup_password_init_sessions' ) ) {
	function signup_password_init_sessions() {
		return wpmu_signup_password_init_sessions();
	}
}

function wpmu_signup_password_init_sessions() {
	if ( is_user_logged_in() ) return;

	if (!session_id()) {
		session_start();
	}
}

global $wpmudev_notices;
$wpmudev_notices[] = array( 'id'=> 35, 'name'=> 'Set Password on Multisite Blog Creation', 'screens' => array() );
include_once( dirname( __FILE__ ) . '/dash-notice/wpmudev-dash-notification.php' );
