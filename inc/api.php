<?php 

function internal_api_frequent_messaging($data){
  $subs = subs_list();
  foreach ($subs as $key => $sub_data) {
      send_unsent_queried_msgs($key) ;
  }
}

function reset_daily_msgs_counter(){
  $subs = get_posts( 
    array(
        'numberposts' => -1,
        'post_type'   => 'shop_subscription',
        'post_status' => 'all'
    )
  );
  foreach ($subs as $k => $sub_data) {
      $sub =  $sub_data->ID;
      update_post_meta( $sub ,'available_daily_msgs', daily_msgs );
  }
}
function internal_api_compose_messages_handler($data){
  return compose_messages_handler();
}