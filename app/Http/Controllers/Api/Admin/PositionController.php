<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class PositionController extends Controller
{
    public function index(): JsonResponse
    {
        $positions = Position::all('id','name','slug');
        return response()->json([
            'status' => true,
            'data' => $positions,
        ], Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $position = Position::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Tạo chức vụ thành công',
            'data' => $position,
        ], Response::HTTP_CREATED);
    }

    public function show(Position $position): JsonResponse
    {
        return response()->json([
            'status' => true,
            'data' => $position,
        ], Response::HTTP_OK);
    }

    public function update(Request $request, Position $position): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,' . $position->id,
        ]);

        $data['slug'] = Str::slug($data['name']);
        $position->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật chức vụ thành công',
            'data' => $position,
        ], Response::HTTP_OK);
    }

    public function destroy(Position $position): JsonResponse
    {
        $position->delete();

        return response()->json([
            'status' => true,
            'message' => 'Xóa chức vụ thành công',
        ], Response::HTTP_OK);
    }
}
