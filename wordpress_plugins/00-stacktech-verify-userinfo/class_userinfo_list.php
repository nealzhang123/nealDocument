<?php
include_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class Stacktech_Verify_Userinfo_Table extends WP_List_Table {

    private $main;
    private $vfu_wb;

    public function __construct() {//$main
        $this->vfu_wb = new VerifyUserinfoDb();
        // parent::__construct(array('screen' => 'login-redirect'));
        // $this->main = $main;
    }

    function prepare_items() {
        // $search = NULL;
        // if (function_exists('wp_unslash'))
        //     $search = isset($_REQUEST['s']) ? wp_unslash(trim($_REQUEST['s'])) : '';
        // else
        //     $search = isset($_REQUEST['s']) ? trim($_REQUEST['s']) : '';
        $per_page = 10;
        //$count = $this->vfu_wb->count($search);
        $total_count = $this->vfu_wb->get_userinfos_count();
        $page = isset($_GET['paged']) ? $_GET['paged'] : '1';
        $page = (int) $page;
        if ($page <= 0)
            $page = 1;

        if ($page > ceil($total_count / $per_page))
            $page = ceil($total_count / $per_page);

        $this->items = $this->vfu_wb->get_userinfos($per_page ,$page);
        $this->set_pagination_args( [
            'total_items' => $total_count,
            'per_page' => $per_page,
        ] );
        
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        //echo '<pre>';print_r($this->items);echo '</pre>';
        $this->_column_headers = array($columns, $hidden, $sortable);
    }

    // function get_bulk_actions() {
    //     // $actions = [
    //     //     'bulk-delete' => 'Delete'
    //     // ];

    //     // return $actions;
    // }

    function column_default( $item, $column_name ){
        switch ( $column_name ) {
            case 'id':
            case 'user_id':
            case 'user_email':
            case 'verify_style':
            case 'user_type':
            case 'user_action':
            case 'status':
            case 'time':
              return $item[ $column_name ];
            default:
              return print_r( $item, true ); //Show the whole array for troubleshooting purposes
        }
    }

    function column_user_email($item){
        $user_email = get_user_option('user_email',$item['user_id']);
        
        return $user_email;
    }

    function column_status($item){
        switch ($item['status']) {
            case 'verifying_info':
                $content = '<i class="fa fa-eye fa-1x" style="color:#f57403;"></i>'.__(' 审核用户资料');
                break;
            case 'verify_info_fail':
                $content = '<i class="fa fa-exclamation-triangle fa-1x" style="color:red;"></i>'.__(' 用户资料不完整');
                break;
            case 'verify_info_success':
                $content = '<i class="fa fa-check-circle fa-1x" style="color:green;"></i>'.__(' 用户资料审核通过');
                break;
            case 'fill_bank':
                $transfer_money = get_user_meta( $item['user_id'],'transfer_money',true );
                $money_content = '(金额'.$transfer_money .')';
                
                $content = '<i class="fa fa-hourglass-start fa-1x" style="color:#f57403;"></i>'.__(' 确认用户账号') . $money_content;
                break;
            case 'verify_bank_fail':
                $content = '<i class="fa fa-exclamation-triangle fa-1x" style="color:red;"></i>'.__(' 用户账号错误');
                break;
            case 'verify_success':
                $content = '<i class="fa fa-check-circle fa-1x" style="color:green;"></i>'.__(' 全部信息审核通过');
                break;
            default:
                $content = '';
                break;
        }
        $verify_url = network_admin_url( 'admin.php?page=verifying_info&user_id=' . $item['user_id'] );
        $content .= '&nbsp;&nbsp;&nbsp;<a href="' . $verify_url . '">' . __('审核') . '</a>';

        return $content;
    }

    function column_user_type($item){
        switch ($item['user_type']) {
            case 0:
                $content = __('用户');
                break;
            case 1:
                $content = __('代理');
                break;
            case 2:
                $content = __('开发者');
                break;
            case 3:
                $content = __('代理+开发者');
                break;
            
            default:
                $content = '';
                break;
        }
        return $content;
    }

    function column_user_action($item){
        switch ($item['user_action']) {
            case 1:
                $content = __('申请代理');
                break;
            case 2:
                $content = __('申请开发者');
                break;
            
            default:
                $content = '';
                break;
        }
        return $content;
    }

    function column_verify_style($item){
        switch ($item['verify_style']) {
            case 'personal':
                $content = __('个人认证');
                break;
            case 'company':
                $content = __('公司认证');
                break;
            
            default:
                $content = '';
                break;
        }
        return $content;
    }

    function get_hidden_columns(){
        return array();
    }

    function no_items() {
        //echo $this->main->__('No login redirects found.');
    }

    function get_views() {
        // $role_links = array();

        // return $role_links;
    }

    function get_columns() {
        $columns = array(
            'id' => 'id',
            'user_id' => 'user_id',
            'user_email' => 'user_email',
            'user_type' => 'user_type',
            'user_action' => 'user_action',
            'verify_style' => 'verify_style',
            'status' => 'status',
            'time' => 'time'
        );

        return $columns;
    }

    function get_sortable_columns() {
        return array(
            'time' => array('time',true)
        );
    }

}

?>