@extends('admin')
@section('subscribe', 'active')
@section('title', 'Danh sách đăng kí')

@section('content')

    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-envelope"></i> Gửi Email</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{route('admin.subscribe.mail.sendToAll')}}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <h5>  <label for="add_type">Tiêu đề</label></h5>
                                    <input class="form-control" type="text" name="subject" required>
                                </div>
                                <div class="form-group">
                                    <h5> <label for="script"> Tin nhắn</label></h5>
                                    <textarea name="message"   cols="30" style="width: 100%!important;"   rows="10"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary btn-block" value="Submit">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
