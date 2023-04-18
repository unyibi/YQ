<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UploadPost extends FormRequest
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
            'file'          =>  'required',
            'uuid'          =>  'required',
            'block_id'      =>  'integer',
            'block_tot'     =>  'integer',
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
            'file.required'         => '请选择需要上传的文件',
            'uuid.required'         => '唯一标识不能为空',
            'block_id.integer'      => '分块id类型错误',
            'block_tot.integer'     => '分块总数类型错误',
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
