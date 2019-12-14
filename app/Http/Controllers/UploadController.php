<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UploadController extends Controller
{
    public function uploadFile(Request $request) {
        $file = $request->file('file');
        $fileName = $this->upload($file);
        if ($fileName){
            return $fileName;
        }
        return '上传失败';
    }

    public function upload($file, $disk='public') {
        if (! $file->isValid()) {
            return false;
        }

        $fileExtension = $file->getClientOriginalExtension();
        if(! in_array($fileExtension, ['png', 'jpg', 'gif', 'jpeg'])) {
            return false;
        }

        $tmpFile = $file->getRealPath();
        if (filesize($tmpFile) >= 2048000) {
            return false;
        }

        if (! is_uploaded_file($tmpFile)) {
            return false;
        }

        $fileName = date('Y_m_d').'/'.md5(time()) .mt_rand(0,9999).'.'. $fileExtension;
        if (Storage::disk($disk)->put($fileName, file_get_contents($tmpFile)) ){
            return Storage::url($fileName);
        }
    }

}
