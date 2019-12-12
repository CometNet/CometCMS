<?php


namespace App\Services;

use App\Services\Service;
use App\Models\Post;

class PostService extends Service
{
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
                ->orderBy('posts.id', $sort)->first();
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


    public function getRelatedArticle($post_id, $category_id = 0){

    }

    public function getPopularArticle(){
        $where = [
            'posts.type'   => 0,
            'posts.status' => 1,
        ];
        return Post::where($where)
            ->orderBy('id', 'ASC')
            ->limit(5)
            ->get();
    }
}
