<?php
/*
Plugin Name: 00 Stakctech CDN Rewrite
Plugin URI: http://www.etongapp.com
Description: replace the url of  css,js...files with cdn url
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/

/* Check & Quit */
defined('ABSPATH') OR exit;

/* constants */
define('CDN_ENABLER_FILE', __FILE__);
define('CDN_ENABLER_DIR', dirname(__FILE__));
define('CDN_ENABLER_BASE', plugin_basename(__FILE__));
define('CDN_ENABLER_MIN_WP', '3.8');

/* loader */
add_action('plugins_loaded', array('CDN_Enabler_Stacktech', 'instance'));
/* uninstall */
//register_uninstall_hook( __FILE__, array('CDN_Enabler_Stacktech', 'handle_uninstall_hook'));
/* activation */
register_activation_hook(__FILE__, array('CDN_Enabler_Stacktech', 'handle_activation_hook'));


class CDN_Enabler_Stacktech
{


  /**
  * pseudo-constructor
  *
  * @since   0.0.1
  * @change  0.0.1
  */

  public static function instance()
  {
    new self();
  }


  /**
  * constructor
  *
  * @since   0.0.1
  * @change  0.0.1
  */

  public function __construct()
  {
     /* CDN rewriter hook */
    add_action('init', array(__CLASS__,'handle_rewrite_hook'));
    /* Hooks */
    add_action('admin_init',          array('CDN_Enabler_Settings_Stacktech', 'register_settings'));
    add_action('network_admin_menu',  array('CDN_Enabler_Settings_Stacktech', 'add_settings_page'));
    /* admin notices */
    add_action('all_admin_notices',   array(__CLASS__, 'cdn_enabler_requirements_check'));

    /* Filter */
    if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) OR (defined('DOING_CRON') && DOING_CRON) OR (defined('DOING_AJAX') && DOING_AJAX) OR (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) ) {
      //return;
    }

  }

  /**
  * run uninstall hook
  *
  * @since   0.0.1
  * @change  0.0.1
  */

  public static function handle_uninstall_hook()
  {
        delete_site_option('cdn_enabler');
        delete_site_option('oss_options');
  }


  /**
  * run activation hook
  *
  * @since   0.0.1
  * @change  1.0.2
  */

  public static function handle_activation_hook() {
        add_site_option(
            'cdn_enabler',
            array(
                'url' => untrailingslashit(get_site_option('siteurl')),
                'dirs' => 'wp-content,wp-includes',
                'excludes' => '.php',
                'relative' => '1',
                'https' => ''
            )
        );
        $options = array(
          // 'bucket' => "",
          // 'ak' => "",
          // 'sk' => "",
          // 'host' => "oss.aliyuncs.com",
          'nothumb' => "false",
          'nolocalsaving' => "false",
          // 'upload_url_path' => "",
        );
    
        add_site_option('oss_options', $options, '', 'yes');
  }


  /**
  * check plugin requirements
  *
  * @since   0.0.1
  * @change  0.0.1
  */

  public static function cdn_enabler_requirements_check() {
    // WordPress version check
    if ( version_compare($GLOBALS['wp_version'], CDN_ENABLER_MIN_WP.'alpha', '<') ) {
      show_message(
        sprintf(
          '<div class="error"><p>%s</p></div>',
          sprintf(
            __("CDN Enabler is optimized for WordPress %s. Please disable the plugin or upgrade your WordPress installation (recommended).", "cdn"),
            CDN_ENABLER_MIN_WP
          )
        )
      );
    }
  }


  /**
  * return plugin options
  *
  * @since   0.0.1
  * @change  1.0.2
  *
  * @return  array  $diff  data pairs
  */

  public static function get_site_options()
  {
    return wp_parse_args(
      get_site_option('cdn_enabler'),
      array(
                'url' => untrailingslashit(get_site_option('siteurl')),
                'dirs' => 'wp-content,wp-includes',
                'excludes' => '.php',
                'relative' => 1,
                'https' => 0
      )
    );
  }


    /**
  * run rewrite hook
  *
  * @since   0.0.1
  * @change  1.0.2
  */

    public static function handle_rewrite_hook()
    {
      if( is_admin()){
       //return false;
      }
        $options = self::get_site_options();

        // check if origin equals cdn url
        if (get_option('home') == $options['url']) {
        return;
      }

        $excludes = array_map('trim', explode(',', $options['excludes']));

      $rewriter = new CDN_Enabler_Rewriter_Stacktech(
        get_option('home'),
        $options['url'],
        $options['dirs'],
        $excludes,
        $options['relative'],
        $options['https']
      );
      ob_start(
            array(&$rewriter, 'rewrite')
        );
    }

}

class CDN_Enabler_Settings_Stacktech
{


  /**
  * register settings
  *
  * @since   0.0.1
  * @change  0.0.1
  */

  public static function register_settings(){
    register_setting('cdn_enabler', 'cdn_enabler', array(__CLASS__, 'validate_settings'));
  }

  /**
  * validation of settings
  *
  * @since   0.0.1
  * @change  0.0.1
  *
  * @param   array  $data  array with form data
  * @return  array         array with validated values
  */

