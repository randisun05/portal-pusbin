<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index', [
            'title' => 'Role & Permission',
            'roles' => Role::withCount('users')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('admin.role.edit', [
            'title' => 'Role & Permission',
            'role' => $role,
            'permissionGroups' => Permission::definitions(),
            'currentPermissionIds' => $role->permissions->pluck('id')->all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if ($role->name === Role::SUPER_ADMIN) {
            return back()->with('error', 'Permission Super Admin tidak dapat diubah karena selalu memiliki akses penuh.');
        }

        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($request->input('permissions', []));

        return redirect('/admin/role')->with('success', 'Permission Role ' . $role->label . ' Berhasil Diupdate');
    }
}
