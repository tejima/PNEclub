
<?php
require_once 'twitteroauth/twitteroauth.php';
require_once 'fuzzy_time.php';
<<<<<<< HEAD
<<<<<<< HEAD

function member_list4screenname($owner_screen_name,$tw_obj){
=======
=======
>>>>>>> FETCH_HEAD
function member_info4screenname($screen_name, $tw_obj)
{
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/users/show.json', 'GET', array(
        'screen_name' => $screen_name,
    ));
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    return $tw_obj_request_json1;
}
function member_list4screenname($owner_screen_name, $tw_obj)
{
<<<<<<< HEAD
>>>>>>> FETCH_HEAD
=======
>>>>>>> FETCH_HEAD
    // メンバーをリストから取得
    $options3 = array(
        'slug' => '部員',
        'owner_screen_name' => $owner_screen_name,
    );
    $tw_obj_request3 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/lists/members.json', 'GET', $options3);
    $tw_obj_request_json3 = json_decode($tw_obj_request3, true);
    $i = 0;
<<<<<<< HEAD
<<<<<<< HEAD

    $member_screenname_list = array();
    foreach($tw_obj_request_json3["users"] as $item)
    {
=======
    $member_screenname_list = array();
    foreach ($tw_obj_request_json3["users"] as $item) {
>>>>>>> FETCH_HEAD
=======
    $member_screenname_list = array();
    foreach ($tw_obj_request_json3["users"] as $item) {
>>>>>>> FETCH_HEAD
        $screenname = $item['screen_name'];
        $member_screenname = array(
            "screenname" => $screenname
        );
        $member_screenname_list[$i] = $member_screenname;
        $i++;
    }
    return $member_screenname_list;
<<<<<<< HEAD
<<<<<<< HEAD
}
function tweet_id_list4screen_name($screen_name,$tw_obj){
=======
}
function tweet_id_list4screen_name($screen_name, $tw_obj)
{
>>>>>>> FETCH_HEAD
    $options1 = array(
        'screen_name' => $screen_name,
        'exclude_replies' => true,
        'include_rts' => false,
        'result_type' => 'recent',
<<<<<<< HEAD
        'count' => 5,
=======
        'count' => 10,
>>>>>>> FETCH_HEAD
        'include_entities' => true
    );
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET', $options1);
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $i = 0;
    return $tw_obj_request_json1;
}
<<<<<<< HEAD

function tweet_id_list4url($url,$tw_obj){
    $options1 = array(
        'q' => "$url -RT",
        'result_type' => 'recent',
        'count' => 5,
=======
function tweet_id_list4url($url, $tw_obj)
{
    $options1 = array(
        'q' => "$url -RT",
        'result_type' => 'recent',
        'count' => 10,
>>>>>>> FETCH_HEAD
        'include_entities' => true
    );
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/search/tweets.json', 'GET', $options1);
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $i = 0;
    return $tw_obj_request_json1['statuses'];
}
<<<<<<< HEAD

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
=======
function image_list4screen_name($owner_screen_name, $tw_obj)
{
    $image_list = array();
    //画像取得2  オーナーのお気に入り写真
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/favorites/list.json', 'GET', array(
        'screen_name' => $owner_screen_name,
        'count' => 100,
        'include_entities' => true
    ));
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    foreach ($tw_obj_request_json1 as $item) {
        foreach ($item['entities']['media'] as $media) {
>>>>>>> FETCH_HEAD
            $image_list[] = $media['media_url'];
        }
    }
    shuffle(array_unique($image_list));
    return array_slice($image_list, 0, 20);
}
<<<<<<< HEAD
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
=======
function image_list4url($url, $tw_obj)
{
    //画像取得１ 部活動urlが含まれる画像
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/search/tweets.json', 'GET', array(
        'q' => "$url -RT",
        'result_type' => 'recent',
        'count' => 100,
        'lang' => 'ja',
        'include_entities' => true,
    ));
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $image_list = array();
    foreach ($tw_obj_request_json1['statuses'] as $item) {
        foreach ($item['entities']['media'] as $media) {
>>>>>>> FETCH_HEAD
            $image_list[] = $media['media_url'];
        }
    }
    shuffle(array_unique($image_list));
    return array_slice($image_list, 0, 20);
}
<<<<<<< HEAD

