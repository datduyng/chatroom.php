
<?php

session_start();

require_once "pdo.php";

if(!$_SESSION["name"] || !$_SESSION['user_id']){
	if(!$_SESSION['user_id']) 
		$_SESSION['error'] = "Please login. No user ID";
	else
		$_SESSION['error'] = "Please login. No User name";
	header("Location: index.php");
}


if(isset($_GET['from']) && isset($_GET['to']) ){


	$q = "SELECT u.user_id, u.name as username, m.content, m.t_stamp FROM messages as m
			INNER JOIN users as u ON u.user_id=m.user_id
			WHERE t_stamp>='".$_GET['from']."' AND t_stamp<'".$_GET['to']."'
			ORDER BY t_stamp"; 
	$stmt = $pdo->prepare($q);
	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	ob_clean();
	header('Content-Type: application/json'); 
    $params = array(
        'type' => 'success',
    	'user_id' => $_SESSION['user_id'],
    	'username' => $_SESSION['name'], 
        'data' => [],
        'log' => $stmt_param
    );

    $messages = array();

	foreach ($results as $row) {
		array_push($messages, [
			'username' => $row['username'], 
			'content' => $row['content'],
			'timestamp' => $row['t_stamp']
		]);
	}
	$params['data'] = $messages;
	$params['log'] = "OK FINE";
     
	echo json_encode($params, JSON_PRETTY_PRINT);
}
