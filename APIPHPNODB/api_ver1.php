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

//メンバーをリストから取得
$rest_api3 = 'https://api.twitter.com/1.1/lists/members.json';
$method3 = 'GET';
$options3 = array (
  'slug'=>'自分',
  'owner_screen_name'=>'sho_qu');

$tw_obj_request3 = $tw_obj->OAuthRequest (
  $rest_api3,
  $method3,
  $options3);

$tw_obj_request_json3 = json_decode($tw_obj_request3, true);
$i=0;
foreach ($tw_obj_request_json3["users"] as $item) {
  $screenname = $item['screen_name'];
  $member_screenname = array("screenname"=>$screenname);
  $member_screenname_list[$i] = $member_screenname;
  $i++;
}

//募集案内のツイート取得
$rest_api1 = 'https://api.twitter.com/1.1/search/tweets.json';
$method1 = 'GET';
$options1 = array (
  //'q'=>'%23一番最初に知ったボカロ曲 nico.ms/sm1050729',
  'q'=>"green.pne.jp",
  'result_type'=>'recent',
  'count'=> 10,
  'include_entities'=> true);

$tw_obj_request1 = $tw_obj->OAuthRequest (
  $rest_api1,
  $method1,
  $options1);

$tw_obj_request_json1 = json_decode($tw_obj_request1, true);
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
    $text = str_replace($media['url'] , '<br/><a href="'.$media['media_url'].'"><img src="'.$media['media_url'].'"></a>' , $text);
  }
  $text = str_replace("\n","<br>",$text);
  $name = $item['user']['name'];
  $screen_name = $item['user']['screen_name'];
  $tweet=array("tweet_id"=>$tweet_id,"datetime"=>$datetime,"text"=>$text,"screen_name"=>$screen_name,"name"=>$name);
  $tweet_list[$i]=$tweet;
  $i++;
}

//活動風景取得
$rest_api = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$method = 'GET';
$count=0; 
foreach($member_screenname_list as $member_screenname){
$screenname = $member_screenname['screenname'];
$options = array (
  'screen_name'=> "$screenname",
  'count'=> 50,
  'include_entities'=> true);
$tw_obj_request = $tw_obj->OAuthRequest (
  $rest_api,
  $method,
  $options);

$tw_obj_request_json = json_decode($tw_obj_request, true);

  foreach($tw_obj_request_json as $item){
    foreach($item['entities']['hashtags'] as $hashtag){
      $hashtag_list[] = $hashtag['text'];
      if(in_array('テスト画像', $hashtag_list)){
        foreach($item['entities']['media'] as $media){
          $image = array("url"=>$media['media_url']);
          $image_list[$count] = $image;
          $count++;
          if($count>5){
            break 4;
          }
        }
      }
    }
  }
}

$data = array("image_list"=>$image_list,"tweet_list"=>$tweet_list,"member_screenname_list"=>$member_screenname_list);
$data = json_encode($data,JSON_UNESCAPED_SLASHES);
echo $data;

?>
