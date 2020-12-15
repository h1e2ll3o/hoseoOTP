<?php
include ('../db/config.php');
include ('../login/check.php');

$name=$_SESSION['name'];
$account=$_SESSION['account'];
$account_pw=$_SESSION['account_pw'];
$userID=$_POST["userid"];
$userPassword=$_POST["userpw"];
$passwordCheck=$_POST["pwcheck"];
$email=$_POST["email1"]."@".$_POST["email2"];
$phone=$_POST['phone1'].$_POST['phone2'].$_POST['phone3'];

$checkID=$con->prepare("select id from client where id=:id");
$checkID->bindParam(':id', $userID);
$checkID->execute();
$id_check =$checkID->fetchColumn();

if($userID == NULL){
  echo "<script>alert('아이디를 입력하세요.'); window.history.back();</script>";
}	else if($id_check >= 1){
  	echo "<script>alert('아이디가 중복됩니다.'); window.history.back();</script>";
}	else if($userPassword == NULL){
  	echo "<script>alert('비밀번호를 입력하세요.'); window.history.back();</script>";
}	else if($passwordCheck != $userPassword){
  	echo "<script>alert('비밀번호가 일치하지 않습니다. 다시 입력해주세요.'); window.history.back();</script>";
}	else if($email==NULL){
  	echo "<script>alert('이메일을 입력하지 않았습니다. 입력해주세요.'); window.history.back();</script>";
}	else {
	$userPassword=hash("sha256", $userPassword);


  //쿼리문 작성해서 sql 변수안에 넣어줌.
  	$stmt=$con->prepare(" update client
  	set id='$userID', password='$userPassword', email='$email', phone='$phone'
  	where account='$account'");
	$stmt->execute();
  	
  	if(empty($stmt)){
    	echo ("<script>alert('잘못되었습니다.'); window.history.back();</script>");
 	 } else{
    		echo "<script>alert('회원가입되었습니다.'); location.href='/lib/index.php'</script>";
    		unset($_SESSION['name']);
    		unset($_SESSION['account']);
    		unset($_SESSION['account_pw']);
  }
}
 ?>
