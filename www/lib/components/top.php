<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
      <link rel="stylesheet" type="text/css" href="../../css/common.css" />
  </head>
  <body>
    <div id="header">
      <div id="logo" style="float:left"><a href="/lib/index.php"><img src="../../img/hoseobank_logo.jpg" style="margin:10px 0 0 10px;"></a></div>
      <div id="top" style="float:right; padding: 15px;">
	      <?php if(!isset($_SESSION["id"])){ ?>
		    	<a href="/lib/login/login_form.php">로그인</a> | <a href="/lib/signup/signup1.php">회원가입</a>
	      <?php
			} else {
		      	if($_SESSION["id"] == "admin" && $_SESSION['is_admin']==1){
			?>
					<?=$_SESSION["name"]?> | <a href="/lib/login/logout.php">로그아웃</a>
			<?php
				} else {?>
					<?=$_SESSION["name"]?> | <a href="/lib/login/logout.php">로그아웃</a>
			<?php
		  		}
	     		} ?>
      </div>
    </div>
  </body>
</html>
