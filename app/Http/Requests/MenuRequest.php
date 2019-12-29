<?php


namespace App\Http\Requests;

class MenuRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'href' => 'required|string|min:2',
        ];
    }

    public function attributes()
    {
        return [
            'href' => '连接',
            'name' => '名称',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
        ];
    }
}
