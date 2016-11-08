
<?php

		//--------------- Header of the all pages Normal Users --------------------//

class DB { 

	protected $connection;

		function __construct(){

			$user="apurvat1_test";
			$pass="#Mayank2827";
			$db="apurvat1_aalekh";
			$host="localhost";

			//require_once("../../../dbInfo.php");

			try{	
				$this->connection = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
				//change error reporting
				$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
			}catch(PDOException $e){
				die("Bad database connection to ApurvaTripathi");
			}
		
		}//Constructor End

			// Check if signed in user exist in database
		function SignUpUserCheck($userid1){

			echo $userid1;

			$query="SELECT COUNT(*) FROM user WHERE userid = '$userid1' ";
			
			$total = $this->connection->query($query)->fetchColumn();

			if($total>0){
				return 1;
			}

			else{

			return 0;
			}


		}

		// Insert new user into database
		function SignUpUser($userid1,$newpass,$newname){


			try{		
				$query="INSERT INTO user SET userid = :userid1, password = :newpass, fullname = :newname ";
			
			
			if($stmt= $this->connection->prepare($query)){
			
				
				$stmt->bindParam("userid1",$userid1,PDO::PARAM_STR);
				$stmt->bindParam("newpass",$newpass,PDO::PARAM_STR);
				$stmt->bindParam("newname",$newname,PDO::PARAM_STR);

				$stmt->execute();
				
				
			}// if condition end

			
		}
			catch(PDOException $e){
				echo $e->getMessage();
				die();
			}
		}

		function signUpSuccess(){
			$var11="<p><strong>User registration successful!</strong></p>
    <p>To log in,<a href='index.php'>Click Here</a> </p>";

       return $var11;
		}
//----------------- Database query to check authentication------------------------//
function databaseQ($uid,$pwd){
		
		$returnVar="default return value";

		
		try{	
				$query="SELECT * FROM user WHERE userid = :uid AND password = :pwd ";
							
			if($stmt= $this->connection->prepare($query)){
			
				
				$stmt->bindParam("uid",$uid,PDO::PARAM_STR);
				$stmt->bindParam("pwd",$pwd,PDO::PARAM_STR);
				
				$stmt->execute();
				$result=$stmt->fetchColumn();
				
				
			}// if condition end

			if (!$result) {
			 $returnVar="Database Error";
			 return $returnVar; 
			}

			if ($result == 0) {

				$check = 0;

			 return $check;
			  
			}

			return 1;

			
		}
			catch(PDOException $e){
				echo $e->getMessage();
				die();
			}
		
		
			
				}// Database function Q ends here

