<?php


namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


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
    public function store(Request $request){
        $name = $request->input('name');
        $nav_id = $request->input('nav_id');
        $parent_id = $request->input('parent_id');
        $status = $request->input('status');
        $list_order = $request->input('list_order');
        $href = $request->input('href');
        $target = $request->input('target');
        $icon = $request->input('icon');


        $menu = Menu::create([
            'name' => $name,
            'nav_id' => $nav_id,
            'parent_id' => $parent_id,
            'status' => $status,
            'list_order' => $list_order,
            'href' => $href,
            'target' => $target,
            'icon' => $icon,
        ]);
        return [
            'code' => 20000,
            'data' => $menu
        ];
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $nav_id = $request->input('nav_id');
        $parent_id = $request->input('parent_id');
        $status = $request->input('status');
        $list_order = $request->input('list_order');
        $href = $request->input('href');
        $target = $request->input('target');
        $icon = $request->input('icon');

        $nav = Menu::find($id);
        $nav->name = $name;
        $nav->nav_id = $nav_id;
        $nav->parent_id = $parent_id;
        $nav->status = $status;
        $nav->list_order = $list_order;
        $nav->href = $href;
        $nav->target = $target;
        $nav->icon = $icon;

        if($nav->save()){
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
