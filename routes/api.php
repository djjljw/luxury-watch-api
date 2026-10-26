<?php

use App\Http\Controllers\Api\WatchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - Luxury Watch Store (Koleksi Jam Mewah)
|--------------------------------------------------------------------------
|
| 1. GET       /api/jam-tangan       -> Mengambil seluruh daftar koleksi jam mewah (200 OK)
| 2. GET       /api/jam-tangan/{id}  -> Mengambil detail 1 jam mewah berdasarkan ID (200 OK)
| 3. POST      /api/jam-tangan       -> Menambahkan data jam mewah baru dengan validasi (201 Created)
| 4. PUT/PATCH /api/jam-tangan/{id}  -> Memperbarui data jam mewah yang tersimpan (200 OK)
| 5. DELETE    /api/jam-tangan/{id}  -> Menghapus data jam mewah dari basis data (200 OK)
|
*/

Route::apiResource('jam-tangan', WatchController::class)->parameters([
    'jam-tangan' => 'id',
]);
