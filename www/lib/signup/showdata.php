<?php
include ('../db/config.php');
include ('../login/check.php');
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script>
      function go_mainpage(){
        location.href="finishingsignup.php";
      }
      function go_loginpage(){
        location.href="../login/login_form.php";
      }
    </script>
  </head>
  <body>
    <div id="header">
      <?php include "../components/top.php"; ?>
    </div>
    <div id="content" style="text-algin:center">
      <table border="1" width="640" cellspacing="1" cellpadding="4">
        <tr>
          <th>이름</th>
            <td>
              <?php
              echo $_SESSION['name'];
               ?>
            </td>
        </tr>
        <tr>
          <th>계좌번호</th>
            <td>
              <?php
              echo $_SESSION['account'];
               ?>
            </td>
        </tr>
        <tr>
          <th>계좌비밀번호</th>
            <td>
              <?php
              echo $_SESSION['account_pw'];
               ?>
            </td>
        </tr>
        <tr>
          <th>아이디</th>
            <td>
              <?php
              echo $_SESSION['id'];
               ?>
            </td>
        </tr>
        <tr>
          <th>패스워드</th>
            <td>
              <?php
              echo $_SESSION['password'];
               ?>
            </td>
        </tr>
        <tr>
          <th>이메일</th>
           <td>
             <?php
             echo $_SESSION['email'];
              ?>
           </td>
        </tr>
      </table>
      <input type="button" value="확인" onclick="go_mainpage();"> <input type="button" value="Login" onclick="go_loginpage();">
    </div>
  </body>
</html>
