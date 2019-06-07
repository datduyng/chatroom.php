<?php 


session_start(); 


require_once "pdo.php";

if( isset($_SESSION['name']) && isset($_SESSION['user_id']) ){
	header("Location: view.php");
	return;
}

if( isset($_POST['cancelPost']) ){
	header("Location: index.php");  
	return;
}

if ( isset($_POST['loginPost']) && isset($_POST['name'])) {
	unset($_SESSION["name"]);  // Logout current user
	$q = "SELECT name FROM users 
						WHERE name=:name";
	$stmt = $pdo->prepare($q);
	$stmt->execute(array(':name' => $_POST['name']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	var_dump($row);

	if($row){
		print("User already exist\n");
		$_SESSION["error"] = "User already exist";
		header( 'Location: index.php' ) ;
		return;
	}else{
		$q = "INSERT INTO users (name) 
						VALUES (:name)";
		$stmt = $pdo->prepare($q);
		$stmt->execute(array(':name' => $_POST['name']));
		$user_id = $pdo->lastInsertId();
		$_SESSION['user_id'] = $user_id;
		$_SESSION['name'] = $_POST['name']; 
		header("Location: view.php");
		return;
	}

}
?>


<!DOCTYPE html>
<html>

<style type="text/css">
	/* Chat containers */
.container-custome {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

/* Darker chat container */
.darker {
  border-color: #ccc;
  background-color: #ddd;
}

/* Clear floats */
.container-custome::after {
  content: "";
  clear: both;
  display: table;
}

/* Style time text */
.time-right {
  float: right;
  color: #aaa;
}

/* Style time text */
.time-left {
  float: left;
  color: #999;
}

.col-centered {
    float: none;
    display: block;
    margin-left: auto;
    margin-right: auto;
}


.center-block {
    float: none !important
}

img {
  max-width:50%;
  max-height:50%;
}
</style>


<head>
	<title>MarkUpChat - A simple MVC based chat app</title>
	<a href="https://github.com/datduyng/markup_chat.git" target='_blank' class="github-corner" aria-label="View source on GitHub"><svg width="200" height="200" viewBox="0 0 250 250" style="fill:#151513; color:#fff; position: absolute; top: 0; border: 0; right: 0;" aria-hidden="true"><path d="M0,0 L115,115 L130,115 L142,142 L250,250 L250,0 Z"></path><path d="M128.3,109.0 C113.8,99.7 119.0,89.6 119.0,89.6 C122.0,82.7 120.5,78.6 120.5,78.6 C119.2,72.0 123.4,76.3 123.4,76.3 C127.3,80.9 125.5,87.3 125.5,87.3 C122.9,97.6 130.6,101.9 134.4,103.2" fill="currentColor" style="transform-origin: 130px 106px;" class="octo-arm"></path><path d="M115.0,115.0 C114.9,115.1 118.7,116.5 119.8,115.4 L133.7,101.6 C136.9,99.2 139.9,98.4 142.2,98.6 C133.8,88.0 127.5,74.4 143.8,58.0 C148.5,53.4 154.0,51.2 159.7,51.0 C160.3,49.4 163.2,43.6 171.4,40.1 C171.4,40.1 176.1,42.5 178.8,56.2 C183.1,58.6 187.2,61.8 190.9,65.4 C194.5,69.0 197.7,73.2 200.1,77.6 C213.8,80.2 216.3,84.9 216.3,84.9 C212.7,93.1 206.9,96.0 205.4,96.6 C205.1,102.4 203.0,107.8 198.3,112.5 C181.9,128.9 168.3,122.5 157.7,114.1 C157.9,116.9 156.7,120.9 152.7,124.9 L141.0,136.5 C139.8,137.7 141.6,141.9 141.8,141.8 Z" fill="currentColor" class="octo-body"></path></svg></a><style>.github-corner:hover .octo-arm{animation:octocat-wave 560ms ease-in-out}@keyframes octocat-wave{0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}@media (max-width:500px){.github-corner:hover .octo-arm{animation:none}.github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}}</style>
	<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
	<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="./style.css">

</head>
<body>
  <div class="container">
    

    
    <div class="page-header">
  		<h1>Welcome to MarkupChat! <small>Simple Markdown supported chat app</small></h1>
	</div>
    <?php
	if ( isset($_SESSION["error"]) ) {//flash message
		echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
		unset($_SESSION["error"]);
	}
    ?>
    <br><br> <br><br>
    <div class="form-group col-lg-5 center-block">	

		<div class="form-group">
			<h3>Login</h3>
			<form method='post'>
				<label for='nameplace' class="col-md-2 control-label">Name: </label>
				<div class="col-sm-10">
					<input type="text" id='nameplace' class="form-control" name="name" placeholder="Enter Your name here.."></p>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<input type="submit" name="loginPost" value="Login" class="btn btn-default"/>  		<input type="submit" name="cancelPost" value="Cancel" class="btn btn-default"/>
					</div>
					<div class="col-sm-offset-2 col-sm-10">
						<p><a href="<?php echo($_SERVER['PHP_SELF']);?>">Refresh</a></p>
					</div>	
				</div>
			</form>
		</div>
	</div>
  </div>






</body></html>