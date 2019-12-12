<!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" lang="en-US">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" lang="en-US">
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html lang="en-US">
<!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <title>@yield('title')</title>
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="pingback" href="http://javhard.net/xmlrpc.php" />
    <!--[if lt IE 9]>
    <script src="/static/js/html5.js" type="text/javascript"></script>
    <![endif]-->
    <link rel="alternate" type="application/rss+xml" title="JAV Hard &raquo; Feed" href="http://javhard.net/feed" />
    <link rel="alternate" type="application/rss+xml" title="JAV Hard &raquo; Comments Feed" href="http://javhard.net/comments/feed" />
    <style type="text/css">
        .wp-pagenavi{float:left !important; }
    </style>
    <link rel='stylesheet' id='parament-css'  href='/static/css/style.css?ver=4.1.28' type='text/css' media='all' />
    <link rel='stylesheet' id='slb_core-css'  href='/static/css/app.css?ver=2.3.1' type='text/css' media='all' />
    <link rel='stylesheet' id='wp-pagenavi-style-css'  href='/static/css/css3_black.css?ver=1.0' type='text/css' media='all' />
    <link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://javhard.net/xmlrpc.php?rsd" />
    <link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://javhard.net/wp-includes/wlwmanifest.xml" />
    <meta name="generator" content="WordPress 4.1.28" />
    <style type="text/css">
        .wp-pagenavi
        {
            font-size:12px !important;
        }
    </style>
</head>

<body class="home blog">

<div id="page-wrap" class="contain">
    <header id="branding" role="banner">
		<span id="site-title" style=" font-size: 40px;
    font-weight: normal;
    line-height: 47px;
    margin: 20px 0 0 15px;"><a href="http://javhard.net">@yield('title')</a></span>
        <h2 id="site-description">@yield('description')</h2>
    </header><!-- #branding -->

    <nav id="menu" role="navigation"><ul id="primary-menu" class="menu">
            <li id="menu-item-0" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-0"><a href="/">Home</a></li>
            @foreach(getMenu(1) as $menu)
            <li id="menu-item-{{$menu->id}}" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-{{$menu->id}}">
                <a href="{{$menu->href}}">{{$menu->name}}</a>
            </li>
            @endforeach
            <li id="menu-item-7" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-7"><a href="http://javhard.net/?feed=rss2">RSS</a></li>
        </ul></nav>
    <div id="container" class="contain">

        @yield('content')
        <!-- end main -->

        <ul id="sidebar" role="complementary">
            <li id="search-2" class="widget widget_search">
                <form role="search" method="get" id="searchform" class="searchform" action="http://javhard.net/">
                    <div>
                        <label class="screen-reader-text" for="s">Search for:</label>
                        <input type="text" value="" name="s" id="s" />
                        <input type="submit" id="searchsubmit" value="Search" />
                    </div>
                </form>
            </li>
            <li id="popular-posts" class="widget show_PopularPostss"><h2 class="widget-title">Popular Posts</h2>
                <ul>
                    @foreach($popular_article as $post)
                    <li>
                        <a href='/{{$post->alias}}.html' rel='nofollow'>
                            <img src="{{$post->thumbnail}}"  width="600"  alt="{{$post->title}}" class="aligncenter" />
                            <br>{{$post->title}}</a>
                    </li>
                    @endforeach
                </ul>
            </li>
            <li id="tag_cloud-2" class="widget widget_tag_cloud">
                <h2 class="widget-title">Tags</h2>
                <div class="tagcloud">
                    @foreach($tags as $tag)
                    <a href='/tag/{{$tag->name}}' class='tag-link-{{$tag->id}}' title='602 topics' style='font-size: 8pt;'>{{$tag->name}}</a>
                    @endforeach
                </div>
            </li>
        </ul><!-- end sidebar -->
    </div><!-- end container -->


</div><!-- end page-wrap -->
<footer id="colophon" role="contentinfo">
    <div id="site-generator">
        <!--LiveInternet counter--><script type="text/javascript"><!--
            document.write("<a href='//www.liveinternet.ru/click' "+
                "target=_blank><img src='//counter.yadro.ru/hit?t17.5;r"+
                escape(document.referrer)+((typeof(screen)=="undefined")?"":
                    ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                ";"+Math.random()+
                "' alt='' title='LiveInternet: показано число просмотров за 24"+
                " часа, посетителей за 24 часа и за сегодня' "+
                "border='0' width='88' height='31'><\/a>")
            //--></script><!--/LiveInternet-->
    </div>
</footer>

<script type="text/javascript" id="slb_context">/* <![CDATA[ */if ( !!window.jQuery ) {(function($){$(document).ready(function(){if ( !!window.SLB ) { {$.extend(SLB, {"context":["public","user_guest"]});} }})})(jQuery);}/* ]]> */</script>

</body>
</html>
