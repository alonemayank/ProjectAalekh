<?php
	
	for($i=0;$i<12;$i++){
		$x = file_get_contents("$i.xml");
		$pos1 = stripos($x,'[[Category:');
		if($pos1 != ""){
			echo "$i";
			echo "found";
			echo "<br>";
		}else{
			echo "$i";
			echo "not found";
			echo "<br>";
		}
		/*if(strpos($x,"[[category:")){
			echo "found";
			echo "$i <br>";
		}*/
	}
	// $arr = str_split($x);
	$arr1 = strstr($x,'[[Category:');
	// print_r($arr1);
	$arr2 = preg_match('/\[\[Category\:/',$arr1,$m);
	print_r($m);

	$startsAt = strpos($arr1, "[[Category:") + strlen("[[Category:");
	$endsAt = strpos($arr1, "[[Category:", $startsAt);
	$result = substr($arr1, $startsAt, $endsAt - $startsAt); 
	print_r($result);

	/*$findme    = 'a';
	$mystring1 = 'xyz';
	$mystring2 = 'ABC';

	$pos1 = stripos($mystring1, $findme);
	$pos2 = stripos($mystring2, $findme);

	// Nope, 'a' is certainly not in 'xyz'
	if ($pos1 === false) {
	    echo "The string '$findme' was not found in the string '$mystring1'";
	}

	// Note our use of ===.  Simply == would not work as expected
	// because the position of 'a' is the 0th (first) character.
	if ($pos2 !== false) {
	    echo "We found '$findme' in '$mystring2' at position $pos2";
	}*/

