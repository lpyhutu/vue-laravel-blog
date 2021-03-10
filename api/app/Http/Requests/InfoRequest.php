<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class InfoRequest extends FormRequest
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
            "english" => "required|max:200",
            "copyright" => "required|max:70",
            "email" => "required|email",
            "content" => "required",
            "record" => "required|max:20",
            "record_link" => "required|max:30",
            "created_at" => "numeric",
            "sort" => "numeric|between:0,127",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "标题为空！",
            "title.max" => "标题过长！",
            "english.required" => "翻译为空！",
            "english.max" => "翻译过长！",
            "copyright.required" => "版权信息为空！",
            "copyright.max" => "版权信息过长！",
            "record.required" => "备案信息为空！",
            "record.max" => "备案信息过长！",
            "record_link.required" => "备案链接为空！",
            "record_link.max" => "备案链接过长！",
            "email.required" => "邮箱不存在！",
            "email.email" => "邮箱格式错误！",
            "content.required" => "简介为空！",
            "created_at.numeric" => "创建时间格式错误！",
            "sort.numeric" => "权重格式错误！",
            "sort.between" => "权重超出范围！",
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json([
            "code" => 1003, "msg" => $validator->errors()->first(),
        ])));
    }
}
