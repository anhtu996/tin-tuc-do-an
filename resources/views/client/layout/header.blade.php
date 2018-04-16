
<header id="header">
    <div class="container">
        <div class="column">
            <div class="logo">
                <a href="{{ route('home') }}"><img src="client_css/img/logo.png" alt="MyPassion" /></a>
            </div>
            
            <div class="search">
                <form action="{{ route('search') }}" method="get">
                    <input type="text" value="Search." onblur="if(this.value=='') this.value='Search.';" onfocus="if(this.value=='Search.') this.value='';" class="ft" name="textSearch" />
                    <input type="submit" value="" class="fs">
                    
                    <div id='suggestions' style="display: none;">
                        <ul id="auto-complete"> 
                            <li class="child-top"><b>Tìm kiếm bài viết</b></li>
                        </ul>
                    </div>
                </form>
            </div>
            <!-- Nav -->
            <nav id="nav">
                <ul class="sf-menu">
                    <li class="current"><a href="{{ route('home') }}">Home.</a></li>
                    @foreach ($categories as $item)
                    <li>
                        <a href="{{ route('category', [$item->Url,$item->id]) }}">{{ $item->Name }}</a>
                        @if ($item->hasChilCate())
                        <ul>
                            @foreach ($item->getChilCate() as $chilItem)
                            <li>
                                <i class="icon-right-open"></i><a href="{{ route('category', [$chilItem->Url,$chilItem->id]) }}">{{ $chilItem->Name }}</a>
                            </li>
                            @endforeach
                        </ul>
                        @endif
                    </li>
                
                    @endforeach
                    
                </ul>
                
            </nav>
            <!-- /Nav -->
        </div>
    </div>
</header>
<!-- /Header