  public static function validate_settings($data)
  {
    return array(
      'url'   => esc_url($data['url']),
      'dirs'    => esc_attr($data['dirs']),
      'excludes'  => esc_attr($data['excludes']),
      'relative'  => (int)($data['relative']),
      'https'   => (int)($data['https'])
    );
  }


  /**
  * add settings page
  *
  * @since   0.0.1
  * @change  0.0.1
  */

  public static function add_settings_page(){
    add_menu_page('CDN Enabler', 'CDN Enabler', 'manage_options', 'cdn_enabler', array(__CLASS__, 'settings_page'), 'dashicons-admin-generic', 6 );
  }


  /**
  * settings page
  *
  * @since   0.0.1
  * @change  0.0.1
  *
  * @return  void
  */

  public static function settings_page(){ 
    if($_POST){
      // print_r($_POST);
      update_site_option(
          'cdn_enabler',
          array(
              'url'       => $_POST['cdn_enabler_url'],
              'dirs'      => $_POST['cdn_enabler_dirs'],
              'excludes'  => $_POST['cdn_enabler_excludes'],
              'relative'  => $_POST['cdn_enabler_relative'],
              'https'     => $_POST['cdn_enabler_https']
          )
      );
      update_site_option(
        'oss_options', 
        array(
          'nothumb'       => $_POST['nothumb']?'true':'false',
          'nolocalsaving' => $_POST['nolocalsaving']?'true':'false'
        )
      );
      $upload_path = OSS_CDN_UPLOAD_PATH;
      update_site_option('upload_path', $upload_path );
      $upload_url_path = OSS_CDN_UPLOAD_URL_PATH;
      update_site_option('upload_url_path', $upload_url_path );
    }
    
    // $options_oss = array();
    // if($_POST['nothumb']) {
      // $options_oss['nothumb'] = (isset($_POST['nothumb']))?'true':'false';
    // }
    // if($_POST['nolocalsaving']) {
      // $options_oss['nolocalsaving'] = (isset($_POST['nolocalsaving']))?'true':'false';
    // }
    // if($options_oss !== array() ){
      //更新数据库oss
      // update_site_option('oss_options', $options_oss);
     
    // }
    

?>
    <div class="wrap">
      <h2>
        <?php _e("CDN Enabler Settings", "cdn"); ?>
      </h2>

      <form method="post" action="?page=cdn_enabler">
        

        <?php 

          $options = CDN_Enabler_Stacktech::get_site_options();
          $oss_options = get_site_option('oss_options', TRUE);
          $upload_path = OSS_CDN_UPLOAD_PATH;
          $upload_url_path = OSS_CDN_UPLOAD_URL_PATH;
          $oss_nothumb = attribute_escape($oss_options['nothumb']);
          $oss_nothumb = ( $oss_nothumb == 'true' );
        
          $oss_nolocalsaving = attribute_escape($oss_options['nolocalsaving']);
          $oss_nolocalsaving = ( $oss_nolocalsaving == 'true' );

        ?>

        <table class="form-table">

          <tr valign="top">
            <th scope="row">
              <?php _e("CDN URL", "cdn"); ?>
            </th>
            <td>
              <fieldset>
                <label for="cdn_enabler_url">
                  <input type="text" name="cdn_enabler_url" id="cdn_enabler_url" value="<?php echo $options['url']; ?>" size="64" class="regular-text code" />
                  <?php _e("", "cdn"); ?>
                </label>

                <p class="description">
                  <?php _e("Enter the CDN URL without trailing", "cdn"); ?> <code>/</code>
                </p>
              </fieldset>
            </td>
          </tr>

          <tr valign="top">
            <th scope="row">
              <?php _e("Included Directories", "cdn"); ?>
            </th>
            <td>
              <fieldset>
                <label for="cdn_enabler_dirs">
                  <input type="text" name="cdn_enabler_dirs" id="cdn_enabler_dirs" value="<?php echo $options['dirs']; ?>" size="64" class="regular-text code" />
                  <?php _e("Default: <code>wp-content,wp-includes</code>", "cdn"); ?>
                </label>

                <p class="description">
                  <?php _e("Assets in these directories will be pointed to the CDN URL. Enter the directories separated by", "cdn"); ?> <code>,</code>
                </p>
              </fieldset>
            </td>
          </tr>

          <tr valign="top">
            <th scope="row">
              <?php _e("Excluded Extensions", "cdn"); ?>
            </th>
            <td>
              <fieldset>
                <label for="cdn_enabler_excludes">
                  <input type="text" name="cdn_enabler_excludes" id="cdn_enabler_excludes" value="<?php echo $options['excludes']; ?>" size="64" class="regular-text code" />
                  <?php _e("Default: <code>.php</code>", "cdn"); ?>
                </label>

                <p class="description">
                  <?php _e("Enter the exclusions separated by", "cdn"); ?> <code>,</code>
                </p>
              </fieldset>
            </td>
          </tr>

          <tr valign="top">
            <th scope="row">
              <?php _e("Relative Path", "cdn"); ?>
            </th>
            <td>
              <fieldset>
                <label for="cdn_enabler_relative">
                  <input type="checkbox" name="cdn_enabler_relative" id="cdn_enabler_relative" value="1" <?php checked(1, $options['relative']) ?> />
                  <?php _e("Enable CDN for relative paths (default: enabled).", "cdn"); ?>
                </label>

                <p class="description">
                  <?php _e("", "cdn"); ?>
                </p>
              </fieldset>
            </td>
          </tr>

          <tr valign="top">
            <th scope="row">
              <?php _e("CDN HTTPS", "cdn"); ?>
            </th>
            <td>
              <fieldset>
                <label for="cdn_enabler_https">
                  <input type="checkbox" name="cdn_enabler_https" id="cdn_enabler_https" value="1" <?php checked(1, $options['https']) ?> />
                  <?php _e("Enable CDN for HTTPS connections (default: disabled).", "cdn"); ?>
                </label>

                <p class="description">
                  <?php _e("", "cdn"); ?>
                </p>
              </fieldset>
            </td>
          </tr>

        </table>
        <h2>阿里云附件 v2.0 设置</h2>
        <table class="form-table">
          <tr>
            <th><legend>不上传缩略图</legend></th>
            <td><input type="checkbox" name="nothumb" <?php if($oss_nothumb) echo 'checked="TRUE"';?> /></td>
          </tr>
          <tr>
            <th><legend>不在本地保留备份</legend></th>
            <td><input type="checkbox" name="nolocalsaving" <?php if($oss_nolocalsaving) echo 'checked="TRUE"';?> /></td>
          </tr>
        </table>

       <input type="submit" name="submit" value="Save" class="button-primary" >
      </form>
    </div><?php
  }
}



