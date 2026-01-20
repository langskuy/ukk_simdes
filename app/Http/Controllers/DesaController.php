<?php

namespace App\Http\Controllers;

class DesaController extends Controller
{
    /**
     * Tampilkan halaman profil desa.
     */
    public function profile()
    {
        // Default profile data
        $desa = [
            'nama' => 'Desa Wonokasian',
            'kecamatan' => 'Kecamatan Contoh',
            'kabupaten' => 'Kabupaten Contoh',
            'provinsi' => 'Provinsi Jawa Timur',
            'populasi' => '5,234 jiwa',
            'luas_wilayah' => '25.5 km²',
            'jumlah_rt' => '12 RT',
            'jumlah_rw' => '3 RW',
            'sejarah' => 'Desa Wonokasian adalah sebuah desa yang kaya akan sejarah dan budaya. Desa ini didirikan pada tahun 1800-an dan berkembang menjadi pusat pertanian yang produktif. Masyarakat desa hidup secara harmonis dan menjaga kelestarian lingkungan sekitar.',
            'visi' => 'Mewujudkan Desa Wonokasian yang maju, sejahtera, dan berkelanjutan melalui pemberdayaan masyarakat dan pelestarian lingkungan.',
            'misi' => [
                'Meningkatkan kualitas hidup masyarakat melalui pendidikan dan kesehatan yang lebih baik',
                'Mengembangkan ekonomi lokal dengan mendukung usaha kecil dan menengah',
                'Menjaga kelestarian alam dan lingkungan untuk generasi mendatang',
                'Memperkuat kohesi sosial dan keamanan di tingkat desa',
            ],
            'kontak' => [
                'alamat' => 'Jln. Desa No. 1, Wonokasian',
                'telepon' => '(0331) 123-4567',
                'email' => 'info@desawonokasian.go.id',
            ],
        ];

        // If an editable profile exists in storage, merge it (non-destructive, keeps existing workflow)
        $path = storage_path('app/desa.json');
        if (file_exists($path)) {
            try {
                $json = json_decode(file_get_contents($path), true);
                if (is_array($json)) {
                    $desa = array_replace_recursive($desa, $json);
                }
            } catch (\Throwable $e) {
                // ignore and use defaults
            }
        }

        return view('desa.profile', ['desa' => $desa]);
    }

    /**
     * Update editable desa profile (admin only).
     */
    public function updateProfile(\Illuminate\Http\Request $request)
    {
        // only allow admins to edit
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:191',
            'kecamatan' => 'nullable|string|max:191',
            'kabupaten' => 'nullable|string|max:191',
            'provinsi' => 'nullable|string|max:191',
            'populasi' => 'required|numeric|min:0',
            'luas_wilayah' => 'nullable|numeric|min:0',
            'jumlah_rt' => 'nullable|integer|min:0',
            'jumlah_rw' => 'nullable|integer|min:0',
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string', // multiline text, will be split
            'kontak_alamat' => 'nullable|string|max:255',
            'kontak_telepon' => 'nullable|string|max:50',
            'kontak_email' => 'nullable|email|max:191',
        ]);

        $path = storage_path('app/desa.json');
        $data = [];
        if (file_exists($path)) {
            $existing = json_decode(file_get_contents($path), true) ?: [];
            $data = $existing;
        }

        // Basic string fields
        $data['nama'] = $validated['nama'];
        $data['kecamatan'] = $validated['kecamatan'] ?? $data['kecamatan'] ?? null;
        $data['kabupaten'] = $validated['kabupaten'] ?? $data['kabupaten'] ?? null;
        $data['provinsi'] = $validated['provinsi'] ?? $data['provinsi'] ?? null;

        // Population formatting
        $data['populasi'] = number_format((int) $validated['populasi']) . ' jiwa';

        // Luas wilayah: keep one decimal if provided
        if (isset($validated['luas_wilayah'])) {
            $data['luas_wilayah'] = rtrim(rtrim(number_format((float) $validated['luas_wilayah'], 2, '.', ''), '0'), '.') . ' km²';
        }

        if (isset($validated['jumlah_rt'])) {
            $data['jumlah_rt'] = (int) $validated['jumlah_rt'] . ' RT';
        }
        if (isset($validated['jumlah_rw'])) {
            $data['jumlah_rw'] = (int) $validated['jumlah_rw'] . ' RW';
        }

        $data['sejarah'] = $validated['sejarah'] ?? $data['sejarah'] ?? '';
        $data['visi'] = $validated['visi'] ?? $data['visi'] ?? '';

        // misi: split by newlines into array
        if (!empty($validated['misi'])) {
            $lines = preg_split('/\r\n|\r|\n/', trim($validated['misi']));
            $misi = array_values(array_filter(array_map('trim', $lines), fn($v) => $v !== ''));
            $data['misi'] = $misi;
        }

        // kontak
        $data['kontak'] = $data['kontak'] ?? [];
        if (isset($validated['kontak_alamat'])) {
            $data['kontak']['alamat'] = $validated['kontak_alamat'];
        }
        if (isset($validated['kontak_telepon'])) {
            $data['kontak']['telepon'] = $validated['kontak_telepon'];
        }
        if (isset($validated['kontak_email'])) {
            $data['kontak']['email'] = $validated['kontak_email'];
        }

        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('desa.profile')->with('success', 'Profil desa berhasil diperbarui.');
    }
}
