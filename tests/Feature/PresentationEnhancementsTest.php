<?php

use App\Models\Member;
use App\Models\User;

it('shows a dashboard summary for the authenticated user', function () {
    $user = User::factory()->create();
    Member::factory()->count(3)->create();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Member Dashboard')
        ->assertSee('Members');
});

it('allows an authenticated user to export members as csv', function () {
    $user = User::factory()->create();
    Member::factory()->count(2)->create();

    $this->actingAs($user)
        ->get('/members/export')
        ->assertOk()
        ->assertHeader('content-type', 'text/csv; charset=UTF-8');
});
