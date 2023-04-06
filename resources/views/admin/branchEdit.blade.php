@extends('admin')

@section('branch', 'active')

@section('title', 'sửa chi nhánh')

@section('content')
    <main class="app-content">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-bars"></i> Sửa</h1>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tile">


                    <form action="{{route('admin.branch.update', $branch->id)}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-7">
                                <div class="form-group">
                                    <h5> <label  class="col-form-label">Tiêu đề</label></h5>
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{$branch->name}}"  class="form-control form-control-lg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-5">
                                <div class="form-group">
                                    <h5>  <label class="col-form-label">Trạng thái</label> </h5>
                                    <select class="form-control form-control-lg" name="status">
                                        <option value="1" {{ $branch->status == "1" ? 'selected' : '' }}>Hoạt động</option>
                                        <option value="0" {{ $branch->status == "0" ? 'selected' : '' }}>Không hoạt động</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <h5>  <label for="exampleInputEmail1">Mô tả</label></h5>
                                <textarea  class="form-control" type="text" rows="15" name="description" >{{$branch->description}}</textarea>
                            </div>

                        </div>
                        <div class="tile-footer">
                            <button class="btn btn-primary" style="width: 100%!important;" type="submit">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

@endsection
