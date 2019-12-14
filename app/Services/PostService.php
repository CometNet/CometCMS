<?php


namespace App\Services;

use App\Services\Service;
use App\Models\TagPost;
use App\Models\Tag;
use App\Models\Post;

class PostService extends Service
{
    /**
     * 获取相近文章
     * @param $post_id
     * @param int $category_id
     * @param $act
     * @return mixed
     */
    private function publishedBetweenArticle($post_id, $category_id = 0,$act){
        if ($act == 'prev'){
            $condition = '<';
            $sort = 'DESC';
        }else{
            $condition = '>';
            $sort = 'ASC';
        }

        if(empty($category_id)){
            $where = [
                'posts.type'   => 0,
                'posts.status' => 1,
            ];
            $article = Post::where($where)
                ->where('posts.id', $condition, $post_id)
                ->orderBy('id', $sort)
                ->first();
        }else{
            $where = [
                'posts.type'       => 1,
                'posts.status'     => 1,
                'category_post.category_id' => $category_id,
            ];
            $article = Post::where($where)
                ->where('posts.id', $condition, $post_id)
                ->join('category_post','posts.id','category_post.post_id')
                ->orderBy('posts.id', $sort)
                ->first();
        }
        return $article;
    }

    /**
     * 上一篇文章
     * @param $post_id
     * @param int $category_id
     * @return mixed
     */
    public function publishedPrevArticle($post_id, $category_id = 0){
        return $this->publishedBetweenArticle($post_id,$category_id,'prev');
    }

    /**
     * 下一篇文章
     * @param $post_id
     * @param int $category_id
     * @return mixed
     */
    public function publishedNextArticle($post_id, $category_id = 0){
        return $this->publishedBetweenArticle($post_id,$category_id,'next');
    }

    /**
     * 获取相关文章
     * @param $post_id
     * @param int $category_id
     * @return mixed
     */
    public function getRelatedArticle($post_id, $category_id = 0, $number = 6){
        $where = [
            'posts.type'       => 1,
            'posts.status'     => 1,
            'category_post.category_id' => $category_id,
        ];
        $article = Post::where($where)
            ->where('posts.id', '!=', $post_id)
            ->join('category_post','posts.id','category_post.post_id')
            ->limit($number);
        return $article;
    }

    /**
     * 通过标签获取相关文章
     * @param $tag
     */
    public function getTagArticle($tag){
        $tag = Tag::where('name',$tag)->first();
        if($tag){
            $posts = TagPost::where('tag_id',$tag->id)->get();
            foreach ($posts as $post){
                $posts['post'] = $post->posts;
            }
            return $posts;
        }
        return [];
    }

    /**
     * 获取最受欢迎的文章
     * @param int $number
     * @return mixed
     */
    public function getPopularArticle($number = 5){
        $where = [
            'posts.type'   => 0,
            'posts.status' => 1,
        ];
        return Post::where($where)
            ->orderBy('id', 'ASC')
            ->limit($number)
            ->get();
    }
}
