<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ArticleRequest extends FormRequest
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
            "title" => "required|max:100",
            "author" => "required|max:30",
            "email" => "required|email",
            "type" => "required|numeric",
            "content" => "required",
            "release" => "numeric",
            "read_num" => "numeric",
            "thumb_num" => "numeric",
            "created_at" => "numeric",
            "sort" => "numeric|between:0,100",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "请输入标题！",
            "title.max" => "标题参数过长！",
            "author.required" => "请输入作者！",
            "author.max" => "作者参数过长！",
            "email.required" => "请输入邮箱！",
            "email.email" => "邮箱格式错误！",
            "type.required" => "请选择类别！",
            "type.numeric" => "类别参数格式错误！",
            "content.required" => "请输入内容！",
            "release.numeric" => "发布参数格式错误！",
            "read_num.numeric" => "阅读参数格式错误！",
            "thumb_num.numeric" => "点赞参数格式错误！",
            "sort.numeric" => "权重格式错误！",
            "sort.between" => "权重超出范围！",
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
