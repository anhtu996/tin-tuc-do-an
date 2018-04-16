@extends('admin.layout.master')

@section('content')
<!-- Page Content -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin Tức
                    <small>Cập nhật</small>
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
            <form action="admin/post/update/{{$post->id}}" method="Post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group">
                    <label>Tiêu đề</label>
                    <input type="text" name="Title" id="title" class="form-control" value="{{ $post->Title }}" placeholder="Nhập Tiêu Đề">
                </div>
                 <div class="form-group">
                    <label>Đường dẫn</label>
                    <input type="text" name="FriendlyTitle" id="slug" class="form-control" value="{{ $post->FriendlyTitle }}">
                </div>
                <div class="form-group">
                    <label>Chuyên mục</label>
                    <select name="Category_Id" class="form-control" id="category_id">
                        <option value="null">--------------</option>
                        @foreach ($cates as $key => $value)
                            <option value="{{str_replace("x", "", $key)}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tóm Tắt</label>
                    <textarea name="Headline" class="form-control" rows="3">{{ $post->Headline}}</textarea>
                </div>
                <div class="form-group">
                    <label>Nội Dung</label>
                    <textarea name="Content" id="demo" class="form-control ckeditor" rows="3">{{ $post->Content}}</textarea>
                </div>
                <div class="form-group">
                    <label>Hình Ảnh</label>
                    <input type="file" name="Thumbnail" id="image" class="form-control">
                    <div class="img-thumbnail">
                        <img src="{{ $post->Thumbnail }}" class="img-responsive" id="img-product" alt="Image" width="250px">
                    </div>
                </div>
                <div class="form-group">
                    <label>Thẻ Tag ( cách nhau bằng khoảng trắng )</label>
                    <select class="js-example-basic-multiple" name="tags[]" multiple="multiple" style="width: 100%">
                        
                    </select>
                </div>
                <button type="reset" class="btn btn-default">Làm Mới</button>
                <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
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
         $('#title').keyup(function(event) {
            var title = $('#title').val();
            var slug = ChangeToSlug(title);
            $('#slug').val(slug);
        });
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
                cache: false
            }
        });
        
        // Fetch the preselected item, and add to the control
        var tagSelect = $('.js-example-basic-multiple');
        $.ajax({
            type: 'GET',
            url: '{{ route('search-tag-id', $post->id) }}'
        }).then(function (data) {

            // create the option and append to Select2
            $.each(data, function( index, value ) {
                var option = new Option(value.text, value.id, true, true);
                tagSelect.append(option).trigger('change');
                console.log(option);    
            });
            
            // manually trigger the `select2:select` event
            tagSelect.trigger({
                type: 'select2:select',
                params: {
                    data: data
                }
            });
        });

        $('#category_id').val({{$post->Category_Id}});

        $("#image").change(function() {
            var file = this.files[0];
            var imagefile = file.type;
            var match= ["image/jpeg","image/png","image/jpg"];
            if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
            {
                $("#alert-image").css('display', 'block');
                $("#alert-image").html("Please Select A valid Image File");
                console.log("error");
                return false;
            }
            else
            {
                var reader = new FileReader();
                reader.onload = imageIsLoaded;
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        function imageIsLoaded(e) {
            $('#img-product').attr('src', e.target.result);
            $('#img-product').attr('width', '250px');
        };
    });
</script>
<link rel="stylesheet" type="text/css" href="css/select2.min.css">
<script src="js/select2.min.js"></script>
<script type="text/javascript" language="javascript" src="admin_asset/ckeditor/ckeditor.js" ></script>
@endsection