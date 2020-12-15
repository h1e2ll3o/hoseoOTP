<?php
	//error_reporting(E_ALL);
	//ini_set('display_errors',1);

function is_login(){
	global $con;

	if (isset($_SESSION['id']) && !empty($_SESSION['id'])){
		$stmt = $con->prepare("select id from client where id=:userid");
		$stmt->bindParam(':userid', $SESSION['id']);
		$stmt->execute();
		$count = $stmt->rowcount();

		if($count == 1){return true;}
		else {return false;}
	}
	else{return false;}
}
?>
