<?php
    $con = mysqli_connect("localhost", "root", "hg0331", "Bank");
    mysqli_query($con,'SET NAMES utf8');

    $userURN = $_POST["userRN"];
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



if($id === $userUID) {

if($password === $userUPassword) {

  if($randomNum !== $userURN) {

   
     $response["success"] = "RN";
     $response["userID"] = $id;
     $response["userPassword"] = $password;
     $response["userCP"] = $phone;
     $response["userRN"] = $randomNum;

  }

}

}

}

    echo json_encode($response);
?>
