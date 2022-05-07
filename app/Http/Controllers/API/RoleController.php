<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\ResponseController as ResponseController;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends ResponseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index (Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $roles = Role::with(['permissions', 'permissions.menus'])->get();

            return response()->json([
                'data' => $roles,
                'message' => 'Roles listados con exito'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado',
                'error' => $throwable->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store (Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'required',
            'description' => 'nullable'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        try {
            $role = Role::query()->create($request->all());

            Permission::query()->where('role_id', $role->id)->delete();

            foreach ($request->input('permissions') as $permission) {
                $assign_permission = implode(' ', $permission['permission']);

                if (Str::contains($assign_permission, 'view') && Str::contains($assign_permission, 'edit') && Str::contains($assign_permission, 'create')) {
                    $assign_permission = "all";
                } else if (Str::contains($assign_permission, 'view') && Str::contains($assign_permission, 'edit')) {
                    $assign_permission = "view-edit";
                } else if (Str::contains($assign_permission, 'view') && Str::contains($assign_permission, 'create')) {
                    $assign_permission = "view-create";
                }

                if (count($permission['permission']) > 0) {
                    $permissionNew = Permission::query()->create([
                        'role_id' => $role->id,
                        'menu_id' => $permission['menu_id'],
                        'permission' => $assign_permission
                    ]);
                }
            }

            return response()->json([
                'data' => [
                    'rol' => $role,
                    'permissions' => $role->permissions
                ],
                'message' => 'Roles creado con exito'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado',
                'error' => $throwable->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update (Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|unique:roles,name,' . $request->id . ',id'
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());
        }

        try {
            $role = Role::query()->find($request->id);

            if (!$role) {
                return response()->json('Rol no encontrado', 404);
            }

            $role->update($request->all());

            Permission::query()->where('role_id', $role->id)->delete();
            foreach ($request->input('permissions') as $permission) {
                $assign_permission = implode(' ', $permission['permission']);

                if (Str::contains($assign_permission, 'view') && Str::contains($assign_permission, 'edit') && Str::contains($assign_permission, 'create')) {
                    $assign_permission = "all";
                } else if (Str::contains($assign_permission, 'view') && Str::contains($assign_permission, 'edit')) {
                    $assign_permission = "view-edit";
                } else if (Str::contains($assign_permission, 'view') && Str::contains($assign_permission, 'create')) {
                    $assign_permission = "view-create";
                }

                if (count($permission['permission']) > 0) {
                    $permissionNew = Permission::query()->create([
                        'role_id' => $role->id,
                        'menu_id' => $permission['menu_id'],
                        'permission' => $assign_permission
                    ]);
                }
            }

            return response()->json([
                'data' => [
                    'rol' => $role,
                    'permissions' => $role->permissions
                ],
                'message' => 'Role actualizado con exito'
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado',
                'error' => $throwable->getMessage()
            ]);
        }
    }
}
