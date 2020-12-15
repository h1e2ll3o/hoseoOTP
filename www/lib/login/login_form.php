<?php
include "../db/config.php";
include "check.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../css/common.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title></title>
    <script>
      function go_signup(){
        location.href="../signup/signup1.php";
      		}
    </script>
  </head>
  <body>
    <div id="header">
      <?php include "../components/top.php"; ?>
    </div>
    <div id="content">
        <div id="body" style="text-align:center">
          <div id="login_box">
      		<h1>로그인</h1>
      			<form method="post"  autocomplete="off">
      				<table align="center" border="0" cellspacing="0" width="300">
              		<tr>
                  		<td width="130" colspan="1" style="padding:10px 10px 5px 10px">
                      		<input type="text" name="userID" class="inph" placeholder="아이디를 입력하세요">
                  		</td>
              		</tr>
              		<tr>
                  		<td width="130" colspan="1" style="padding:0 10px 10px 10px">
                     		<input type="password" name="userPassword" class="inph" placeholder="비밀번호를 입력하세요">
                  		</td>
              		</tr>
          			</table>
				  <input type="submit" name='login' class="btn btn-info" value="로그인">
				  <input type="button" name='singUp' class="btn btn-primary" value="회원가입" onclick="go_signup();">
				</form>
      		</div>
      		<div id="footer" style="height:50px"></div>
      	</div>
    </div>
  </body>
</html>

<?php 
if(($_SERVER['REQUEST_METHOD']=='POST') and isset($_POST['login'])){
	$userID=$_POST['userID'];
	$userPassword=$_POST['userPassword'];

	$loginOK=false;

	if(empty($userID)){
	    echo("<script> alert('아이디를 입력해 주세요'); history.back(); </script>");
	} 
	else if(empty($userPassword)){
		echo("<script> alert('비밀번호를 입력해 주세요'); history.back(); </script>");
	}
	else{
		try{
			$stmt = $con->prepare("select * from client where id=:userid");
			$stmt->bindParam(':userid', $userID);
			$stmt->execute();
			$row = $stmt->fetch();
		} catch(PDOException $e){
	 		echo("<script> alert('아이디나 비밀번호를 확인해 주세요.'); history.back(); </script>");
		}
		
		$hashPassword=hash("sha256", $userPassword);
		
		if($hashPassword == $row['password']){ 
		  	$loginOK=true;
	    } else {
	      	echo("<script> alert('아이디나 비밀번호를 확인해 주세요.'); history.back(); </script>");
	    	}
	}

	if($loginOK){
		session_regenerate_id();
		$_SESSION['name']=$row['name'];
		$_SESSION['id']=$userID;
		$_SESSION['is_admin']=$row['is_admin'];
		$_SESSION['account']=$row['account'];

		if($_SESSION['id']=='admin' && $_SESSION['is_admin']==1){
			header('Location: ../root/admin.php');
		}	else{
			header('Location: ../index.php');
		}
		session_write_close();
	}	else{
		echo "<script>alert('$userID 인증 오류')</script>";
	}
}
?>
