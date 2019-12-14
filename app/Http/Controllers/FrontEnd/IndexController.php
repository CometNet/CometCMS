<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\FrontEnd\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagPost;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index($category=false)
    {
        $ps = new PostService();

        // 分类
        if($category){

            $where = [
                'posts.type'       => 0,
                'posts.status'     => 1,
                'category_post.category_id' => $category,
            ];
            $posts = Post::where($where)
                ->join('category_post','posts.id','category_post.post_id')
                ->orderBy('posts.id', 'DESC')->paginate(10);
        }
        // 首页
        else{
            $posts = Post::orderBy('id','desc')->paginate(10);
        }

        foreach ($posts as $key=>$post){
            $posts[$key]['tags'] = $post->tags;
            $posts[$key]['categories'] = $post->categories;
        }

        $tags = Tag::limit(45)->get();

        $popular_article = $ps->getPopularArticle();

        return view('index.index',[
            'posts' => $posts,
            'tags' => $tags,
            'popular_article' => $popular_article
        ]);
    }

    public function search($keyword)
    {

    }

    public function show($alias)
    {
        $ps = new PostService();

        $post = Post::where('alias',$alias)->first();
        $post['tags'] = $post->tags;
        $post['categories'] = $post->categories;

        $tagArr = Tag::limit(45)->get();

        $prev_article = $ps->publishedPrevArticle($post->id);
        $next_article = $ps->publishedNextArticle($post->id);
        $popular_article = $ps->getPopularArticle();
        $related_article = $ps->getRelatedArticle($post->id, $post['categories'][0]->id);

        return view('index.info',[
            'post' => $post,
            'posts' => $popular_article,
            'tags' => $tagArr,
            'prev_article' => $prev_article,
            'next_article' => $next_article,
            'popular_article' => $popular_article,
            'related_article' => $related_article
        ]);
    }

    public function tag($tag){

    }
}
