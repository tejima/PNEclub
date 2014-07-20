<!DOCTYPE html>
<html lang="en" ng-app="app"  ng-controller="Ctrl">
  <head>
    <meta charset="utf-8">
    <title>ふじみ野農園部</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/angular.min.js"></script>
    <?php require_once 'tw-activity.php'; ?>
    <script>
      var myApp = angular.module('app', []);
      function Ctrl($scope) {
        $scope.members = [ 
          {"screen_name":"koiwaka_bot"}, 
          {"screen_name":"sho_qu"}, 
          {"screen_name":"kroroooo"}];
        $scope.club_info = 
          {"name":"ふじみ野農園部", "keyword":"農園", "leader_screen_name":"sho_qu", "leader_address":"kpdyd122@gmail.com", "url":"green.pne.jp"};
      }
      function CtrlB($scope) {
          $scope.images = <?php echo $images; ?>;
      }
    </script>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
    <meta name="description" content="Responsive HTML template for Your company">
    <meta name="author" content="Oskar Żabik (oskar.zabik@gmail.com)">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bosyu.css">
    <link rel="stylesheet" href="css/footer.css">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico">
  </head>

  <body>
        <div class="visual">   
          <div class="visual-content">
            <div class="row-fluid">
              <div class="span12">
              </div>
            </div>
            <div class="row-fluid">
              <div class="span12">
                <div class="club-name">
                  <p>{{club_info.name}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>    

<div class="main">

    <div class="container-fluid container-padding">

      <div class="unit">
        <div class="row-fluid">
          <div class="span12">
            <strong>{{club_info.name}}とは?</strong>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span12">
            <p>{{club_info.name}}とは趣味に一生懸命な人たちが{{club_info.keyword}}を精一杯楽しんでいる活動です。{{club_info.keyword}}が大好きなメンバーたちが集まって、{{club_info.keyword}}をひたすら楽しんでいます。もしあなたが{{club_info.keyword}}好きならば、私たちと一緒に{{club_info.keyword}}行いませんか？</p>
          </div>
        </div>
      </div>

      <div class="section-title">
        <h3>活動風景</h3>
      </div>
      <div class="row-fluid" ng-controller="CtrlB">
        <div class="span3" ng-repeat="image in images">
          <div class="activity-image">
            <img src="{{image.name}}">
          </div>
        </div>
      </div>  

      <div class="section-title">
        <h3>メンバー</h3>
      </div>

      <div class="row-fluid">
        <div class="span4"  ng-repeat="member in members">
          <div class="single-member">
              <a href="https://twitter.com/{{member.screen_name}}"><img src="https://twitter.com/api/users/profile_image?screen_name={{member.screen_name}}&size=original"></p>
              <p align="center"><a href="https://twitter.com/{{member.screen_name}}">＠{{member.screen_name}}</a></p>
          </div>
        </div>
      </div>

      <div class="section-title">
        <h3>募集案内</h3>
      </div>
<div class="apply-info">
<p align="center">参加に興味のある方はツイートにファボ☆で詳細情報をお送りします！</p>
<p align="center">質問などあればリプライか連絡フォームからご連絡おねがいします。</p>
</div>
<div align="center">
<a class="twitter-timeline"  data-chrome="nofooter" href="https://twitter.com/search?q={{club_info.url}}"  data-widget-id="489272678335774721">{{club_info.url}} に関するツイート</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


</div>

      <div class="section-title">
        <h3>連絡</h3>
      </div>

<div class="row-fluid contact">
  <div class="offset2 span4">
    <div class="twitter-box">
      <a href="http://twitter.com/share?text=@{{club_info.leader_screen_name}}">
        <p align="center">Twitter</p>
      </a>
    </div>
  </div>
  <div class="span4">
    <div class="mail-box">
      <a href="mailto:{{club_info.leader_address}}?subject=[{{club_info.name}}]詳細希望&amp;body=">
        <p align="center">メール</p>
      </a>
    </div>
  </div>
  <div class="span2">
  </div>
</div>

    </div><!-- .container -->

</div>

  <footer>
    <div class="footer-content">  
      <div class="container-fluid">
        <div class="row-fluid">
          <div class="span8">
            <div class="row-fluid footer-row-top">
              <div class="span6">
                <h1>PNE.club</h1>
              </div>
              <div class="span6">
                <h3>新しいクラブ、増設中!>></h3>
              </div>
            </div>
            <div class="row-fluid footer-row-bottom">
              <div class="span6">
              </div>
              <div class="span6">
                <div class="found">
                  <div class="found-content">
                    <p><br>新しく</p>
                    <p><strong>クラブをつくる</strong></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="span4">
            <div class="thumb">
              <h2>おしゃべり部</h2>
              <img src="img/piano.jpg" alt="image">
              <div class="footer">
                  <p class="summary">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt</p>
                  <p>目標&nbsp;&nbsp;<meter value="15" low="5" high="10" max="15" optimum="15"></meter>&nbsp;&nbsp;15人</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>


    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/setup.js"></script>

  </body>
</html>
