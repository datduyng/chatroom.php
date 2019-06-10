<?php
ob_clean();

session_start();

require_once "pdo.php";



if(!$_SESSION["name"] || !$_SESSION['user_id']){
	if(!$_SESSION['user_id']) 
		$_SESSION['error'] = "Please login. No user ID";
	else
		$_SESSION['error'] = "Please login. No User name";
	header("Location: index.php");
}




if(isset($_GET['message']) && isset($_GET['timestamp']) ){
	$q = "INSERT INTO messages (user_id, content, t_stamp) VALUES (:user_id, :content, :timestamp)"; 
	$stmt = $pdo->prepare($q);
	$stmt->execute([':user_id'=>$_SESSION['user_id'], ':content'=>$_GET['message'], ':timestamp'=>$_GET['timestamp'] ]);
	
    $params = array(
        'type' => 'success',
    	'user_id' => $_SESSION['user_id'],
    	'name' => $_SESSION['name'], 
		'timestamp' => $_GET['timestamp'],
        'data' => ""
    );
     
	echo json_encode($params, JSON_PRETTY_PRINT);
}
