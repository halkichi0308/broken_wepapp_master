<?php
require('function.php');

session_start();
$errorMessage = "";
$errFlg = "";
$correntForm = '';
//ログイン時の処理
if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['userid']) && isset($_POST['passwd'])){

      $sqlResult = existUserId($_POST['userid'], $_POST['passwd'], $db);

      $existUser = $sqlResult[0];

      $errinfo = $sqlResult[1];

      if($existUser === FALSE){

        if(!empty($errinfo[2])){
          $errorMessage = $errinfo[2];
          $_SESSION['db_err'] = $errinfo[2];
        }
        $_SESSION['err'] = 1;
        //header('Location: ./login.php?err=1');
        header('Location: ./login');
        exit;

      }else{

        foreach($existUser as $key){
          $_SESSION["NAME"] = $key;
        }
        session_regenerate_id();
        header('Location: ./mypage');
        exit;
      }

      return true;
    }else{
      $_SESSION['err'] = 3;
      header('Location: ./mypage');
      exit;
    }

}
//ログアウト時の処理

//新規登録時の処理
if(!empty($_SESSION['signup']) && $_SESSION['signup'] === TRUE){
  $errFlg = 10;
  $errorMessage = '登録完了しました。';
}
if(!empty($_SESSION['signup'])){
  $correntForm = 'signup';
  $_SESSION['signup'] = array();
}
//エラー時の処理
if(isset($_SESSION['err'])){

  $errFlg = $_SESSION['err'];
  switch($errFlg){
    case 0:
      $errorMessage = 'ログアウトしました。';
      break;
    case 1:
      $errorMessage = 'ユーザIDまたはパスワードが正しくありません。';
      $errorMessage .= catchErrInfo();
      break;
    case 2:
      $errorMessage = 'ログイン認証を行って下さい。';
      break;
    case 3:
      $errorMessage = 'ユーザIDまたはパスワードが入力されていません。';
      break;
    case 4:
      $errorMessage = 'ユーザIDまたはパスワードが入力されていません。';
      break;
    case 5:
      $errorMessage = '既に登録されているユーザ名です。';
      break;
    default:
      $errorMessage = '予期せぬエラーが発生しました。';
      break;
  }
  session_destroy();
}
?>

<!DOCTYPE html>
<html>
    <head>
      <title>Login</title>
      <?= $echo_header; ?>
    </head>
    <p class="botto-text" hidden>Designed by Sunil Rajput</p>
    <body id="LoginForm">
        <a href="/">←TOPへ戻る</a>
        <br>
<!------ Include the above in your HEAD tag ---------->
        <div class="container">
          <div id="loginForm" class="login-form login">
            <div class="main-div">
              <div class="panel">
                <h2 id="formName">Login</h2>
                <p style="color:red">
                </p>
              </div>
              <form id="Login" action="./login" method="POST">
                <div class="form-group">
                  <p class="text-danger">
                    <?= $errFlg <= 3 ? htmlspecialchars($errorMessage, ENT_QUOTES) :''; ?>
                  </p>
                  <input type="text" class="form-control" placeholder="Name" name="userid" value="<?= !empty($_POST["userid"]) ? htmlspecialchars($_POST["userid"], ENT_QUOTES):'';?>">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="passwd">
                </div>
                <div class="forgot">
                  <a id="changeForm" href="javascript:void(0)" onClick="formSwitch(this.textContent);return false">-signup-</a>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">Login</button>
                </div>
              </form>
            </div>
          </div>
          <div id="signupForm" class="login-form login" hidden>
            <div class="main-div">
              <div class="panel">
                <h2 id="formName">Signup</h2>
                <p style="color:red">
                </p>
              </div>
              <form id="Login" action="./signup" method="POST">
                <div class="form-group">
                  <p class="text-danger">
                    <?= $errFlg > 3 ? htmlspecialchars($errorMessage, ENT_QUOTES) :''; ?>
                  </p>
                  <input type="text" class="form-control" placeholder="Name" name="userid" value="<?= !empty($_POST["userid"]) ? htmlspecialchars($_POST["userid"], ENT_QUOTES):'';?>">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="inputPassword" placeholder="Password" name="passwd">
                </div>
                <div class="forgot">
                <a id="changeForm" href="javascript:void(0)" onClick="formSwitch(this.textContent);return false">-login-</a>
                </div>
                <button type="submit" class="btn btn-warning">Signup</button>
                <input type="hidden" name="signup" value="true">
              </form>
            </div>
          </div>
        </div>
      </div>
      <script>
        <?php $correntForm = empty($correntForm) || $correntForm === 'login' ? 'login' : 'signup';?>
        let correntForm = '<?= $correntForm; $correntForm = '';?>'
      </script>
  </body>
</html>
