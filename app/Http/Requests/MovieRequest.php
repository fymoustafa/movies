<?php

namespace App\Http\Requests;

use App\Http\Resources\CategoryResource;
use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            $extra = [ 'name'=>'required|unique:movies,name'];
        }
        else {
            $extra = [ 'name'=>'required|unique:movies,id,'.$this->id];
        }

        $validation = [
            'description'=>'required',
            'image'=>'required|image',
            'rate'=>'required|integer|in:1,10',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id'
         ];

        return $validation+$extra; 
    }
}
