<?php

namespace App\Http\Requests;

use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AdminPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'          =>  ['bail','required','unique:App\Models\Center\Admin'],
            'password'      =>  ['bail','required',new Password]
        ];
    }

    /**
     * 获取已定义验证规则的错误消息
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required'         => '账号不能为空',
            'name.unique'           => '账号已存在',
            'password.required'     => '密码不能为空'
        ];
    }

    /**
     * 验证不通过返回信息
     *
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator) {
        $message = $validator->errors()->first();
        throw new BadRequestHttpException($message);
    }
}