class CDN_Enabler_Rewriter_Stacktech
{
  var $blog_url = null; // origin URL
  var $cdn_url = null; // CDN URL

  var $dirs = null; // included directories
  var $excludes = array(); // excluded extensions
  var $relative = false; // use CDN on relative paths
  var $https = false; // use CDN on HTTPS

    /**
  * constructor
  *
  * @since   0.0.1
  * @change  0.0.1
  */

  function __construct($blog_url, $cdn_url, $dirs, array $excludes, $relative, $https) {
    $this->blog_url = $blog_url;
    $this->cdn_url = $cdn_url;
    $this->dirs = $dirs;
    $this->excludes = $excludes;
    $this->relative = $relative;
    $this->https = $https;
  }


    /**
    * excludes assets that should not rewritten
    *
    * @since   0.0.1
    * @change  0.0.1
    *
    * @param   string  $asset  current asset
    * @return  boolean  true if need to be excluded
    */

  protected function exclude_asset(&$asset) {
    foreach ($this->excludes as $exclude) {
      if (!!$exclude && stristr($asset, $exclude) != false) {
        return true;
      }
    }
    return false;
  }


    /**
    * rewrite url
    *
    * @since   0.0.1
    * @change  0.0.1
    *
    * @param   string  $asset  current asset
    * @return  string  updated url if not excluded
    */

    protected function rewrite_url($asset) {
    if ($this->exclude_asset($asset[0])) {
      return $asset[0];
    }
    $blog_url = $this->blog_url;

        // check if not a relative path
    if (!$this->relative || strstr($asset[0], $blog_url)) {
      return str_replace($blog_url, $this->cdn_url, $asset[0]);
    }

    return $this->cdn_url . $asset[0];
  }


    /**
    * get directory scope
    *
    * @since   0.0.1
    * @change  0.0.1
    *
    * @return  string  directory scope
    */

  protected function get_dir_scope() {
    $input = explode(',', $this->dirs);

        // default
    if ($this->dirs == '' || count($input) < 1) {
      return 'wp\-content|wp\-includes';
    }

    return implode('|', array_map('quotemeta', array_map('trim', $input)));
  }


    /**
    * rewrite url
    *
    * @since   0.0.1
    * @change  1.0.1
    *
    * @param   string  $html  current raw HTML doc
    * @return  string  updated HTML doc with CDN links
    */

  public function rewrite($html) {
        // check if HTTPS and use CDN over HTTPS enabled
    if (!$this->https && isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on') {
      return $html;
    }

        // get dir scope in regex format
    $dirs = $this->get_dir_scope();
        $blog_url = quotemeta($this->blog_url);

    // regex rule start
    $regex_rule = '#(?<=[(\"\'])';

        // check if relative paths
        if ($this->relative) {
            $regex_rule .= '(?:'.$blog_url.')?';
        } else {
      $regex_rule .= $blog_url;
    }

        // regex rule end
    $regex_rule .= '/(?:((?:'.$dirs.')[^\"\')]+)|([^/\"\']+\.[^/\"\')]+))(?=[\"\')])#';

        // call the cdn rewriter callback
    $cdn_html = preg_replace_callback($regex_rule, array(&$this, 'rewrite_url'), $html);

    return $cdn_html;
  }
}
require_once("url-edit.php");
