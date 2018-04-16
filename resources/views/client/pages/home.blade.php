@extends('client.layout.master')

@section('title')
    {{ "Trang chủ" }}
@endsection

@section('slider')
    @include('client.layout.slider')
@endsection

@section('content')
    <section id="content">
        <div class="container">
            <!-- Main Content -->
            <div class="main-content">
                @php
                    $cate_1 = $cates->shift();
                @endphp
                
                <!-- Popular News -->
                <div class="column-one-third">
                    <h5 class="line"><span>{{ $cate_1->Name }}</span></h5>
                    <div class="outertight">
                        <ul class="block">

                            @foreach ($mostPopularPosts as $item)
                            <li>
                                
                                <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}"><img src="{{ $item->Thumbnail }}" alt="MyPassion" class="alignleft" /></a>
                                <p>
                                    <span>{{ $item->created_at }}</span>
                                    <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}">{{ $item->Title }}</a>
                                </p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                </div>
                <!-- /Popular News -->
                
                <!-- Hot News -->
                @php
                    $cate_2 = $cates->shift();
                @endphp
                <div class="column-one-third">
                    <h5 class="line"><span>{{ $cate_2->Name }}</span></h5>
                    <div class="outertight m-r-no">
                        <ul class="block">
                            @foreach ($mostNewPosts as $item)
                            <li>
                                <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}"><img src="{{ $item->Thumbnail }}" alt="MyPassion" class="alignleft" /></a>
                                <p>
                                    <span>{{ $item->created_at }}</span>
                                    <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}">{{ $item->Title }}</a>
                                </p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /Hot News -->
                @php $i = 0 @endphp
                @foreach ($cates as $cate_item)
                 @php
                    $posts = $cate_item->posts->where('Status',1)->where('Hot',1)->sortByDesc('created_at')->take(10);
                    $post_1 = $posts->shift();
                    $i++;
                @endphp
                <!-- Life Style -->
                <div class="column-two-third">
                    <h5 class="line">
                        <span>{{ $cate_item->Name }}</span>
                        <div class="navbar">
                            <a id="{{ 'next'.$i }}" class="next" href="#"><span></span></a>   
                            <a id="{{ 'prev'.$i }}" class="prev" href="#"><span></span></a>
                        </div>
                    </h5>
                   
                    <div class="outertight max-img">
                        <img src="{{ empty($post_1->Thumbnail) ? "storage/uploads/5ab871aa6f79b_tải xuống.jpg":$post_1->Thumbnail }}" height="230px" width="300px" alt="MyPassion" />
                        <h6 class="regular"><a href="{{ route('single-post', [$post_1->category->Url,$post_1->FriendlyTitle,$post_1->category->id,$post_1->id]) }}">{{ $post_1->Title }}</a></h6>
                        <span class="meta">{{ $post_1->created_at }}</span>
                        <p>{{ $post_1->Headline }}</p>
                    </div>
                    
                    <div class="outertight m-r-no">
                        <ul class="block" id="{{ 'carousel'.$i }}">
                            @foreach ($posts as $item)
                            <li>
                                <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}"><img src="{{ $item->Thumbnail }}" alt="MyPassion" class="alignleft" /></a>
                                <p>
                                    <span>{{ $item->created_at }}</span>
                                    <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}">{{ $item->Title }}</a>
                                </p>
                            </li>
                            @endforeach
                            
                        </ul>
                    </div>
                </div>
                <!-- /Life Style -->
                @endforeach
            </div>
            <!-- /Main Content -->

            <!-- Left Sidebar -->
            @include('client.layout.left_sidebar_home')
            <!-- /Left Sidebar -->
        </div>    
    </section>
@endsection