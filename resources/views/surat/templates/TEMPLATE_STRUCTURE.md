# 📋 Struktur Template Surat - Panduan Organisasi

## Struktur Folder

```
resources/views/surat/templates/
├── general/                    # Surat umum (domisili, pindah, dll)
│   ├── domisili.blade.php
│   ├── pindah.blade.php
│   └── surat-standar.blade.php
│
├── business/                   # Surat usaha/bisnis
│   ├── usaha.blade.php
│   └── tidak_mampu.blade.php
│
├── religious/                  # Surat keagamaan
│   ├── religious.blade.php
│   └── skck.blade.php
│
├── family/                     # Surat keluarga
│   ├── kelahiran.blade.php
│   └── (future: pernikahan, dll)
│
├── components/                 # Komponen reusable
│   ├── header.blade.php
│   ├── footer.blade.php
│   ├── qr-code.blade.php
│   ├── signature-box.blade.php
│   ├── data-table.blade.php
│   └── styles.blade.php
│
├── universal.blade.php         # Template universal (fallback)
├── official.blade.php          # Template official formal
├── minimal.blade.php           # Template minimal
└── README.md                   # Dokumentasi template
```

## Kategori Surat

### 1. **General** (Surat Umum)
- Surat Keterangan Domisili
- Surat Keterangan Pindah
- Surat Keterangan Umum (Standar)
- Best for: Common administrative needs

### 2. **Business** (Surat Usaha)
- Surat Keterangan Usaha
- Surat Keterangan Tidak Mampu
- Best for: Economic/business related documents

### 3. **Religious** (Surat Keagamaan)
- Surat Keterangan Agama
- Surat Keterangan Kelakuan Baik (SKCK)
- Best for: Religious/moral documentation

### 4. **Family** (Surat Keluarga)
- Surat Keterangan Kelahiran
- Best for: Family related documents

### 5. **Components** (Komponen Reusable)
- Header standar dengan logo dan keterangan desa
- Footer dengan tanda tangan dan QR code
- QR code verification component
- Signature box template
- Data table styling
- Shared CSS styles

## Naming Convention

```
[Category]/[surat-name].blade.php

Examples:
- general/domisili.blade.php
- general/pindah.blade.php
- business/usaha.blade.php
- religious/skck.blade.php
- family/kelahiran.blade.php
```

## Penggunaan di SuratPdfGenerator

```php
// OLD
$viewName = 'surat.templates.surat-standar';

// NEW - Kategori berdasarkan jenis surat
switch($surat->jenis_surat) {
    case 'Surat Keterangan Domisili':
        $viewName = 'surat.templates.general.domisili';
        break;
    case 'Surat Keterangan Usaha':
        $viewName = 'surat.templates.business.usaha';
        break;
    case 'Surat Keterangan Kelahiran':
        $viewName = 'surat.templates.family.kelahiran';
        break;
    // ... etc
}
```

## Cara Menggunakan Components

```php
<!-- Header -->
@include('surat.templates.components.header', [
    'village' => $village,
    'logo_base64' => $logo_base64,
    'title' => 'SURAT KETERANGAN DOMISILI'
])

<!-- Data Table -->
@include('surat.templates.components.data-table', [
    'data' => [
        'Nama' => $surat->nama_pemohon,
        'NIK' => $surat->nik,
    ]
])

<!-- QR Code -->
@include('surat.templates.components.qr-code', [
    'qr_code' => $qr_code
])

<!-- Signature Box -->
@include('surat.templates.components.signature-box', [
    'village' => $village
])
```

## Best Practices

### 1. Keep Components DRY (Don't Repeat Yourself)
- Extract common layouts to components
- Reuse header, footer, QR code across templates
- Share CSS through components

### 2. Consistent Naming
- Use kebab-case for file names
- Use snake_case for variable names
- Use clear, descriptive names

### 3. Template Hierarchy
```
Specific Template (e.g., domisili.blade.php)
    └─ Components (header, footer, etc)
        └─ Universal Styles
```

### 4. Responsive Design
- Test all templates for PDF rendering
- Ensure consistent styling across categories
- Use standard A4 paper size

## Migrasi File

```bash
# Struktur lama:
resources/views/surat/templates/
├── surat-standar.blade.php
├── domisili.blade.php
├── pindah.blade.php
├── usaha.blade.php
├── tidak_mampu.blade.php
├── skck.blade.php
├── kelahiran.blade.php
├── religious.blade.php
├── official.blade.php
├── minimal.blade.php
└── universal.blade.php

# Struktur baru:
resources/views/surat/templates/
├── general/
│   ├── domisili.blade.php
│   ├── pindah.blade.php
│   └── surat-standar.blade.php
├── business/
│   ├── usaha.blade.php
│   └── tidak_mampu.blade.php
├── religious/
│   ├── religious.blade.php
│   └── skck.blade.php
├── family/
│   └── kelahiran.blade.php
├── components/
│   ├── header.blade.php
│   ├── footer.blade.php
│   ├── ...
└── universal.blade.php (deprecated)
```

## Template Maintenance

### Menambah Template Baru
1. Tentukan kategori (general/business/religious/family)
2. Buat file di folder yang sesuai: `[category]/[surat-name].blade.php`
3. Include components yang diperlukan
4. Update SuratPdfGenerator.php dengan mapping jenis surat
5. Test PDF generation

### Update Components
- Edit file di `components/` folder
- Changes automatically applied to all templates yang include component tersebut
- No need to modify individual template files

### Standardisasi Styling
- All CSS di `components/styles.blade.php`
- Template import dengan: `@include('surat.templates.components.styles')`
- Consistent appearance across all surat types

## Performance Tips

1. **Use Components**: Reduce code duplication and maintenance overhead
2. **Cache Common Data**: Village info, jenis surat, dll
3. **Lazy Load Images**: Logo hanya loaded saat dibutuhkan
4. **Optimize CSS**: Minify dan consolidate styles

## Future Improvements

- [ ] Create base template class untuk inheritance
- [ ] Implement template versioning (v1.0, v2.0, etc)
- [ ] Add template preview system
- [ ] Create template builder UI
- [ ] Auto-generate DOCX format alongside PDF
- [ ] Template customization per desa

---

**Status:** ✅ Struktur reorganisasi selesai  
**Last Updated:** January 22, 2026