$club_list["recorder"] = array( 
                 "club_name"=>"recorder",
                 "club_name_long"=>"リコーダー部",
                 "keyword"=>"リコーダー",
                 "description"=>"リコーダーが好きな人が集まって、持ち寄った曲を合奏します。初心者から上級者まで楽しく演奏するのが目的です。演奏した曲はyoutubeで公開していきます！",
                 "regular_activity"=>"月１〜２回",
                 "use_budget"=>"楽譜代",
                 "leader_screenname"=>"sho_qu",
                 "place"=>"新宿区、早稲田大学戸山キャンパス学生会館",
                 "mail_address"=>"kpdyd122@gmail.com",
                 "bot_mode"=>false,
                 "name"=>"リコーダー部",
                 "caption"=>"リコーダーが好きな人が集まって、持ち寄った曲を合奏します。初心者から上級者まで楽しく演奏するのが目的です。演奏した曲はyoutubeで公開していきます！",
                 "member_total"=>2,
                 "member_last"=>3,
                 "member_new"=>1,
                 "img"=>"http://shimizu.cqc.jp/img/sample.jpg",
              );

$club_list["otome"] = array( 
                "club_name"=>"otome",
                "club_name_long"=>"乙女の工作部",
                "keyword"=>"工作",
                "description"=>"「可愛い、作れたら・・・」を一緒に形にしていきませんか？乙女の工作部はやる気がある女性ならどなたでもご参加頂けます。みんなで一緒に楽しく作って遊ぶのが目的です。手芸の枠を超えた乙女のＤＩＹ♪",
                "regular_activity"=>"月3〜4回、カフェや部室での工作活動",
                "use_budget"=>"共有資材・共有物（ハサミや工具）の購入 イベント参加費 共有アトリエの維持費 など",
                "leader_screenname"=>"otomenokousakub",
                "place"=>"新宿区",
                "mail_address"=>"otomenokousakubu@gmail.com",
                "bot_mode"=>true,
                "name"=>"乙女の工作部",
                "caption"=>"「可愛い、作れたら・・・」を一緒に形にしていきませんか？乙女の工作部はやる気がある女性ならどなたでもご参加頂けます。みんなで一緒に楽しく作って遊ぶのが目的です。手芸の枠を超えた乙女のＤＩＹ♪",
                "member_total"=>5,
                "member_last"=>2,
                "member_new"=>2,
                "img"=>"http://p.pne.jp/d/201407231946.png",
              );

$club_list["kuzu"] = array( 
               "club_name"=>"kuzu",
               "club_name_long"=>"クズ部",
               "keyword"=>"飲み会",
               "description"=>"月に一回、ふじみ野ログハウスに集まって仲間と活動します。料理、ボードゲーム、カラオケ、農作業、工作などが中心。夏は、花火、スイカ割り、流しそうめん。秋は収穫祭。冬はボードゲームを中心に遊んでいます。",
               "regular_activity"=>"月1回、ふじみ野ログハウスでの合宿",
               "use_budget"=>"共有設備の購入、燃料、修繕費などのつみたて",
               "leader_screenname"=>"tejima",
               "place"=>"新宿区,埼玉県富士見市",
               "mail_address"=>"tejima@gmail.com",
               "bot_mode"=>false,
               "name"=>"クズ部",
               "caption"=>"月に一回、ふじみ野ログハウスに集まって仲間と活動します。料理、ボードゲーム、カラオケ、農作業、工作などが中心。夏は、花火、スイカ割り、流しそうめん。秋は収穫祭。冬はボードゲームを中心に遊んでいます。",
               "member_total"=>5,
               "member_last"=>2,
               "member_new"=>2,
               "img"=>"http://fujimino.cqc.jp/wp-content/themes/fujimino/images/f56886408.jpg",
              );
