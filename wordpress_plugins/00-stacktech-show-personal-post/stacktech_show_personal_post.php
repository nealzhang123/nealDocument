<?php
/*
Plugin Name: 00 stacktech show personal post
Plugin URI: http://www.etongapp.com
Description: show private product for developer
Version: 1.0
Author: Stacktech
Author URI: http://www.etongapp.com
License: GPL
*/

class ShowPersonalPost{
    
    function posts_for_current_author($query){
        global $pagenow;
        if( 'edit.php' != $pagenow || !$query->is_admin || 'stacktech_product' != $query->query['post_type'] )
            return $query;

        if( !current_user_can( 'manage_options' ) ) {
            global $user_ID;
            $query->set('author', $user_ID );
            add_filter( 'wp_count_posts', array( 'ShowPersonalPost' ,'fix_count_orders') ,20 ,2 );
        }

        return $query;
    }

    function fix_count_orders( $counts, $type ) {
        global $wpdb;

        $query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";
        $query .= $wpdb->prepare( " AND post_author = %d", get_current_user_id() );
        $query .= ' GROUP BY post_status';

        $results = (array) $wpdb->get_results( $wpdb->prepare( $query, $type ), ARRAY_A );
        $counts = array_fill_keys( get_post_stati(), 0 );

        foreach ( $results as $row ) {
            $counts[ $row['post_status'] ] = $row['num_posts'];
        }

        return (object) $counts;
    }
}

add_filter( 'pre_get_posts', array( 'ShowPersonalPost' ,'posts_for_current_author') ,10 ,2 );