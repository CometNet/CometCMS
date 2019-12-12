<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\TagPost;
use App\Models\Category;
use App\Models\CategoryPost;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'alias', 'content', 'thumbnail', 'author', 'type', 'status', 'more'
    ];

    public function tags(){
        return $this->belongsToMany('App\Models\Tag','tag_post','post_id','tag_id');
    }

    public function categories(){
        return $this->belongsToMany('App\Models\Category','category_post','post_id','category_id');
    }

    /**
     * 添加标签
     * @param $keywords
     * @param $post_id
     */
    public function addTags($keywords, $post_id){

        $tagIds = [];

        $data = [];

        if (!empty($keywords)) {
            $oldTagIds = TagPost::select('tag_id')
                ->where('post_id',$post_id)
                ->get()
                ->map(function($tag){
                    return $tag->tag_id;
                })->toArray();
            foreach ($keywords as $keyword) {
                $keyword = trim($keyword);
                if (!empty($keyword)) {
                    $findTag = Tag::where('name', $keyword)->first();
                    if (empty($findTag)) {
                        $newTag = Tag::create([
                            'name' => $keyword,
                            'status' => 1
                        ]);
                        $tagId = $newTag->id;
                    }else{
                        $tagId = $findTag->id;
                    }
                    if (!in_array($tagId, $oldTagIds)) {
                        array_push($data, ['tag_id' => $tagId, 'post_id' => $post_id]);
                    }

                    array_push($tagIds, $tagId);
                }
            }

            if (empty($tagIds) && !empty($oldTagIds)) {
                TagPost::where('post_id', $post_id)->delete();
            }

            $sameTagIds = array_intersect($oldTagIds, $tagIds);

            $shouldDeleteTagIds = array_diff($oldTagIds, $sameTagIds);

            if (!empty($shouldDeleteTagIds)) {
                TagPost::where('post_id', $post_id)
                    ->whereIn('tag_id', $shouldDeleteTagIds)
                    ->delete();
            }
            if (!empty($data)) {
                TagPost::insert($data);
            }
        }else{
            TagPost::where('post_id', $post_id)->delete();
        }

    }

    public function addCategories($categories, $post_id){

        if (is_string($categories)) {
            $categories = explode(',', $categories);
        }

        if(!empty($keywords)){
            CategoryPost::where('post_id', $post_id)->delete();
        }

        $oldCategoryIds = CategoryPost::where('post_id',$post_id)->get()->map(function($category){return $category->category_id;})->toArray();

        $data = [];

        if($oldCategoryIds){
            $sameCategoryIds       = array_intersect($categories, $oldCategoryIds);
            $needDeleteCategoryIds = array_diff($oldCategoryIds, $sameCategoryIds);
            $newCategoryIds        = array_diff($categories, $sameCategoryIds);


            if (!empty($needDeleteCategoryIds)) {
                CategoryPost::where('post_id', $post_id)
                    ->whereIn('tag_id', $needDeleteCategoryIds)
                    ->delete();
            }

            if (!empty($newCategoryIds)) {
                foreach ($newCategoryIds as $categorie){
                    array_push($data, ['category_id' => $categorie, 'post_id' => $post_id]);
                }
                CategoryPost::insert($data);
            }
            return true;
        }else{
            foreach ($categories as $categorie){
                array_push($data, ['category_id' => $categorie, 'post_id' => $post_id]);
            }
            CategoryPost::insert($data);
            return true;
        }
    }
}
