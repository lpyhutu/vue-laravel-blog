<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MessageRequest extends FormRequest
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
            "qq" => "required|max:11",
            "name" => "required|max:20",
            "email" => "required|email",
            "avatar" => "required|max:100",
            "content" => "required|max:150",
            "thumb_num" => "numeric",
            "master" => "numeric",
            "created_at" => "numeric",
        ];
    }

    public function messages()
    {
        return [
            "qq.required" => "QQ为空！",
            "qq.max" => "QQ格式错误！",
            "name.required" => "昵称为空！",
            "name.max" => "昵称过长！",
            "email.required" => "邮箱为空！",
            "email.email" => "邮箱格式不正确！",
            "avatar.required" => "头像为空！",
            "avatar.max" => "头像参数过长！",
            "content.required" => "评论为空！",
            "content.max" => "评论过长！",
            "thumb_num.numeric" => "点赞参数格式错误！",
            "master.numeric" => "角色格式错误！",
            "created_at.numeric" => "创建时间参数格式错误！",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json([
            "code" => 1003, "msg" => $validator->errors()->first(),
        ])));
    }
}
