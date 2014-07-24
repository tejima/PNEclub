<?php
require_once 'twitteroauth/twitteroauth.php';

$consumer_key = 'ANY2AbUdw0itapdkdXEdmVqi4';
$consumer_secret = 'QZefgPLiUgrDHFtO1ZMGeWfnqYXK6ekLgb2nTq7KZYjZuagLBk';
$access_token = '261665320-d4FqnxJJG60XfIuXKMHajenkA7xssuXrSCv2ZYaf';
$access_token_secret = 'otI1d7CmNJfMj5x9w7X0SK1DbNEzcFtsqYw5USZRlF6ob';

$tw_obj = new TwitterOAuth (
  $consumer_key,
  $consumer_secret,
  $access_token,
  $access_token_secret);

$rest_api = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$method = 'GET';
$options = array (
  'screen_name'=> 'sho_qu',
  'count'=> 100,
  'include_entities'=> true);

$tw_obj_request = $tw_obj->OAuthRequest (
  $rest_api,
  $method,
  $options);

$tw_obj_request_json = json_decode($tw_obj_request, true);
$count=0;
$images=array();
foreach ($tw_obj_request_json as $item) {
  $url = $item['entities']['media'][0]['media_url'];
  $hashtag = $item['entities']['hashtags'][0]['text'];
  if($url and $hashtag=="活動風景"){
    $images[$count]=array("name" => $url);
    $count++;
  }
  if($count > 3){
    break;
  }
}
$images  = json_encode($images,JSON_UNESCAPED_SLASHES);
?>
