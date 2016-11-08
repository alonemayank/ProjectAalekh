
<?php require('accesscontrol.php'); 

	$words = array();

	function addTo($line){
    	return strtolower(trim($line));
	}

	function editDistance($s1,$s2){

        $m = array(array());

        //initialize matrix with 0
        for ($row = 0; $row <= strlen($s1); $row++){
            for ($col = 0; $col <= strlen($s2); $col++){
                if($col == 0)
                    $m[$row][$col] = $row;
                else
                    $m[$row][$col] = 0;

                if($row == 0)
                    $m[$row][$col] = $col;
            }
        }

        for ($row = 1; $row <= strlen($s1); $row++){
            $m[$row][1] = $row;
        }

        for ($col = 1; $col <= strlen($s2); $col++){
            $m[1][$col] = $col;
        }

        for ($row = 1; $row <= strlen($s1); $row++){
            for ($col = 1; $col <= strlen($s2); $col++){
                if($s1[$row-1] == $s2[$col-1])
                    $add = 0;
                else
                    $add = 1;
                $x = $m[$row-1][$col-1] + $add;
                $y = $m[$row-1][$col] + 1;
                $z = $m[$row][$col-1] + 1;

                $min = $x;
                if($y < $min)
                    $min = $y;

                if($z < $min)
                    $min = $z;

                $m[$row][$col] = $min;
            }
        }

        /*echo "<hr>";
        //print
        for ($row = 0; $row <= strlen($s1); $row++){
            for ($col = 0; $col <= strlen($s2); $col++){
                echo "".$m[$row][$col]."-";
            }
            echo "<br>";
        }*/

        return $m[strlen($s1)][strlen($s2)];
    }

	function checkSpelling($input, $words){
	    $suggestions = array();
/*	    if(in_array($input, $words)){
	        echo "you spelled the word right!";
	        similar_text("kinf","king",$percent);
	        echo "<br>".levenshtein("ask","asking");
	        echo "<br>".$percent;
	    }*/
	    //else{
	        /*foreach($words as $word){
	            $percentageSimilarity=0.0;
	            $input = preg_replace('/[^a-z0-9 ]+/i', '', $input);
	            similar_text(strtolower(trim($input)), strtolower(trim($word)), $percentageSimilarity);
	            if($percentageSimilarity>=90 && $percentageSimilarity<100){
	                if(!in_array($suggestions)){
	                        array_push($suggestions, $word);
	                }
	            }
	        }*/

	        if(empty($suggestions)){
	            foreach($words as $word){
	                $input = preg_replace('/[^a-z0-9 ]+/i', '', $input);
	                /*$levenshtein = levenshtein(strtolower(trim($input)), strtolower(trim($word)));
	                if($levenshtein<=2 && $levenshtein>0){
	                    if(!in_array($word,$suggestions)){
	                        array_push($suggestions, $word);
	                    }
	                }*/
	                $editdistance = editDistance(strtolower(trim($input)), strtolower(trim($word)));
	                if($editdistance == 1){// && $editdistance>0){
	                    if(!in_array($word,$suggestions)){
	                        array_push($suggestions, $word);
	                    }
	                }
	            }
	        }
	    	
	    	if(count($suggestions) > 0){
	    		 foreach($suggestions as $suggestion){
	            	echo "<br />$suggestion";
	    		}
	        }else
	        	echo "No match found";
	        }
	            /*echo "<form action='result2.php' method='post'>
	<input type='text' name='search' value='$suggestion' disabled>
	<input type='submit' value='Search'></form>"; 
	*/
	            // echo "".$suggestion;	//."<br />
	    // }
	// }

	if(isset($_GET['check'])){
		// echo "<h3>{$_GET['check']}</h3>";

		$words = array_map('addTo', file('words2.txt'));
		$words = array_unique($words);
		//var_dump($_POST);}
		echo "<h3>Looks like you spelled it wrong, did you mean? </h3>";
		//header("Location : spellcheck.php?{$_POST['search']}");
		$input = trim($_GET['check']);
	    // $sentence='';
	    // $x = stripos($input, ' ');
	    // echo "<h1>$x</h1><hr />";
	    /*if(stripos($input, ' ') !== false){
	        $sentence = explode(' ', $input);
	        foreach($sentence as $item){
	            checkSpelling($item, $words);
	        }
	    }
	    else{*/
	    checkSpelling($input, $words);
	    //}
	}

?>
<form action="result2.php" method="post">
	<lable> <h2>Search String </h2></lable>
	<input type="text" name="search" required>
	<input type="submit" value="Search">

</form>

<h3>Please search your desired searh term. You an search partial term or phrase. <br/>
	The results will display the exact matches and It will recommend articles based on the search term categeory.<br/>
	The search results contains tags that help to describe nature of article.</h3>

</body>
</html>

<?php

	$user="test2";
	$pass="test123";
	$db="aalekh";
	$host="localhost";
	$userName=$_SESSION['uid'];
		$connection= new mysqli($host,$user,$pass,$db);
		//========================================================================//
		$query = "select * from rank where user ='$userName' order by weight desc limit 5";
		

		//echo $query;
		$stmt= $connection->prepare($query);
		//$stmt->bind_param("s",$title);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user,$term,$link,$weight,$id,$file);
		$data = array();
		if($stmt->num_rows>0){
			echo "<h3>Your top searches :</h3>";
			//echo "<a href='#reco'>Click here for General Recommendations</a>";
			while($stmt->fetch()){
				$data[]=array("user"=>$user,
					"term"=>$term,
					"link"=>$link,
					"weight"=>$weight,
					"id"=>$id,
					"file"=>$file					
					);
			}
		
			$count = count($data);
					
			foreach($data as $row){
				echo "<hr/>";
				echo "<h2 class='headingR'>{$row['term']} </h2>
				<table border=0><tr><th>File </th><th>Actual Article</th></tr>";
				echo "<tr><td><a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword=$link&term={$row['term']}&filename={$row['file']}&count={$row['weight']}&wikipedia=false'>file: {$row['file']}</a> </td>";
				echo "<td><a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword=$link&term={$row['term']}&filename={$row['file']}&count={$row['weight']}&wikipedia=true'>Wikipedia Link</a></td></tr> ";
				echo "</table>";
				
				echo "<hr/>";
			}
		}
			//========================================
?>