<?php
    
namespace App\Http\Requests\admin\hotel;

use App\Http\Requests\BaseApiRequest;

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
            return [ ];
        case 'store':
            return [
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'province_code' => 'required|string|exists:provinces,code',
                'district_code' => 'nullable|string|exists:districts,code',
                'country_code' => 'required|string|exists:countries,code',  
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'star_rating' => 'nullable|integer|min:0|max:5',
                'checkin_time' => 'nullable|date_format:H:i:s',
                'checkout_time' => 'nullable|date_format:H:i:s',
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
                'website' => 'nullable|url',
                'status' => 'nullable|integer|in:0,1',
                'subdomain' => 'nullable|string|max:255|unique:hotels,subdomain'
            ];

        case 'update':
            return [
                'name' => 'sometimes|string|max:255',
                'address' => 'sometimes|string',
                'province_code' => 'nullable|exists:provinces,code',
                'country_code' => 'nullable|exists:countries,code',  
                'phone' => 'sometimes|string',
                'email' => 'sometimes|email'
            ];
        case 'upload_thumbnail':    
            return [
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096'
        ];

       default:
            return [];
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
