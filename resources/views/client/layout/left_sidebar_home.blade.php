
<div class="column-one-third">
    
    <div class="sidebar">
        <h5 class="line"><span>Vimeo Video.</span></h5>
        <iframe src="http://player.vimeo.com/video/65110834?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="300px" height="170px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
    </div>
    
    
    <div class="sidebar">
        <div id="tabs">
            <ul>
                <li><a href="#tabs1">New</a></li>
                <li><a href="#tabs2">Hot</a></li>
                <li><a href="#tabs3">Popular</a></li>
            </ul>
            <div id="tabs1">
                <ul>
                    @foreach ($mostNewPosts as $item)
                    <li>
                        <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}" class="title">{{ $item->Title }}</a>
                        <span class="meta">{{ $item->created_at }}</span>
                    </li>
                    @endforeach
                    
                </ul>
            </div>
            <div id="tabs2">
                <ul>
                    @foreach ($mostHotPosts as $item)
                    <li>
                        <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}" class="title">{{ $item->Title }}</a>
                        <span class="meta">{{ $item->created_at }}</span>
                    </li>
                    @endforeach
                    
                </ul>
            </div>
            <div id="tabs3">
                <ul>
                    @foreach ($mostPopularPosts as $item)
                    <li>
                        <a href="{{ route('single-post', [$item->category->Url,$item->FriendlyTitle,$item->category->id,$item->id]) }}" class="title">{{ $item->Title }}</a>
                        <span class="meta">{{ $item->created_at }}</span>
                    </li>
                    @endforeach
                    
                </ul>
            </div>
        </div>
    </div>
    
    <div class="sidebar">
        <h5 class="line"><span>Ads Spot.</span></h5>
        <a href="#"><img src="client_css/img/tf_300x250_v1.gif" alt="MyPassion" /></a>     
    </div>
    
    <div class="sidebar">
        <h5 class="line"><span>Facebook.</span></h5>
        <div class="fb-page" data-href="https://www.facebook.com/facebook" data-tabs="timeline" data-width="298" data-height="214" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/facebook" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/facebook">Facebook</a></blockquote></div>
    </div>

    <div class="sidebar">
        <h5 class="line"><span>Follow us</h5>
        <ul class="social">
        
        <li  class="twitter">
            <div class="btn">
            {{-- <a href="#" class="twitter"><i class="icon-twitter"></i></a> --}}
                <a href="https://twitter.com/nextWPthemes" class="twitter-follow-button " data-show-count="false" data-show-screen-name="false">Follow @nextWPthemes</a>
                <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
            </div>
        </li>
        <li class="google_plus">
            <div class="btn">
                <!-- Place this tag where you want the +1 button to render. -->
                <div class="g-plusone" data-size="medium"></div>

                <!-- Place this tag after the last +1 button tag. -->
                <script type="text/javascript">
                  (function() {
                    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
                  })();
                </script>
            </div>
            
        </li>
        </ul>
    </div>

    <div class="sidebar">
        <h5 class="line"><span>Tags</span></h5>
        <div class="tags">

        @foreach ($tags as $item)
            <a href="{{ route('tag', $item->FriendlyTitle) }}">{{ $item->Title }}</a>
        @endforeach
        </div>    
    </div>
</div>
<!-- /Left Sidebar