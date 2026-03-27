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
                'checkin_time' => 'nullable|date_format:H:i',
                'checkout_time' => 'nullable|date_format:H:i',
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
                'website' => 'nullable|url',
                'status' => 'nullable|integer|in:0,1',
                'subdomain' => 'nullable|string|max:255|unique:hotels,subdomain',

                'short_description' => 'nullable|string',
                'rating_avg' => 'nullable|numeric',
                'rating_count' => 'nullable|integer',
                'price_from' => 'nullable|integer',
                'price_to' => 'nullable|integer',
                'total_images' => 'nullable|integer',
                'is_refundable' => 'nullable|boolean',
                'is_free_cancellation' => 'nullable|boolean',
                'checkin_policy' => 'nullable|string',
                'checkout_policy' => 'nullable|string',
                'is_featured' => 'nullable|boolean',
                'is_top_deal' => 'nullable|boolean',
                'booking_count' => 'nullable|integer',
                'view_count' => 'nullable|integer',
                'type' => 'nullable|int',
                'languages' => 'nullable|array',
                'payment_options' => 'nullable|array',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'amenity_ids' => 'nullable|array',
                'amenity_ids.*' => 'integer|distinct|exists:amenities,id',
            ];

        case 'update':
            return [
                'name' => 'sometimes|string|max:255',
                'address' => 'sometimes|string',
                'province_code' => 'nullable|exists:provinces,code',
                'country_code' => 'nullable|exists:countries,code',
                'phone' => 'sometimes|string',
                'email' => 'sometimes|email',

                'short_description' => 'nullable|string',
                'price_from' => 'nullable|integer',
                'price_to' => 'nullable|integer',
                'total_images' => 'nullable|integer',
                'is_refundable' => 'nullable|boolean',
                'is_free_cancellation' => 'nullable|boolean',
                'checkin_policy' => 'nullable|string',
                'checkout_policy' => 'nullable|string',
                'is_featured' => 'nullable|boolean',
                'is_top_deal' => 'nullable|boolean',
                'booking_count' => 'nullable|integer',
                'view_count' => 'nullable|integer',
                'type' => 'nullable|string',
                'languages' => 'nullable|array',
                'payment_options' => 'nullable|array',
                'meta_title' => 'nullable|string',
                'meta_description' => 'nullable|string',
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