		function headerSec(){

			$head="<!DOCTYPE html>
			<html>
			    
			    <head>
			        <meta charset='utf-8'>
			        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
			        <meta name='viewport' content='width=device-width'>
			        <title>Aalekh</title>
			        <meta name='description' content='An interactive getting started guide for Brackets.'>
			        <link href='https://fonts.googleapis.com/css?family=Petit+Formal+Script' rel='stylesheet' type='text/css'>
			        <link href='https://fonts.googleapis.com/css?family=Vidaloka' rel='stylesheet' type='text/css'>
			        <link rel='stylesheet' href='css/style.css'>
			        <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
			        <link rel='icon' type='image/png' href='images/favicon.png' />
			        <script src='include/include.js'></script>
			         <script>
			        	function refreshPage(){
			        		setTimeout(function(){ location.reload(true); }, 1000);
			        	}
			        	</script>
			    </head>
			     <body>
			       <header>
			           <div id='logo'>
							<img alt='Image Loading  Failed' id='img1' src='images/Drawing.png'>
			           </div>   
			           <div id='headh'>
			           		<h1 id='headh1'>Aalekh</h1>
			           		<h2 id='headh2'>Search Unlimited</h2></div>
			           		<nav>
			               		<hr>
			    				<h3>
			    			 ";

			    			 $head2=" ";

			    				if(isset($_SESSION['uid'])){	
			    					$head2.="<a href='#'>Welcome <strong>{$_SESSION['uid']}</strong> !</a>
									<a id='nav2' href='index.php'>Home</a>
									<a id='nav3' href='logout.php'>Log Out</a>";
								}

								$head2.="
								</h3>
			               		<hr>
							</nav>
					</header>
			        <div id='container'>";
			        $result=$head.$head2;

        return $result;
		}

//--------------- Header of the all pages Admin Users --------------------//
			function AdminheaderSec(){

			$head="<!DOCTYPE html>
			<html>
			    
			    <head>
			        <meta charset='utf-8'>
			        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
			        <meta name='viewport' content='width=device-width'>
			        <title>Aalekh</title>
			        <meta name='description' content='An interactive getting started guide for Brackets.'>
			        <link href='https://fonts.googleapis.com/css?family=Petit+Formal+Script' rel='stylesheet' type='text/css'>
			        <link href='https://fonts.googleapis.com/css?family=Vidaloka' rel='stylesheet' type='text/css'>
			        <link rel='stylesheet' href='css/style.css'>
			        <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
			        <link rel='icon' type='image/png' href='images/favicon.png' />
			          <script src='include/include.js'></script>
			          <script>
			        	function refreshPage(){
			        		setTimeout(function(){ location.reload(true); }, 1000);
			        	}
			        	</script>
			    </head>
			   <body>
			       <header>
			           <div id='logo'>
							<img alt='Image Loading  Failed' id='img1' src='images/Drawing.png'>
			           </div>   
			           <div id='headh'>
			           		<h1 id='headh1'>Aalekh</h1>
			           		<h2 id='headh2'>Search Unlimited</h2></div>
			           		<nav>
			               		<hr>
			    				<p>
									<a href='#'>Welcome {$_SESSION['uid']} !!</a>
									<a id='nav2' href='index.php'>Home</a>
									<a id='nav3' href='logout.php'>Log Out</a>
									<a href='script2.php'>Split Files </a>
									<a href='script3.php'> Index Files</a>
								</p>
			               		<hr>
							</nav>
					</header>
			        <div id='container'>";

        return $head;
		}

	//-----------------------Footer for all pages----------------------//

		function footerSec(){

			$foot="</div>
		      <footer><nav>
		               <hr />

		    <p>
		        <a id='fnav1' href='index.php'>Home</a>
		        <a id='fnav5' href='#'>References</a>
		        <a id='fnav6' href='#'>Destinations</a>
		    </p>
		          <img alt='common creative' src='images/cc.logo.svg'>
		          <img id='footrit' alt='RIT LOGO' src='images/tiger_walking_rit_color.gif'>
		               <hr />
		</nav></footer>

		           </body>
		</html> ";

			return $foot;
		}

		//------------------------------------SignUp-------------------------------//

		function displaySignUp(){
			$temp=$_SERVER['PHP_SELF'];
						$var10="<h3>New User Registration Form</h3>
			<p>All are required fields</p>
			
			<form method='post' action='$temp'>
			<table>
			
			    <tr>
			        <td >
			            <p>User ID</p>
			        </td>
			        <td>
			            <input name='newid' type='text' maxlength='20' size='20' />
			           
			        </td>
			    </tr>
			    <tr>
			        <td >
			            <p>Full Name</p>
			        </td>
			        <td>
			            <input name='newname' type='text' maxlength='20' size='20' />
			           
			        </td>
			    </tr>
			    <tr>
			        <td>
			            <p>Password</p>
			        </td>
			        <td>
			            <input name='newpass' type='password' maxlength='16' size='20' />
			            
			        </td>
			    </tr>
			   
			    <tr>
			        <td >
			            <hr />
			           
			            <input type='submit' name='submitok' value='   OK   ' />
			        </td>
			    </tr>
			</table>
			</form>";

			return $var10;
		}

	
		//------------------------Login form for all pages------------------------//

		function getLoginForm(){
	$self=$_SERVER['PHP_SELF'];
	$loginForm="  <h1> Please Login </h1>
				  <p>Please register if you are not registered user <a href='signup.php'>click here</a>
				  </p>
				 
				  <form method='post' action='$self'>
				   <table>
				    <tr><td>User ID: <input type='text' name='uid' size='8' /></td></tr>
				    
				    <tr><td>Password: <input type='password' name='pwd' size='8' /></td></tr>
				    
				    <tr><td><input type='submit' class='normal' value='Log in' /></td></tr>
				  </table>
				  </form>
				  
				  ";

	return $loginForm;
} // Get login form function ends here

}// Class ends here
?>