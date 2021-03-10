<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LinkRequest extends FormRequest
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
            "title" => "required|max:30",
            "site" => "required|max:70",
            "email" => "required|email",
            "created_at" => "numeric",
            "sort" => "numeric|between:0,127",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "站点名称为空！",
            "title.max" => "站点名称过长！",
            "site.required" => "站点地址为空！",
            "site.max" => "站点地址过长！",
            "email.required" => "邮箱不存在！",
            "email.email" => "邮箱格式错误！",
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
