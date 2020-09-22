<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreAttribute extends FormRequest
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
            'attr_name' =>[
                'required',Rule::unique('attribute')->ignore(request()->attr_id,'attr_id')
            ],
            'cat_id' => 'required',
        ];
    }

    public function messages(){
        return [
            'attr_name.required' => '属性名称不能为空',
            'attr_name.unique' => '属性名称已存在',
            'cat_id.required' => '商品分类不能为空',
        ];
    }
}
