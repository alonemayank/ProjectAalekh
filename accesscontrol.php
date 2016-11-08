<?php 

// accesscontrol.php
require_once('LIB_project1.php');

session_start();

$display= new DB();

$var2=$display->headerSec();

$logincall= new DB();

if( isset($_POST['uid']) OR isset($_SESSION['uid'])){

$uid = isset($_POST['uid']) ? $_POST['uid'] : $_SESSION['uid'];
$pwd = isset($_POST['pwd']) ? sha1($_POST['pwd']) : ($_SESSION['pwd']);

}

// Display login form if not logged in

if(!isset($uid)) {
  echo $var2;
  $loginFormData= $logincall->getLoginForm();
  echo $loginFormData;

  $var3=$display->footerSec();

  echo $var3;  
  exit(" ");
}

$_SESSION['uid'] = $uid;
$_SESSION['pwd'] = $pwd;

$self=$_SERVER['PHP_SELF'];

$auth=$logincall->databaseQ($uid,$pwd);

if($auth==0){
   echo $var2;
   echo $uid."<br/>";
   echo $pwd."<br/>";
   echo $_SESSION['uid']."<br/>";
   echo $_SESSION['pwd']."<br/>";
   unset($_SESSION['uid']);
   unset($_SESSION['pwd']);
   echo "<h1> Access Denied </h1>
        <p>Wrong Credentials, Please register or to login again <a href='$self'>Click Here</a>
       . To Register <a href='signup.php'> Click Here</a>.</p>";
       exit(" ");
  }

if($uid!="admin"){

$var2=$display->headerSec();
echo $var2;
}

else{


$var2=$display->AdminheaderSec();



echo $var2;
}


?>
