@extends('client.layout.master')

@section('title')
    {{ "Tin tuc" }}
@endsection

@section('content')
    <section id="content">
        <div class="container">
            <div class="breadcrumbs column">
                <p>
                    <a href="{{ route('home') }}">Home.</a>
                    @if ($post->category->IsSubCategory == 1)   
                    \\ <a href="{{ route('category', [$post->category->getParentCate()->Url,$post->category->getParentCate()->id]) }}">{{ $post->category->getParentCate()->Name }}</a>
                    @endif   
                    \\   <a href="{{ route('category', [$post->category->Url,$post->category->id]) }}">{{ $post->category->Name }}</a></span>
                </p>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <!-- Single -->
                <div class="column-two-third single">
                    <div class="flexslider">
                        <ul class="slides">
                            <li>
                                <img src="{{ $post->Thumbnail }}" alt="MyPassion" />
                            </li>
                        </ul>
                    </div>

                    
                    <h6 class="title">{{ $post->Title }}</h6>
                    <span class="meta">{{ $post->created_at }}
                    @if ($post->category->IsSubCategory == 1)   
                    \\ <a href="{{ route('category', [$post->category->getParentCate()->Url,$post->category->getParentCate()->id]) }}">{{ $post->category->getParentCate()->Name }}</a>
                    @endif   
                    \\   <a href="{{ route('category', [$post->category->Url,$post->category->id]) }}">{{ $post->category->Name }}</a></span>
                    <p>{!! $post->Content !!} </p>
                    <p style="text-align:right"><em>Tham khảo: Cnet</em></p>
                    @if (isset($tags))
                        <div class="tags">
                        @foreach ($tags as $item)
                            <a href="{{ route('tag', $item->FriendlyTitle) }}">{{ $item->Title }}</a>
                        @endforeach
                        </div>
                    @endif
                        

                    
                    <div class="fb-comments" data-href="{{ route('single-post', [$post->category->Url,$post->FriendlyTitle,$post->category->id,$post->id]) }}" data-width="100%" data-numposts="5"></div>
                    
                    <div class="relatednews">
                        <h5 class="line"><span>Related News.</span></h5>
                        <ul>
                            @foreach ($mostRelatePosts as $item)
                            <li>
                                <a href="#"><img src="{{ $item->Thumbnail }}" alt="MyPassion" /></a>
                                <p>
                                    <span>{{ $item->created_at }}</span>
                                    <a href="#">{{ $item->Title }}</a>
                                </p>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                    
                        
                    </div>
                <!-- /Single -->
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
      js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=2088893518047208&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=466610240408371&autoLogAppEvents=1';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5ad15f0ed5176aef"></script>
@endsection
