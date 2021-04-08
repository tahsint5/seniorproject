<?php
$game = "Call of Duty";
$url = "https://api.isthereanydeal.com/v02/search/search/?key=6c235fc36e0e145a03011c4a28b4acfc9d4cb418&q=" . $game . "&limit=10&strict=0";

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_VERBOSE, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
$response = curl_exec($ch);

curl_close($ch);

$data = json_decode($response);

//Database connection
$dsn = 'mysql:host=localhost;dbname=games';
	$username = 'root';
	$password = '';
	
try{
	$db = new PDO($dsn, $username, $password);
} catch(PDOException $e) {
	$error_message = $e->getMessage();
	print($error_message);
	exit();
}

for($i=0;$i<5;$i++) {
	$game = $data->data->results[$i]->title;
	$query = "INSERT INTO videogamenames
				(Name)
			VALUES
				('$game')";
	$db->exec($query);
}
?>

<div><?php for($i=0; $i<5; $i++) { echo $data->data->results[$i]->title."<br>";} ?></div> 		