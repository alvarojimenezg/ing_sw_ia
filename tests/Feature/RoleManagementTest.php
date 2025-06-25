<?php

use App\Models\User;

it('solo los administradores pueden acceder a la gestión de roles', function () {
    $admin = User::factory()->create(['role_id' => 1]);
    $user = User::factory()->create(['role_id' => 2]); 

    actingAs($admin)
        ->get('/roles')
        ->assertStatus(200);

    actingAs($user)
        ->get('/roles')
        ->assertStatus(403);
});