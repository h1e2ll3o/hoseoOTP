<?php
    $con = mysqli_connect("localhost", "root", "hg0331", "Bank");
    mysqli_query($con,'SET NAMES utf8');

    $userUID = $_POST["userID"];
    $userUPassword = $_POST["userPassword"];
    $userUUUID = $_POST["userUUID"];
    $userUUUIDCheckNB = $_POST["userUUIDCheckNB"];
	$userHashPassword = hash("sha256", $userUPassword);

    $statement = mysqli_prepare($con, "SELECT * FROM client WHERE id = ? AND password = ? OR androidID = ?");
    mysqli_stmt_bind_param($statement, "sss", $userUID, $userHashPassword, $userUUUID);
    mysqli_stmt_execute($statement);



    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $name, $id, $password, $account, $account_pw, $phone, $email, $androidID, $is_admin, $randomNum);

    $response = array();
    $response["success"] = "false";


while(mysqli_stmt_fetch($statement)) {

if(strcmp($userUUUIDCheckNB, "1")) {

if($id === $userUID) {

if($password === $userHashPassword) {

  if(empty($androidID) ) {

     $response["success"] = "UUIDnull";
     $response["userName"] = $name;
     $response["userCP"] = $phone;

  }

  else if($androidID !== $userUUUID) {

     $response["success"] = "UUIDfalse";
     $response["userName"] = $name;

  }

  else if($androidID === $userUUUID) {
     $response["success"] = "true";
     $response["userName"] = $name;
     $response["userID"] = $id;
     $response["userPassword"] = $password;
     $response["Account"] = $account;
     $response["Account_pw"] = $account_pw;
     $response["userCP"] = $phone;
     $response["userEmail"] = $email;
     $response["userUUID"] = $androidID;
     $response["Is_admin"] = $is_admin;
     $response["userRN"] = $randomNum;


   }
}
}

}



else if(strcmp($userUUUIDCheckNB, "2")) {

if($id === $userUID) {

if($password === $userHashPassword) {

if(empty($androidID)) {

    $statement = mysqli_prepare($con, "UPDATE client SET androidID = ? WHERE id = ? AND password = ?");
    mysqli_stmt_bind_param($statement, "sss", $userUUUID, $userUID, $userHashPassword);
    mysqli_stmt_execute($statement);

    $statement = mysqli_prepare($con, "SELECT * FROM client WHERE id = ? AND password = ?");
    mysqli_stmt_bind_param($statement, "ss", $userUID, $userHashPassword);
    mysqli_stmt_execute($statement);

    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $name, $id, $password, $account, $account_pw, $phone, $email, $androidID, $is_admin, $randomNum);

    mysqli_stmt_fetch($statement);

     $response["success"] = "true";
     $response["userName"] = $name;
     $response["userID"] = $id;
     $response["userPassword"] = $password;
     $response["Account"] = $account;
     $response["Account_pw"] = $account_pw;
     $response["userCP"] = $phone;
     $response["userEmail"] = $email;
     $response["userUUID"] = $androidID;
     $response["Is_admin"] = $is_admin;
     $response["userRN"] = $randomNum;



}

else if($androidID !== $userUUUID) {

     $response["success"] = "UUIDfalse";
     $response["userName"] = $name;

  }

  else if($androidID === $userUUUID) {
     $response["success"] = "true";
     $response["userName"] = $name;
     $response["userID"] = $id;
     $response["userPassword"] = $password;
     $response["Account"] = $account;
     $response["Account_pw"] = $account_pw;
     $response["userCP"] = $phone;
     $response["userEmail"] = $email;
     $response["userUUID"] = $androidID;
     $response["Is_admin"] = $is_admin;
     $response["userRN"] = $randomNum;

   }

}
}

}






}

    echo json_encode($response);
?>
