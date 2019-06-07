caveman_rock2<?php
session_start();


if(!$_SESSION["name"] || !$_SESSION['user_id']){
	if(!$_SESSION['user_id']) 
		$_SESSION['error'] = "Please login. No user ID";
	else
		$_SESSION['error'] = "Please login. No User name";
	header("Location: index.php");
}



require_once "pdo.php";

if(isset($_GET['message'])){
	$q = "INSERT INTO messages (user_id, content) VALUES (:user_id, :content)"; 
	$stmt = $pdo->prepare($q);
	$stmt->execute([':user_id'=>$_SESSION['user_id'], ':content'=>$_GET['message'] ]);

    $params = array(
        'type' => 'success',
    	'user_id' => $_SESSION['user_id'],
    	'name' => $_GET['name'], 
        'data' => ""
    );

	ob_clean();
	header('Content-Type: application/json');      
	echo json_encode($params, JSON_PRETTY_PRINT);
}