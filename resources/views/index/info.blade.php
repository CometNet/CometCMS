@extends('index.layout')
@section('content')
    <div id="main" role="main">

        <article id="post-{{$post->id}}" class="post-{{$post->id}} post type-post status-publish format-standard hentry category-bondage-asian-porn tag-asterisk tag-ikoma-haruna tag-risk tag-2060 tag-5487 contain has-byline">

            <div class="title">
                <h1 class="entry-title">{{$post->title}}</h1>
                <div class="entry-byline">
                    <span><a href="/{{$post->alias}}.html">December 10, 2019</a></span>
                </div>

                <div class="entry-meta">
                    Posted in:
                    @foreach($post['categories'] as $categorie)
                        <a href="/category/{{$categorie->title}}" rel="category tag">{{$categorie->title}}</a>.
                    @endforeach
                    Tagged:
                    @foreach($post['tags'] as $tag)
                        <a href="/tag/{{$tag->name}}" rel="tag">{{$tag->name}}</a>,
                    @endforeach
                </div><!-- entry-meta -->

            </div><!-- end title -->

            <div class="entry-content">
                <p>
                    {{$post->content}}
                <p>
                    @foreach(json_decode($post->more)->files as $file)
                    <a href="{{$file->uri}}" target="_blank">{{$file->name}}</a>
                    @endforeach
                </p>
            </div>

            <nav id="post-nav" class="contain">
                @if($prev_article)
                <div class="nav-older">← <a href="/{{$prev_article->alias}}.html" rel="prev">{{$prev_article->title}}</a></div>
                @endif
                @if($next_article)
                <div class="nav-newer"><a href="/{{$next_article->alias}}.html" rel="next">{{$next_article->title}}く</a> →</div>
                @endif
            </nav>

        </article>
        <article id="post-45" class="post-45 post type-post status-publish format-standard hentry category-scatting tag-amo tag-asian-scat tag-eat-shit tag-extreme tag-scat tag-vrxs tag-40 tag-7 tag-38 contain has-byline">
            <h2 style="padding-left:40px">Related posts</h2>
            <table width="100%" style="border:none" align="center" cellpadding="2" cellspacing="2">
                <tbody>
                    <tr>
                        <td valign="top" align="center" width="33%" style="background:none"> <div id="pictssidebar">
                                <div style="height:5px"></div>
                                <a href="/.html"><img src="/jpg" style="width:200px; height:auto"></a></div>
                            <div style="height:10px"></div>
                            <a href="e/.html">title</a>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="center" width="33%" style="background:none"> <div id="pictssidebar">
                                <div style="height:5px"></div>
                                <a href="/"><img src="/" style="width:200px; height:auto"></a></div>
                            <div style="height:10px"></div>
                            <a href="/.html">/</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </article>
    </div>
@endsection
