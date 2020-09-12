<?php

function create_custom_msgs_table($sub) {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
    $table_name = get_msgs_table_name($sub);
    
    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT ,
        mobile_number VARCHAR(20) NOT NULL ,
        msg_body VARCHAR(2000) NOT NULL ,
        msg_type VARCHAR(2000) NOT NULL ,
        msg_caption VARCHAR(2000) NOT NULL ,
        is_sent TINYINT(1) NOT NULL ,
        note VARCHAR(255) NOT NULL ,
        source TINYINT(1) NOT NULL ,
        status TINYINT(1) NOT NULL ,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
	)"; $charset_collate;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}
function create_sessions_table($sub) {
    /*
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
    $table_name = get_sessions_name($sub);
    
    $sql = "CREATE TABLE $table_name (
        id INT(11) NOT NULL AUTO_INCREMENT ,
        mobileNumber VARCHAR(20) NOT NULL ,
        textMessage VARCHAR(2000) NOT NULL ,
        isSent TINYINT(1) NOT NULL ,
        note VARCHAR(255) NOT NULL ,
        source TINYINT(1) NOT NULL ,
        status TINYINT(1) NOT NULL ,
        createdAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ,
        updatedAt DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (id)
	)"; $charset_collate;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    */
}
function get_msgs_table_name($sub){
    return slug."_msgs_".$sub;
}
function get_table_name($sub,$table){
    return slug."_".$table."_".$sub;
}
function get_sessions_name($sub){
    return slug."_sessions_".$sub;
}
function subs_option_field_name()
{
    return slug . "_subs";
}
function subs_option_field_value(){
    return get_option(subs_option_field_name());
}
function subs_option_field_array(){
    return json_decode(subs_option_field_value() , true);
}
function add_sub_to_blog($blog,$sub){
    switch_to_blog($blog);
    $option_name   =  subs_option_field_name();
    $current_value =  get_option( $option_name );

    $slug =  rand_sub_code($sub) ; 

    if ( $current_value !== false ) {
        $new_value   = json_decode($current_value,true);
        $new_value[$slug] = array('id'=> $sub ,'slug' => $slug);
        $new_value = json_encode($new_value);
        update_option($option_name,$new_value);
    }else {     
        $deprecated = null;
        $autoload   = 'no';
        $new_value[$slug]  = array('id'=> $sub ,'slug' => $slug );
        $new_value  = json_encode($new_value);
        add_option($option_name,$new_value,$deprecated,$autoload);
    }    
    restore_current_blog();
    return $slug; 
}
function related_msgs_table(){
    $sub    =  get_page_sub_id();
    return get_msgs_table_name($sub);
}
function related_sub_id($slug)
{
    $subs =  subs_option_field_array();
    foreach ($subs as $key => $sub) {
        if(is_array($sub) &&  $sub['slug'] ==  $slug ){
            return  $sub['id'];
        }
    }
    return ;
}

function do_insert($place_holders, $values) {

    global $wpdb;

    $query           = "INSERT INTO settings-table (`option_name`, `option_value`, `option_created`, `option_edit`, `option_user`) VALUES ";
    $query           .= implode( ', ', $place_holders );
    $sql             = $wpdb->prepare( "$query ", $values );

    if ( $wpdb->query( $sql ) ) {
        return true;
    } else {
        return false;
    }

}

$data_to_be_inserted = array( 
    array(
        'option_name'   => 'name-1', 
        'option_value'  => 'val-1', 
        'option_created'=> current_time('mysql'),
        'option_edit'   => current_time('mysql'),
        'option_user'   => 'user-1' 
    ),
    array(
        'option_name'   => 'name-2', 
        'option_value'  => 'val-2', 
        'option_created'=> current_time('mysql'),
        'option_edit'   => current_time('mysql'),
        'option_user'   => 'user-2' 
    ),
    array(
        'option_name'   => 'name-1', 
        'option_value'  => 'val-3', 
        'option_created'=> current_time('mysql'),
        'option_edit'   => current_time('mysql'),
        'option_user'   => 'user-3'
    )
);

$values = $place_holders = array();

if(count($data_to_be_inserted) > 0) {
    foreach($data_to_be_inserted as $data) {
        array_push( $values, $data['option_name'], $data['option_value'], $data['option_created'], $data['option_edit'], $data['option_user']);
        $place_holders[] = "( %s, %s, %s, %s, %s)";
    }

    do_insert( $place_holders, $values );
}