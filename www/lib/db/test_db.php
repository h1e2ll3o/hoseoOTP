<?php
error_reporting(E_ALL);

ini_set("display_errors", 1);

$host="localhost";
$user="root";
$password="123456";
$dbName="user";

$connect=mysqli_connect($host,$user,$password, $dbName);
// mysqli->select_db("user");

$sql="select accountnum from user_info where accountnum = 12345 and name = '강민지'";
$result=mysqli_query($connect, $sql);
var_dump($result->num_rows);
// print_r(mysqli_fetch_array($result));
$row=mysqli_fetch_array($result);
if(!$row){
  echo "db에 없습니다.";
}
else{
echo $row['accountnum'];  
}

// print_r($row);
// if (!$row['accountnum']) {
//     echo "Error: " . $sql . "" . $connect->error;
// } else {
//     echo "존재하는 값 입니다.";
// }
 ?>
