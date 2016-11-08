<?php
	
	$user="test2";
	$pass="test123";
	$db="aalekh";
	$host="localhost";

	$count = $_GET['count'];
	$file = "{$_GET['filename']}.xml";
	// echo $count."             ".$file;
	$newCount = $count + 1;
	$connection= new mysqli($host,$user,$pass,$db);
	$query = "update titleindex set clickCount = $newCount where id = {$_GET['filename']}";
	// echo $query;
	$stmt= $connection->prepare($query);
	$stmt->execute();

	if($_GET['wikipedia'] == "false"){	//open xml file not wikipedia link
		header('Location: '.$file);
	}else{
		header("Location: https://en.wikipedia.org/wiki/{$_GET['term']}");
	}

	

?>