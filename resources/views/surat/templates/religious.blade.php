<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat {{ $surat->jenis_surat }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Calibri', 'Arial', sans-serif; 
            margin: 12px 16px; 
            color: #1a1a1a; 
            line-height: 1.4;
            background: #ffffff;
            font-size: 10px;
        }
        .header-section {
            text-align: center;
            border-bottom: 3px solid #2d5a2d;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .bismillah {
            font-style: italic;
            font-size: 14px;
            color: #2d5a2d;
            margin-bottom: 4px;
            font-weight: 600;
        }
        .header-top {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 6px;
            margin-top: 4px;
        }
        .logo-placeholder {
            width: 55px;
            height: 55px;
            border: 2px solid #2d5a2d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 20px;
            color: #2d5a2d;
            background: #f5faf5;
            flex-shrink: 0;
        }
        .logo-image {
            width: 55px;
            height: 55px;
            flex-shrink: 0;
            overflow: hidden;
            border-radius: 50%;
        }
        .logo-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .header-text {
            text-align: center;
            flex: 1;
        }
        .header-title {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1px;
            color: #2d5a2d;
        }
        .header-sub {
            font-size: 9px;
            margin-bottom: 0px;
            color: #4a6b4a;
        }
        .header-address {
            font-size: 8px;
            color: #666;
            margin-bottom: 0px;
        }
        .header-web {
            font-size: 7px;
            color: #777;
        }
        .letter-number {
            text-align: right;
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 6px;
            color: #2d5a2d;
        }
        .letter-title {
            text-align: center;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
            color: #2d5a2d;
        }
        .content-section {
            margin-bottom: 6px;
        }
        .intro-line {
            text-align: justify;
            font-size: 9px;
            line-height: 1.4;
            margin-bottom: 6px;
        }
        .data-table {
            width: 100%;
            margin: 4px 0;
            font-size: 9px;
        }
        .data-table tr {
            height: 15px;
        }
        .data-table td {
            padding: 1px 0;
            vertical-align: top;
        }
        .data-table td:first-child {
            width: 110px;
            font-weight: bold;
            color: #2d5a2d;
        }
        .data-table td:nth-child(2) {
            width: 12px;
            text-align: center;
        }
        .data-table td:nth-child(3) {
            padding-left: 6px;
        }
        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 6px;
            margin-bottom: 4px;
            font-size: 9px;
            border-bottom: 1px dotted #2d5a2d;
            padding-bottom: 2px;
            color: #2d5a2d;
        }
        .letter-body {
            text-align: justify;
            font-size: 9px;
            line-height: 1.5;
            margin: 6px 0;
        }
        .letter-body p {
            margin-bottom: 4px;
        }
        .signature-section {
            margin-top: 12px;
            display: flex;
            justify-content: space-between;
        }
        .signature-col {
            width: 45%;
            text-align: center;
            font-size: 9px;
        }
        .sig-date {
            margin-bottom: 30px;
            font-weight: bold;
        }
        .sig-name {
            border-top: 1px solid #000;
            padding-top: 2px;
            font-weight: bold;
        }
        .footer-banner {
            text-align: center;
            background: #2d5a2d;
            color: #fff;
            padding: 4px;
            margin-top: 8px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <!-- Header dengan Kop Surat -->
    <div class="header-section">
        <div class="bismillah">بسم الله الرحمن الرحيم</div>
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
                <div class="logo-placeholder"></div>
            @endif
            <div class="header-text">
                <div class="header-title">PEMERINTAH KABUPATEN SIDOARJO</div>
                <div class="header-title" style="font-size:11px; margin-top:1px;">DESA {{ strtoupper($village['nama_desa'] ?? 'WONOKASIAN') }}</div>
                <div class="header-sub">KECAMATAN {{ strtoupper($village['kecamatan'] ?? 'WONOAYU') }}</div>
                <div class="header-address">Jln. Desa No. 1  Telepon: (0331) 123-4567</div>
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
            <td>{{ strtoupper($surat->nama_pemohon ?? '') }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->nik ?? '' }}</td>
        </tr>
        <tr>
            <td>Nomor Telepon</td>
            <td>:</td>
            <td>{{ $surat->no_hp ?? '' }}</td>
        </tr>
        <tr>
            <td>Tempat/Tanggal Lahir</td>
            <td>:</td>
            <td>{{ $surat->created_at?->format('d-m-Y') ?? '' }}</td>
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
                <td>{{ $value ?? '' }}</td>
            </tr>
            @endif
        @endforeach
    </table>
    @endif

    <!-- Body Surat -->
    <div class="letter-body">
        <p>Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk sah di Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan {{ $village['kecamatan'] ?? 'Wonoayu' }}.</p>
        
        <p>Surat keterangan ini diberikan berdasarkan data administrasi kependudukan desa yang tercatat dalam sistem registrasi penduduk dan digunakan untuk keperluan administrasi yang sah. Data yang tertera dalam surat ini adalah benar dan dapat dipertanggungjawabkan sesuai dengan peraturan perundang-undangan yang berlaku.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya. Semoga bermanfaat dan mendapat berkah serta rahmat dari Allah Subhanahu wa Ta'ala. Apabila di kemudian hari terbukti bahwa data dalam surat ini tidak sesuai dengan kenyataan, maka pihak yang bersangkutan siap menerima konsekuensi hukum sesuai dengan peraturan perundang-undangan yang berlaku.</p>
    </div>

    <!-- Tanda Tangan -->
    <div class="signature-section">
        <div class="signature-col">
            <div class="sig-date">
                {{ $village['nama_desa'] ?? 'Wonokasian' }}, {{ now()->locale('id')->isoFormat('D MMMM Y') }}
            </div>
        </div>
        <div class="signature-col">
            <div style="margin-bottom: 30px;">
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
