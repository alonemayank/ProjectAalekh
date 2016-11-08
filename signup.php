<?php // signup.php

require("LIB_project1.php");

$display= new DB();

$var2=$display->headerSec();

echo $var2;

echo "<h2 class='center'> Sign Up Page </h2>";

$call= new DB();

if (!isset($_POST['submitok'])){
    // Display the user signup form

  $var5= $call->displaySignUp();
  echo $var5;
}
    
else
{


    if ($_POST['newid']=='' or $_POST['newname']==''
      or $_POST['newpass']=='') {
      echo "Please fill required fields";

    }
    
    // Check for existing user with the new id
    $userid1=strip_tags($_POST['newid']);
    $newpass =strip_tags($_POST['newpass']);
    $newpass=sha1($newpass);
    $newname=strip_tags( $_POST['newname']);

    $var6=$call->SignUpUserCheck($userid1);

    
    if ($var6==1) {
        echo "<h3>A user already exist by this name. Please try again</h3>";
                      
        $var3=$display->footerSec();

        echo $var3;
        exit(" ");
    }
    
    else{
      $call->SignUpUser($userid1,$newpass,$newname);

    
         $var6=$call->SignUpSuccess();
         echo $var6;
     }
    
   }



?>

<?php

   
$var3=$display->footerSec();

echo $var3;

?>
