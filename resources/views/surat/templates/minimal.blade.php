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
            color: #666;
        }
        .header-address {
            font-size: 9px;
            color: #777;
            margin-bottom: 1px;
        }
        .header-web {
            font-size: 8px;
            color: #888;
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
            color: #0ea5a4;
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
            border-bottom: 1px dotted #0ea5a4;
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
            background: #0ea5a4;
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
                <div style="width:65px; height:65px; background:#0ea5a4; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:bold; font-size:18px;">{{ strtoupper(substr($village['nama_desa'] ?? 'D', 0, 1)) }}</div>
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
        <p>Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk sah {{ $village['nama_desa'] ?? 'Desa Wonokasian' }}, Kecamatan {{ $village['kecamatan'] ?? 'Wonoayu' }}.</p>
        
        <p>Surat keterangan ini diberikan berdasarkan data administrasi kependudukan desa yang tercatat dan digunakan untuk keperluan administrasi. Data tersebut adalah sah dan dapat dipertanggungjawabkan sesuai dengan peraturan perundang-undangan yang berlaku.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dipergunakan sebagaimana mestinya. Apabila di kemudian hari terbukti bahwa data dalam surat ini tidak sesuai dengan kenyataan, maka pihak yang bersangkutan bersedia menerima konsekuensi hukum yang berlaku.</p>
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
        SURAT KETERANGAN RESMI PEMERINTAH DESA
    </div>

</body>
</html>
        .header-card{padding:18px 22px; background:linear-gradient(135deg, #0ea5a4 0%, #06b6d4 100%); border-radius:10px; margin-bottom:18px; box-shadow:0 2px 8px rgba(14,165,164,0.15)}
        .header-top{display:flex; align-items:center; gap:16px}
        .logo-circle{width:65px; height:65px; background:#ffffff; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:900; color:#0ea5a4; font-size:22px; flex-shrink:0; box-shadow:0 2px 4px rgba(0,0,0,0.1)}
        .header-info{flex:1; color:#ffffff}
        .header-title{font-size:19px; font-weight:900; text-transform:uppercase; margin:0; letter-spacing:1px}
        .header-sub{font-size:11px; margin:4px 0 0; opacity:0.95}
        .header-num{text-align:right; color:#ffffff; font-size:12px; font-weight:700}
        .title{text-align:center; margin:24px 0 20px; font-size:17px; font-weight:900; text-transform:uppercase; color:#0ea5a4; border-bottom:3px solid #0ea5a4; padding-bottom:10px; letter-spacing:0.5px}
        .info-grid{display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:18px}
        .info-card{padding:14px; background:#f0fdf4; border:2px solid #0ea5a4; border-radius:6px}
        .info-label{font-weight:800; color:#0ea5a4; font-size:12px; text-transform:uppercase; margin-bottom:4px}
        .info-value{color:#0f172a; font-weight:600; font-size:13px}
        .content{margin:22px 0 26px; line-height:1.8; text-align:justify; color:#1a1a1a}
        .content p{margin-bottom:14px}
        .content strong{color:#0ea5a4; font-weight:800}
        .signature-row{display:flex; justify-content:space-between; gap:20px; margin-top:48px}
        .signature-col{flex:1; text-align:center}
        .sig-label{font-weight:700; color:#0f172a; font-size:12px; margin-bottom:12px}
        .sig-line{border-top:2px solid #000; margin-top:60px; padding-top:8px; font-weight:700; font-size:12px; color:#0f172a}
        .footer-banner{background:#f8fafc; border-left:4px solid #0ea5a4; padding:12px 16px; margin-top:32px; border-radius:4px}
        .footer-text{text-align:center; color:#64748b; font-size:10px; line-height:1.6}
    </style>
</head>
<body>
    <div class="header-card">
        <div class="header-top">
            <div class="logo-circle">{{ strtoupper(substr($village['nama_desa'] ?? 'D', 0, 1)) }}</div>
            <div class="header-info">
                <div class="header-title">{{ strtoupper($village['nama_desa'] ?? 'Desa Wonokasian') }}</div>
                <div class="header-sub">
                    @if($village['kecamatan'])Kecamatan {{ ucwords($village['kecamatan']) }}@endif
                    @if($village['kabupaten']) • Kabupaten {{ ucwords($village['kabupaten']) }}@endif
                    @if($village['provinsi']) • {{ ucwords($village['provinsi']) }}@endif
                </div>
            </div>
            <div class="header-num">{{ now()->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="title">SURAT KETERANGAN {{ strtoupper($surat->jenis_surat) }}</div>

    <div class="info-grid">
        <div class="info-card">
            <div class="info-label">Nama Pemohon</div>
            <div class="info-value">{{ $surat->nama_pemohon ?? '—' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">NIK</div>
            <div class="info-value">{{ $surat->nik ?? '—' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">No. HP</div>
            <div class="info-value">{{ $surat->no_hp ?? '—' }}</div>
        </div>
        <div class="info-card">
            <div class="info-label">Tanggal Pengajuan</div>
            <div class="info-value">{{ $surat->created_at?->format('d-m-Y H:i') ?? '—' }}</div>
        </div>
    </div>

    @php
        $kObj = null;
        if (!empty($surat->keterangan)) {
            $tmp = json_decode($surat->keterangan, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($tmp)) {
                $kObj = $tmp;
            }
        }
    @endphp

    @if($surat->keterangan)
    <div class="info-grid" style="grid-template-columns:1fr">
        <div class="info-card">
            <div class="info-label">Keterangan Tambahan</div>
            @if($kObj)
                @foreach($kObj as $k=>$v)
                    <div style="margin-bottom:8px"><strong>{{ ucwords(str_replace(['_','-'],' ',$k)) }}:</strong> {{ is_array($v) ? json_encode($v) : $v }}</div>
                @endforeach
            @else
                <div style="white-space:pre-wrap; color:#0f172a">{{ $surat->keterangan }}</div>
            @endif
        </div>
    </div>
    @endif

    <div class="content">
        <p>Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk <strong>{{ $village['nama_desa'] ?? 'Desa Wonokasian' }}</strong>. Berdasarkan data administrasi kependudukan desa, data tersebut adalah sah dan dapat dipergunakan untuk keperluan administrasi.</p>
        <p>Demikian surat keterangan ini dibuat agar dapat digunakan sebagaimana mestinya. Terima kasih.</p>
    </div>

    <div class="signature-row">
        <div class="signature-col">
            <div class="sig-label">Pemohon</div>
            <div class="sig-line">{{ $surat->nama_pemohon ?? '—' }}</div>
        </div>
        <div class="signature-col">
            <div class="sig-label">Kepala Desa</div>
            <div class="sig-line">&nbsp;</div>
        </div>
    </div>

    <div class="footer-banner">
        <div class="footer-text">
            <div>Nomor Surat: {{ $surat->id }}/Surat/{{ now()->format('m/Y') }}</div>
            <div style="margin-top:6px; font-size:9px">Digenerate otomatis pada {{ now()->format('d-m-Y H:i:s') }} • Sistem Informasi Manajemen Desa</div>
        </div>
    </div>
</body>
</html>