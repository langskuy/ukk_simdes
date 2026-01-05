<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat {{ $surat->jenis_surat }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Calibri', 'Arial', sans-serif; 
            margin: 16px 20px; 
            color: #1a1a1a; 
            line-height: 1.5;
            background: #ffffff;
            margin: 12px 16px; 
            font-size: 10px;
            padding-bottom: 8px;
            margin-bottom: 8px;
                gap: 12px;
                margin-bottom: 6px;
                width: 55px;
                height: 55px;
                border-radius: 3px;
                font-size: 12px;
                margin-bottom: 1px;
                font-size: 9px;
                margin-bottom: 0px;
                font-size: 8px;
                margin-bottom: 0px;
                font-size: 7px;
                font-size: 9px;
                margin-bottom: 6px;
                font-size: 11px;
                margin-bottom: 8px;
                margin-bottom: 6px;
                font-size: 9px;
                margin-bottom: 6px;
                margin: 4px 0;
                font-size: 9px;
                height: 15px;
                padding: 1px 0;
                width: 110px;
                padding-left: 6px;
                margin-top: 6px;
                margin-bottom: 4px;
                font-size: 9px;
                font-size: 9px;
                line-height: 1.5;
                margin: 6px 0;
                margin-bottom: 4px;
                margin-top: 12px;
                font-size: 9px;
                margin-bottom: 30px;
                padding-top: 2px;
                padding: 4px;
                margin-top: 8px;
                font-size: 8px;
        .header-address {
            font-size: 9px;
            color: #555;
            margin-bottom: 1px;
        }
        .header-web {
            font-size: 8px;
            color: #666;
        }
        .letter-number {
            text-align: right;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .letter-title {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 12px;
            letter-spacing: 0.5px;
        }
        .content-section {
            margin-bottom: 10px;
        }
        .intro-line {
            text-align: justify;
            font-size: 10px;
            line-height: 1.5;
            margin-bottom: 8px;
        }
        .data-table {
            width: 100%;
            margin: 6px 0;
            font-size: 10px;
        }
        .data-table tr {
            height: 18px;
        }
        .data-table td {
            padding: 2px 0;
            vertical-align: top;
        }
        .data-table td:first-child {
            width: 120px;
            font-weight: bold;
        }
        .data-table td:nth-child(2) {
            width: 12px;
            text-align: center;
        }
        .data-table td:nth-child(3) {
            padding-left: 8px;
        }
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 8px;
            margin-bottom: 6px;
            font-size: 10px;
            border-bottom: 1px dotted #999;
            padding-bottom: 2px;
        }
        .letter-body {
            text-align: justify;
            font-size: 10px;
            line-height: 1.6;
            margin: 10px 0;
        }
        .letter-body p {
            margin-bottom: 6px;
        }
        .signature-section {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
        .signature-col {
            width: 45%;
            text-align: center;
            font-size: 10px;
        }
        .sig-date {
            margin-bottom: 40px;
            font-weight: bold;
        }
        .sig-name {
            border-top: 1px solid #000;
            padding-top: 4px;
            font-weight: bold;
        }
        .footer-banner {
            text-align: center;
            background: #333;
            color: #fff;
            padding: 6px;
            margin-top: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <!-- Header dengan Kop Surat -->
    <div class="header-section">
        <div class="header-top">
            @php
                $logoBase64 = '';
                $logoPath = public_path('images/logo-desa.png');
                if (file_exists($logoPath)) {
                    $logoData = file_get_contents($logoPath);
                    $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
                }
            @endphp
            @if(!empty($logoBase64))
                <div class="logo-image">
                    <img src="{{ $logoBase64 }}" alt="Logo Desa" />
                </div>
            @else
                <div style="width:65px; height:65px; background:#f5f5f5; border:2px solid #000; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#333; font-weight:bold; font-size:18px;">{{ strtoupper(substr($village['nama_desa'] ?? 'D', 0, 1)) }}</div>
            @endif
            <div class="header-text">
                <div class="header-title">PEMERINTAH KABUPATEN SIDOARJO</div>
                <div class="header-title" style="font-size:12px; margin-top:1px;">DESA {{ strtoupper($village['nama_desa'] ?? 'WONOKASIAN') }}</div>
                <div class="header-sub">KECAMATAN {{ strtoupper($village['kecamatan'] ?? 'WONOAYU') }}</div>
                <div class="header-address">Jl. Desa No. 1 • Telepon: (0331) 123-4567</div>
            </div>
        </div>
    </div>

    <!-- Nomor Surat -->
    <div class="letter-number">
        Nomor: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/SK/{{ now()->format('m/Y') }}
    </div>

    <!-- Judul Surat -->
    <div class="letter-title">
        SURAT KETERANGAN {{ strtoupper($surat->jenis_surat) }}
    </div>

    <!-- Pembuka -->
    <div class="intro-line">
        Yang bertanda tangan di bawah ini adalah Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan {{ $village['kecamatan'] ?? 'Wonoayu' }}, menerangkan bahwa:
    </div>

    <!-- Data Pemohon -->
    <div class="section-title">DATA PEMOHON</div>
    <table class="data-table">
        <tr>
            <td>Nama</td>
            <td>:</td>
            <td>{{ strtoupper($surat->nama_pemohon ?? '—') }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->nik ?? '—' }}</td>
        </tr>
        <tr>
            <td>Nomor Telepon</td>
            <td>:</td>
            <td>{{ $surat->no_hp ?? '—' }}</td>
        </tr>
        <tr>
            <td>Tanggal Pengajuan</td>
            <td>:</td>
            <td>{{ $surat->created_at?->format('d-m-Y') ?? '—' }}</td>
        </tr>
    </table>

    <!-- Keterangan Tambahan -->
    @php
        $kObj = null;
        if (!empty($surat->keterangan)) {
            $tmp = json_decode($surat->keterangan, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($tmp)) {
                $kObj = $tmp;
            }
        }
    @endphp

    @if($kObj && count($kObj) > 0)
    <div class="section-title">KETERANGAN KHUSUS</div>
    <table class="data-table">
        @foreach($kObj as $key => $value)
            @if(!is_array($value))
            <tr>
                <td>{{ ucwords(str_replace(['_', '-'], ' ', $key)) }}</td>
                <td>:</td>
                <td>{{ $value ?? '—' }}</td>
            </tr>
            @endif
        @endforeach
    </table>
    @endif

    <!-- Body Surat -->
    <div class="letter-body">
        <p>Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk sah di Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan {{ $village['kecamatan'] ?? 'Wonoayu' }}.</p>
        
        <p>Surat keterangan ini diberikan berdasarkan data administrasi kependudukan desa yang tercatat dalam sistem registrasi penduduk dan digunakan untuk keperluan administrasi yang sah.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya sesuai dengan peraturan perundang-undangan yang berlaku.</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-col">
            <div class="sig-date">
                {{ $village['nama_desa'] ?? 'Wonokasian' }}, {{ now()->locale('id')->isoFormat('D MMMM Y') }}
            </div>
        </div>
        <div class="signature-col">
            <div style="margin-bottom: 40px;">
                Kepala {{ $village['nama_desa'] ?? 'Desa Wonokasian' }}
            </div>
            <div class="sig-name">
                {{ '(__________________________)' }}
            </div>
        </div>
    </div>

    <!-- Footer Banner -->
    <div class="footer-banner">
        Surat Keterangan Resmi Pemerintah Desa
    </div>

</body>
</html>
