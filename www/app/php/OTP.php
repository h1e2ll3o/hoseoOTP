<?php
    $con = mysqli_connect("localhost", "root", "hg0331", "Bank");
    mysqli_query($con,'SET NAMES utf8');

    $userURN = $_POST["userRN"];
    $userUUUID = $_POST["userUUID"];
    $userUID = $_POST["userID"];
    $userUPassword = $_POST["userPassword"];


    $statement = mysqli_prepare($con, "SELECT * FROM client WHERE id = ? AND password = ?");
    mysqli_stmt_bind_param($statement, "ss", $userUID, $userUPassword);
    mysqli_stmt_execute($statement);



    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $name, $id, $password, $account, $account_pw, $phone, $email, $androidID, $is_admin, $randomNum);

    $response = array();
    $response["success"] = "false";


while(mysqli_stmt_fetch($statement)) {



if($randomNum === $userURN) {

	if($androidID === $userUUUID) {

	$key = (int)$randomNum ^ $androidID;						

	$hash_sha256 = hash("sha256", $key);

	$subrandom = (int)$randomNum % 10;		

	$hash_5 = substr($hash_sha256,$subrandom,5);		

	$hash_final = hexdec($hash_5);


	     $response["success"] = "OK";
	     $response["userCode"] = $hash_final;

	  } 

}






}

    echo json_encode($response);
?>
