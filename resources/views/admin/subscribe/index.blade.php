@extends('admin')
@section('subscribe', 'active')
@section('title', 'Danh sách đăng kí')

@section('content')
    <main class="app-content">
        <div class="raw">
            <div class="col-lg-12">
                <div class="tile">
                    <h3 class="tile-title pull-left">Toàn bộ người đăng kí</h3>
                    <a href="{{route('admin.subscribe.mail.send.form')}}" class="btn btn-outline-primary float-right"><i class="fa fa-envelope-o"></i>Gửi Newletter cho tất cả những người đăng kí</a>
                    <p style="margin:0px;clear:both;"></p>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            @if(count($subscribe) == 0)
                                <td class="text-center">
                                    <h2>Không tìm thấy dữ liệu</h2>
                                </td>
                            @else
                                <tr>
                                    <th>#</th>
                                    <th>Email</th>
                                    <th>HÀNH ĐỘNG</th>
                                </tr>
                            </thead>
                            <tbody>


                            @foreach($subscribe as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$value->email}}</td>
                                    <td >
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-{{ $value->id }}"><i class="fa fa-trash"></i>   </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="delete-{{ $value->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title danger" id="myModalLabel2"><i class='fa fa-trash '></i> <span class="danger">Bạn có chắc chắn xóa không?</span></h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="post" action="{{route('admin.subscribe.delete',$value->id)}}" class="action-route">
                                                @csrf
                                                <div class="modal-body">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success"> OK</button>
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Không</button>&nbsp;
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="d-flex flex-row-reverse">
                            {{$subscribe->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
