<?php

	require_once 'config_names.php';

	require_once 'config.php';

//This calls the Untappd Library
	require_once 'Untappd.php';

//This can be used to choose between CSV or MYSQL DB
	$db = true;
	
	// Setup array for all the beers that will be contained in the list
	$beers = array();
	
	if($db){
		// Connect to the database
		db();
		
		
		$config = array();
		$sql = "SELECT * FROM config";
		$qry = mysql_query($sql);
		while($c = mysql_fetch_array($qry)){
			$config[$c['configName']] = $c['configValue'];
		}
		
		$sql =  "SELECT * FROM vwGetActiveTaps";
		$qry = mysql_query($sql);
		while($b = mysql_fetch_array($qry))
		{
			$beeritem = array(
				"id" => $b['id'],
				"beername" => $b['name'],
				"untID" => $b['untID'],
				"style" => $b['style'],
				"notes" => $b['notes'],
				"og" => $b['ogAct'],
				"fg" => $b['fgAct'],
				"srm" => $b['srmAct'],
				"ibu" => $b['ibuAct'],
				"startAmount" => $b['startAmount'],
				"amountPoured" => $b['amountPoured'],
				"remainAmount" => $b['remainAmount'],
				"tapNumber" => $b['tapNumber'],
				"srmRgb" => $b['srmRgb']
			);
			$beers[$b['tapNumber']] = $beeritem;
		}
		
		$tapManager = new TapManager();
		$numberOfTaps = $tapManager->GetTapNumber();
	}



 function utBreweryFeed($config) {
//Only checkins if $BreweryID is set
		if($config['ClientID']){ 

$utconfig = array(
    'clientId'     => $config['ClientID'],
    'clientSecret' => $config['ClientSecret'],
    'redirectUri'  => '',
    'accessToken'  => '',
);



$cachefile = "cache/bfeed";
$filetimemod = filemtime($cachefile)+1800;
if (time()<$filetimemod) {
include $cachefile;
} else {
ob_start();
$buntappd = new Pintlabs_Service_Untappd($utconfig);
try {
    
    $bfeed = $buntappd->breweryFeed($config['BreweryID'], '','', '4');
    
} catch (Exception $e) {
    die($e->getMessage());
} 

  
$bfeeds .="<table width=95%><tr>";

foreach ($bfeed->response->checkins->items as $i) {
    
        $j = $i->beer->beer_name;
        $bfeeds .="<td width=20%><table width=95%><tr><td><div class='beerfeed'>";
        $bfeeds .="<center><div class=circular style='width: 50px;height: 50px;background-image: url(". $i->user->user_avatar .");background-size: cover;display: block;border-radius: 100px;-webkit-border-radius:  100px;-moz-border-radius: 100px;'></div>";
      $bfeeds .="".$i->user->user_name."<br />";

      $bfeeds .=$i->beer->beer_name;

      $bfeeds .="</td></tr></table>";
      $bfeeds .="</div></td>";
 
}

$bfeeds .="</tr></table>";
    $fp = fopen($cachefile, 'w');
    fwrite($fp, $bfeeds);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
} else {

echo "";
}
}

function beerIMG($config,$untid) {
// This section calls for the rating from Untappd
                                                       
   $beerImg = '';																				
//Only Display rating if $Client[id] is set
if($config[ConfigNames::ClientID] && $untid!='0'){ 

$cachefile = "cache/".$untid.".img";
$filetimemod = filemtime($cachefile)+86400;
if (time()<$filetimemod) {
include $cachefile;
} else {
ob_start();	                                                                                      
$utconfig = array(
    'clientId'     => $config['ClientID'],
    'clientSecret' => $config['ClientSecret'],
    'redirectUri'  => '',
    'accessToken'  => '',
);


$untappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $feed = $untappd->beerInfo($untid);
}  catch (Exception $e) {
    die($e->getMessage());
}
$beerImg = "<img src=".$feed->response->beer->beer_label." border=0 width=75 height=75>";
$fp = fopen($cachefile, 'w');
    fwrite($fp, $beerImg);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
} else {

$beerImg = '';
} 
}

function BeerRating($config,$untid) {
// This section calls for the rating from Untappd
                                                       
   																
//Only Display rating if $Client[id] is set
if($config[ConfigNames::ClientID] && $untid!='0'){ 
$cachefile = "cache/".$untid.".rating";
$filetimemod = filemtime($cachefile)+86400;
if (time()<$filetimemod) {
include $cachefile;
} else {
ob_start();		                                                                                      
$utconfig = array(
    'clientId'     => $config['ClientID'],
    'clientSecret' => $config['ClientSecret'],
    'redirectUri'  => '',
    'accessToken'  => '',
);

$untappd = new Pintlabs_Service_Untappd($utconfig);
try {
    $feed = $untappd->beerInfo($untid);
}  catch (Exception $e) {
    die($e->getMessage());
}


$rs = $feed->response->beer->rating_score;

if ($rs >= '0' && $rs<'.5') {
 $img = "<span class=\"rating small r00\"></span>";
} else if ($rs=='.5') {
$img = "<span class=\"rating small r05\"></span>";
} else if ($rs >'.5' && $rs<'1.5') {
$img = "<span class=\"rating small r10\"></span>";
} else if ($rs=='1.5') {
$img = "<span class=\"rating small r15\"></span>";
} else if ($rs >'1.5' && $rs <'2.5') {
$img = "<span class=\"rating small r20\"></span>";
} else if ($rs =='2.5' ) {
$img = "<span class=\"rating small r25\"></span>";
} else if ($rs >'2.5' && $rs < '3.5') {
$img = "<span class=\"rating small r30\"></span>";
} else if ($rs=='3.5') {
 $img = "<span class=\"rating small r35\"></span>";
}  else if ($rs > '3.5' && $rs< '4.5') {
 $img = "<span class=\"rating small r40\"></span>";
} else if ($rs =='4.5') {
$img = "<span class=\"rating small r45\"></span>";
} else if ($rs>'4.5') {
$img = "<span class=\"rating small r50\"></span>";
} 
$fp = fopen($cachefile, 'w');
    fwrite($fp, $img);
    fclose($fp);

ob_end_flush();
include $cachefile;
}
} else {
$img = '';



} 
}
