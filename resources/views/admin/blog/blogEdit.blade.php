@extends('admin')

@section('blog', 'active')

@section('title', 'sửa tin')

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

                    <form action="{{route('admin.blog.update', $blog->id)}}" method="post" class="form-horizontal form-bordered" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-8">
                                <div class="form-group">
                                    <h5> <label  class="col-form-label">Tiêu đề</label></h5>
                                    <div class="input-group">
                                        <input type="text" name="title" value="{{$blog->title}}"  class="form-control form-control-lg">
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6 col-lg-4">
                                <div class="form-group">
                                    <h5> <label  class="col-form-label">Trạng thái</label></h5>

                                    <select name="status" class="form-control form-control-lg" id="sel1" >
                                        <option value="1" @if($blog->status == 1) selected="selected"  @endif>Hiện</option>
                                        <option value="0" @if($blog->status != 1 ) selected="selected"  @endif>Ẩn</option>
                                    </select>


                                </div>
                            </div>

                            <div class="form-group col-lg-12 col-md-6">
                                <h5> <label for="exampleInputEmail1">Image</label></h5>

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="max-width: 1920px; max-height: 800px;">
                                        <img src="{{asset('assets/image/blog/'.$blog->image)}}" alt="*" />
                                    </div>

                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 1920px; max-height: 800px;"> </div>
                                    <div>
                                                <span class="btn btn-info btn-file">
                                                     <span class="fileinput-new"> Thay đổi </span>
                                                    <span class="fileinput-exists"> Thay đổi </span>
                                                 <input type="file" name="image"> </span>
                                        <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> Xóa </a>
                                    </div>
                                    <code>Image will be resize width: 750px; height: 400px</code>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <h5>  <label for="exampleInputEmail1">Mô tả</label></h5>
                                <textarea id="area2" class="form-control" type="text" rows="15" name="description" >{{$blog->description}}</textarea>
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
