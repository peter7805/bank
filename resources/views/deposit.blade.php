@extends('homepage')

@section('content')
    <div class="login_box p-5">
    <h4 class="text-center mb-3" style="color: royalblue">存款</h4>
    <form>
      <div class="form-group">
        <label for="amount">目前餘額：</label>
        <input type="number" maxlength="10" class="form-control" id="amount" value="" disabled>
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
@endsection