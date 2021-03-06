<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Twitter App</title>

  <link rel="stylesheet" href="styles.css">

</head>

<body>

  <div>
    Search <img src="twitter.png" alt="twitter image"><span>Twitter</span> for: <br>



  <form method="get" action="" class="search-bar">
  	<input type="search" name="keyword" pattern=".*\S.*" required="required">
  	<button class="search-btn" type="submit">
  		<span>Search</span>
  	</button>
  </form>

  <?php
  // ini_set('display_errors','1');
  require_once('TwitterAPIExchange.php');

  $settings = array(
  'oauth_access_token' => "access_token",
  'oauth_access_token_secret' => "access_token_secret",
  'consumer_key' => "consumer_key",
  'consumer_secret' => "consumer_secret"
  );
  $url = "https://api.twitter.com/1.1/search/tweets.json";
  $requestMethod = "GET";
  $getfield = '?q='.$_GET['keyword'].'&result_type=recent&count=10';
  $twitter = new TwitterAPIExchange($settings);
  $string = json_decode($twitter->setGetfield($getfield)
  ->buildOauth($url, $requestMethod)
  ->performRequest(),$assoc = TRUE);
  if(array_key_exists("errors", $string)) {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
  foreach($string['statuses'] as $items)
    {
        echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo "Tweet: ". $items['text']."<br />";
        echo "Tweeted by: ". $items['user']['name']."<br />";
        echo "Screen name: ". $items['user']['screen_name']."<br />";
        echo "Followers: ". $items['user']['followers_count']."<br />";
        echo "Friends: ". $items['user']['friends_count']."<br />";
        echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
  ?>


</div>


</body>

</html>
