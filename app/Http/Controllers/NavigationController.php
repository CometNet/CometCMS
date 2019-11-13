<?php


namespace App\Http\Controllers;
use App\Models\Navigation;
use Illuminate\Http\Request;


class NavigationController extends Controller
{

    public function list(Request $request) {
        $page = $request->input('page');
        $limit = $request->input('limit');
        $page = $page ? $page : 0;
        $limit = $limit ? $limit : 10;
        $navArr = Navigation::offset($page)->limit($limit)->get();
        return [
            'code' => 20000,
            'data' => [
                'total' => 100,
                'items' => $navArr,
            ]];
    }


    public function add(Request $request) {
        $name = $request->input('name');
        $remark = $request->input('remark');
        $nav = Navigation::create([
            'name' => $name,
            'remark' => $remark
        ]);
        return [
            'code' => 20000
        ];
    }

}
