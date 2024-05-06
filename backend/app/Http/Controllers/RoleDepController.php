<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleDepController extends Controller
{
    public function addRoleDep(Request $request)
    {
        $validatedData = $request->validate([
            'role' => 'required|string',
            'user_id' => 'required',
            'department_id' => 'required',
        ]);

        try {
            $role = new Role();
            $role->user_id = $validatedData['user_id'];
            $role->department_id = $validatedData['department_id'];
            $role->role = $validatedData['role'];

            $role->save();

            return response()->json(['message' => 'Role added successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to add role'], 500);
        }
    }

    public function getRoleDep()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
