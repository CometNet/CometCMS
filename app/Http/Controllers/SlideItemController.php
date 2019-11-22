<?php


namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\SlideItem;
use Illuminate\Http\Request;


class SlideItemController extends Controller
{

    ### RESTFul start
    public function store(Request $request){
        $slide_id = $request->input('slide_id');
        $title = $request->input('title');
        $description = $request->input('description');
        $content = $request->input('content');
        $image = $request->input('image');
        $status = $request->input('status');
        $list_order = $request->input('list_order');
        $url = $request->input('url');

        $nav = SlideItem::create([
            'slide_id' => $slide_id,
            'title' => $title,
            'description' => $description,
            'content' => $content,
            'image' => $image,
            'status' => $status,
            'list_order' => $list_order,
            'url' => $url,
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
        $slide_id = $request->input('slide_id');
        $title = $request->input('title');
        $description = $request->input('description');
        $content = $request->input('content');
        $image = $request->input('image');
        $status = $request->input('status');
        $list_order = $request->input('list_order');
        $url = $request->input('url');

        $nav = SlideItem::find($id);
        $nav->slide_id = $slide_id;
        $nav->title = $title;
        $nav->status = $status;
        $nav->description = $description;
        $nav->content = $content;
        $nav->image = $image;
        $nav->status = $status;
        $nav->url = $url;
        $nav->list_order = $list_order;

        if($nav->save()){
            return ['code' => 20000];
        }else{
            return ['code' => 20001,'message' => '编辑失败'];
        }
    }

    public function destroy($id)
    {
        $nav = SlideItem::find($id);
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
