<?php


namespace App\Http\Requests;

class UserRequest extends Request
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'birthday' => 'required',
            'sex' => 'required|int',
            'account' => 'required|string|max:255',
            'status' => 'required',
//            'avatar' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'password' => '密码',
            'name' => '用户名',
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
