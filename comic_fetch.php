<?php
function getRandomComicId(){
    $url= "https://c.xkcd.com/random/comic/";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Must be set to true so that PHP follows any "Location:" header
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$a = curl_exec($ch); // $a will contain all headers

$url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL); // This is what you need, it will return you the last effective URL

// Uncomment to see all headers
/*
echo "<pre>";
print_r($a);echo"<br>";
echo "</pre>";
*/
$url = explode('.com/',$url);
return  substr($url[1],0,-1);
}

function getComicDetails($comic_id){
$json_data = file_get_contents("https://xkcd.com/".$comic_id."/info.0.json");
// Converts it into a PHP object
$data = json_decode($json_data);
return $data;
}

?>