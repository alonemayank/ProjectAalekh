<?php 

	require('accesscontrol.php');

	$uniCount=0;
	

	$user="apurvat1_test";
			$pass="#Mayank28273";
			$db="apurvat1_aalekh";
			$host="localhost";

	if(isset($_POST)){
		
		$title= $_POST['search'];

		$connection= new mysqli($host,$user,$pass,$db);
		//========================================================================//
		$query = "select * from rank where link like '%$title%' order by weight desc";
		

		//echo $query;
		$stmt= $connection->prepare($query);
		//$stmt->bind_param("s",$title);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($user,$term,$link,$weight,$id,$file);
		$data = array();
		if($stmt->num_rows>0){
			echo "<h2>User Specific Recommendations </h2>";
			echo "<a href='#reco'>Click here for General Recommendations</a>";
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
			//echo "<h2 id='search'>Total No of Results : $count </h2>";
			//echo "<a href='#reco'>Click here for Recommendations</a>";
			
		
			foreach($data as $row){
				echo "<hr/>";
				echo "<h2 class='headingR'>{$row['term']} </h2>
				<table border=0><tr><th>File </th><th>Actual Article</th></tr>";
				echo "<tr><td><a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword={$_POST['search']}&term={$row['term']}&filename={$row['file']}&count={$row['weight']}&wikipedia=false'>file: {$row['file']}</a> </td>";
				echo "<td><a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword={$_POST['search']}&term={$row['term']}&filename={$row['file']}&count={$row['weight']}&wikipedia=true'>Wikipedia Link</a></td></tr> ";
				echo "</table>";
				
				echo "<hr/>";
			}
			
			
		}else{
			//echo "<h2>Spelling correction</h2>";
			//header('Location: index.php?check='.$title);
		}
			//======================================================================//
		$query = "select * from titleindex where term like '%$title%' order by clickCount desc";


		//echo $query;
		$stmt= $connection->prepare($query);
		//$stmt->bind_param("s",$title);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id,$term,$file,$category,$clickCount);
		$data = array();
		if($stmt->num_rows>0){
			$uniCount++;
			while($stmt->fetch()){
				$data[]=array("id"=>$id,
					"term"=>$term,
					"file"=>$file,
					"category"=>$category,
					"clickCount"=>$clickCount);
			}
		
			$count = count($data);
			echo "<h2 id='search'>Total No of Results : $count </h2>";
			echo "<a href='#reco'>Click here for Recommendations</a>";
			
		
			foreach($data as $row){
				echo "<hr/>";
				echo "<h2 class='headingR'>{$row['term']} </h2>
				<table border=0><tr><th>File </th><th>Actual Article</th></tr>";
				echo "<tr><td><a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword={$_POST['search']}&term={$row['term']}&filename={$row['id']}&count={$row['clickCount']}&wikipedia=false'>file: {$row['file']}</a> </td>";
				echo "<td><a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword={$_POST['search']}&term={$row['term']}&filename={$row['id']}&count={$row['clickCount']}&wikipedia=true'>Wikipedia Link</a></td></tr> ";
				echo "</table>";
				if(!empty($row['category'])){
				echo "<h4>Tags</h4><p>{$row['category']}</p>";
				}
				echo "<hr/>";
			}
			
			
		}else{
			//echo "<h2>Spelling correction</h2>";
			header('Location: index.php?check='.$title);
		}
		
		// Recommendation Table

		$query = "select * from titleindex where category like '%$title%' AND  term NOT LIKE '%$title%' order by clickCount desc";
		//echo $query;
		$stmt= $connection->prepare($query);
		//$stmt->bind_param("s",$title);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id,$term,$file,$category,$clickCount);
		$data = array();
		if($stmt->num_rows>0){
			if($uniCount == 1){
				echo "<h2 id='reco'> Recommendations </h2>";
				echo "<a href='#search'>Click here for Search Results</a>";
			}
			else{
				echo "<h2> No exact match found here are some Recommendations</h2>";
			}

			$uniCount++;
			while($stmt->fetch()){
				$data[]=array("id"=>$id,
					"term"=>$term,
					"file"=>$file,
					"category"=>$category,
					"clickCount"=>$clickCount);
			}
			
			$count = count($data);
			echo "<h2>Total No of Recommendations : $count </h2>";
			
			
			foreach($data as $row){
				echo "<hr/>";
				echo "<table border=1><tr><th>Recommended Article </th><th>File </th><th>Actual Article</th></tr>";
				echo " <tr><td>{$row['term']} </td><td>  <a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword={$_POST['search']}&term={$row['term']}&filename={$row['id']}&count={$row['clickCount']}&wikipedia=false'>file: {$row['file']}</a> </td>";
				echo "<td><a onclick='refreshPage()' target='_blank' href='increaseCount.php?keyword={$_POST['search']}&term={$row['term']}&filename={$row['id']}&count={$row['clickCount']}&wikipedia='true'>Wikipedia Link</a></td></tr> ";
				echo "</table>";
				echo "<h4>Tags</h4><p>{$row['category']}</p>";

			}
			
			//echo "</table>";
		}

		if($uniCount == 0){
			echo "<h2> No Result Found !! </h2>";
		}

		echo "<br/><a href='index.php'> Home </a>";
	}else{
		header('Location: index.php');
	}
	
?>

</body>
</html>