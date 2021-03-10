<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AdminUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "username" => "required|max:20",
            "password" => "required|max:20",
            "power" => "numeric",
            "created_at" => "numeric",
        ];
    }

    public function messages()
    {
        return [
            "username.required" => "账号参数不存在！",
            "username.max" => "账号参数过长！",
            "password.required" => "密码参数不存在！",
            "password.max" => "密码参数过长！",
            "power.numeric" => "级别参数格式错误！",
            "created_at.numeric" => "创建时间格式错误！",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json([
            "code" => 1003, "msg" => $validator->errors()->first(),
        ])));
    }
}
