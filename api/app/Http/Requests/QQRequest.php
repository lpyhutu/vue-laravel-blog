<?php

namespace App\Http\Requests;

use App\Http\Common\Code;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class QQRequest extends FormRequest
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
//            "qq" => "required|max:11",
        ];
    }

    public function messages()
    {
        return [
//            "qq.required" => Code::$QQ_FORMAT_ERR,
//            "qq.max" => Code::$QQ_FORMAT_ERR,
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json([
            "code" => $validator->errors()->first(),
        ])));
    }
}
