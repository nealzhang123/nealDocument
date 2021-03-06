<?php
include_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class Crm_Customer_List extends WP_List_Table {
    public $cate_id;
    public $key_creater,$key_charger,$key_customer,$key_country,$key_province,$key_city,$key_area;

	function __construct( $cate_id ){
        $this->cate_id = $cate_id;

        $this->key_creater  = 'creater';
        $this->key_charger  = 'charger';
        $this->key_customer = 'customer';
        $this->key_country  = 'country';
        $this->key_province = 'province';
        $this->key_city     = 'city';
        $this->key_area     = 'area';
	}

	function get_customer_count(){
        global $wpdb;

        if( empty( $this->cate_id ) ) {
            $customer_table = $wpdb->prefix . 'crm_customer_info';
            $sql = "SELECT count(*) FROM " . $customer_table . " WHERE is_delete=0";
            if( count($_POST) >0 )
                $sql .= " AND customer_name like '%". $_POST['search_text']."%'";

            $count = $wpdb->get_var( $sql );
        }else{
            $category_table = $wpdb->prefix . 'crm_category';
            $sql = "SELECT cate_condition FROM " . $category_table . " WHERE cate_id=" . $this->cate_id;
            $condition = $wpdb->get_val( $sql );

            //分类视图后续。。。
        }

        return $count;

	}

	function get_customer_infos( $per_page = 10 ,$page = 1 ) {
		global $wpdb;

        if( empty( $this->cate_id ) ) {
            $customer_table = $wpdb->prefix . 'crm_customer_info';
            $sql = "SELECT * FROM " . $customer_table . " WHERE is_delete=0";
            if( count($_POST) >0 )
                $sql .= " AND customer_name like '%". $_POST['search_text']."%'";

            $customer = $wpdb->get_results( $sql, 'ARRAY_A' );
        }else{
            $category_table = $wpdb->prefix . 'crm_category';
            $sql = "SELECT cate_condition FROM " . $category_table . " WHERE cate_id=" . $this->cate_id;
            $condition = $wpdb->get_val( $sql );

            //分类视图后续。。。
        }

        return $customer;
	}

    function prepare_items() {

        $per_page = 10;
        $total_count = $this->get_customer_count();
        // $page = isset($_GET['paged']) ? $_GET['paged'] : '1';
        // $page = (int) $page;
        // if ($page <= 0)
        //     $page = 1;

        // if ($page > ceil($total_count / $per_page))
        //     $page = ceil($total_count / $per_page);

        $this->items = $this->get_customer_infos();
        // $this->set_pagination_args( [
        //     'total_items' => $total_count,
        //     'per_page' => $per_page,
        // ] );
        
        $columns = $this->get_columns();
        //echo '<pre>';print_r($columns);echo '</pre>';
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        //echo '<pre>';print_r($this->items);echo '</pre>';
        $this->_column_headers = array($columns, $hidden, $sortable);
    }


    function column_default( $item, $column_name ){
        global $wpdb;

        $form_options = $wpdb->prefix . 'crm_form_options';
        $sql = "SELECT option_id,form_type,special_key FROM " . $form_options . " WHERE model='customer' AND form_name='" . $column_name . "'";

        $customer = $wpdb->get_row( $sql, 'ARRAY_A' );

        switch ( $customer['form_type'] ) {
            case 'select':
                $form_values = $wpdb->prefix . 'crm_form_option_value';
                $sql = "SELECT option_value FROM " . $form_values . " WHERE option_id=" . $customer['option_id'] . " AND option_key='" . $item[$column_name] . "'";

                $option_value = $wpdb->get_var( $sql );
                return $option_value;
                break;

            case 'special':
                switch ( $customer['special_key'] ) {
                    case $this->key_creater:
                    case $this->key_charger:
                        $user = get_user_by( 'id', $item[$column_name] );
                        $option_value = $user->display_name;
                        return $option_value;
                        break;
                    
                    default:
                        //$option_value = $item[$column_name];
                        break;
                }
            
            default:
                $option_value = $item[$column_name];
                return $option_value;
                break;
        }
    }

    function column_customer_name( $item ) {
        echo '<a href="'.admin_url( 'admin.php?page=crm_edit_model&model=customer&pid='.$item['customer_id'] ).'" target="_blank">'.$item['customer_name'].'</i></a>';
    }

    function get_hidden_columns(){
        return array();
    }

    function no_items() {
        echo __('没有相关数据');
    }

    function get_columns() {
        global $wpdb;

        $customer_form = array();

        if( empty( $this->cate_id ) ) {
            $form_options = $wpdb->prefix . 'crm_form_options';
            $sql = "SELECT * FROM " . $form_options . " WHERE model='customer'";

            $customer_form = $wpdb->get_results( $sql, 'ARRAY_A' );
        }else{
            $category_table = $wpdb->prefix . 'crm_category';
            $sql = "SELECT show_fields FROM " . $category_table . " WHERE cate_id=" . $this->cate_id;
            $show_fields = $wpdb->get_val( $sql );

            //分类视图后续。。。
        }

        $i = 0;
        $columns = array();
        $columns['cb'] = '<input type="checkbox" />';

        foreach ($customer_form as $option) {
            if( $i == 10 )
                break;

            $columns[$option['form_name']] = $option['title'];
            $i++;
        }

        $columns['tools'] = '编辑 | 删除';
    	
        return $columns;
    }

    function column_tools( $item ) {
        echo '<a href="'.admin_url( 'admin.php?page=crm_edit_model&model=customer&pid='.$item['customer_id'] ).'" target="_blank"><i class="fa fa-pencil-square-o"></i></a>';
        echo '&nbsp;|&nbsp;';
        echo '<a class="list_item_delete" data-pid="'.$item['customer_id'].'"><i class="fa fa-trash-o"></i></a>';
    }

    function column_cb( $item ) {
        return sprintf('<input type="checkbox" name="bulk-delete[]" value="%s" />', $item['customer_id']);
    }

    function column_next_contact_time( $item ) {
        echo date( 'Y-m-d H:i:s', strtotime( $item['next_contact_time'] ) );
    }
}

?>