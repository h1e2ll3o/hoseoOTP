<?php

function OTP(){
	$randomNumber=rand(100000, 999999);
	$randNum=$con->prepare(" update client set randomNum='$randomNumber' where account=:account ");
	$randNum->bindParam(':account', $_SESSION['account']);
	$randNum->execute();

	$stmt=$con->prepare('select * from client where account=:account');
	$stmt->execute();
	$row=$stmt->fetch();

	$key = $randNum ^ $row['androidID'];						
	$hash_sha256 = hash("sha256", $key);
	$subrandom = $randomNum % 10;		
	$hash_5 = substr($hash_sha256,$subrandom,5);		
	$hash_final = hexdec($hash_5);

}
?>
