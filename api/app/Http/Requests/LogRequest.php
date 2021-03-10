<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LogRequest extends FormRequest
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
            "type" => "required|numeric",
            "version" => "required|max:10",
            "content" => "required",
            "created_at" => "numeric",
        ];
    }

    public function messages()
    {
        return [
            "type.required" => "日志类别为空！",
            "type.numeric" => "日志类别参数格式错误！",
            "version.required" => "版本号为空！",
            "version.max" => "版本号参数格式错误！",
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
