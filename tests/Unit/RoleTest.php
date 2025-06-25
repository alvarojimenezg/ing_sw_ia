<?php

use App\Models\Role;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

it('puede crear rol', function(){
    $role = Role::create(['name' => 'Editor']);
    expect($role->name)->toBe('Editor');
    expect(Role::where('name', 'Editor')->exists())->toBeTrue();
});

it('puede editar nombre de un rol existente', function(){
    $role = Role::create(['name' => 'Test']);
    $role->update(['name' => 'actualizado']);
    expect($role->fresh()->name)->toBe('actualizado');
});

it('puede eliminar un rol si no tiene usuarios asignados', function () {
    $role = Role::create(['name' => 'SinUsuarios']);
    $role->delete();
    expect(Role::where('name', 'SinUsuarios')->exists())->toBeFalse();
});

it('no puede eliminar un rol si tiene usuarios asignados', function () {
    $role = Role::create(['name' => 'ConUsuarios']);
    $user = User::factory()->create(['role_id' => $role->id]);
    $deleted = false;
    try {
        $role->delete();
    } catch (\Exception $e) {
        $deleted = true;
    }
    expect(Role::where('name', 'ConUsuarios')->exists())->toBeTrue();
});

it('muestra un listado de todos los roles existentes', function () {
    Role::create(['name' => 'Admin']);
    Role::create(['name' => 'User']);
    $roles = Role::all()->pluck('name')->toArray();
    expect($roles)->toContain('Admin')->toContain('User');
});