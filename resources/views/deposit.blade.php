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
  <style>
    .login_box {
      width: 40%;
      margin: 0px auto;
    }
  </style>
  <title>Bank</title>
</head>

<body>

    <div class="container">
      <div class="text-center">
        <h2 class="m-4">歡迎光臨網路銀行</h2>
      </div>
    </div>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      @if (!isset($_SESSION['rname']))
        <div class="align-left">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="/bank/homepage">搜尋紀錄 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
              <a class="nav-link" href="/bank/deposit">存款 <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/bank/withdrawal">提款 <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </div>  
        <div class="align-right">
          <ul class="nav navbar-nav navbar-right">
            <li class="active">
              <a href="/bank">Sign out</a>
            </li>
          </ul>
        </div>          
      @else
        <div class="align-left">
          <ul class="navbar-nav"></ul>
        </div> 
        <div class="align-right">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="/bank">Sign in</a></li>
            <li class="ml-3"><a href="/bank/signup">Sign up</a></li>
          </ul>
        </div>          
      @endif
    </div>
  </nav>
  <div class="container">
    <h5 class="m-3">帳戶資訊</h5>
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">帳號</th>
          <th scope="col">姓名</th>
          <th scope="col">餘額</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">1</th>
          <td>Mark</td>
          <td>{{$money}}</td>
        </tr>
      </tbody>
    </table>
    <div class="login_box p-5">
      <h4 class="text-center mb-3" style="color: royalblue">存款</h4>
      <form>
        <div class="form-group">
          <label for="amount">目前餘額：</label>
          <input type="number" maxlength="10" class="form-control" id="amount" value="{{$money}}" disabled>
        </div>
        <div class="form-group">
          <label for="money">存款金額：</label>
          <input type="number" maxlength="10" class="form-control" id="money" placeholder="請輸入金額">
        </div>
        <div class="form-group">
          <label for="remark">備註：</label>
          <input type="text" maxlength="6" class="form-control" id="remark" placeholder="請輸入備註">
        </div>
        <div class="text-center">
          <button type="button" class="btn btn-primary btn-lg m-3" id="depositok" style="width: 35%;">送出</button>
        </div>
      </form>
    </div>
  </div>
</body>
<script>
  $(document).ready(function() {
    //存款
    $("#depositok").click(function() {
      var amount = $("#amount").val();
      var money = $("#money").val();
      var remark = $("#remark").val();
      if (money != "") {
        $.ajax({
          type: "POST",
          url: "/bank/deposit",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            user_id: "1",
            amount: amount,
            money: money,
            remark: remark,
          },
          async: false,
          success: function(msg) {
            if(msg == 1){
              alert('存款成功');
              window.location.href = "/bank/homepage";
            }else{
              alert(msg);            
            }
          },
          error: function(msg) {
            alert("存款失敗");
          }
        });
      } else {
        alert('輸入金額不得為空');
      }
    });
  });
</script>

</html>