<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_login_page_is_available(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
    }

    public function test_about_page_is_available_for_authenticated_user(): void
    {
        $user = \App\Models\User::factory()->create([
            'role_id' => \App\Models\Role::firstOrCreate(['name' => 'admin'])->id,
        ]);

        $this->actingAs($user)
            ->get('/about')
            ->assertOk()
            ->assertSee('Tentang Perusahaan')
            ->assertSee('POS Rizal');
    }

    public function test_product_page_handles_string_error_flash_without_crashing(): void
    {
        $user = \App\Models\User::factory()->create([
            'role_id' => \App\Models\Role::firstOrCreate(['name' => 'admin'])->id,
        ]);

        $this->actingAs($user)
            ->withSession(['errors' => 'Keranjang masih kosong.'])
            ->get('/produk')
            ->assertOk();
    }
}
