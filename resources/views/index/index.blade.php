@extends('index.layout')
@section('content')
    <div id="main" role="main">
        @foreach($posts as $post)
        <article id="post-{{$post->id}}" class="post-{{$post->id}} post type-post status-publish format-standard hentry category-bondage-asian-porn tag-asterisk tag-ikoma-haruna tag-risk contain">

            <div class="title">
                <h2 class="entry-title">
                    <a href="/{{$post->alias}}.html" rel="bookmark">{{$post->title}}</a></h2>
                <div class="entry-byline">
                    <span><a href="/{{$post->alias}}.html">{{date("M d, Y",strtotime($post->created_at))}}</a></span>
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
                <p><a href="/{{$post->alias}}.html">
                        <img src="{{$post->thumbnail}}" alt="{{$post->title}}" width="1191" height="800" class="aligncenter size-full wp-image-{{$post->id}}" />
                    </a>
                </p>
            </div>


        </article>
        @endforeach
        <nav id="posts-nav" class="paged-navigation contain">
            <div class='wp-pagenavi'>
                {{$posts->links('index.page')}}
            </div>
        </nav>
    </div>
@endsection
