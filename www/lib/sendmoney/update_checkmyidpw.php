<?php
include "../db/config.php";
include '../login/check.php';

if(!isset($_SESSION["id"])){
  echo "<script>alert('로그인 후 이용하세요.'); location.href='/lib/index.php';</script>";
}	else{
	if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
	  	$userID=$_POST['userID'];
	  	$userPassword=$_POST['userPassword'];

		if($userID == $_SESSION['id']){
		  	$stmt=$con->prepare("select password from client where id=:userID");
		  	$stmt->bindParam(':userID', $userID);
			$stmt->execute();
			$row=$stmt->fetch();

		  	$userPassword=hash("sha256", $userPassword);

			if($userPassword == $row['password']){
				header('Location: banktransfer.php');
			}else {
				echo"<script>alert('비밀번호가 틀렸습니다.');  window.history.back();</script>";
		  	}
		}	else{
			echo"<script>alert('아이디가 틀렸습니다.');  window.history.back();</script>";
		}
	}
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
	<link rel="stylesheet" type="text/css" href="../../css/common.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<style>
		#button { margin: 20px 0px 0px 100px; width: 25%; }
		h2 { margin: auto; width: 50%; }
	</style>
  </head>
  <body>
	<div id="header">
      	<?php include "../components/top.php"; ?>
    </div>
    <div id="content">
		<h2>계정 확인</h2>
      <form method="post">
          <table align="center" border="0" cellspacing="0" width="300">
                <tr>
						<td><b>아이디</b></td>
                    	<td width="130" colspan="1" style="padding:10px 10px 5px 10px">
                      <input type="text" name="userID" class="inph" size='20' placeholder="아이디를 입력하세요">
                  	</td>
              </tr>
              <tr>
					<td><b>비밀번호</b></td>
                  <td width="130" colspan="1" style="padding:10px 10px 5px 10px">
                    <input type="password" name="userPassword" class="inph" size='20' placeholder="비밀번호를 입력하세요">
                </td>
            </tr>
      		</table>
      	<input type="submit" id='button' name='submit' value="확인" class="btn btn-outline-success">
      </form>
    </div>
  </body>
</html>
