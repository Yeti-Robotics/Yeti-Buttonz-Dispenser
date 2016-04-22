<?php
$tweetIdFile = "tweetId.txt";
$twitterUrl = "https://api.twitter.com/1.1/search/tweets.json?q=%23yetibuttonz&since_id=";
$photonFunctionUrl = "https://api.particle.io/v1/devices/" . "photon id" . "/dispense?access_token=" . "access token";

//Get the tweet the photon last dispensed for
$lastTweetId = file_get_contents($tweetIdFile);
//var_dump($lastTweetId);
//Searches twitter for tweets past the tweet id
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $twitterUrl . $lastTweetId);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 25);
curl_setopt($ch, CURLOPT_HTTPHEADER, array (
	"Authorization: " . ""
));
$responsejson = json_decode(curl_exec($ch), true);
curl_close($ch);
var_dump($responsejson);

if(!empty($responsejson["statuses"])) {
	$newId = $responsejson["statuses"][0]["id_str"];
	$statusCount = count($responsejson["statuses"]);
	//Call the function on the photon
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $photonFunctionUrl);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 25);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "args=" . $statusCount);
	var_dump(curl_exec($ch));
	curl_close($ch);
	
	file_put_contents($tweetIdFile, $newId);
	//echo($newId);
}
?>
