<?php
require_once 'twitteroauth/twitteroauth.php';
require_once 'fuzzy_time.php';

$consumer_key = 'ANY2AbUdw0itapdkdXEdmVqi4';
$consumer_secret = 'QZefgPLiUgrDHFtO1ZMGeWfnqYXK6ekLgb2nTq7KZYjZuagLBk';
$access_token = '261665320-d4FqnxJJG60XfIuXKMHajenkA7xssuXrSCv2ZYaf';
$access_token_secret = 'otI1d7CmNJfMj5x9w7X0SK1DbNEzcFtsqYw5USZRlF6ob';

$tw_obj = new TwitterOAuth (
  $consumer_key,
  $consumer_secret,
  $access_token,
  $access_token_secret);

//募集案内のツイート取得
$rest_api1 = 'https://api.twitter.com/1.1/search/tweets.json';
$method1 = 'GET';
$options1 = array (
  'q'=>'乙女の工作部',
  'result_type'=>'recent',
  'count'=> 5,
  'include_entities'=> true);

$tw_obj_request1 = $tw_obj->OAuthRequest (
  $rest_api1,
  $method1,
  $options1);

$tw_obj_request_json1 = json_decode($tw_obj_request1, true);
$tweets=array();
$i=0;
foreach ($tw_obj_request_json1['statuses'] as $item) {
  $tweet_id = $item['id_str'];
  $created_at = $item['created_at'];
  $datetime = date('Y-m-d H:i:s', strtotime($created_at));
  $datetime = convert_to_fuzzy_time($datetime);
  $text = $item['text'];
  foreach($item['entities']['hashtags'] as $tags){
    $text = str_replace("#".$tags['text'] , '<a href="https://twitter.com/search?q=%23'.$tags['text'].'&src=hash">#'.$tags['text'].'</a>' , $text);
  }
  foreach($item['entities']['urls'] as $urls){
    $text = str_replace($urls['url'] , '<a href="'.$urls['expanded_url'].'">'.$urls['url'].'</a>' , $text);
  }
  foreach($item['entities']['user_mentions'] as $mentions){
    $text = str_replace("@".$mentions['screen_name'] , '<a href="https://twitter.com/'.$mentions['screen_name'].'">@'.$mentions['screen_name'].'</a>' , $text);
  }
  foreach($item['entities']['media'] as $media){
    $text = str_replace($media['url'] , '<br/><div class="text-img"><a href="'.$media['media_url'].'"><img src="'.$media['media_url'].'"></a></div>' , $text);
  }
  $text = str_replace("\n","<br>",$text);
  $name = $item['user']['name'];
  $screen_name = $item['user']['screen_name'];
  $tweet=array("tweet_id"=>$tweet_id,"datetime"=>$datetime,"text"=>$text,"screen_name"=>$screen_name,"name"=>$name);
  $tweet_list[$i]=$tweet;
  //print_r($item['entities']);
  $i++;
}

//活動風景取得
$rest_api2 = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$method2 = 'GET';
$options2 = array (
  'screen_name'=> sho_qu,
  'count'=> 100,
  'include_entities'=> true);

$tw_obj_request2 = $tw_obj->OAuthRequest (
  $rest_api2,
  $method2,
  $options2);

$tw_obj_request_json2 = json_decode($tw_obj_request2, true);
$count=0;
foreach ($tw_obj_request_json2 as $item) {
  $url = $item['entities']['media'][0]['media_url'];
  $hashtag = $item['entities']['hashtags'][0]['text'];
  //if($url and $hashtag=="活動風景"){
  if($url){
    $image=array("url"=>$url);
    $image_list[$count]=$image;
    $count++;
  }
  if($count > 3){
    break;
  }
}

$data = array("tweet_list"=>$tweet_list,"image_list"=>$image_list);
$data = json_encode($data,JSON_UNESCAPED_SLASHES);
echo $data;

?>
