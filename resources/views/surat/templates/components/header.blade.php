<!-- Reusable Header Component for Surat PDF -->
<!-- Usage: @include('surat.templates.components.header', ['village' => $village, 'logo_base64' => $logo_base64, 'title' => 'JUDUL SURAT']) -->

<style>
    .pdf-header {
        display: flex;
        align-items: center;
        gap: 15px;
        border-bottom: 3px double #000;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    
    .pdf-logo {
        width: 60px;
        height: 60px;
        flex-shrink: 0;
    }
    
    .pdf-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    .pdf-header-text {
        flex: 1;
        text-align: center;
    }
    
    .pdf-header-text h1 {
        font-size: 16px;
        font-weight: bold;
        margin: 0 0 3px 0;
        text-transform: uppercase;
    }
    
    .pdf-header-text p {
        font-size: 11px;
        margin: 2px 0;
        color: #333;
    }
    
    .pdf-header-text .kecamatan {
        font-size: 10px;
        color: #555;
        font-style: italic;
    }
</style>

<div class="pdf-header">
    @if($logo_base64)
        <div class="pdf-logo">
            <img src="{{ $logo_base64 }}" alt="Logo Desa">
        </div>
    @endif
    
    <div class="pdf-header-text">
        <h1>{{ $village['nama_desa'] ?? 'WONOKASIAN' }}</h1>
        <p>Kecamatan {{ $village['kecamatan'] ?? 'WONOAYU' }}</p>
        <p>Kabupaten {{ $village['kabupaten'] ?? '' }}</p>
        <p class="kecamatan">Provinsi {{ $village['provinsi'] ?? '' }}</p>
    </div>
</div>

@if(!empty($title))
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="font-size: 14px; font-weight: bold; text-transform: uppercase; margin: 0;">{{ $title }}</h2>
    </div>
@endif
