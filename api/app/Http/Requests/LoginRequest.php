<?php

namespace App\Http\Requests;

use App\Http\Common\Code;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
//            "username"=>"required|min:5|max:16",
//            "password"=>"required|min:6|max:20",
//            "captchaCode" => "required|min:4|max:4",
//            "captchaKey" => "required",
        ];
    }
    public function messages()
    {
        return [
//            "username.required"=>Code::$LOGIN_USERNAME_ERR,
//            "username.min"=>Code::$LOGIN_USERNAME_ERR,
//            "username.max"=>Code::$LOGIN_USERNAME_ERR,
//            "password.required"=>Code::$LOGIN_PASSWORD_ERR,
//            "password.min"=>Code::$LOGIN_PASSWORD_ERR,
//            "password.max"=>Code::$LOGIN_PASSWORD_ERR,
//            "captchaCode.required" =>Code::$LOGIN_CAPTCHA_ERR,
//            "captchaCode.min" =>Code::$LOGIN_CAPTCHA_ERR,
//            "captchaCode.max" =>Code::$LOGIN_CAPTCHA_ERR,
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw (new HttpResponseException(response()->json([
            "code"=> $validator->errors()->first(),
        ])));
    }
}
