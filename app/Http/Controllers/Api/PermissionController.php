<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $response = $this->permissionRepository->all();
        return !$response['success'] ? 
            $this->sendError($response['message'], Response::HTTP_INTERNAL_SERVER_ERROR):
            $this->sendResponse($response['message'], [
                'permissions' => PermissionResource::collection($response['permissions'])
            ]);
    }

    /**
     * Create a new resource.
     */
    public function store(CreatePermissionRequest $request)
    {
        $response = $this->permissionRepository->createPermission($request);
        return !$response['success'] ?
            $this->sendError($response['message'], Response::HTTP_INTERNAL_SERVER_ERROR) :
            $this->sendResponse($response['message'], [
                'permission' => new PermissionResource($response['permission'])
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $response = $this -> permissionRepository -> destroyPermission($id);
        return !$response['success'] ?
            $this->sendError($response['message'], Response::HTTP_INTERNAL_SERVER_ERROR) : 
            $this->sendResponse($response['message']);
    }
}
