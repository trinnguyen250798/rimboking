<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function index(): JsonResponse
    {
        $departments = Department::all();
        return response()->json([
            'status' => true,
            'data' => $departments,
        ], Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        $department = Department::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Tạo phòng ban thành công',
            'data' => $department,
        ], Response::HTTP_CREATED);
    }

    public function show(Department $department): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $department,
        ], Response::HTTP_OK);
    }

    public function update(Request $request, Department $department): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
        ]);

        $department->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật phòng ban thành công',
            'data' => $department,
        ], Response::HTTP_OK);
    }

    public function destroy(Department $department): JsonResponse
    {
        $department->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa phòng ban thành công',
        ], Response::HTTP_OK);
    }
}
