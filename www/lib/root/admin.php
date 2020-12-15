<?php
    include('../db/config.php');
    include('../login/check.php');


/*if($_SESSOION['id']=='admin' && $_SESSION['is_admin']==1){
	header('Location: admin.php');
}	else{
	header('Location: ../index.php');	
}*/

function validatePassword($password){
	if(strlen($password) == 6) {
		if(preg_match('/[^0-9]/i',$password)){
		return true;
		}	 else{ return 0; }
	}	else { return 0; }
}

if( ($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])){

	$name=$_POST['name'];
	$account=$_POST['account'];
	$password=$_POST['password'];
	$confirmpassword=$_POST['confirmpassword'];

	if (validatePassword($password)){
		$errMSG = "잘못된 패스워드";
	}

	if ($password != $confirmpassword) {
		$errMSG = "패스워드가 일치하지 않습니다.";
	}

	if(empty($name)){
		$errMSG = "이름을 입력하세요.";
	} else if(empty($password)){
		$errMSG = "패스워드를 입력하세요.";
	} else if(empty($account)){
		$errMSG = "계좌번호를 입력하세요.";
	} 

	try { 
		$stmt = $con->prepare('select name, account from client where account=:account');
		$stmt->bindParam(':account', $account);
		$stmt->execute();
	} catch(PDOException $e) {
		die("Database error: " . $e->getMessage()); 
	}
	$row = $stmt->fetch();

	if ($row){
		$errMSG = "이미 존재하는 계좌번호입니다.";
	}

		if(!isset($errMSG))
		{
          try{
				$stmt = $con->prepare('INSERT INTO client(name, account, account_pw) VALUES(:name, :account, :password)');
				$stmt->bindParam(':name',$name);
				$stmt->bindParam(':account',$account);			
		       $encrypted_password = hash("sha256",$password);
		       $stmt->bindParam(':password', $encrypted_password);

				if($stmt->execute()){
					$successMSG = "새로운 사용자를 추가했습니다.";
				}
				else{
					$errMSG = "사용자 추가 에러";
				}
           } catch(PDOException $e) {
                        die("Database error: " . $e->getMessage()); 
                     }
		}
	}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title></title>
</head>
<style>
.add	{ width: 1000px;	height: 30px; padding: 50px 0 40px 0;}
</style>
<body>
<div class='header'>
<? 	include "../components/top.php"; ?>
</div>
	<div class="container">
		<div class='add'>
		<h1 class="h1" align="center"> 새로운 사용자 추가</h1>
			<?php
				if(isset($errMSG)){
			?>
			<div class="alert alert-danger" id='message' align="center" style='color: red; padding:10px;'>
			<span class="glyphicon glyphicon-info-sign"></span> <strong><?php echo $errMSG; ?></strong>
			</div>
			<?php
				} else if(isset($successMSG)){
			?>
					<div class="alert alert-success" id='message' align="center" style='color: red; padding:10px;'>
					    <strong><span class="glyphicon glyphicon-info-sign"></span> <?php echo $successMSG; ?></strong>
					</div>
			<?php
					}
			?>   
	    </div>
		<form id="form" method="post" >
			<table class="table table-responsive" align="center" width="500">
		    <tr>
		    	<td><label class="control-label">이름</label></td>
				<td><input class="form-control" type="text" name='name' autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" />
			</td>
		    </tr>
		    <tr>
		    	<td><label class="control-label">계좌번호</label></td>
				<td><input class="form-control" type="text" name='account' autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" />
			</td>
		    </tr>
		    <tr>
		    	<td><label class="control-label">계좌 비밀번호</label></td>
			<td><input class="form-control" type="password" name='password' placeholder="패스워드를 입력하세요" autocomplete="off" readonly 
				   onfocus="this.removeAttribute('readonly');" /></td>
		    </tr>
		    <tr>
		    	<td><label class="control-label">비밀번호 확인</label></td>
			<td><input class="form-control" type="password" name='confirmpassword' placeholder="패스워드를 다시 한번 입력하세요" autocomplete="off" readonly onfocus="this.removeAttribute('readonly');" /></td>
		    </tr>
					
		    <tr>
			<td colspan="2" align="center" style='padding:5px'>
			<button type="submit" name="submit"  class="btn btn-primary"><span class="glyphicon glyphicon-floppy-save"></span>&nbsp; 저장</button>
			</td>
		    </tr>
		    </table>
		</form>
</div>
</body>
</html>
