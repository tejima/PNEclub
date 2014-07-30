
<?php
require_once 'twitteroauth/twitteroauth.php';
require_once 'fuzzy_time.php';

function member_list4screenname($owner_screen_name,$tw_obj){
    // メンバーをリストから取得
    $options3 = array(
        'slug' => '部員',
        'owner_screen_name' => $owner_screen_name,
    );
    $tw_obj_request3 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/lists/members.json', 'GET', $options3);
    $tw_obj_request_json3 = json_decode($tw_obj_request3, true);
    $i = 0;

    $member_screenname_list = array();
    foreach($tw_obj_request_json3["users"] as $item)
    {
        $screenname = $item['screen_name'];
        $member_screenname = array(
            "screenname" => $screenname
        );
        $member_screenname_list[$i] = $member_screenname;
        $i++;
    }
    return $member_screenname_list;
}
function tweet_id_list4screen_name($screen_name,$tw_obj){
    $options1 = array(
        'screen_name' => $screen_name,
        'exclude_replies' => true,
        'include_rts' => false,
        'result_type' => 'recent',
        'count' => 5,
        'include_entities' => true
    );
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET', $options1);
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $i = 0;
    return $tw_obj_request_json1;
}

function tweet_id_list4url($url,$tw_obj){
    $options1 = array(
        'q' => "$url -RT",
        'result_type' => 'recent',
        'count' => 5,
        'include_entities' => true
    );
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/search/tweets.json', 'GET', $options1);
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $i = 0;
    return $tw_obj_request_json1['statuses'];
}

function tweet_list4url($url,$tw_obj){
    // 募集案内のツイート取得
    $options1 = array(
        'q' => "$url -RT",
        'result_type' => 'recent',
        'count' => 5,
        'include_entities' => true
    );
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/search/tweets.json', 'GET', $options1);
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $i = 0;
    $tweet_list = array();
    foreach($tw_obj_request_json1['statuses'] as $item)
    {
        $tweet_id = $item['id_str'];
        $created_at = $item['created_at'];
        $datetime = date('Y-m-d H:i:s', strtotime($created_at));
        $datetime = convert_to_fuzzy_time($datetime);
        $text = $item['text'];

        foreach($item['entities']['hashtags'] as $tags)
        {
            $text = str_replace("#" . $tags['text'], '<a href="https://twitter.com/search?q=%23' . $tags['text'] . '&src=hash">#' . $tags['text'] . '</a>', $text);
        }

        foreach($item['entities']['urls'] as $urls)
        {
            $text = str_replace($urls['url'], '<a href="' . $urls['expanded_url'] . '">' . $urls['url'] . '</a>', $text);
        }

        foreach($item['entities']['user_mentions'] as $mentions)
        {
            $text = str_replace("@" . $mentions['screen_name'], '<a href="https://twitter.com/' . $mentions['screen_name'] . '">@' . $mentions['screen_name'] . '</a>', $text);
        }

        foreach($item['entities']['media'] as $media)
        {
            $text = str_replace($media['url'], '<br/><div class="text-img"><a href="' . $media['media_url'] . '"><img class="square" src="' . $media['media_url'] . '"></a></div>', $text);
        }

        $text = str_replace("\n", "<br />", $text);
        $name = $item['user']['name'];
        $screen_name = $item['user']['screen_name'];
        $tweet = array(
            "tweet_id" => $tweet_id,
            "datetime" => $datetime,
            "text" => $text,
            "screen_name" => $screen_name,
            "name" => $name
        );
        $tweet_list[$i] = $tweet;
        $i++;
    }
    return $tweet_list;
}

function image_list4screen_name($owner_screen_name,$tw_obj){
    $image_list = array();
    //画像取得2  オーナーのお気に入り写真
    $tw_obj_request1 = $tw_obj->OAuthRequest(
        'https://api.twitter.com/1.1/favorites/list.json',
        'GET',
        array(
            'screen_name' => $owner_screen_name,
            'count' => 100,
            'include_entities' => true
        )
    );
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    foreach($tw_obj_request_json1 as $item)
    {
        foreach($item['entities']['media'] as $media)
        {
            $image_list[] = $media['media_url'];
        }
    }
    shuffle(array_unique($image_list));
    return array_slice($image_list, 0, 20);
}
function image_list4url($url,$tw_obj){
    //画像取得１ 部活動urlが含まれる画像
    $tw_obj_request1 = $tw_obj->OAuthRequest(
        'https://api.twitter.com/1.1/search/tweets.json',
        'GET',
        array(
            'q' => "$url -RT",
            'result_type' => 'recent',
            'count' => 100,
            'lang' => 'ja',
            'include_entities' => true,
        )
    );
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $image_list = array();
    foreach($tw_obj_request_json1['statuses'] as $item)
    {
        foreach($item['entities']['media'] as $media)
        {
            $image_list[] = $media['media_url'];
        }
    }
    shuffle(array_unique($image_list));
    return array_slice($image_list, 0, 20);
}

