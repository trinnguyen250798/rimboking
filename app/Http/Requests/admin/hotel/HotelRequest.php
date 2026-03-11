<?php
    
namespace App\Http\Requests;

class HotelRequest extends BaseApiRequest
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
        switch ($this->route()->getActionMethod()) {
        case 'index':
            return [
                'owner_id' => 'required|exists:users,id',
            ];
        case 'store':
            return [
                'name' => 'required|string',
                'city' => 'required|string'
            ];

        case 'update':
            return [
                'name' => 'sometimes|string',
                'city' => 'sometimes|string'
            ];

        case 'index':   
            return [
                'city' => 'nullable|string'
            ];
        }   
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên khách sạn không được để trống',
            'city.required' => 'Thành phố không được để trống',
            'owner_id.required' => 'Chủ sở hữu không được để trống',
            'owner_id.exists' => 'Chủ sở hữu không tồn tại',
        ];
    }
}
