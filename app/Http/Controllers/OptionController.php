<?php


namespace App\Http\Controllers;
use App\Models\Option;
use Illuminate\Http\Request;


class OptionController extends Controller
{
    public function getAllList(){
        $list = Option::select('id','option_name')->get();
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

        $navArr = Option::offset($page)->limit($limit)->get();
        $total = Option::count();
        return [
            'code' => 20000,
            'data' => [
                'total' => $total,
                'items' => $navArr,
            ]];
    }

    ### RESTFul start
    public function store(Request $request){
        $option_name = $request->input('option_name');
        $option_value = $request->input('option_value');
        $description = $request->input('description');

        $nav = Option::create([
            'option_name' => $option_name,
            'option_value' => $option_value,
            'description' => $description
        ]);
        return [
            'code' => 20000,
            'data' => $nav
        ];
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $option_name = $request->input('option_name');
        $option_value = $request->input('option_value');
        $description = $request->input('description');

        $nav = Option::find($id);
        $nav->option_name = $option_name;
        $nav->option_value = $option_value;
        $nav->description = $description;

        if($nav->save()){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $nav = Option::find($id);
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