$club_list["BoulderingInTakadanobaba"] = array( 
                "club_name"=>"BoulderingInTakadanobaba",
                "club_name_long"=>"高田馬場駅ボルダリング部", 
                "keyword"=>"ボルダリング", 
                "description"=>"新しく何か始めたい人、ボルダリングしましょう！高田馬場駅周辺でボルダリングをします！学生の方はもちろん、社会人の方もぜひ！",
                "regular_activity"=>"月4〜6回、ボルダリングジムでボルダリングを行う",
                "use_budget"=>"ボルダリングジムの利用料金 など",
                "leader_screenname"=>"Akhr5884", 
                "place"=>"東京都新宿区", 
                "mail_address"=>"a.kobayashi@tejimaya.com",
                "bot_mode"=>false,
                "name"=>"高田馬場駅ボルダリング部",
                "caption"=>"新しく何か始めたい人、ボルダリングしましょう！高田馬場駅周辺でボルダリングをします！学生の方はもちろん、社会人の方もぜひ！",
                "member_total"=>1,
                "member_last"=>4,
                "member_new"=>0,
                "img"=>"http://shimizu.cqc.jp/img/sample.jpg",
              );
$club_list["buto"] = array(
                "club_name"=>"buto",
                "club_name_long"=>"舞踏倶楽部",
                "keyword"=>"舞踏",
                "description"=>"舞踏倶楽部は、社交ダンスのリーダー、パートナーなど、ダンスのお相手やダンス友達と出会えて踊れる、日本で初めての社交ダンス専門の会員制ダンサーコミュニティサイトです。",
                "regular_activity"=>"月に都合のつく回数",
                "use_budget"=>"場所代",
                "leader_screenname"=>"butoclub",
                "place"=>"東京",
                "mail_address"=>"info@buto.jp",
                "bot_mode"=>false,
                "name"=>"舞踏倶楽部",
                "caption"=>"舞踏倶楽部は、社交ダンスのリーダー、パートナーなど、ダンスのお相手やダンス友達と出会えて踊れる、日本で初めての社交ダンス専門の会員制ダンサーコミュニティサイトです。",
                "member_total"=>1,
                "member_last"=>4,
                "member_new"=>0,
                "img"=>"http://shimizu.cqc.jp/img/sample.jpg",
                );
$club_list["kaosknight"] = array(
                "club_name"=>"kaosknight",
                "club_name_long"=>"混沌の騎士団",
                "keyword"=>"西洋魔術",
                "description"=>"最先端の魔術で時代をリードする混沌の騎士団",
                "regular_activity"=>"一日30分",
                "use_budget"=>"指輪代",
                "leader_screenname"=>"kontonnokisidan",
                "place"=>"日本",
                "mail_address"=>"postmaster@konton-no-kisidan.jp",
                "bot_mode"=>false,
                "name"=>"混沌の騎士団",
                "caption"=>"最先端の魔術で時代をリードする混沌の騎士団",
                "member_total"=>1,
                "member_last"=>4,
                "member_new"=>0,
                "img"=>"http://freebies-db.com/wp-content/uploads/2012/09/free-texture-flame-photostream.jpg",
                );
$club_list["cfes"] = array(
                "club_name"=>"cfes",
                "club_name_long"=>"チャレンジドフェスティバル応援部",
                "keyword"=>"応援",
                "description"=>"知的障がいを持つ子ども・青年70名とその母親たち30名が出演するミュージカルです。継続的なイベント開催のため、イベントを応援してくれる応援部員を求めています。",
                "regular_activity"=>"年1回のダンスイベント・その他セミナー開催",
                "use_budget"=>"イベント資金",
                "leader_screenname"=>"challengedfes",
                "place"=>"東京都千代田区",
                "mail_address"=>"info@challenged-festival.jp",
                "bot_mode"=>false,
                "name"=>"チャレンジド・フェスティバル応援部",
                "caption"=>"知的障がいを持つ子ども・青年70名とその母親たち30名が出演するミュージカルです。継続的なイベント開催のため、イベントを応援してくれる応援部員を求めています。",
                "member_total"=>1,
                "member_last"=>4,
                "member_new"=>0,
                "img"=>"http://u.jimdo.com/www40/o/sa7cc540b5b388dea/emotion/crop/header.png?t=1401254179",
                );
