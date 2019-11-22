<?php


namespace App\Http\Controllers;
use App\User;
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
    public function store(Request $request){
        $name = $request->input('name');
        $account = $request->input('account');
        $email = $request->input('email');
        $password = $request->input('password');
        $sex = $request->input('sex');
        $birthday = $request->input('birthday');
        $status = $request->input('status');
        $avatar = $request->input('avatar');
        $mobile = $request->input('mobile');

        $nav = User::create([
            'name' => $name,
            'account' => $account,
            'email' => $email,
            'password' => Hash::make($password),
            'api_token' => \Str::random(60),
            'sex' => $sex,
            'birthday' => strtotime($birthday),
            'status' => $status,
            'avatar' => $avatar,
            'mobile' => $mobile,
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
        $name = $request->input('name');
        $account = $request->input('account');
        $email = $request->input('email');
        $password = $request->input('password');
        $sex = $request->input('sex');
        $birthday = $request->input('birthday');
        $status = $request->input('status');
        $avatar = $request->input('avatar');
        $mobile = $request->input('mobile');

        $nav = User::find($id);
        $nav->name = $name;
        $nav->account = $account;
        $nav->email = $email;
        $nav->password = Hash::make($password);
        $nav->api_token = \Str::random(60);
        $nav->sex = $sex;
        $nav->birthday = strtotime($birthday);
        $nav->status = $status;
        $nav->avatar = $avatar;
        $nav->mobile = $mobile;

        if($nav->save()){
            return ['code' => 20000];
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
