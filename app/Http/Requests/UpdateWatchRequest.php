<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateWatchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /**
             * Nama model jam mewah.
             * @example Rolex Submariner Date
             */
            'nama' => ['sometimes', 'required', 'string', 'max:255'],

            /**
             * Brand atau produsen jam mewah.
             * @example Rolex
             */
            'brand' => ['sometimes', 'required', 'string', 'max:100'],

            /**
             * Harga jam mewah dalam Rupiah (IDR).
             * @example 265000000
             */
            'harga' => ['sometimes', 'required', 'integer', 'min:1'],

            /**
             * Tahun pembuatan atau rilis jam.
             * @example 2024
             */
            'tahun_rilis' => ['sometimes', 'required', 'integer', 'min:1800', 'max:' . (date('Y') + 1)],

            /**
             * Tipe pergerakan (movement) jam tangan.
             * @example Automatic
             */
            'tipe_gerakan' => ['sometimes', 'required', 'string', 'in:Automatic,Manual,Quartz'],

            /**
             * Material case dan strap jam tangan mewah.
             * @example Oystersteel
             */
            'material' => ['sometimes', 'required', 'string', 'max:100'],

            /**
             * Status ketersediaan jam tangan (tersedia / terjual).
             * @example terjual
             */
            'status' => ['sometimes', 'required', 'string', 'in:tersedia,terjual'],

            /**
             * URL tautan foto jam tangan mewah.
             * @example https://images.unsplash.com/photo-1523275335684-37898b6baf30
             */
            'foto' => ['sometimes', 'required', 'url', 'max:500'],
        ];
    }

    /**
     * Kustomisasi nama atribut untuk validasi.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nama' => 'nama jam tangan',
            'brand' => 'brand jam tangan',
            'harga' => 'harga jam tangan',
            'tahun_rilis' => 'tahun rilis',
            'tipe_gerakan' => 'tipe pergerakan',
            'material' => 'material jam tangan',
            'status' => 'status ketersediaan',
            'foto' => 'URL foto jam tangan',
        ];
    }

    /**
     * Pesan kesalahan validasi dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi jika disertakan.',
            'string' => ':attribute harus berupa teks.',
            'integer' => ':attribute harus berupa bilangan bulat.',
            'min' => ':attribute minimal bernilai :min.',
            'max' => ':attribute maksimal bernilai :max.',
            'in' => ':attribute harus bernilai salah satu dari: :values.',
            'url' => ':attribute harus berupa URL yang valid (contoh: https://...).',
        ];
    }

    /**
     * Tangani kegagalan validasi dengan format JSON standar amplop.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validasi gagal, silakan periksa data input Anda',
            'errors' => $validator->errors(),
        ], 422));
    }
}
