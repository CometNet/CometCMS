<?php


namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class MenuController extends Controller
{

    public function list(Request $request) {
        $page = $request->input('page');
        $limit = $request->input('limit');
        return [
            'code' => 20000,
            'data' => [
                'total' => 100,
                'items' => [
                    [
                        'id' => 1,
                        'timestamp' => time(),
                        'author' => 'admin',
                        'status' => 'draft',
                        'title' => 'title',
                        'type' => 'CN',
                        'importance' => 3
                    ]
                ],
            ]];
    }

}
