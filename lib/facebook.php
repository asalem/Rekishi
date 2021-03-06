
<?php
  try {
    $me = $facebook->api('/me');
    date_default_timezone_set('Asia/Calcutta');
    $lastyearSameday = strtotime('-1 year');
    $lastyearNextday = strtotime('-1 year +7 day');
    $params = array(
        'method' => 'fql.query',
        'query' => 'SELECT created_time,message,description,share_count, like_info, type, attachment,permalink,action_links,post_id  FROM stream WHERE source_id='.$me["id"].' and created_time>'.$lastyearSameday.' AND created_time<'.$lastyearNextday.' LIMIT 1000'
    );
    $posts = $facebook->api($params);
    $me = $facebook->api("/me", array("fields"=>'picture'));
    $obj = new StdClass;
    $obj->me = $me;
    $obj->posts = $posts;
  } 
  
  catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
  echo json_encode($obj);