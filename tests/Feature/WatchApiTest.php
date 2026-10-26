<?php

namespace Tests\Feature;

use App\Models\Watch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WatchApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test GET /api/jam-tangan mengambil seluruh daftar koleksi jam mewah.
     */
    public function test_can_list_all_watches(): void
    {
        Watch::factory()->count(3)->create();

        $response = $this->getJson('/api/jam-tangan');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'nama',
                        'brand',
                        'harga',
                        'tahun_rilis',
                        'tipe_gerakan',
                        'material',
                        'status',
                        'foto',
                    ],
                ],
            ])
            ->assertJson([
                'message' => 'Daftar koleksi jam mewah berhasil diambil',
            ]);

        $this->assertCount(3, $response->json('data'));
    }

    /**
     * Test GET /api/jam-tangan/{id} berhasil mengambil detail 1 jam mewah.
     */
    public function test_can_get_watch_detail(): void
    {
        $watch = Watch::create([
            'nama' => 'Rolex Submariner Date',
            'brand' => 'Rolex',
            'harga' => 250000000,
            'tahun_rilis' => 2023,
            'tipe_gerakan' => 'Automatic',
            'material' => 'Oystersteel',
            'status' => 'tersedia',
            'foto' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
        ]);

        $response = $this->getJson("/api/jam-tangan/{$watch->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Detail jam mewah berhasil diambil',
                'data' => [
                    'id' => $watch->id,
                    'nama' => 'Rolex Submariner Date',
                    'brand' => 'Rolex',
                    'harga' => 250000000,
                    'tahun_rilis' => 2023,
                    'tipe_gerakan' => 'Automatic',
                    'material' => 'Oystersteel',
                    'status' => 'tersedia',
                    'foto' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
                ],
            ]);
    }

    /**
     * Test GET /api/jam-tangan/{id} mengembalikan 404 bila ID tidak ditemukan.
     */
    public function test_get_non_existent_watch_returns_404(): void
    {
        $response = $this->getJson('/api/jam-tangan/99999');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Data jam mewah tidak ditemukan',
                'data' => null,
            ]);
    }

    /**
     * Test POST /api/jam-tangan berhasil menambahkan data jam mewah baru (201 Created).
     */
    public function test_can_create_new_watch(): void
    {
        $payload = [
            'nama' => 'Patek Philippe Nautilus 5711/1R',
            'brand' => 'Patek Philippe',
            'harga' => 1850000000,
            'tahun_rilis' => 2022,
            'tipe_gerakan' => 'Automatic',
            'material' => 'Rose Gold 18k',
            'status' => 'tersedia',
            'foto' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9',
        ];

        $response = $this->postJson('/api/jam-tangan', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Data jam mewah berhasil ditambahkan',
                'data' => [
                    'nama' => 'Patek Philippe Nautilus 5711/1R',
                    'brand' => 'Patek Philippe',
                    'harga' => 1850000000,
                    'tahun_rilis' => 2022,
                    'tipe_gerakan' => 'Automatic',
                    'material' => 'Rose Gold 18k',
                    'status' => 'tersedia',
                ],
            ]);

        $this->assertDatabaseHas('koleksi_jam', [
            'nama' => 'Patek Philippe Nautilus 5711/1R',
            'brand' => 'Patek Philippe',
            'harga' => 1850000000,
        ]);
    }

    /**
     * Test POST /api/jam-tangan gagal validasi ketika data kosong (422 Unprocessable Content).
     */
    public function test_create_watch_fails_validation(): void
    {
        $response = $this->postJson('/api/jam-tangan', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'nama',
                'brand',
                'harga',
                'tahun_rilis',
                'tipe_gerakan',
                'material',
                'status',
                'foto',
            ]);
    }

    /**
     * Test PUT/PATCH /api/jam-tangan/{id} berhasil memperbarui data jam mewah (200 OK).
     */
    public function test_can_update_watch(): void
    {
        $watch = Watch::create([
            'nama' => 'Rolex Submariner Date',
            'brand' => 'Rolex',
            'harga' => 250000000,
            'tahun_rilis' => 2023,
            'tipe_gerakan' => 'Automatic',
            'material' => 'Oystersteel',
            'status' => 'tersedia',
            'foto' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
        ]);

        $updatePayload = [
            'harga' => 265000000,
            'status' => 'terjual',
        ];

        $response = $this->putJson("/api/jam-tangan/{$watch->id}", $updatePayload);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Data jam mewah berhasil diperbarui',
                'data' => [
                    'id' => $watch->id,
                    'nama' => 'Rolex Submariner Date',
                    'harga' => 265000000,
                    'status' => 'terjual',
                ],
            ]);

        $this->assertDatabaseHas('koleksi_jam', [
            'id' => $watch->id,
            'harga' => 265000000,
            'status' => 'terjual',
        ]);
    }

    /**
     * Test PUT /api/jam-tangan/{id} mengembalikan 404 jika ID tidak ditemukan.
     */
    public function test_update_non_existent_watch_returns_404(): void
    {
        $response = $this->putJson('/api/jam-tangan/99999', [
            'harga' => 200000000,
        ]);

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Data jam mewah tidak ditemukan',
                'data' => null,
            ]);
    }

    /**
     * Test DELETE /api/jam-tangan/{id} berhasil menghapus jam mewah (200 OK).
     */
    public function test_can_delete_watch(): void
    {
        $watch = Watch::create([
            'nama' => 'Cartier Santos',
            'brand' => 'Cartier',
            'harga' => 140000000,
            'tahun_rilis' => 2022,
            'tipe_gerakan' => 'Automatic',
            'material' => 'Steel',
            'status' => 'tersedia',
            'foto' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa',
        ]);

        $response = $this->deleteJson("/api/jam-tangan/{$watch->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Data jam mewah berhasil dihapus',
                'data' => null,
            ]);

        $this->assertDatabaseMissing('koleksi_jam', [
            'id' => $watch->id,
        ]);
    }

    /**
     * Test DELETE /api/jam-tangan/{id} mengembalikan 404 jika ID tidak ditemukan.
     */
    public function test_delete_non_existent_watch_returns_404(): void
    {
        $response = $this->deleteJson('/api/jam-tangan/99999');

        $response->assertStatus(404)
            ->assertJson([
                'message' => 'Data jam mewah tidak ditemukan',
                'data' => null,
            ]);
    }

    /**
     * Test endpoint dokumentasi interaktif Scramble di /docs/api dapat diakses.
     */
    public function test_scramble_docs_accessible(): void
    {
        $response = $this->get('/docs/api');

        $response->assertStatus(200);
    }
}
