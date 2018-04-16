@extends('client.layout.master')

@section('title')
    {{ "Tin tuc" }}
@endsection

@section('content')
    <section id="content">
        <div class="container">
            <div class="breadcrumbs column">
                <h2>Tags: "{{ $tag }}"</h2>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                <!-- World News -->
                <div class="column-two-third">
                    @if (!isset($posts))
                    <h5 class="line">
                        <span>Tìm thấy:  kết quả</span>
                        <div class="navbar">
                            <a id="next2" class="next" href="#"><span></span></a>   
                            <a id="prev2" class="prev" href="#"><span></span></a>
                        </div>
                    </h5>
                    @else
                    <h5 class="line">
                        <span>Kết quả:</span>
                        <div class="navbar">
                            <a id="next2" class="next" href="#"><span></span></a>   
                            <a id="prev2" class="prev" href="#"><span></span></a>
                        </div>
                    </h5>
                    
                    <div class="outerwide" >
                        <ul class="wnews" id="carousel2">
                            @foreach ($posts as $item)
                            <li>
                                <img src="{{ $item->Thumbnail }}" width="280px" height="170px" alt="MyPassion" class="alignleft ct" />
                                <h6 class="regular"><a href="#">{{ $item->Title }}</a></h6>
                                <span class="meta">{{ $item->created_at }}   \\   <a href="#">World News.</a>   \\   <a href="#">No Coments.</a></span>
                                <p>{{ $item->Headline }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                <!-- /World News -->
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

    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.12&appId=466610240408371&autoLogAppEvents=1';
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
@endsection
