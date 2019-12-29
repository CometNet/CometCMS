<?php


namespace App\Http\Requests;

class NavigationRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'remark' => 'required|string|min:2',
        ];
    }

    public function attributes()
    {
        return [
            'remark' => '描述',
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
