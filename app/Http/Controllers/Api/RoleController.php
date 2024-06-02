<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json(['roles' => $roles], 200);
    }

    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }
        return response()->json(['role' => $role], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'type' => 'nullable|in:'.implode(',', array_values(Role::TYPES)),
        ]);

        $role = Role::create([
            'name' => $request->name,
            'type' => $request->type ?? Role::TYPES['DEFAULT'],
        ]);

        return response()->json(['message' => 'Role created successfully', 'role' => $role], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => [
                'required',
                Role::unique('roles')->ignore($id),
            ],
            'type' => 'nullable|in:'.implode(',', array_values(Role::TYPES)),
        ]);

        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->name = $request->name;
        $role->type = $request->type ?? Role::TYPES['DEFAULT'];
        $role->save();

        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 200);
    }

    public function destroy($id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}
