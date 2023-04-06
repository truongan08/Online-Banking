

@extends('user')
@section('Dashboard', 'active')
@section('title')
    @lang('Dashboard')
@stop

@section('content')
  @include('user.breadcrumb')


  <section class="atop">
      <div class="container">
         <div class="row justify-content-center">
                <div class="col-md-10 col-lg-12 text-center">
                    <div class="heading-title padding-bottom-70">
                        <h2>
                            @lang('AC') #{{Auth::user()->account_number}}
                        </h2>
                        <div class="sectionSeparator"></div>

                    </div>
                </div>
            </div>

          <div class="row aboutTop">
             <div class="col-lg-4">
                 <a href="{{route('user.account.statement')}}">
                  <div class="box">
                      <i class="fas fa-money-check-alt"></i>
                      <span>{{$gnl->cur_symbol}}{{Auth::user()->balance}} </span>
                      <h4>@lang('Current balance')</h4>
                  </div>
                 </a>

              </div>
              <div class="col-lg-4">
                  <a href="{{route('user.account.statement')}}">
                  <div class="box">
                      <i class="fa fa-exchange"></i>
                      <span>{{$totaltf}}</span>
                      <h4>@lang('Total Transaction')</h4>

                  </div>
                   </a>
              </div>
          </div>
      </div>
  </section>
@endsection
