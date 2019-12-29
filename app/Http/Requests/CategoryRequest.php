<?php


namespace App\Http\Requests;

class CategoryRequest extends Request
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'keywords' => 'required|string|min:2',
            'description' => 'required',
            'status' => 'required|int',
        ];
    }

    public function attributes()
    {
        return [
            'keywords' => '关键字',
            'title' => '用户名',
        ];
    }

    public function messages()
    {
        return [
            'title.unique' => '用户名已被占用，请重新填写',
            'title.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'title.between' => '用户名必须介于 3 - 25 个字符之间。',
            'title.required' => '用户名不能为空。',
        ];
    }
}
