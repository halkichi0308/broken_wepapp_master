<?php
require('function.php');

session_start();

if(isset($_COOKIE['SID']) && isset($_SESSION["NAME"])){

  $username = $_SESSION["NAME"];
  
  if(!empty($_GET['logout']) && $_GET['logout'] === 'true'){
    $_SESSION['err'] = 0;
    header('Location: ./login');
    exit();
  }
}else{
  header('Location: ./login');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>マイページ</title>
    <?php echo $echo_header; ?>
  </head>
  <body>
  <nav class="navbar navbar-expand navbar-dark bg-dark fixed-top">
<a class="navbar-brand" href="#">脆弱性データベース</a>
  <div class="collapse navbar-collapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <p class="my-2 text-light">ようこそ <?php echo $username; ?>さん</p>
      </li>

    </ul>
    <ul class="navbar-nav">
        <li class="nav-item">
        <form class="navbar-form" action="#">
            <button type="submit" class="btn btn-info" onclick="logout()">Logout</button>
        </form>
        </li>
    </ul>
  </div>
</nav>
    <div class="container my-3">
	<div class="row">

		<div class="col-md-12">
        <table class="table mt-5 my-3">
            <tr class="result_class_header_tr">
            <th class="result_class_header_tr_id" nowrap="nowrap"><a href="javascript:doSort('a1');">ID&nbsp;</th>
            <th class="result_class_header_tr_title" ><a href="javascript:doSort('a2');">脆弱性</a></th>
            <th class="result_class_header_tr_cvss" nowrap="nowrap"><a href="javascript:doSort('d3');">CVSSv3</a></th>
            <th class="result_class_header_tr_cvss" nowrap="nowrap"><a href="javascript:doSort('d4');">CVSSv2</a></th>
            <th class="result_class_header_tr_date" nowrap="nowrap"><a href="javascript:doSort('d5');">公表日</a></th>
            <th class="result_class_header_tr_date" nowrap="nowrap"><a href="javascript:doSort('d6');">最終更新日</a></th>
        </tr>
        <tr>
        <td align="center" nowrap="nowrap"><a href="#">JVNDB-2018-010079</a></td>
        <td>Apache Traffic Server におけるアクセス制御に関する脆弱性</td>
          <td align="center" nowrap="nowrap">5.3</td>
            <td align="center" nowrap="nowrap">5.0</td>
          <td align="center" nowrap="nowrap">2018/07/06</td>
        <td align="center" nowrap="nowrap">2018/12/05</td>
      </tr>
      <tr>
        <td align="center" nowrap="nowrap"><a href="#">JVNDB-2018-010078</a></td>
        <td>Apache Traffic Server おける HTTP リクエストスマグリングに関する脆弱性</td>
          <td align="center" nowrap="nowrap">6.5</td>
            <td align="center" nowrap="nowrap">4.0</td>
          <td align="center" nowrap="nowrap">2018/03/01</td>
        <td align="center" nowrap="nowrap">2018/12/05</td>
      </tr>
      <tr>
        <td align="center" nowrap="nowrap"><a href="#">JVNDB-2018-010034</a></td>
        <td>Apache Camel Mail におけるパストラバーサルの脆弱性</td>
          <td align="center" nowrap="nowrap">5.3</td>
            <td align="center" nowrap="nowrap">5.0</td>
          <td align="center" nowrap="nowrap">2018/07/09</td>
        <td align="center" nowrap="nowrap">2018/12/04</td>
      </tr>
      <tr>
        <td align="center" nowrap="nowrap"><a href="#">JVNDB-2018-010007</a></td>
        <td>Apache Traffic Server における入力確認に関する脆弱性</td>
          <td align="center" nowrap="nowrap">7.5</td>
            <td align="center" nowrap="nowrap">5.0</td>
          <td align="center" nowrap="nowrap">2018/08/28</td>
        <td align="center" nowrap="nowrap">2018/12/04</td>
      </tr>
      </tr>
</table>
		</div>
	</div>
    <script>
      'use strict'
      function logout(){
        location.href="./mypage?logout=true";
      }
    </script>
  </body>
</html>
