<?php


namespace App\Http\Controllers;
use App\Models\Navigation;
use Illuminate\Http\Request;
use App\Http\Requests\NavigationRequest;


class NavigationController extends Controller
{
    public function getAllList(){
        $list = Navigation::select('id','name')->get();
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
        $navArr = Navigation::offset($page)->limit($limit)->get();
        $total = Navigation::count();
        return [
            'code' => 20000,
            'data' => [
                'total' => $total,
                'items' => $navArr,
            ]];
    }

    ### RESTFul start
    public function store(NavigationRequest $request){

        $nav = Navigation::create($request->all());

        return [
            'code' => 20000,
            'data' => $nav
        ];
    }

    public function update(NavigationRequest $request)
    {
        $id = $request->input('id');

        $nav = Navigation::find($id);

        if($nav->save($request->all())){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $nav = Navigation::find($id);
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
