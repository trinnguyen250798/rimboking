<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class StaffController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $hotel = app('currentHotel');
        $staffs = Staff::with(['user', 'department', 'position'])
            ->where('hotel_id', $hotel->id)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $staffs,
        ], Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $hotel = app('currentHotel');
        $data = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'position_id'   => 'required|exists:positions,id',
        ]);

        $data['hotel_id'] = $hotel->id;
        $data['ulid'] = (string) Str::ulid();

        $staff = Staff::create($data);
        $staff->load(['user', 'department', 'position']);

        return response()->json([
            'status' => true,
            'message' => 'Thêm nhân viên thành công',
            'data' => $staff,
        ], Response::HTTP_CREATED);
    }

    public function show(Staff $staff): JsonResponse
    {
        $hotel = app('currentHotel');
        if ($staff->hotel_id !== $hotel->id) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy nhân viên trong khách sạn này'], 404);
        }

        $staff->load(['user', 'department', 'position', 'hotel']);

        return response()->json([
            'status' => true,
            'data' => $staff,
        ], Response::HTTP_OK);
    }

    public function update(Request $request, Staff $staff): JsonResponse
    {
        $hotel = app('currentHotel');
        if ($staff->hotel_id !== $hotel->id) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy nhân viên trong khách sạn này'], 404);
        }

        $data = $request->validate([
            'department_id' => 'sometimes|required|exists:departments,id',
            'position_id'   => 'sometimes|required|exists:positions,id',
        ]);

        $staff->update($data);
        $staff->load(['user', 'department', 'position']);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật nhân viên thành công',
            'data' => $staff,
        ], Response::HTTP_OK);
    }

    public function destroy(Staff $staff): JsonResponse
    {
        $hotel = app('currentHotel');
        if ($staff->hotel_id !== $hotel->id) {
            return response()->json(['status' => false, 'message' => 'Không tìm thấy nhân viên trong khách sạn này'], 404);
        }

        $staff->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa nhân viên thành công',
        ], Response::HTTP_OK);
    }
}
