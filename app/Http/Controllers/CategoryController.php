<?php


namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;


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
    public function store(CategoryRequest $request){

        $category = Category::create($request->all());

        return [
            'code' => 20000,
            'data' => $category
        ];
    }

    public function update(CategoryRequest $request)
    {
        $id = $request->input('id');

        $category = Category::find($id);

        if($category->save($request->all())){
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
