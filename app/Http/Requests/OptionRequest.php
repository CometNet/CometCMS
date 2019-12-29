<?php


namespace App\Http\Requests;

class OptionRequest extends Request
{
    public function rules()
    {
        return [
            'option_name' => 'required|string|max:255',
            'option_value' => 'required|string|min:2',
        ];
    }

    public function attributes()
    {
        return [
            'option_value' => '配置值',
            'option_name' => '配置名称',
        ];
    }

    public function messages()
    {
        return [
            'option_name.unique' => '用户名已被占用，请重新填写',
            'option_name.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'option_name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'option_name.required' => '用户名不能为空。',
        ];
    }
}
