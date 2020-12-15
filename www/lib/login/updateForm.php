<?php
include "../db/config.php";
include "check.php";

$AndroidID=$con->prepare("select androidID from client where id=:userid");
$AndroidID->bindParam(':userid', $SESSION['id']);
$AndroidID->execute();
$_SESSION['androidID'] = $AndroidID;
?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>내 정보 변경</title>
     <style>
		td { padding:10px; }
		h1 { margin:auto; width: 50%; }
		#button { margin:auto; width: 50%; } 
	 </style>
<link rel="stylesheet" type="text/css" href="../../css/common.css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
   </head>
   <body>
     <div id="header">
       <?php include "../components/top.php"; ?>
     </div>
     <div id="content" >
       <form method="post"  autocomplete="off">
         <h1><b>내 정보</b></h1>
         <fieldset>
           <table width="1000" cellspacing="1" cellpadding="10">
             <tr>
               <td>이름</td>
               <td><?php echo $_SESSION['name'];?></td>
             </tr>
				<tr>
               <td>계좌번호</td>
               <td><?php echo $_SESSION['account'];?></td>
             </tr>
             <tr>
               <td>아이디</td>
               <td><?php echo $_SESSION['id'];?></td>
             </tr>
             <tr>
               <td>비밀번호</td>
               <td><input type="password" size="13" name="updatePassword" value=""></td>
             </tr>
				<tr>
               <td>비밀번호 확인</td>
               <td><input type="password" size="13" name="checkPassword" value=""></td>
             </tr>
             <tr>
               <td>이메일</td>
               <td><input type="text" class="box" size="13" name="updateEmail1"> @ <input type="text" class="box" size="13"  				name="updateEmail2">
               </td>
             </tr>
				<tr>
               <td>기기정보</td>
               <td><a name='androidID'><?php echo $_SESSION['androidID'];?></a>
				<input type="submit" value="삭제" name='deleteAndroidID'></td>
               <td> </td>
             </tr>
           </table>
			<div id='button'>
           <input type="submit" class="btn btn-outline-primary" name='update' value="정보수정완료">
           <input type="button" class="btn btn-outline-warning" name='back' value="취소">
			</div>
         </fieldset>
       </form>
     </div>
   </body>
 </html>

<?php


if(($_SERVER['REQUEST_METHOD']=='POST') and isset($_POST['deleteAndroidID'])){
	$deleteID = $_POST['deleteAndroidID'];
	$android=$con->prepare("update client set androidID=' ' ");
	$android->execute();
	echo "<script>alert('삭제 되었습니다.');location.href='updateForm.php';</script>" ;
}
if(($_SERVER['REQUEST_METHOD']=='POST') and isset($_POST['update'])){
	$account=$_SESSION['account'];
	$updatePassword=$_POST['updatePassword'];
	$checkPassword=$_POST['checkPassword'];
	$updateEmail=$_POST['updateEmail1'].'@'.$_POST['updateEmail2'];
	$updateAndroidID=$_SESSION['androidID'];
	
		
	if(!empty($updatePassword)){
		if($updatePassword == $checkPassword){
			$updatePassword=hash("SHA256", $updatePassword);
			$password=$con->prepare(" update client set password='$updatePassword' where account='$account' ");
			$password->execute();
		}	else{
			echo "<script>alert('비밀번호가 서로 맞지 않습니다.');</script>" ;
		}
	}
	if(!empty($updateEmail)){
			$email=$con->prepare(" update client set email='$updateEmail' where account='$account' ");
			$email->execute();
	}
	if(!empty($updateAndroidID)){
			$androidID=$con->prepare(" update client set androidID='$updateAndroidID' where account='$account' ");
			$androidID->execute();
	}
}
else if(($_SERVER['REQUEST_METHOD']=='POST') and isset($_POST['back'])){
	echo "<script>alert('로그인 후 이용하세요.'); location.href='../index.php';</script>";
}


?>
