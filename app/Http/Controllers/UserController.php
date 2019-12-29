<?php


namespace App\Http\Controllers;
use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllList(){
        $list = User::select('id','name')->get();
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

        $navArr = User::offset($page)->limit($limit)->get();
        $total = User::count();
        return [
            'code' => 20000,
            'data' => [
                'total' => $total,
                'items' => $navArr,
            ]];
    }

    ### RESTFul start
    public function store(UserRequest $request){
        $request['api_token'] = \Str::random(60);
        $user = User::create($request->all());
        return [
            'code' => 20000,
            'data' => $user
        ];
    }

    public function update(UserRequest $request)
    {
        $id = $request->input('id');

        $nav = User::find($id);

        if($nav->save($request->all())){
            return ['code' => 20000,'message' => '编辑成功'];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $nav = User::find($id);
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
