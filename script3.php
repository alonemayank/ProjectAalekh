<?php

	// Script to insert terms and category into database
	
	//Connection for Database
	$user="test2";
	$pass="test123";
	$db="aalekh";
	$host="localhost";

	//Using connection and improved mysql API
	$connection= new mysqli($host,$user,$pass,$db);
	$query = "insert into titleindex (id, term, file, category, clickCount) values (?,?,?,?,?)";
	$stmt= $connection->prepare($query);
			
	// Reading XML files
	$dom = new DOMDocument();
	$dom->load("enwik.xml");
	
	$y = intval(0);
	$items = $dom->getElementsByTagName("page");
	//Getting elements based on Page element
	foreach($items as $item){
		echo "<br/>";
		$title = $item->getElementsByTagName("title")->item(0)->nodeValue;
		echo $title;

		$cck = 0;
		$file = "$y.xml";
		$tempStr= "";
		
		// Category
		$x = file_get_contents("$y.xml");
		$pos1 = strpos($x,'[[Category:');
		if($pos1 != ""){
			// echo "found $i<br>";
			$y1 = strstr($x,"[[Category:");
			$z = explode(']]', $y1);
			
			for($j=0;$j<=count($z)-2;$j++){
				$cat = explode(':', $z[$j]);

				$foundN = strpos($cat[1],"|");					
				if($foundN != ""){
					$cat[1] = str_replace("|", "", $cat[1]);
				}
				$tempStr .= $cat[1];				
			}
		}else{
			//echo "not found  $i";
			$temp2 = strpos($x, "#REDIRECT");
			if($temp2 != ""){
				$a = strstr($x,"#REDIRECT");
				$b = explode('[[', $a);
				$c = explode(']]',$b[1]);
				// echo $c[0];
				// echo "<br>";
				
				$tempStr .= $c[0];
				$c[0] .= ",";
			}
		}
		// Category ends 
		// Insert whole arguments and variables into database
		$stmt->bind_param("isssi",$y,$title,$file,$tempStr,$cck);
		$stmt->execute();
		$stmt->store_result();
		$y = intval($y) + 1;
		echo "<br>".$y;
	}
?>