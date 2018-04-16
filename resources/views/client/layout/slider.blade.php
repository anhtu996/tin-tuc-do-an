<section id="slider">
    <div class="container">
        <div class="main-slider">
        	<div class="badg">
            	<p><a href="#">Popular.</a></p>
            </div>
        	<div class="flexslider">
                <ul class="slides">
                    @foreach ($popularPosts as $item)
                    <li>
                        <img src="{{ $item->Thumbnail }}" alt="MyPassion" height="372px"/>
                        <p class="flex-caption"><a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}">{{ $item->Title }}</a> {{ $item->Headline }} </p>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <?php 
            $post_1 = $lastestPosts->shift();
        ?>
        <div class="slider2">
        	<div class="badg">
            	<p><a href="#">Latest.</a></p>
            </div>
            <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}"><img src="{{ $post_1->Thumbnail }}" height="217px" width="380px"  alt="MyPassion" /></a>
            <p class="caption"><a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}">{{ $post_1->Title }}</a> {{ $post_1->Headline }} </p>
        </div>

        @foreach ($lastestPosts as $item)
        <div class="slider3">
            <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}"><img src="{{ $item->Thumbnail }}" alt="MyPassion" height="135px" /></a>
            <p class="caption"><a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}">{{ $item->Title }}</a></p>
        </div>
        @endforeach
        
    </div>    
</section>