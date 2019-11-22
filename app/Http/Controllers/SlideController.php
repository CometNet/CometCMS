<?php


namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\SlideItem;
use Illuminate\Http\Request;


class SlideController extends Controller
{
    public function getAllList(){
        $list = Slide::select('id','name')->get();
        return [
            'code' => 20000,
            'data' => [
                'items' => $list
            ]
        ];
    }

    public function listClassify(Request $request) {
        $page = $request->input('page');
        $limit = $request->input('limit');
        $page = $page ? $page - 1 : 0;
        $limit = $limit ? $limit : 10;

        $navArr = Slide::offset($page)->limit($limit)->get();
        $total = Slide::count();

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
        $remark = $request->input('remark');
        $status = $request->input('status');

        $nav = Slide::create([
            'name' => $name,
            'remark' => $remark,
            'status' => $status
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
        $remark = $request->input('remark');
        $status = $request->input('status');

        $nav = Slide::find($id);
        $nav->name = $name;
        $nav->remark = $remark;
        $nav->status = $status;

        if($nav->save()){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $nav = Slide::find($id);
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
