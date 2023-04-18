<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ColumnPost extends FormRequest
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
            'name'          =>  'required|max:255',
            'show_app'      =>  'required',
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
            'name.required'        => '名称不能为空',
            'name.max'             => '名称过长',
            'show_app.required'    => '请至少选择一个平台',
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
