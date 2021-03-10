<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TypeRequest extends FormRequest
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
            "title" => "required|max:20",
            "created_at" => "numeric",
            "sort" => "numeric|between:0,100",
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "标题为空！",
            "title.max" => "标题过长！",
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
