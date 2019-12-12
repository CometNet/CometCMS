<?php


namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function getAllList(){
        $list = Category::select('id','title')->get();
        return [
            'code' => 20000,
            'data' => [
                'items' => $list
            ]
        ];
    }

    public function list(Request $request) {
        $page = $request->input('page');
        $limit = $request->input('limit');
        $page = $page ? ($page - 1) * $limit : 0;
        $limit = $limit ? $limit : 10;
        $navArr = Category::offset($page)->limit($limit)->get();
        $total = Category::count();
        return [
            'code' => 20000,
            'data' => [
                'total' => $total,
                'items' => $navArr,
            ]];
    }

    ### RESTFul start
    public function store(Request $request){
        $parent_id = $request->input('parent_id');
        $title = $request->input('title');
        $keywords = $request->input('keywords');
        $description = $request->input('description');
        $status = $request->input('status');
        $list_order = $request->input('list_order');

        $nav = Category::create([
            'parent_id' => $parent_id,
            'title' => $title,
            'keywords' => $keywords,
            'description' => $description,
            'status' => $status,
            'list_order' => $list_order,
            'more' => ''
        ]);
        return [
            'code' => 20000,
            'data' => $nav
        ];
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $parent_id = $request->input('parent_id');
        $title = $request->input('title');
        $keywords = $request->input('keywords');
        $description = $request->input('description');
        $status = $request->input('status');
        $list_order = $request->input('list_order');

        $nav = Category::find($id);
        $nav->parent_id = $parent_id;
        $nav->title = $title;
        $nav->keywords = $keywords;
        $nav->description = $description;
        $nav->status = $status;
        $nav->list_order = $list_order;

        if($nav->save()){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $nav = Category::find($id);
        if($nav->delete()){
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
