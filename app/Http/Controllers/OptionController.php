<?php


namespace App\Http\Controllers;
use App\Models\Option;
use Illuminate\Http\Request;
use App\Http\Requests\OptionRequest;


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
    public function store(OptionRequest $request){

        $nav = Option::create($request->all());
        return [
            'code' => 20000,
            'data' => $nav
        ];
    }

    public function update(OptionRequest $request)
    {
        $id = $request->input('id');

        $option = Option::find($id);

        if($option->save($request->all())){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $option = Option::find($id);

        if($option->delete()){
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