$club["recorder"] = array( 
    "club_name"=>"recorder",
    "club_name_long"=>"リコーダー部", 
    "keyword"=>"リコーダー", 
    "description"=>"リコーダーが好きな人が集まって、持ち寄った曲を合奏します。初心者から上級者まで楽しく演奏するのが目的です。演奏した曲はyoutubeで公開していきます！",
    "regular_activity"=>"月１〜２回",
    "use_budget"=>"楽譜代",
    "leader_screenname"=>"sho_qu", 
    "place"=>"新宿区、早稲田大学戸山キャンパス学生会館", 
    "mail_address"=>"kpdyd122@gmail.com",
    "bot_mode" => false,
);
$club["otome"] = array(
    "club_name" => "otome",
    "club_name_long" => "乙女の工作部",
    "keyword" => "工作",
    "description" => "「可愛い、作れたら・・・」を一緒に形にしていきませんか？乙女の工作部はやる気がある女性ならどなたでもご参加頂けます。みんなで一緒に楽しく作って遊ぶのが目的です。手芸の枠を超えた乙女のＤＩＹ♪",
    "regular_activity" => "月3〜4回、カフェや部室での工作活動",
    "use_budget" => "共有資材・共有物（ハサミや工具）の購入 イベント参加費 共有アトリエの維持費 など",
    "leader_screenname" => "otomenokousakub",
    "place" => "新宿区",
    "mail_address" => "otomenokousakubu@gmail.com",
    "bot_mode" => true,
);
$club["soccer"] = array(
    "club_name" => "soccer",
    "club_name_long" => "クラブテスト",
    "keyword" => "工作",
    "description" => "「可愛い、作れたら・・・」を一緒に形にしていきませんか？乙女の工作部はやる気がある女性ならどなたでもご参加頂けます。みんなで一緒に楽しく作って遊ぶのが目的です。手芸の枠を超えた乙女のＤＩＹ♪",
    "regular_activity" => "月3〜4回、カフェや部室での工作活動",
    "use_budget" => "共有資材・共有物（ハサミや工具）の購入 イベント参加費 共有アトリエの維持費 など",
    "leader_screenname" => "sho_qu",
    "place" => "新宿区",
    "mail_address" => "otomenokousakubu@gmail.com",
    "bot_mode" => false,
);
$club["kuzu"] = array(
    "club_name" => "kuzu",
    "club_name_long" => "クズ部",
    "keyword" => "飲み会",
    "description" => "月に一回、ふじみ野ログハウスに集まって仲間と活動します。料理、ボードゲーム、カラオケ、農作業、工作などが中心。夏は、花火、スイカ割り、流しそうめん。秋は収穫祭。冬はボードゲームを中心に遊んでいます。",
    "regular_activity" => "月1回、ふじみ野ログハウスでの合宿",
    "use_budget" => "共有設備の購入、燃料、修繕費などのつみたて",
    "leader_screenname" => "tejima",
    "place" => "新宿区,埼玉県富士見市",
    "mail_address" => "tejima@gmail.com",
    "bot_mode" => false,
);

$domain = $_GET["domain"] ?: 'otome';
$club_info = $club[$domain];

$url = $domain . "." . $_SERVER["SERVICE_DOMAIN"];
$tw_obj = new TwitterOAuth($_SERVER['CONSUMER_KEY'], $_SERVER['CONSUMER_SECRET'], $_SERVER['ACCESS_TOKEN'], $_SERVER['ACCESS_TOKEN_SECRET']);

//apc_clear_cache("user");

$member_screenname_list = apc_fetch("member_screenname_list:".$url,$is_success_member_screenname_list) ?: member_list4screenname($club_info["leader_screenname"],$tw_obj);


if($club_info["bot_mode"]){
    $image_list = apc_fetch("image_list:".$url,$is_success_image_list) ?: image_list4screen_name($club_info["leader_screenname"],$tw_obj);
    $tweet_list = apc_fetch("tweet_list:".$url,$is_success_tweet_list) ?: tweet_id_list4screen_name($club_info["leader_screenname"],$tw_obj);
}else{
    $image_list = apc_fetch("image_list:".$url,$is_success_image_list) ?: image_list4url($url,$tw_obj);
    $tweet_list = apc_fetch("tweet_list:".$url,$is_success_tweet_list) ?: tweet_id_list4url($url,$tw_obj);
}


if(!$is_success_member_screenname_list){
    apc_store("member_screenname_list:".$url,$member_screenname_list,120);
}
if(!$is_success_image_list){
    apc_store("image_list:".$url,$image_list,120);
}
if(!$is_success_tweet_list){
    apc_store("tweet_list:".$url,$tweet_list,120);
}

$data = array(
    "club_info" => $club_info,
    "image_list" => $image_list,
    "tweet_list" => $tweet_list,
    "member_screenname_list" => $member_screenname_list
);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($data);
