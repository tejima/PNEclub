<?php
require_once 'twitteroauth/twitteroauth.php';
require_once 'fuzzy_time.php';

$club["otome"] = array( 
                "club_name"=>"otome",
                "club_name_long"=>"乙女の工作部", 
                "keyword"=>"工作", 
                "description"=>"「可愛い、作れたら・・・」を一緒に形にしていきませんか？乙女の工作部はやる気がある女性ならどなたでもご参加頂けます。みんなで一緒に楽しく作って遊ぶのが目的です。手芸の枠を超えた乙女のＤＩＹ♪",
                "regular_activity"=>"月3〜4回、カフェや部室での工作活動",
                "use_budget"=>"共有資材・共有物（ハサミや工具）の購入 イベント参加費 共有アトリエの維持費 など",
                "leader_screenname"=>"otomenokousakub", 
                "place"=>"新宿区", 
                "mail_address"=>"otomenokousakubu@gmail.com"
              );
      
$club["soccer"] = array( 
                "club_name"=>"soccer",
                "club_name_long"=>"クラブテスト", 
                "keyword"=>"工作", 
                "description"=>"「可愛い、作れたら・・・」を一緒に形にしていきませんか？乙女の工作部はやる気がある女性ならどなたでもご参加頂けます。みんなで一緒に楽しく作って遊ぶのが目的です。手芸の枠を超えた乙女のＤＩＹ♪",
                "regular_activity"=>"月3〜4回、カフェや部室での工作活動",
                "use_budget"=>"共有資材・共有物（ハサミや工具）の購入 イベント参加費 共有アトリエの維持費 など",
                "leader_screenname"=>"sho_qu", 
                "place"=>"新宿区", 
                "mail_address"=>"otomenokousakubu@gmail.com"
              );
$club["kuzu"] = array( 
                "club_name"=>"kuzu",
                "club_name_long"=>"クズ部", 
                "keyword"=>"飲み会", 
                "description"=>"月に一回、ふじみ野ログハウスに集まって仲間と活動します。料理、ボードゲーム、カラオケ、農作業、工作などが中心。夏は、花火、スイカ割り、流しそうめん。秋は収穫祭。冬はボードゲームを中心に遊んでいます。",
                "regular_activity"=>"月1回、ふじみ野ログハウスでの合宿",
                "use_budget"=>"共有設備の購入、燃料、修繕費などのつみたて",
                "leader_screenname"=>"tejima", 
                "place"=>"新宿区,埼玉県富士見市", 
                "mail_address"=>"tejima@gmail.com"
              );

$domain = $_GET["domain"];
$url = $domain."pne.club";
$club_info = $club[$domain];

$consumer_key = $_SERVER['CONSUMER_KEY'];
$consumer_secret = $_SERVER['CONSUMER_SECRET'];
$access_token = $_SERVER['261665320-d4FqnxJJG60XfIuXKMHajenkA7xssuXrSCv2ZYaf'];
$access_token_secret = $_SERVER['otI1d7CmNJfMj5x9w7X0SK1DbNEzcFtsqYw5USZRlF6ob'];

$tw_obj = new TwitterOAuth (
  $consumer_key,
  $consumer_secret,
  $access_token,
  $access_token_secret);

//メンバーをリストから取得
$rest_api3 = 'https://api.twitter.com/1.1/lists/members.json';
$method3 = 'GET';
$options3 = array (
  'slug'=>'部員',
  'owner_screen_name'=>$club_info["leader_screenname"]);

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
  'q'=> "$url -RT",
  'result_type'=>'recent',
  'count'=> 5,
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
    $text = str_replace($media['url'] , '<br/><div class="text-img"><a href="'.$media['media_url'].'"><img class="square" src="'.$media['media_url'].'"></a></div>' , $text);
  }
  $text = str_replace("\n","<br>",$text);
  $name = $item['user']['name'];
  $screen_name = $item['user']['screen_name'];
  $tweet=array("tweet_id"=>$tweet_id,"datetime"=>$datetime,"text"=>$text,"screen_name"=>$screen_name,"name"=>$name);
  $tweet_list[$i]=$tweet;
  $i++;
}
//風景画像取得
$rest_api1 = 'https://api.twitter.com/1.1/search/tweets.json';
$method1 = 'GET';
$options1 = array (
  'q'=>"$url -RT",
  'result_type'=>'recent',
  'count'=> 10,
  'lang' => 'ja',
  'include_entities'=> true);
$tw_obj_request1 = $tw_obj->OAuthRequest (
  $rest_api1,
  $method1,
  $options1);
$tw_obj_request_json1 = json_decode($tw_obj_request1, true);
$count=0; 
foreach($tw_obj_request_json1['statuses'] as $item){
  foreach($item['entities']['media'] as $media){
    $image = array("url"=>$media['media_url']);
    $image_list[$count] = $image;
    $count++;
    if($count>5){
      break 2;
    }
  }
}

$data = array("club_info"=>$club_info,"image_list"=>$image_list,"tweet_list"=>$tweet_list,"member_screenname_list"=>$member_screenname_list);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($data);
?>
