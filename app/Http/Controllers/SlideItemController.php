<?php


namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\SlideItem;
use Illuminate\Http\Request;
use App\Http\Requests\SlideItemRequest;


class SlideItemController extends Controller
{

    ### RESTFul start
    public function store(SlideItemRequest $request){

        $nav = SlideItem::create($request->all());

        return [
            'code' => 20000,
            'data' => $nav
        ];
    }

    public function update(SlideItemRequest $request)
    {
        $id = $request->input('id');

        $slide = SlideItem::find($id);

        if($slide->save($request->all())){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $slide = SlideItem::find($id);
        if($slide->delete()){
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


    public function list(Request $request) {
        $slide_id = $request->input('slide_id');
        $page = $request->input('page');
        $limit = $request->input('limit');
        $page = $page ? ($page - 1) * $limit : 0;
        $limit = $limit ? $limit : 10;

        if($slide_id > 0){
            $navArr = SlideItem::where(['slide_id' => $slide_id])->offset($page)->limit($limit)->get();
            $total = SlideItem::where(['slide_id' => $slide_id])->count();
        }else{
            $navArr = SlideItem::offset($page)->limit($limit)->get();
            $total = SlideItem::count();
        }
        return [
            'code' => 20000,
            'data' => [
                'total' => $total,
                'items' => $navArr,
            ]];
    }
}
