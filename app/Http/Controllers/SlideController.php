<?php


namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\SlideItem;
use Illuminate\Http\Request;
use App\Http\Requests\SlideRequest;


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
    public function store(SlideRequest $request){

        $nav = Slide::create($request->all());

        return [
            'code' => 20000,
            'data' => $nav
        ];
    }

    public function update(SlideRequest $request)
    {
        $id = $request->input('id');

        $nav = Slide::find($id);

        if($nav->save($request->all())){
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
