<?php
include ('../db/config.php');
include ('../login/check.php');

	if(!empty($_SESSION['id'])){
		header('Location: ../index.php');
	}

	$name=$_SESSION['name'];
	$account=$_SESSION['account'];
	$account_pw=$_SESSION['account_pw'];
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script>
    	$(document).ready(function(e) {
			$(".check").on("keyup", function(){ //check라는 클래스에 입력을 감지
				var self = $(this);
				var userid;

				if(self.attr("id") === "userid"){ userid = self.val(); }

				$.post( //post방식으로 id_check.php에 입력한 userid값을 넘깁니다
					"id_check.php",
					{ userid : userid },
					function(data){
						if(data){ //만약 data값이 전송되면
							self.parent().parent().find("p").html(data); //div태그를 찾아 html방식으로 data를 뿌려줍니다.
							self.parent().parent().find("p").css("color", "#F00"); //div 태그를 찾아 css효과로 빨간색을 설정합니다
						}
					}
				);
			});
		});
    </script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/common.css" />
	<style>
		#button {
			margin: auto;
			width: 50%;
		}
		th {
			padding: 10px;
		}
	</style>
  </head>
  <body>
    <div id="header">
      <?php include "../components/top.php"; ?>
    </div>
    <div id="content">
      <form name="sign2" method="post" action="signup_check.php" autocomplete="off">
        <fieldset>
				<legend><b>입력사항</b></legend>
        <table width="800" cellspacing="1" cellpadding="10" >
          <tr>
            <th>이름</th>
              <td>
                <?php echo "$name"; ?>
              </td>
          </tr>
          <tr>
            <th>계좌번호</th>
              <td>
                <?php  echo "$account"; ?>
              </td>
          </tr>
          <tr>
            <th>아이디</th>
              <td>
                <input type="text" size="15" maxlength="20" name="userid" id="userid" class="check" placeholder="ID"  required>
				  <p id="id_check"></p>
              </td>
          </tr>
          <tr>
            <th>패스워드</th>
              <td>
                <input name="userpw" type="password" size="15" maxlength="12">
              </td>
          </tr>
          <tr>
            <th>패스워드 확인</th>
            <td>
              <input name="pwcheck" type="password" size="15" maxlength="12">
            </td>
          </tr>
			<tr>
            <th>전화번호</th>
            <td>
              <input name="phone1" type="text" size="3" maxlength="3"> - <input name="phone2" type="text" size="4" maxlength="4"> - <input name="phone3" type="text" size="4" maxlength="4">
            </td>
          </tr>
          <tr>
            <th>이메일</th>
             <td>
               <input type="text" class="box" size='15' name="email1"> @ <input type="text" class="box" size='15' name="email2">
             </td>
          </tr>
        </table>
        <div id='button'> <input type="submit" class="btn btn-warning" value="확인" style='margin:10px;'> </div>
      </fieldset>
      </form>
    </div>
  </body>
</html>
