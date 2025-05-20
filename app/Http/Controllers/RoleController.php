<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('updated_at', 'desc')->get();

        return Inertia::render('roles/dashboard', [
            'roles' => $roles,
        ]);

    }

    public function create()
    {
        return Inertia::render('roles/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.dashboard')->with('success', 'Rol creado correctamente.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return Inertia::render('roles/edit', [
            'role' => $role,
        ]);
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->validate([
            'name' => 'required|string|max:255',
        ]));

        return redirect()->route('roles.dashboard')->with('success', 'Rol actualizado correctamente.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.dashboard')->with('success', 'Rol eliminado correctamente.');
    }

}