$club_list["trpg"] = array(
                "club_name"=>"trpg",
                "club_name_long"=>"TRPGSNS",
                "keyword"=>"TRPG",
                "description"=>"ＴＲＰＧの情報とプレイ機会をシェアするためのＳＮＳです。参加すると、気軽にプライベート・セッションの企画や、コンベンションや例会、オンラインセッションなどの告知が可能となります。また、同好の士が集まるので、プレイに誘われる機会が増えるかも知れません。",
                "regular_activity"=>"自由",
                "use_budget"=>"サイト運営費",
                "leader_screenname"=>"inouekari",
                "place"=>"オンライン",
                "mail_address"=>"",
                "bot_mode"=>false,
                "name"=>"TRPGSNS",
                "caption"=>"ＴＲＰＧの情報とプレイ機会をシェアするためのＳＮＳです。参加すると、気軽にプライベート・セッションの企画や、コンベンションや例会、オンラインセッションなどの告知が可能となります。また、同好の士が集まるので、プレイに誘われる機会が増えるかも知れません。",
                "member_total"=>1,
                "member_last"=>4,
                "member_new"=>0,
                "img"=>"http://shimizu.cqc.jp/img/sample.jpg",
                );

$recorder_json = json_encode($club_list["recorder"]);
$otome_json = json_encode($club_list["otome"]);
$kuzu_json = json_encode($club_list["kuzu"]);
$BoulderingInTakadanobaba_json = json_encode($club_list["BoulderingInTakadanobaba"]);
$buto_json = json_encode($club_list["buto"]);
$kaosknight_json = json_encode($club_list["kaosknight"]);
$cfes_json = json_encode($club_list["cfes"]);
$trpg_json = json_encode($club_list["trpg"]);


$result = <<<EOF
{
        "top_widget_list":[$otome_json,$recorder_json,$kuzu_json],
        "hot_widget_list":[$otome_json,$recorder_json,$kuzu_json],
        "new_widget_list":[$otome_json,$recorder_json,$kuzu_json],
        "other_widget_list":[
                           $otome_json,
                           $recorder_json,
                           $kuzu_json,
                           $BoulderingInTakadanobaba_json,
                           $buto_json,
                           $kaosknight_json,
                           $cfes_json,
                           $trpg_json
                            ], 
        "footer_widget_list":[$otome_json]
}
EOF;

$domain = $_GET["domain"];
if(!isset($domain)){
    header("Content-Type: application/json; charset=utf-8");
    echo $result;
    exit;
}else{
    $club_info = $club_list[$domain];
}  
 
$url = $domain . "." . $_SERVER["SERVICE_DOMAIN"];
$tw_obj = new TwitterOAuth($_SERVER['CONSUMER_KEY'], $_SERVER['CONSUMER_SECRET'], $_SERVER['ACCESS_TOKEN'], $_SERVER['ACCESS_TOKEN_SECRET']);

apc_clear_cache("user");

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
    "club_footer" => $club_list["otome"],
