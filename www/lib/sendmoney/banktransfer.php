<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


include ('../db/config.php');
include ('../login/check.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../../css/common.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<style>
		#submit{ margin:  20px 0px 0px 200px; }
		h2 { margin: auto; width: 50%; }
	</style>
  </head>
  <body>
    <div id="header">
      <?php include "../components/top.php"; ?>
    </div>
    <div id="content">
	 <form method="post"  autocomplete="off">
		<h2>송금</h2>
      <table width="800" cellspacing="1" cellpadding="4">
        <tr>
          <th>이름</th>
            <td style="padding:10px 10px 5px 10px">
              <?php echo $_SESSION['name'];  ?>
            </td>
        </tr>
        <tr>
          <th>계좌번호</th>
            <td style="padding:10px 10px 5px 10px">
              <?php echo $_SESSION['account']; ?>
            </td>
        </tr>
        <tr>
          <th>계좌비밀번호</th>
            <td style="padding:10px 10px 5px 10px">
              <input type="password" name="accountPassword">
            </td>
        </tr>
        <tr>
          <th>송금계좌</th>
            <td style="padding:10px 10px 5px 10px">
              <input type="text" name="remittanceAccount">
            </td>
        </tr>
        <tr>
          <th>금액</th>
            <td style="padding:10px 10px 5px 10px">
              <input type="text" name="money">
            </td>
        </tr>
        <tr>
          <th>OTP</th>
           <td style="padding:10px 10px 5px 10px">
             <input type="text" name="otp" maxlength="6">
             <input type="submit" value="OTP" name="OTP">
           </td>
        </tr>
      </table>
      <input type="submit" name='submit' class="btn btn-outline-success" value="확인">
	</form>
    </div>
  </body>
</html>

<?
$stmt=$con->prepare('select androidID, account_pw from client where account=:account');
$stmt->bindParam(':account', $_SESSION['account']);
$stmt->execute();
$row = $stmt->fetch();

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['OTP'])){

		$randomNum=rand(100000, 999999);
		$randNum=$con->prepare(" update client set randomNum='$randomNum' where account=:account ");
		$randNum->bindParam(':account', $_SESSION['account']);
		$randNum->execute();

		$androidID = hexdec($row['androidID']);
		$key = $randomNum ^ $androidID;						
		$hash_sha256 = hash("sha256", $key);
		$subrandom = $randomNum % 10;		
		$hash_5 = substr($hash_sha256,$subrandom,5);		
		$hash_final = hexdec($hash_5);

		session_regenerate_id();
		$_SESSION['OTP']=$hash_final;

		if($hash_final != null){echo("<script> alert('$hash_final');</script>");	}
		else{echo("<script> alert('error');</script>");}
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
	global $hash_final;
	echo "<script>$hash_final</script>";
	$accountPassword=hash("SHA256",$_POST['accountPassword']);
	$remit=$_POST['remittanceAccount'];
	$money=$_POST['money'];
	$otp=$_POST['otp'];

	if(empty($accountPassword) || empty($remit) || empty($money) || empty($otp)){
			echo("<script> alert('모두 입력해 주세요.'); history.back(); </script>");

	}	else{
			if(($otp == $_SESSION['OTP'])&&($accountPassword==$row['account_pw'])){
				echo("<script> alert('성공적으로 송금 되었습니다.');</script>");	
				//header('Location: ../index.php');
			}	else {
				if($otp != $_SESSION['OTP'])
					echo("<script> alert('OTP를 다시 확인해주세요.');</script>");
				else if($accountPassword!=$row['account_pw'])
					echo("<script> alert('비밀번호를 다시 확인해주세요.');</script>");
			}
	}
}

?>
