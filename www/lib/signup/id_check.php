<?php
	include ('../db/config.php');
	if($_POST['userid'] != NULL){
	   	$stmt=$con->prepare("select count(*) from client where id=:id");
		$stmt->bindparam(':id', $_POST['userid']);
		$stmt->execute();
		$id_check=$stmt->fetchColumn();
 
		if($id_check >= 1){
			echo "이미 사용하고 있는 아이디입니다.";
		} else {
			echo "사용 가능한 아이디입니다.";
		}
	} 

?>
