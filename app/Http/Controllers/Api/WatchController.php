<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWatchRequest;
use App\Http\Requests\UpdateWatchRequest;
use App\Http\Resources\WatchResource;
use App\Models\Watch;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * @tags Koleksi Jam Mewah
 */
class WatchController extends Controller
{
    /**
     * Mengambil Seluruh Koleksi Jam Mewah
     *
     * Endpoint untuk mendapatkan daftar seluruh koleksi jam tangan mewah yang tersedia di katalog.
     * Mendukung filter opsional berdasarkan brand, tipe_gerakan, status, dan pencarian kata kunci.
     *
     * @response 200 {
     *   "message": "Daftar koleksi jam mewah berhasil diambil",
     *   "data": [
     *     {
     *       "id": 1,
     *       "nama": "Rolex Submariner Date",
     *       "brand": "Rolex",
     *       "harga": 250000000,
     *       "tahun_rilis": 2023,
     *       "tipe_gerakan": "Automatic",
     *       "material": "Oystersteel",
     *       "status": "tersedia",
     *       "foto": "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
     *     }
     *   ]
     * }
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Watch::query();

        if ($request->filled('brand')) {
            $query->where('brand', $request->query('brand'));
        }

        if ($request->filled('tipe_gerakan')) {
            $query->where('tipe_gerakan', $request->query('tipe_gerakan'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        if ($request->filled('search')) {
            $search = $request->query('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('material', 'like', "%{$search}%");
            });
        }

        $watches = $query->orderBy('id', 'desc')->get();

        return WatchResource::collectionWithMessage(
            $watches,
            'Daftar koleksi jam mewah berhasil diambil'
        );
    }

    /**
     * Menambahkan Jam Mewah Baru
     *
     * Menambahkan data jam tangan mewah baru ke dalam katalog setelah lolos validasi request yang ketat.
     *
     * @response 201 {
     *   "message": "Data jam mewah berhasil ditambahkan",
     *   "data": {
     *     "id": 1,
     *     "nama": "Rolex Submariner Date",
     *     "brand": "Rolex",
     *     "harga": 250000000,
     *     "tahun_rilis": 2023,
     *     "tipe_gerakan": "Automatic",
     *     "material": "Oystersteel",
     *     "status": "tersedia",
     *     "foto": "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
     *   }
     * }
     * @response 422 {
     *   "message": "Validasi gagal, silakan periksa data input Anda",
     *   "errors": {
     *     "nama": ["nama jam tangan wajib diisi."]
     *   }
     * }
     */
    public function store(StoreWatchRequest $request): JsonResponse
    {
        $watch = Watch::create($request->validated());

        return (new WatchResource($watch, 'Data jam mewah berhasil ditambahkan'))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Mengambil Detail Jam Mewah
     *
     * Mendapatkan informasi lengkap satu item jam tangan mewah berdasarkan ID uniknya.
     *
     * @param string|int $id ID jam tangan mewah
     * @response 200 {
     *   "message": "Detail jam mewah berhasil diambil",
     *   "data": {
     *     "id": 1,
     *     "nama": "Rolex Submariner Date",
     *     "brand": "Rolex",
     *     "harga": 250000000,
     *     "tahun_rilis": 2023,
     *     "tipe_gerakan": "Automatic",
     *     "material": "Oystersteel",
     *     "status": "tersedia",
     *     "foto": "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
     *   }
     * }
     * @response 404 {
     *   "message": "Data jam mewah tidak ditemukan",
     *   "data": null
     * }
     */
    public function show(string|int $id): JsonResponse|WatchResource
    {
        $watch = Watch::find($id);

        if (!$watch) {
            return response()->json([
                'message' => 'Data jam mewah tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return new WatchResource($watch, 'Detail jam mewah berhasil diambil');
    }

    /**
     * Memperbarui Data Jam Mewah
     *
     * Memperbarui informasi atribut jam tangan mewah yang telah tersimpan di basis data (mendukung PUT maupun PATCH).
     *
     * @param UpdateWatchRequest $request
     * @param string|int $id ID jam tangan mewah
     * @response 200 {
     *   "message": "Data jam mewah berhasil diperbarui",
     *   "data": {
     *     "id": 1,
     *     "nama": "Rolex Submariner Date",
     *     "brand": "Rolex",
     *     "harga": 265000000,
     *     "tahun_rilis": 2023,
     *     "tipe_gerakan": "Automatic",
     *     "material": "Oystersteel",
     *     "status": "terjual",
     *     "foto": "https://images.unsplash.com/photo-1523275335684-37898b6baf30"
     *   }
     * }
     * @response 404 {
     *   "message": "Data jam mewah tidak ditemukan",
     *   "data": null
     * }
     */
    public function update(UpdateWatchRequest $request, string|int $id): JsonResponse|WatchResource
    {
        $watch = Watch::find($id);

        if (!$watch) {
            return response()->json([
                'message' => 'Data jam mewah tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $watch->update($request->validated());

        return new WatchResource($watch, 'Data jam mewah berhasil diperbarui');
    }

    /**
     * Menghapus Data Jam Mewah
     *
     * Menghapus data jam tangan mewah dari katalog basis data secara permanen berdasarkan ID.
     *
     * @param string|int $id ID jam tangan mewah
     * @response 200 {
     *   "message": "Data jam mewah berhasil dihapus",
     *   "data": null
     * }
     * @response 404 {
     *   "message": "Data jam mewah tidak ditemukan",
     *   "data": null
     * }
     */
    public function destroy(string|int $id): JsonResponse
    {
        $watch = Watch::find($id);

        if (!$watch) {
            return response()->json([
                'message' => 'Data jam mewah tidak ditemukan',
                'data' => null,
            ], 404);
        }

        $watch->delete();

        return response()->json([
            'message' => 'Data jam mewah berhasil dihapus',
            'data' => null,
        ], 200);
    }
}
