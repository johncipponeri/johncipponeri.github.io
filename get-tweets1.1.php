<?php
session_start();
require_once("twitteroauth/twitteroauth.php"); //Path to twitteroauth library
 
$twitteruser = "johncipponeri";
$notweets = 30;
$consumerkey = "iS8Ex6IugAgWmeskKAg8FqOsX";
$consumersecret = "OE6o79MZChLuIqTnfknRgK9JGWQF6JL8n5yC7uCVDuCgrQqggz";
$accesstoken = "436182644-fFRODqLNeCnTO2vWlRHNLtWokoOn86T1mZKG3ICz";
$accesstokensecret = "Oc467TCVrNlc7XWRAYWHqTGVM92NWdGuNk9BzpH1FMxWe";
 
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
  $connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
  return $connection;
}
 
$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);
 
echo json_encode($tweets);
?>