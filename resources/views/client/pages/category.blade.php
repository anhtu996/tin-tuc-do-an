@extends('client.layout.master')

@section('title')
    {{ "Tin tuc" }}
@endsection

@section('content')
    

        <section id="content">
            <div class="container">
                @if(!isset($key)) 
                <div class="breadcrumbs column">
                    <p>
                        <a href="{{ route('home') }}">Home.</a>
                        @if ($cate->IsSubCategory == 1)   
                        \\ <a href="{{ route('category', [$cate->getParentCate()->Url,$cate->getParentCate()->id]) }}">{{ $cate->getParentCate()->Name }}</a>
                        @endif   
                        \\   <a href="{{ route('category', [$cate->Url,$cate->id]) }}">{{ $cate->Name }}</a></span>
                    </p>
                </div>
                <!-- Main Content -->
                <div class="main-content">
                   
                    <!-- World News -->
                    <div class="column-two-third">
                        <h5 class="line">
                            <span>{{ $cate->Name }}</span>
                            <div class="navbar">
                               
                            </div>
                        </h5>
                        
                        <div class="outerwide" >
                            <ul class="wnews">
                                @foreach ($listPost as $item)
                                <li>
                                    <img src="{{ $item->Thumbnail }}" width="280px" height="170px" alt="MyPassion" class="alignleft ct" />
                                    <h6 class="regular"><a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}">{{ $item->Title }}</a></h6>
                                    <span class="meta">{{ $item->created_at }}   \\   <a href="#">World News.</a>   \\   <a href="#">No Coments.</a></span>
                                    <p>{{ $item->Headline }}</p>
                                </li>
                                @endforeach
                            </ul>
                            
                        </div>
                        {!! $listPost->render()!!}
                    </div>
                    <!-- /World News -->
                @else
                <div class="main-content"> 
                    <div class="column-two-third">
                       <h2> Không có bài viết</h2>
                    </div>  
                </div>  
                @endif     
                </div>
                <!-- /Main Content -->
                <!-- Left Sidebar -->
                @include('client.layout.left_sidebar_single')
                <!-- /Left Sidebar -->
            </div>    
        </section>
    
@endsection
@section('js-fb')

    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=466610240408371&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endsection
