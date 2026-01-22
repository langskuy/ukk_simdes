# 🔄 Panduan Migrasi Template - Langkah demi Langkah

## Phase 1: Struktur & Components (✅ SELESAI)

- [x] Buat folder kategori (general, business, religious, family)
- [x] Buat components reusable (header, footer, data-table, qr-code, styles)
- [x] Update SuratPdfGenerator dengan selectTemplate()
- [x] Dokumentasi lengkap

## Phase 2: Migrasi Template (IN PROGRESS)

### Langkah 1: Copy Template ke Folder Baru

```bash
# GENERAL
cp templates/domisili.blade.php templates/general/domisili.blade.php
cp templates/pindah.blade.php templates/general/pindah.blade.php
cp templates/surat-standar.blade.php templates/general/surat-standar.blade.php

# BUSINESS
cp templates/usaha.blade.php templates/business/usaha.blade.php
cp templates/tidak_mampu.blade.php templates/business/tidak_mampu.blade.php

# RELIGIOUS
cp templates/religious.blade.php templates/religious/religious.blade.php
cp templates/skck.blade.php templates/religious/skck.blade.php

# FAMILY
cp templates/kelahiran.blade.php templates/family/kelahiran.blade.php
```

### Langkah 2: Refactor Setiap Template

#### Template Lama:
```php
<!DOCTYPE html>
<html>
<head>
    <style>
        * { margin: 0; padding: 0; }
        @page { size: A4; margin: 1.5cm; }
        body { font-family: 'Times New Roman'; }
        .header { ... } /* 50+ baris CSS */
        .logo { ... }
        .signature { ... }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="logo">
            <img src="{{ $logo_base64 }}">
        </div>
        <div class="header-text">
            <h1>{{ $village['nama_desa'] }}</h1>
            ...
        </div>
    </div>
    
    <!-- Data -->
    <table class="data-table">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ $surat->nama_pemohon }}</td>
        </tr>
        ...
    </table>
    
    <!-- Footer -->
    <div class="signature">
        ...
    </div>
</body>
</html>
```

#### Template Baru (Refactored):
```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $surat->jenis_surat }}</title>
    @include('surat.templates.components.styles')
</head>
<body>
    <div class="pdf-container">
        <!-- ✨ Use Component: Header -->
        @include('surat.templates.components.header', [
            'village' => $village,
            'logo_base64' => $logo_base64,
            'title' => 'SURAT KETERANGAN USAHA'
        ])

        <!-- Nomor Surat -->
        <div class="text-center mb-2">
            <span style="border-top: 2px solid #000; padding-top: 5px;">
                No: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/SK/{{ now()->format('m/Y') }}
            </span>
        </div>

        <!-- Intro -->
        <p class="mb-3 text-justify">
            Yang bertanda tangan di bawah ini Kepala Desa {{ $village['nama_desa'] }}, menerangkan bahwa:
        </p>

        <!-- ✨ Use Component: Data Table -->
        @include('surat.templates.components.data-table', [
            'data' => [
                'Nama Lengkap' => $surat->nama_pemohon,
                'NIK' => $surat->nik,
                'Alamat' => $kObj['alamat'] ?? '—',
            ],
            'title' => 'DATA PEMOHON'
        ])

        <!-- Isi Surat -->
        <p class="mb-3 text-justify">
            Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar warga penduduk...
        </p>

        <!-- ✨ Use Component: QR Code -->
        @include('surat.templates.components.qr-code', ['qr_code' => $qr_code])

        <!-- ✨ Use Component: Footer -->
        @include('surat.templates.components.footer', [
            'village' => $village,
            'qr_code' => $qr_code,
            'surat' => $surat
        ])
    </div>
</body>
</html>
```

**Hasil:**
- CSS berkurang dari 300+ baris menjadi 0 (semua di styles component)
- HTML lebih clean dan readable
- Mudah di-maintain

### Langkah 3: Test Setiap Template

```bash
# Test PDF generation untuk setiap jenis surat
php artisan surat:test-pdf [id]

# Example:
php artisan surat:test-pdf 1  # Domisili
php artisan surat:test-pdf 2  # Usaha
php artisan surat:test-pdf 3  # Kelahiran
```

### Langkah 4: Verifikasi di Admin

1. Login ke admin panel
2. Pilih surat dari masing-masing kategori
3. Generate PDF untuk setiap kategori
4. Pastikan tampilan rapi dan benar

## Phase 3: Cleanup (PENDING)

### Deprecate Old Templates
- Rename atau hapus template lama
- Backup di folder `_old` atau git

### Update Documentation
- Remove referensi ke template lama
- Update tutorials & guides

## Checklist Migrasi per Template

### General - Domisili
```
[ ] Copy ke templates/general/domisili.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

### General - Pindah
```
[ ] Copy ke templates/general/pindah.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

### General - Surat Standar
```
[ ] Copy ke templates/general/surat-standar.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

### Business - Usaha
```
[ ] Copy ke templates/business/usaha.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

### Business - Tidak Mampu
```
[ ] Copy ke templates/business/tidak_mampu.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

### Religious - Religious
```
[ ] Copy ke templates/religious/religious.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

### Religious - SKCK
```
[ ] Copy ke templates/religious/skck.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

### Family - Kelahiran
```
[ ] Copy ke templates/family/kelahiran.blade.php
[ ] Refactor menggunakan components
[ ] Test PDF generation
[ ] Verify tampilan PDF
[ ] Admin test
```

## Troubleshooting

### Problem: Template tidak ditemukan
```
Error: View [surat.templates.general.domisili] not found

Solution:
1. Check file exists: templates/general/domisili.blade.php
2. Check template path di selectTemplate()
3. Verify view name format
```

### Problem: Component tidak loading
```
Error: View [surat.templates.components.header] not found

Solution:
1. Check file di components folder
2. Verify @include path
```

### Problem: PDF styling inconsistent
```
Solution:
1. Check styles component included
2. Verify CSS di components/styles.blade.php
3. Check PDF margins & page settings
```

## Performance Impact

| Metrik | Sebelum | Sesudah |
|--------|---------|--------|
| Template lines | 300-400 | 100-150 |
| Code duplication | ~70% | ~20% |
| Maintenance time | High | Low |
| PDF generation | Same | Same |
| File size | Same | Same |

## Timeline

```
Week 1: ✅ Structure & Components (DONE)
Week 2: 🔄 Template Migration (IN PROGRESS)
Week 3: Testing & QA
Week 4: Cleanup & Documentation
```

## Success Criteria

- [x] Struktur folder terorganisir
- [x] Components reusable dibuat
- [ ] Semua template ter-migrate
- [ ] Semua PDF generate dengan benar
- [ ] Consistent styling di semua surat
- [ ] Documentation updated
- [ ] Old templates deprecated

---

**Status:** In Progress  
**Phase:** 2/3  
**Completion:** ~40%

Next: Mulai migrasi template satu per satu
