<?php


namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;


class MenuController extends Controller
{

    public function list(Request $request) {

        $navid = $request->input('navid');
        $page = $request->input('page');
        $limit = $request->input('limit');
        $page = $page ? ($page - 1) * $limit : 0;
        $limit = $limit ? $limit : 10;

        if($navid > 0){
            $total = Menu::where(['nav_id' => $navid])->count();
            $navArr = Menu::where(['nav_id' => $navid])->offset($page)->limit($limit)->get();
        }else{
            $total = Menu::count();
            $navArr = Menu::offset($page)->limit($limit)->get();
        }
        return [
            'code' => 20000,
            'data' => [
                'total' => $total,
                'items' => $navArr,
            ]];
    }

    ### RESTFul start
    public function store(MenuRequest $request){

        $menu = Menu::create($request->all());
        return [
            'code' => 20000,
            'data' => $menu
        ];
    }

    public function update(MenuRequest $request)
    {
        $id = $request->input('id');

        $menu = Menu::find($id);

        if($menu->save($request->all())){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $nav = Menu::find($id);
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
