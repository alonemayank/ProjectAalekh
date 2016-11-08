<?php
	
	require_once('accesscontrol.php');
	
	$user="test2";
	$pass="test123";
	$db="aalekh";
	$host="localhost";


	$term=$_GET['term'];
	$keyword=$_GET['keyword'];
	$userName=$_SESSION['uid'];
	$count = $_GET['count'];
	$testT = substr($_GET['filename'], -4);
	if($testT!=".xml"){
	$file = "{$_GET['filename']}.xml";}
	else{
		$file = "{$_GET['filename']}";
	}

	echo $file;
	$newCount = $count + 1;
	$connection= new mysqli($host,$user,$pass,$db);
	
	$query = "select id from rank where user = ? and term = ? and link = ?";
	$stmt= $connection->prepare($query);
	$stmt->bind_param("sss",$userName,$term,$keyword);
	$stmt->execute();
	$stmt->store_result();
	$insertId = $stmt->insert_id;
	echo $insertId;
	if($stmt->num_rows > 0){
		echo "exists";
		$query = "update rank set weight='$newCount' where user = ? and term = ? and link = ?";
		if($stmt= $connection->prepare($query)){
			$stmt->bind_param("sss",$userName,$term,$keyword);
			$stmt->execute();
			$stmt->store_result();	
		}
		
	}else{
		echo "does not exist";
		$query = "insert into rank (user,term,link,file,weight) values (?,?,?,?,?)";
		$stmt= $connection->prepare($query);
		$stmt->bind_param("ssssi",$userName,$term,$keyword,$file,intval($newCount));
		$stmt->execute();
		$stmt->store_result();
	}

	if($_GET['wikipedia'] == "false"){	//open xml file not wikipedia link
		header('Location: '.$file);
	}else{
		header("Location: https://en.wikipedia.org/wiki/{$_GET['term']}");
	}
















	//var_dump($connection);
	/*$query = "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
	BEGIN TRANSACTION;
	UPDATE rank SET  weight='$newCount'  WHERE uesr='$userName' AND term='$keyword' AND link='$term' AND file='$file';
	IF @@ROWCOUNT = 0
	BEGIN
	INSERT INTO rank (user,term,link,file,weight) VALUES('$userName','$keyword','$term','$file','0');
	END
	COMMIT TRANSACTION;";
	echo $query;*/

/*UPDATE aalekh.rank SET  weight='$newCount'  WHERE uesr='$userName' AND term='$keyword' AND link='$term' AND file='$file';
IF @@ROWCOUNT = 0
BEGIN
*/

	/*
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
BEGIN TRANSACTION;
UPDATE aalekh.rank SET  weight=$newCount  WHERE uesr=$userName AND term=$keyword AND link=$term AND file=$file ;
IF ROWCOUNT = 0
BEGIN
  INSERT INTO aalekh.rank (user,term,link,file,weight) VALUES($user,$keyword,$term,$file,'0');
END
COMMIT TRANSACTION;

*/

/*
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
BEGIN TRANSACTION;
UPDATE dbo.table SET ... WHERE PK = @PK;
IF @@ROWCOUNT = 0
BEGIN
  INSERT dbo.table(PK, ...) SELECT @PK, ...;
END
COMMIT TRANSACTION;

*/
?>