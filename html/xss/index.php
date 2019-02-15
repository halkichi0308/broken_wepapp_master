<?php
  require('./function.php');

  //検索キーワード
  $search_arry = [
    "test1","test2","test3","test4"
  ];
  $result_matches = [];

  //パラメータ=> 変数
  if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mode'])){

    $xss1 = $_POST['mode'] == "xss1" ? $_POST['keyword'] : '';
    //なんちゃって検索処理
    $result_matches = pseudoSearch($search_arry, $_POST['keyword']);

  }elseif($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['mode'])){


    switch($_GET['mode']){

      case 'dom2':
        $dom2 = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        break;

      case 'xss2':
          $req = [];
          //POSTでJSON投げる時用
          //$req = json_decode(file_get_contents('php://input'), true);
          $req['keyword'] = $_GET['keyword'];
          $req['mode'] = $_GET['mode'];

          //Redosに対し脆弱なコードであるため使用しない。
          $regExp = '/' . $req['keyword'] . '.*$/';

          if($req['mode'] === 'xss2'){
            $case_xss2 = '';
            $case_xss2 = pseudoSearch($search_arry, $req['keyword'], 'JSON');

            //対策
            //header('Content-Type: application/json');
            header('Content-Type: text/html');

            exit($case_xss2);
          }
        break;

      default:
        break;
    }

  }
?>

<!DOCTYPE html>
  <html>
  <head>
  <title><?=$HOST;?></title>
  <?=$echo_header;?>
  <style>
    form{
      margin: 10vw 0 10vw 0;
    }
    li{
      list-style: none;
    }
    fieldset{
      width: 30%
    }
  </style>
  </head>
  <body>
    <a href="/">←TOPへ戻る</a>
    <div id="container">
      <a href="<?=$FileName;?>">
        <button class="btn m-2">Reload</button>
      </a>
      <h1>XSS</h1>
      <p class="alert-info">Usage: input "test" in each form and click -search-.
      <form id="form1" action="<?=$FileName;?>" method="post">
        <label>The first:</label>
        <?php
        //対策
        //<input type="text" name="keyword" placeholder="search" value=<?=htmlspecialchars($xss1,ENT_QUOTES);
        ?>
        <input type="text" name="keyword" placeholder="search" value=<?=$xss1;?>>
        <input type="hidden" name="mode" value="xss1">
        <input type="submit" id="btn" value="-search-">
      </form>

      <?php 
        if($_POST['mode'] === 'xss1'){
          echo '<p>' . htmlspecialchars($xss1) . 'の検索結果</p>';
          echo writeResult($result_matches);
        }
      ?>
      <hr>

      <form id="form4" name="form4">
        <label>The fourth:</label>
        <input type="text" name="keyword" placeholder="search">
        <input type="hidden" name="mode" value="xss2">
        <input type="button" id="btn4" value="-search-">
      </form>
      <p id="keyword_result"></p>
      <span id="search_result"></span>
      <script>
        let submit_btn = document.getElementById('btn4');
        let search_result = document.getElementById('search_result');
        let keyword_result_elem = document.getElementById('keyword_result');

        submit_btn.addEventListener('click',function(){

          let keyword = document.querySelector('#form4').elements['keyword'];
          let queryStrings = `?mode=xss2&keyword=${keyword.value}`;

          let xhr = new XMLHttpRequest();
          xhr.open('GET','<?=$FileName;?>' + queryStrings);

          //POSTでJSONを送る場合
          //let body = `{"mode":"xss2","keyword":"${keyword.value}"}`;
          xhr.addEventListener('load',function(evt){

            let keyword_result = JSON.parse(evt.target.response).keyword;

            keyword_result_elem.innerText = keyword_result + 'の検索結果';

            //検索結果のレンダリング
            if(evt.target.status === 200){
                renderAry(search_result, evt.target.response);
            }
          })

          //xhr.send(body);
          xhr.send();
        });
      </script>
      <hr>


      <h1>DOM-Based-XSS</h1>

      <form id="form8" action="<?=$FileName;?>#form8" method="get">
        <label>The first:</label>
        <input type="text" name="keyword" id="dom_target" placeholder="search" value="<?=htmlspecialchars($dom2);?>">
        <input type="hidden" name="mode" value="dom2">
        <input type="submit" id="btn8" value="-search-">
      </form>
      <?php 
        if(isset($_GET['mode']) && $_GET['mode'] === 'dom2'){
          $dom2_result = isset($_GET['keyword']) ? pseudoSearch($search_arry, $_GET['keyword'], 'JSON', true) :'';
          echo '<p class="forResult"><span class="result"></span></p>';

$writeHtml = <<<EOF
<script>
  let resultAry = '{$dom2_result}';
  let forResult = document.querySelector('.forResult');
  let dom_target_elem = document.querySelector('#dom_target');
  renderAry(forResult, resultAry, render_callback, 'dom2');
</script>
EOF;
          echo $writeHtml;
        }
      ?>


    </div>
  </body>
</html>
