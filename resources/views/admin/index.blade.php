@extends('admin')
@section('dashboard', 'active')
@section('title', 'Dashboard')

@section('title')
{{'Dashboard '}}
@endsection

@section('style')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
@endsection

@section('content')



<main class="app-content">
  <div class="app-title">
    <div>
      <h1>Admin Dashboard</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card" style="margin-bottom: 20px!important;">
        <div class="card-header">
          <i class="icon fa fa-users"></i> Thống kê người dùng
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-3">
              <a href="{{route('admin.allUser')}}" style="text-decoration: none">
                <div class="widget-small primary"><i class="icon fa fa-user-circle-o fa-3x"></i>
                  <div class="info">
                    <h4>Tất cả người dùng</h4>
                    <p><b>{{$totalUser}}</b></p>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3">
              <a href="{{route('admin.banned.user')}}" style="text-decoration: none">
                <div class="widget-small danger"><i class="icon fa fa-user-times fa-3x"></i>
                  <div class="info">
                    <h4>Tất cả người dùng bị cấm</h4>
                    <p><b>{{$bannedUser}}</b></p>
                  </div>
                </div>
              </a>
            </div>


          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      <div class="card" style="margin-bottom: 20px!important;">
        <div class="card-header">
          <i class="icon fa fa-money"></i> Thống kê tài chính người dùng
        </div>
        <div class="card-body">

          <div class="col-md-6">
            <a href="{{route('admin.allUser')}}" style="text-decoration: none">
              <div class="widget-small bg-success"><i class="icon fa fa-credit-card fa-3x"></i>
                <div class="info">
                  <h4>Số dư của tất cả người dùng</h4>
                  <p><b>{{$totalUserBal}} {{$gnl->cur}}</b></p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <i class="icon fa fa fa-exchange"></i> Thống kê giao dịch ngân hàng khác
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-4">

              <div class="widget-small primary"><i class="icon fa fa-money fa-3x"></i>
                <div class="info">
                  <h4>Tổng Số Giao Dịch</h4>
                  <p><b>{{$trOtBankTotal}} </b></p>
                </div>
              </div>

            </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


</main>
@endsection
@section('script')

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>



@stop