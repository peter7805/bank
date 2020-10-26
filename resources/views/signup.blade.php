<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
  </script>
  <style>
    body {
      height: 100%;
    }
    .login_box {
      width: 40%;
      margin: 0px auto;
    }
  </style>

  <title>login</title>
</head>

<body>
  <div class="login_box mt-3 p-5">
    <h2 class="text-center">歡迎註冊網路銀行</h2>
    <form>
      <div class="form-group">
        <label for="account">身分證字號：</label>
        <input type="text" class="form-control" id="account" placeholder="請輸入您的身分證字號">
      </div>
      <div class="form-group">
        <label for="userId">使用者代碼：</label>
        <input type="text" class="form-control" id="userId" placeholder="請輸入6~20位英文數字">
      </div>
      <div class="form-group">
        <label for="password">Password：</label>
        <input type="password" maxlength="20" class="form-control" id="password" placeholder="請輸入6~20位英文數字">
      </div>
      <div class="form-group">
        <label for="repassword">二次確認Password：</label>
        <input type="password" maxlength="20" class="form-control" id="repassword" placeholder="請再次輸入密碼">
      </div>
      <div class="text-center">
        <button type="button" class="btn btn-primary btn-lg m-3" id="btnok" style="width: 35%;">註冊</button>
        <button type="button" class="btn btn-secondary btn-lg m-3" id="btncancel" style="width: 35%;">取消</button>
      </div>
    </form>
  </div>
</body>
<script>
  $(document).ready(function() {
    $("#btnok").click(function() {
      var checkAccount = /^[A-Z]{1}[0-9]{9}$/;
      var checkPwd = /^[a-zA-Z0-9]{6,20}$/;
      var account = $("#account").val();
      var userId = $("#userId").val();
      var pwd = $("#password").val();
      var repwd = $("#repassword").val();
      if (
        userId != "" &&
        checkAccount.test(account) &&
        checkPwd.test(userId) &&
        checkPwd.test(pwd) &&
        pwd == repwd
      ) {
        $.ajax({
          type: "POST",
          url: "login_pdo.php",
          data: {
            email: email,
            password: pwd,
          },
          async: false,
          success: function(res) {
            if (res == 'account_false') {
              alert('無此使用者');
              $("#password").val("");
            } else if (res == 'pwd_false') {
              alert('密碼錯誤請確認');
              $("#password").val("");
            } else if (res == 'true') {
              alert('登入成功');
              window.location.href = "index.php";
            }
          },
          error: function(res) {
            alert("登入失敗");
          }
        });
      } else {
        if (!checkAccount.test(account)) {
          alert('身分證字號輸入格式錯誤');
          $("#password").val("");
          $("#repassword").val("");
        }else if (!checkPwd.test(userId)) {
          alert('使用者代碼輸入格式錯誤');
          $("#password").val("");
          $("#repassword").val("");
        } else if (!checkPwd.test(pwd)) {
          alert('password輸入格式錯誤');
          $("#password").val("");
          $("#repassword").val("");
        }else if (password != pwd) {
          alert('密碼不一致');
          $("#repassword").val("");
        }
      }
    });
    $("#btncancel").click(function() {
      window.location.href = "login";
    });
  });
</script>

</html>