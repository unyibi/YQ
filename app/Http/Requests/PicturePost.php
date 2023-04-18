<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PicturePost extends FormRequest
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
            'column_uuid'   =>  'required',
            'title'         =>  'required|max:255',
            'show_app'      =>  'required',
            'release_time'  =>  'required',
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
            'column_uuid.required'  => '请选择栏目',
            'title.required'        => '标题不能为空',
            'title.max'             => '标题过长',
            'show_app.required'     => '请至少选择一个平台',
            'release_time.required' => '发布时间不能为空',
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
