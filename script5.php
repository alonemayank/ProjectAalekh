<?php
	
	// for($i=0;$i<120;$i++){
		$x = file_get_contents("2311.xml");
		$pos1 = strpos($x,'[[Category:');
		if($pos1 != ""){
			// echo "found $i<br>";
			$y = strstr($x,"[[Category:");
			$z = explode(']]', $y);

			for($j=0;$j<=count($z)-2;$j++){
				$cat = explode(':', $z[$j]);
				$temp = str_replace("|", "", $cat[1]);
				echo " $temp <br>";
			}
		}else{
			//echo "not found  $i";
			$temp2 = strpos($x, "#REDIRECT");
			if($temp2 != ""){
				$a = strstr($x,"#REDIRECT");
				$b = explode('[[', $a);
				$c = explode(']]',$b[1]);
				echo $c[0];
				echo "<br>";
			}
		}
		echo "<br>";
	// }
?>