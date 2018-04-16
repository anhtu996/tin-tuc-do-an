@extends('admin.layout.master')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin Tức
                    <small>Thêm</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-12" style="padding-bottom:70px">
             @if(count($errors)>0)
             <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                {{ $err }}<br>
                @endforeach
            </div>
            @endif
            @if(session('errfile'))
                <div class="alert alert-danger">
                    <strong>{{session('errfile')}}</strong>
                </div>
            @endif
           
            <form action="admin/post/add" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="Title" id="title" class="form-control" value="{{ old('Title')}}" placeholder="Nhập Tiêu Đề">
                </div>
                <div class="form-group">
                    <label>Đường dẫn</label>
                    <input type="text" name="FriendlyTitle" id="slug" class="form-control" value="{{ old('FriendlyTitle')}}">
                </div>
                <div class="form-group">
                    <label>Chuyên mục</label>
                    <select name="Category_Id" class="form-control">
                        <option value="null">--------------</option>
                        @foreach ($cates as $key => $value)
                            <option value="{{str_replace("x", "", $key)}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tóm Tắt</label>
                    <textarea name="Headline" class="form-control" rows="3">{{ old('Headline')}}</textarea>
                </div>

                <div class="form-group">
                    <label>Nội Dung</label>
                    <textarea name="Content" id="demo" class="form-control ckeditor" rows="3">{{ old('Content')}}</textarea>
                </div>
                <div class="form-group">
                    <label>Hình Ảnh</label>
                    <input type="file" name="Thumbnail" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <label>Thẻ Tag ( cách nhau bằng khoảng trắng )</label>
                    <select class="js-example-basic-multiple" name="tags[]" multiple="multiple" style="width: 100%">
                    </select>
                </div>
                <button type="reset" class="btn btn-default">Làm Mới</button>
                <button type="submit" class="btn btn-primary">Thêm</button>
            </form>
        </div>
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->
@endsection
@section('script')
<script src="js/slug.js"></script>
<script>
    $(document).ready(function(){
        var options = {
                filebrowserImageBrowseUrl: 'laravel-filemanager?type=Images',
                filebrowserImageUploadUrl: 'laravel-filemanager/upload?type=Images&_token={{csrf_token()}}',
                filebrowserBrowseUrl: 'laravel-filemanager?type=Files',
                filebrowserUploadUrl: 'laravel-filemanager/upload?type=Files&_token={{csrf_token()}}'
              };
        CKEDITOR.replace('demo', options);
        $('.js-example-basic-multiple').select2({
            placeholder: "Choose tags...",
            minimumInputLength: 2,
            ajax: {
                url: "{{ route('search-tag') }}",
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });


         $('#title').keyup(function(event) {
                var title = $('#title').val();
                var slug = ChangeToSlug(title);
                $('#slug').val(slug);
            });
    });
</script>
<link rel="stylesheet" type="text/css" href="css/select2.min.css">
<script src="js/select2.min.js"></script>
<script type="text/javascript" language="javascript" src="admin_asset/ckeditor/ckeditor.js" ></script>
@endsection