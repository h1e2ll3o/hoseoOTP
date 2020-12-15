<?php
include ('../db/config.php');
include ('../login/check.php');

if(!empty($_SESSION['id'])){
	header('Location: ../index.php');
}

if(($_SERVER['REQUEST_METHOD']=='POST') && isset($_POST['submit'])){
      	$stmt=$con->prepare("select name, account, account_pw from client where name=:name and account=:account");
		$stmt->bindParam(':name', $_POST["name"]);
		$stmt->bindParam(':account', $_POST["account"]);
		$stmt->execute();
		$row=$stmt->fetch();

		$hashAccountPW=hash('SHA256', $_POST['account_pw']);

      	if (empty($row['name']) || empty($row['account']) ) {
        	echo "<script>alert('회원정보가 없습니다.');</script>";
      	}	else if(/*$hashAccountPW != */!$row['account_pw']){
        		echo"<script>alert('비밀번호가 틀렸습니다.');</script>";
      	}	else {
        		header('Location: signup2.php');
          		$_SESSION['name']=$_POST["name"];
          		$_SESSION['account']=$_POST["account"];
          		$_SESSION['account_pw']=$_POST["account_pw"];
      		}
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/common.css" />
	<style>	
		#button {
			margin: auto;
			width: 50%;
		}
	</style>
  </head>
  <body>
    <div id="header">
      <?php include "../components/top.php"; ?>
    </div>
    <div id="content">
      <form method="post" action="signup1.php"  autocomplete="off">
        <table  width="640" cellspacing="1" cellpadding="10" frame="void" >
          <tr>
            <th>이름</th>
              <td>
                <input name="name" type="text" maxlength="5" style='margin:5px;'>
              </td>
          </tr>
          <tr>
            <th>계좌번호</th>
              <td>
                <input name="account" type="text" min="13" maxlength="15" style='margin:5px;'>
              </td>
          </tr>
          <tr>
            <th>계좌비밀번호</th>
              <td>
                <input name="account_pw" type="password"  min="6" style='margin:5px;'>
              </td>
          </tr>
        </table>
		<div id='button'>
        <input type="submit" name='submit' class="btn btn-warning" value="제출" style='margin:10px;'>
		</div>
      </form>
    </div>
  </body>
</html>
