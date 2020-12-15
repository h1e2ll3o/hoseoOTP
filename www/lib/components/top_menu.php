<style>
  nav{
    content:'';
    margin-left: 200px;
    clear:both;
  }
</style>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
    li {float: left;}
    li a {
      display: inline-block;
      padding: 8px;
    	}
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="/lib/sendmoney/update_checkmyidpw.php?id=<?=$_SESSION["id"]?>">계좌이체</a> </li>
        <li><a href="/lib/login/update_checkmyidpw.php?id=<?=$_SESSION["id"]?>">마이페이지</a> </li>
      </ul>
    </nav>
  </body>
</html>
