<?php
$HOST = $_SERVER['HTTP_HOST'];
  $ua = $_SERVER['HTTP_USER_AGENT'];
date_default_timezone_set('Asia/Tokyo');//timezone
preg_match('/(?<=(?!.*\/)).+\.php/', $_SERVER['SCRIPT_NAME'], $FileName);
$FileName = './' .$FileName[0];
session_start();
ini_set('display_errors', 0);

//function modules. [ec - hacker site]
function HasPostParams(){
  if($_SERVER['REQUEST_METHOD'] === 'POST'){

    if(isset($_POST['uid']) && isset($_POST['pw'])){

      return true;
    }

    return false;
  }

  return false;
}

function EncyptIds($uid, $password){

  $_data = $uid .':'. $password;

  return base64_encode($_data);
}

function HasSid(){
  if(isset($_COOKIE['sid'])){
    return true;
  }
  return false;
}

function getUname($sid){

  $_pattern = '/^.*(?=\:)/';

  $_tmp = base64_decode($sid);

  if($_tmp === false)return false;

  preg_match($_pattern, $_tmp, $_result);

  return $_result[0];
}

//xss.php
function writeResult($result_matches, $flg = false, $xss_str = false){

  $_tmp = '';

    //イベントハンドラ内はURLエンコード
    //$_tmp .= '<button onclick="chkTargetUser(\'' . urlencode($xss_str) . '\')">更新</button></div>';
    $_tmp .= '<button onclick="chkTargetUser(\'' . htmlspecialchars($xss_str,ENT_QUOTES) . '\')">更新</button></div>';

  if(count($result_matches) !== 0){

    $_tmp .= '<fieldset>';
    for($i = 0; $i < count($result_matches); $i++){

      $_tmp .= $result_matches[$i] != NULL
                                ? '<li>・' . $result_matches[$i] . '</li>'
                                : '';
    }
    $_tmp .= '</fieldset>';
  }
  return $_tmp;
}

//なんちゃって検索処理
function pseudoSearch($target_ary, $keyword, $type = FALSE, $escape = FALSE){

  $_tmp = [];
  $_tmp['JSON'] = '';
  $keyword = $escape === TRUE ? htmlspecialchars($keyword, ENT_QUOTES) : $keyword;

  for($i = 0; $i < count($target_ary); $i++){

    //これはDoSの可能性があります。検索に正規表現が使える場合はバックトラックさせない処理にすること。
    preg_match('/' . $keyword . '.*$/', $target_ary[$i], $matches);

    if(empty($matches[0]))continue;

    if(strlen($matches[0]) > 0){

      //JSONの場合は配列にしない
      if($type === 'JSON'){

        if(strlen($_tmp['JSON']) > 1){
          $_tmp['JSON'] .= ',';
        }

        $_tmp['JSON'] .= sprintf('"%s"', $target_ary[$i]);


      }else{
        array_push($_tmp, $target_ary[$i]);
      }

    }
  }
  if($type === 'JSON'){
    $format = '{"keyword":"%1$s","match":[%2$s]}';
    return ''. sprintf($format, $keyword, $_tmp['JSON']);
  }

  return $_tmp;
}

$echo_header = <<< EOF
<link rel="stylesheet" href="../css/style.css">
<link href="../css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<meta charset="UTF-8">
<script type="text/javascript" src="./js/main.js"></script>
EOF;

?>
