@extends('admin')
@section('branch', 'active')
@section('title', 'Tất cả chi nhánh')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1> Tất cả chi nhánh </h1>
            </div>
            <a href="{{route('admin.branch.add')}}"> <button type="button"  class="btn btn-info"><i class="fa fa-plus"></i> Thêm chi nhánh</button> </a>


        </div>
        <div class="tile">

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    @if(count($branches) == 0)
                        <tr>
                            <td class="text-center">
                                <h2>Không có dữ liệu </h2>
                            </td>
                        </tr>
                    @else
                        <tr>
                            <th>#</th>
                            <th>Tên</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($branches as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->name}}</td>
                            <td>
                                @if($data->status == 1) <span class="badge badge-success">hoạt động</span>
                                @else <span class="badge badge-danger">không hoạt động</span>
                                @endif

                            </td>
                            <td>
                                <a href="{{route('admin.branch.edit', $data->id)}}"> <button type="button" class="btn btn-info"><i class="fa fa-edit"></i>  </button></a>

                                <button type="button" class="btn btn-danger delete" data-toggle="modal" data-name="{{$data->name}}" data-gate="{{$data->id}}" data-target="#exampleModalCenter">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex flex-row-reverse">

            </div>
        </div>



    </main>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Bạn có chắc chắn xóa không?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-right">
                    <form action="{{route('admin.blog.delete')}}" method="POST">
                        @csrf
                        <input type="hidden" name="blog" id="blog"/>

                        <div class="modal-gorup">
                            <button type="submit" class="btn btn-danger"> OK</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> Không</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $(document).on('click','.delete', function(){

                $('#blog').val($(this).data('gate'));
            });
        });
    </script>

@endsection