=======
}
function tweet_id_list4screen_name($screen_name, $tw_obj)
{
    $options1 = array(
        'screen_name' => $screen_name,
        'exclude_replies' => true,
        'include_rts' => false,
        'result_type' => 'recent',
        'count' => 10,
        'include_entities' => true
    );
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/statuses/user_timeline.json', 'GET', $options1);
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $i = 0;
    return $tw_obj_request_json1;
}
function tweet_id_list4url($url, $tw_obj)
{
    $options1 = array(
        'q' => "$url -RT",
        'result_type' => 'recent',
        'count' => 10,
        'include_entities' => true
    );
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/search/tweets.json', 'GET', $options1);
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $i = 0;
    return $tw_obj_request_json1['statuses'];
}
function image_list4screen_name($owner_screen_name, $tw_obj)
{
    $image_list = array();
    //画像取得2  オーナーのお気に入り写真
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/favorites/list.json', 'GET', array(
        'screen_name' => $owner_screen_name,
        'count' => 100,
        'include_entities' => true
    ));
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    foreach ($tw_obj_request_json1 as $item) {
        foreach ($item['entities']['media'] as $media) {
            $image_list[] = $media['media_url'];
        }
    }
    shuffle(array_unique($image_list));
    return array_slice($image_list, 0, 20);
}
function image_list4url($url, $tw_obj)
{
    //画像取得１ 部活動urlが含まれる画像
    $tw_obj_request1 = $tw_obj->OAuthRequest('https://api.twitter.com/1.1/search/tweets.json', 'GET', array(
        'q' => "$url -RT",
        'result_type' => 'recent',
        'count' => 100,
        'lang' => 'ja',
        'include_entities' => true,
    ));
    $tw_obj_request_json1 = json_decode($tw_obj_request1, true);
    $image_list = array();
    foreach ($tw_obj_request_json1['statuses'] as $item) {
        foreach ($item['entities']['media'] as $media) {
            $image_list[] = $media['media_url'];
        }
    }
    shuffle(array_unique($image_list));
    return array_slice($image_list, 0, 20);
}
$club["buto"] = array(
    "club_name" => "buto",
    "club_name_long" => "舞踏倶楽部",
    "keyword" => "舞踏",
    "description" => "舞踏倶楽部は、社交ダンスのリーダー、パートナーなど、ダンスのお相手やダンス友達と出会えて踊れる、日本で初めての社交ダンス専門の会員制ダンサーコミュニティサイトです。",
    "regular_activity" => "月に都合のつく回数",
    "use_budget" => "場所代",
    "leader_screenname" => "butoclub",
    "place" => "東京",
    "mail_address" => "info@buto.jp",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 30,
    "member_new" => 0,
);
$club["BoulderingInTakadanobaba"] = array(
    "club_name" => "BoulderingInTakadanobaba",
    "club_name_long" => "高田馬場駅ボルダリング部",
    "keyword" => "ボルダリング",
    "description" => "新しく何か始めたい人、ボルダリングしましょう！高田馬場駅周辺でボルダリングをします！学生の方はもちろん、社会人の方もぜひ！",
    "regular_activity" => "月4〜6回、ボルダリングジムでボルダリングを行う",
    "use_budget" => "ボルダリングジムの利用料金 など",
    "leader_screenname" => "Akhr5884",
    "place" => "東京都新宿区",
    "mail_address" => "a.kobayashi@tejimaya.com",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 4,
    "member_new" => 0,
);
$club["recorder"] = array(
    "club_name" => "recorder",
    "club_name_long" => "リコーダー部",
    "keyword" => "リコーダー",
    "description" => "リコーダーが好きな人が集まって、持ち寄った曲を合奏します。初心者から上級者まで楽しく演奏するのが目的です。演奏した曲はyoutubeで公開していきます！",
    "regular_activity" => "月１〜２回",
    "use_budget" => "楽譜代",
    "leader_screenname" => "sho_qu",
    "place" => "新宿区、早稲田大学戸山キャンパス学生会館",
    "mail_address" => "kpdyd122@gmail.com",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 4,
    "member_new" => 0,
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
    "member_total" => 5,
    "member_last" => 5,
    "member_new" => 0,
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
    "member_total" => 1,
    "member_last" => 0,
    "member_new" => 0,
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
    "member_total" => 1,
    "member_last" => 9,
    "member_new" => 0,
);
$club["onnobesendenbu"] = array(
    "club_name" => "onnobesendenbu",
    "club_name_long" => "オンノベ宣伝部",
    "keyword" => "自作小説の宣伝",
    "description" => "自作オンラインノベルをいろんな人に読んでもらいたい。そのためオフでも宣伝活動行います。",
    "regular_activity" => "文学フリマ",
    "use_budget" => "イベント参加費、本の印刷費など",
    "leader_screenname" => "iduha_sousaku",
    "place" => "オンライン",
    "mail_address" => "orpimentffd800@gmail.com",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 5,
    "member_new" => 0,
);
$club["cfes"] = array(
    "club_name" => "cfes",
    "club_name_long" => "チャレンジド・フェスティバル応援部",
    "keyword" => "応援",
    "description" => "知的障がいを持つ子ども・青年70名とその母親たち30名が出演するミュージカルです。継続的なイベント開催のため、イベントを応援してくれる応援部員を求めています。",
    "regular_activity" => "年1回のダンスイベント・その他セミナー開催",
    "use_budget" => "イベント資金",
    "leader_screenname" => "challengedfes",
    "place" => "東京都千代田区",
    "mail_address" => "info@challenged-festival.jp",
    "bot_mode" => true,
    "member_total" => 7,
    "member_last" => 23,
    "member_new" => 5,
);
$club["trpg"] = array(
    "club_name" => "trpg",
    "club_name_long" => "TRPGSNS",
    "keyword" => "TRPG",
    "description" => "ＴＲＰＧの情報とプレイ機会をシェアするためのＳＮＳです。参加すると、気軽にプライベート・セッションの企画や、コンベンションや例会、オンラインセッションなどの告知が可能となります。また、同好の士が集まるので、プレイに誘われる機会が増えるかも知れません。",
    "regular_activity" => "自由",
    "use_budget" => "サイト運営費",
    "leader_screenname" => "inouekari",
    "place" => "オンライン",
    "mail_address" => "",
    "bot_mode" => false,
    "member_total" => 758,
    "member_last" => 30,
    "member_new" => 0,
);
$club["kaosknight"] = array(
    "club_name" => "kaosknight",
    "club_name_long" => "混沌の騎士団",
    "keyword" => "西洋魔術",
    "description" => "最先端の魔術で時代をリードする混沌の騎士団",
    "regular_activity" => "一日30分",
    "use_budget" => "指輪代",
    "leader_screenname" => "kontonnokisidan",
    "place" => "日本",
    "mail_address" => "postmaster@konton-no-kisidan.jp",
    "bot_mode" => true,
    "member_total" => 1,
    "member_last" => 10,
    "member_new" => 0,
);
$domain = $_GET["domain"] ? : 'otome';
$club_info = $club[$domain];
$url = $domain . "." . $_SERVER["SERVICE_DOMAIN"];
$tw_obj = new TwitterOAuth($_SERVER['CONSUMER_KEY'], $_SERVER['CONSUMER_SECRET'], $_SERVER['ACCESS_TOKEN'], $_SERVER['ACCESS_TOKEN_SECRET']);
//apc_clear_cache("user");
if ($club_info["bot_mode"]) {
    $member_screenname_list = apc_fetch("member_screenname_list:" . $url, $is_success_member_screenname_list) ? : member_list4screenname($club_info["leader_screenname"], $tw_obj);
    $image_list = apc_fetch("image_list:" . $url, $is_success_image_list) ? : image_list4screen_name($club_info["leader_screenname"], $tw_obj);
    $tweet_list = apc_fetch("tweet_list:" . $url, $is_success_tweet_list) ? : tweet_id_list4screen_name($club_info["leader_screenname"], $tw_obj);
    $twitter_member = apc_fetch("member_info:" . $url, $is_success_twitter_member) ? : member_info4screenname($club_info["leader_screenname"], $tw_obj);
    $club_info["background"] = $twitter_member["profile_banner_url"];
} else {
    $member_screenname_list = apc_fetch("member_screenname_list:" . $url, $is_success_member_screenname_list) ? : member_list4screenname($club_info["leader_screenname"], $tw_obj);
    $image_list = apc_fetch("image_list:" . $url, $is_success_image_list) ? : image_list4url($url, $tw_obj);
    $tweet_list = apc_fetch("tweet_list:" . $url, $is_success_tweet_list) ? : tweet_id_list4url($url, $tw_obj);
}
if (!$is_success_twitter_member) {
    apc_store("member_info:" . $url, $twitter_member, 600);
}
if (!$is_success_member_screenname_list) {
    apc_store("member_screenname_list:" . $url, $member_screenname_list, 600);
}
if (!$is_success_image_list) {
    apc_store("image_list:" . $url, $image_list, 600);
}
if (!$is_success_tweet_list) {
    apc_store("tweet_list:" . $url, $tweet_list, 600);
}
$data = array(
>>>>>>> FETCH_HEAD
=======
$club["buto"] = array(
    "club_name" => "buto",
    "club_name_long" => "舞踏倶楽部",
    "keyword" => "舞踏",
    "description" => "舞踏倶楽部は、社交ダンスのリーダー、パートナーなど、ダンスのお相手やダンス友達と出会えて踊れる、日本で初めての社交ダンス専門の会員制ダンサーコミュニティサイトです。",
    "regular_activity" => "月に都合のつく回数",
    "use_budget" => "場所代",
    "leader_screenname" => "butoclub",
    "place" => "東京",
    "mail_address" => "info@buto.jp",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 30,
    "member_new" => 0,
);
$club["BoulderingInTakadanobaba"] = array(
    "club_name" => "BoulderingInTakadanobaba",
    "club_name_long" => "高田馬場駅ボルダリング部",
    "keyword" => "ボルダリング",
    "description" => "新しく何か始めたい人、ボルダリングしましょう！高田馬場駅周辺でボルダリングをします！学生の方はもちろん、社会人の方もぜひ！",
    "regular_activity" => "月4〜6回、ボルダリングジムでボルダリングを行う",
    "use_budget" => "ボルダリングジムの利用料金 など",
    "leader_screenname" => "Akhr5884",
    "place" => "東京都新宿区",
    "mail_address" => "a.kobayashi@tejimaya.com",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 4,
    "member_new" => 0,
);
$club["recorder"] = array(
    "club_name" => "recorder",
    "club_name_long" => "リコーダー部",
    "keyword" => "リコーダー",
    "description" => "リコーダーが好きな人が集まって、持ち寄った曲を合奏します。初心者から上級者まで楽しく演奏するのが目的です。演奏した曲はyoutubeで公開していきます！",
    "regular_activity" => "月１〜２回",
    "use_budget" => "楽譜代",
    "leader_screenname" => "sho_qu",
    "place" => "新宿区、早稲田大学戸山キャンパス学生会館",
    "mail_address" => "kpdyd122@gmail.com",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 4,
    "member_new" => 0,
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
    "member_total" => 5,
    "member_last" => 5,
    "member_new" => 0,
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
    "member_total" => 1,
    "member_last" => 0,
    "member_new" => 0,
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
    "member_total" => 1,
    "member_last" => 9,
    "member_new" => 0,
);
$club["onnobesendenbu"] = array(
    "club_name" => "onnobesendenbu",
    "club_name_long" => "オンノベ宣伝部",
    "keyword" => "自作小説の宣伝",
    "description" => "自作オンラインノベルをいろんな人に読んでもらいたい。そのためオフでも宣伝活動行います。",
    "regular_activity" => "文学フリマ",
    "use_budget" => "イベント参加費、本の印刷費など",
    "leader_screenname" => "iduha_sousaku",
    "place" => "オンライン",
    "mail_address" => "orpimentffd800@gmail.com",
    "bot_mode" => false,
    "member_total" => 1,
    "member_last" => 5,
    "member_new" => 0,
);
$club["cfes"] = array(
    "club_name" => "cfes",
    "club_name_long" => "チャレンジド・フェスティバル応援部",
    "keyword" => "応援",
    "description" => "知的障がいを持つ子ども・青年70名とその母親たち30名が出演するミュージカルです。継続的なイベント開催のため、イベントを応援してくれる応援部員を求めています。",
    "regular_activity" => "年1回のダンスイベント・その他セミナー開催",
    "use_budget" => "イベント資金",
    "leader_screenname" => "challengedfes",
    "place" => "東京都千代田区",
    "mail_address" => "info@challenged-festival.jp",
    "bot_mode" => true,
    "member_total" => 7,
    "member_last" => 23,
    "member_new" => 5,
);
$club["trpg"] = array(
    "club_name" => "trpg",
    "club_name_long" => "TRPGSNS",
    "keyword" => "TRPG",
    "description" => "ＴＲＰＧの情報とプレイ機会をシェアするためのＳＮＳです。参加すると、気軽にプライベート・セッションの企画や、コンベンションや例会、オンラインセッションなどの告知が可能となります。また、同好の士が集まるので、プレイに誘われる機会が増えるかも知れません。",
    "regular_activity" => "自由",
    "use_budget" => "サイト運営費",
    "leader_screenname" => "inouekari",
    "place" => "オンライン",
    "mail_address" => "",
    "bot_mode" => false,
    "member_total" => 758,
    "member_last" => 30,
    "member_new" => 0,
);
$club["kaosknight"] = array(
    "club_name" => "kaosknight",
    "club_name_long" => "混沌の騎士団",
    "keyword" => "西洋魔術",
    "description" => "最先端の魔術で時代をリードする混沌の騎士団",
    "regular_activity" => "一日30分",
    "use_budget" => "指輪代",
    "leader_screenname" => "kontonnokisidan",
    "place" => "日本",
    "mail_address" => "postmaster@konton-no-kisidan.jp",
    "bot_mode" => true,
    "member_total" => 1,
    "member_last" => 10,
    "member_new" => 0,
);
$domain = $_GET["domain"] ? : 'otome';
$club_info = $club[$domain];
$url = $domain . "." . $_SERVER["SERVICE_DOMAIN"];
$tw_obj = new TwitterOAuth($_SERVER['CONSUMER_KEY'], $_SERVER['CONSUMER_SECRET'], $_SERVER['ACCESS_TOKEN'], $_SERVER['ACCESS_TOKEN_SECRET']);
//apc_clear_cache("user");
if ($club_info["bot_mode"]) {
    $member_screenname_list = apc_fetch("member_screenname_list:" . $url, $is_success_member_screenname_list) ? : member_list4screenname($club_info["leader_screenname"], $tw_obj);
    $image_list = apc_fetch("image_list:" . $url, $is_success_image_list) ? : image_list4screen_name($club_info["leader_screenname"], $tw_obj);
    $tweet_list = apc_fetch("tweet_list:" . $url, $is_success_tweet_list) ? : tweet_id_list4screen_name($club_info["leader_screenname"], $tw_obj);
    $twitter_member = apc_fetch("member_info:" . $url, $is_success_twitter_member) ? : member_info4screenname($club_info["leader_screenname"], $tw_obj);
    $club_info["background"] = $twitter_member["profile_banner_url"];
} else {
    $member_screenname_list = apc_fetch("member_screenname_list:" . $url, $is_success_member_screenname_list) ? : member_list4screenname($club_info["leader_screenname"], $tw_obj);
    $image_list = apc_fetch("image_list:" . $url, $is_success_image_list) ? : image_list4url($url, $tw_obj);
    $tweet_list = apc_fetch("tweet_list:" . $url, $is_success_tweet_list) ? : tweet_id_list4url($url, $tw_obj);
}
if (!$is_success_twitter_member) {
    apc_store("member_info:" . $url, $twitter_member, 600);
}
if (!$is_success_member_screenname_list) {
    apc_store("member_screenname_list:" . $url, $member_screenname_list, 600);
}
if (!$is_success_image_list) {
    apc_store("image_list:" . $url, $image_list, 600);
}
if (!$is_success_tweet_list) {
    apc_store("tweet_list:" . $url, $tweet_list, 600);
}
$data = array(
>>>>>>> FETCH_HEAD
    "club_info" => $club_info,
    "image_list" => $image_list,
    "tweet_list" => $tweet_list,
    "member_screenname_list" => $member_screenname_list
);
header("Content-Type: application/json; charset=utf-8");
echo json_encode($data);
