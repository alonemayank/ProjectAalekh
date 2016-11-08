<?php
	
		$tempStr = "";
		$x = file_get_contents("11.xml");
		$pos1 = strpos($x,'[[Category:');
		if($pos1 != ""){
			// echo "found $i<br>";
			$y1 = strstr($x,"[[Category:");
			$z = explode(']]', $y1);
			
			for($j=0;$j<=count($z)-2;$j++){
				$cat = explode(':', $z[$j]);

				$foundN = strpos($cat[1],"|");					
				if($foundN != ""){
					// echo $cat[1];
					$cat[1] = str_replace("|", "", $cat[1]);
					// echo $cat[1];
				}
				// echo "<br> $temp";
				// $temp .= ",";
								// echo "<br> $temp";
				$tempStr .= $cat[1];				
								// echo "<br> $tempStr";
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
		echo $tempStr;

?>