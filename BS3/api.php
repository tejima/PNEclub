<?php
require_once 'twitteroauth/twitteroauth.php';
require_once 'fuzzy_time.php';
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

$leader_screen_name = $_POST["leader_screen_name"];
$club_name_long = $_POST["club_name_long"];

//募集案内のツイート取得
$rest_api = 'https://api.twitter.com/1.1/search/tweets.json';
$method = 'GET';
$options = array (
  'q'=>'乙女の工作部',
  'result_type'=>'recent',
  'count'=> 5,
  'include_entities'=> true);

$tw_obj_request = $tw_obj->OAuthRequest (
  $rest_api,
  $method,
  $options);

$tw_obj_request_json = json_decode($tw_obj_request, true);
$tweets=array();
$i=0;
foreach ($tw_obj_request_json['statuses'] as $item) {
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
    $text = str_replace($media['url'] , '<br/><a href="'.$media['media_url'].'"><img src="'.$media['media_url'].'"></a>' , $text);
  }
  $text = str_replace("\n","<br>",$text);
  $name = $item['user']['name'];
  $screen_name = $item['user']['screen_name'];
  $tweet=array("tweet_id"=>$tweet_id,"datetime"=>$datetime,"text"=>$text,"screen_name"=>$screen_name,"name"=>$name);
  $tweets[$i]=$tweet;
  //print_r($item['entities']);
  $i++;
}
$tweet_list  = json_encode($tweets,JSON_UNESCAPED_SLASHES);

//活動風景取得
$rest_api = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$method = 'GET';
$options = array (
  'screen_name'=> $club_name_long,
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
echo $_POST['leader_screenname'];
?>
