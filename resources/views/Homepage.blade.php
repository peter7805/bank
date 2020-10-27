<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <title>Bank</title>
</head>

<body>
    <div>
      <h1 class="text-center m-4">歡迎光臨網路銀行</h1>
        <a href="login.php">Sign in</a>
        <a href="signup.php">Sign up</a>
    </div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <div>
        <span class="navbar-brand">Welcome ，
        </span>
      </div>

      <div class="align-right">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/bank/homepage">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              功能
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">存款</a>
              <a class="dropdown-item" href="#">提款</a>
              <a class="dropdown-item" href="#">查詢</a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>


</body>
<script>
  $(document).ready(function() {
    $("#btnok").click(function() {
      var checkAccount = /^[A-Z]{1}[0-9]{9}$/;
      var checkPwd = /^[a-zA-Z0-9]{6,20}$/;
      var account = $("#account").val();
      var userId = $("#userId").val();
      var pwd = $("#password").val();
      if (
        userId != "" &&
        checkAccount.test(account) &&
        checkPwd.test(userId) &&
        checkPwd.test(pwd)
      ) {
        $.ajax({
          type: "POST",
          url: "/bank/login",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            account: account,
            userId: userId,
            password: pwd,
          },
          async: false,
          success: function(msg) {
            if(msg == 1){
              alert('登入成功');
              window.location.href = "/bank/homepage";
            }else{
              alert(msg);            
            }
          },
          error: function(msg) {
            alert("登入失敗");
          }
        });
      } else {
        if (!checkAccount.test(account)) {
          alert('身分證字號輸入格式錯誤');
          $("#password").val("");
        }else if (!checkPwd.test(userId)) {
          alert('使用者代碼輸入格式錯誤');
          $("#password").val("");
        } else if (!checkPwd.test(pwd)) {
          alert('password輸入格式錯誤');
          $("#password").val("");
        }
      }
    });
    $("#btnrg").click(function() {
      window.location.href = "/bank/signup";
    });
  });
</script>

</html>