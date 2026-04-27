<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * GeminiService — jembatan utama ke Gemini API.
 * Menangani validasi foto kerusakan jalan dan penentuan prioritas SLA.
 */
class GeminiService
{
    private ?string $kunciApi;
    private string $namaModel;
    private ?string $urlDasar;
    private bool $aktif;

    public function __construct()
    {
        $this->kunciApi  = config('services.gemini.api_key') ?: null;
        $this->namaModel = config('services.gemini.model', 'gemini-1.5-flash');
        $this->urlDasar  = config('services.gemini.base_url') ?: null;
        $this->aktif     = !empty($this->kunciApi) && !empty($this->urlDasar);
    }

    /**
     * Validasi apakah foto yang diunggah benar-benar menampilkan kerusakan jalan.
     * Mengembalikan array berisi: valid (bool), alasan (string), skor_keyakinan (float).
     */
    public function validasiFotoKerusakan(string $base64Gambar, string $tipeMedia = 'image/jpeg'): array
    {
        // Fallback jika API key belum dikonfigurasi
        if (!$this->aktif) {
            return [
                'valid'           => true,
                'skor_keyakinan'  => 1.0,
                'alasan'          => 'Validasi AI tidak aktif — foto diterima otomatis.',
                'jenis_kerusakan' => 'tidak_diketahui',
            ];
        }

        $prompt = <<<PROMPT
Kamu adalah sistem validasi foto kerusakan infrastruktur jalan di Indonesia.

Analisis foto ini dan tentukan:
1. Apakah foto ini menampilkan kerusakan jalan yang nyata? (lubang, retak, amblas, dll.)
2. Seberapa yakin kamu? (0.0 - 1.0)
3. Alasan singkat dalam Bahasa Indonesia.

Berikan respons HANYA dalam format JSON berikut, tanpa teks tambahan:
{
  "valid": true/false,
  "skor_keyakinan": 0.85,
  "alasan": "Terlihat lubang jalan berdiameter ±40cm di permukaan aspal",
  "jenis_kerusakan": "lubang/retak/amblas/lainnya/bukan_kerusakan"
}
PROMPT;

        try {
            $respons = $this->buatPermintaan()->post($this->buatUrl('generateContent'), [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $tipeMedia,
                                    'data'      => $base64Gambar,
                                ],
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature'     => 0.1,
                    'maxOutputTokens' => 256,
                ],
            ]);

            return $this->uraiResponsJson($respons, [
                'valid'            => false,
                'skor_keyakinan'   => 0.0,
                'alasan'           => 'Gagal memvalidasi gambar.',
                'jenis_kerusakan'  => 'tidak_diketahui',
            ]);
        } catch (\Throwable $e) {
            Log::error('[GeminiService] Validasi gagal: ' . $e->getMessage());
            return [
                'valid'           => true,
                'skor_keyakinan'  => 1.0,
                'alasan'          => 'Sistem AI tidak tersedia — foto diterima otomatis.',
                'jenis_kerusakan' => 'tidak_diketahui',
            ];
        }
    }

    /**
     * Tentukan prioritas SLA berdasarkan foto + deskripsi laporan.
     * Mengembalikan: prioritas (tinggi/sedang/rendah), skor, estimasi_hari, catatan.
     */
    public function tentukanPrioritasSLA(
        string $base64Gambar,
        string $deskripsi,
        string $tipeMedia = 'image/jpeg'
    ): array {
        // Fallback jika API key belum dikonfigurasi
        if (!$this->aktif) {
            return [
                'prioritas'      => 'sedang',
                'skor_keparahan' => 50,
                'estimasi_hari'  => 7,
                'catatan_ai'     => 'Penilaian AI tidak aktif — prioritas diatur ke sedang secara otomatis.',
            ];
        }

        $prompt = <<<PROMPT
Kamu adalah sistem penilaian prioritas kerusakan jalan untuk pemerintah daerah Indonesia.

Deskripsi dari pelapor: "{$deskripsi}"

Analisis foto kerusakan ini dan tentukan:
1. Tingkat prioritas penanganan (tinggi/sedang/rendah)
2. Skor keparahan (0-100)
3. Estimasi hari penanganan ideal
4. Catatan teknis singkat dalam Bahasa Indonesia

Kriteria prioritas:
- TINGGI: Berbahaya/membahayakan nyawa, lubang dalam >10cm, jalan utama, risiko kecelakaan
- SEDANG: Mengganggu kelancaran lalu lintas, retak signifikan, jalan kolektor
- RENDAH: Kerusakan ringan, estetika, jalan lokal/gang

Berikan respons HANYA dalam format JSON ini, tanpa teks tambahan:
{
  "prioritas": "tinggi/sedang/rendah",
  "skor_keparahan": 75,
  "estimasi_hari": 3,
  "catatan_ai": "Lubang dalam pada jalur cepat, risiko tinggi bagi pengendara motor"
}
PROMPT;

        try {
            $respons = $this->buatPermintaan()->post($this->buatUrl('generateContent'), [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $tipeMedia,
                                    'data'      => $base64Gambar,
                                ],
                            ],
                        ],
                    ],
                ],
                'generationConfig' => [
                    'temperature'     => 0.2,
                    'maxOutputTokens' => 256,
                ],
            ]);

            return $this->uraiResponsJson($respons, [
                'prioritas'      => 'sedang',
                'skor_keparahan' => 50,
                'estimasi_hari'  => 7,
                'catatan_ai'     => 'Tidak dapat dinilai, gunakan penilaian manual.',
            ]);
        } catch (\Throwable $e) {
            Log::error('[GeminiService] Prioritas SLA gagal: ' . $e->getMessage());
            return [
                'prioritas'      => 'sedang',
                'skor_keparahan' => 50,
                'estimasi_hari'  => 7,
                'catatan_ai'     => 'Sistem AI tidak tersedia — prioritas diatur ke sedang.',
            ];
        }
    }

    // ────────────── PRIVATE HELPERS ──────────────

    private function buatPermintaan(): PendingRequest
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(30);
    }

    private function buatUrl(string $method): string
    {
        return "{$this->urlDasar}/models/{$this->namaModel}:{$method}?key={$this->kunciApi}";
    }

    private function uraiResponsJson($respons, array $defaultJikaGagal): array
    {
        if (!$respons->successful()) {
            Log::error('[GeminiService] HTTP error: ' . $respons->status() . ' - ' . $respons->body());
            return $defaultJikaGagal;
        }

        $teksRespons = $respons->json('candidates.0.content.parts.0.text', '');
        $teksRespons = preg_replace('/```json\s*|\s*```/', '', trim($teksRespons));

        $data = json_decode($teksRespons, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            Log::warning('[GeminiService] Gagal decode JSON: ' . $teksRespons);
            return $defaultJikaGagal;
        }

        return $data;
    }
}