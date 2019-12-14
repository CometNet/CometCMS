<?php


namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Tag;
use App\Models\TagPost;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ArticleController extends Controller
{

    public function list(Request $request) {
        $page = $request->input('page');
        $limit = $request->input('limit');
        $page = $page ? ($page - 1) * $limit : 0;
        $limit = $limit ? $limit : 10;

        $posts = Post::offset($page)->limit($limit)->get();
        foreach ($posts as $key=>$post){
            $posts[$key]['tags'] = $post->tags;
            $posts[$key]['categories'] = $post->categories;
        }

        $total = Post::count();
        return [
            'code' => 20000,
            'data' => [
                'total' => $total,
                'items' => $posts,
            ]];
    }

    ### RESTFul start
    public function show($id){

        $post = Post::find($id);

        $tags = $post->tags->map(function($tag){
            return $tag['name'];
        });

        $post['categorys'] = $post->categories->map(function($categorie){
            return $categorie['id'];
        });

        $more = json_decode($post['more'],true);
        $post['files'] = $more['files'];

        unset($post['tags']);
        $post['tags'] = $tags->toArray();
        if($post) {
            return [
                'code' => 20000,
                'data' => $post
            ];
        }else{
            return [
                'code' => 20001,
                'message' => '找不到文章'
            ];
        }
    }

    public function store(Request $request){
        $title = $request->input('title');
        $alias = $request->input('alias');
        $content = $request->input('content');
        $thumbnail = $request->input('thumbnail');
        $type = $request->input('type');
        $status = $request->input('status');
        $tags = $request->input('tags');
        $files = $request->input('files');
        $categorys = $request->input('categorys');
        $more['files'] = $files;

        $postModel = new Post();

        $post= $postModel->create([
            'title' => $title,
            'alias' => $alias,
            'content' => $content,
            'thumbnail' => $thumbnail ? $thumbnail : '0',
            'author' => Auth::id(),
            'type' => $type ? $type : 0,
            'status' => $status,
            'more' => json_encode($more)
        ]);
        $postModel->addTags($tags, $post->id);
        $postModel->addCategories($categorys,$post->id);

        return [
            'code' => 20000,
            'data' => $post
        ];
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $title = $request->input('title');
        $alias = $request->input('alias');
        $content = $request->input('content');
        $thumbnail = $request->input('thumbnail');
        $type = $request->input('type');
        $status = $request->input('status');
        $files = $request->input('files');
        $tags = $request->input('tags');
        $categorys = $request->input('categorys');
        $more['files'] = $files;

        $postModel = new Post();

        $post = $postModel->find($id);
        $post->title = $title;
        $post->alias = $alias;
        $post->content = $content;
        $post->thumbnail = $thumbnail;
        $post->type = $type;
        $post->status = $status;
        $post->more = json_encode($more);

        $postModel->addTags($tags, $id);
        $postModel->addCategories($categorys,$post->id);

        if($post->save()){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->delete()){
            return [
                'code' => 20000
            ];
        }else{
            return [
                'code' => 20001,
                'message' => '删除失败'
            ];
        }
    }
    ### RESTFul end
}
