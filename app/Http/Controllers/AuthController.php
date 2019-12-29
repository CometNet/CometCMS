<?php


namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function logout() {
        Auth::logout();
        return [
            'code'=>20000
        ];
    }

    public function login(Request $request) {

        $account = $request->input('username');
        $password = $request->input('password');

        if (Auth::attempt(['account' => $account, 'password' => $password])) {
            $api_token = \Str::random(60);
            $user = User::find(Auth::id());
            $user->api_token = $api_token;
            $user->save();
            return [
                'data'=>[
                    'token' => $api_token
                ],
                'code'=>20000
            ];
        }else{

            return [
                'message' => '登录失败,账号或密码错误!',
                'code'=>20001
            ];
        }
    }

    public function info(Request $request) {

        $user = User::find(Auth::id());

        return [
            'code' => 20000,
            'data' => [
                'roles' => ['admin'],
                'introduction' => 'I am a super administrator',
                'avatar'    =>  'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif',
                'name'  =>  $user->name,
            ]];
    }

    public function register(Request $request) {
        $account = $request->input('username');
        $password = $request->input('password');
        $email = $request->input('email');


        $user = User::create([
            'name' => $account,
            'account' => $account,
            'email' => $email,
            'password' => Hash::make($password),
            'api_token' => \Str::random(60),
        ]);
        return [
            'code' => 20000,
            'message' => '注册成功!',
        ];
    }
}
