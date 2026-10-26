<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Resource untuk serialisasi data koleksi jam mewah.
 *
 * @mixin \App\Models\Watch
 */
class WatchResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'data';

    /**
     * Inisialisasi resource dengan pesan kustom opsional.
     *
     * @param mixed $resource
     * @param string|null $message
     */
    public function __construct($resource, ?string $message = null)
    {
        parent::__construct($resource);

        if ($message !== null) {
            $this->additional(['message' => $message]);
        }
    }

    /**
     * Membuat AnonymousResourceCollection dengan bungkus pesan (envelope).
     *
     * @param mixed $resource
     * @param string $message
     * @return AnonymousResourceCollection
     */
    public static function collectionWithMessage($resource, string $message): AnonymousResourceCollection
    {
        return self::collection($resource)->additional(['message' => $message]);
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'brand' => $this->brand,
            'harga' => (int) $this->harga,
            'tahun_rilis' => (int) $this->tahun_rilis,
            'tipe_gerakan' => $this->tipe_gerakan,
            'material' => $this->material,
            'status' => $this->status,
            'foto' => $this->foto,
        ];
    }
}
