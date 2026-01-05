<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Lainnya</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Calibri', 'Arial', sans-serif; 
            margin: 12px 16px; 
            color: #1a1a1a; 
            line-height: 1.5;
            font-size: 10px;
        }
        .header-section {
            display: flex;
            gap: 12px;
            margin-bottom: 6px;
            align-items: flex-start;
        }
        .logo-image {
            width: 55px;
            height: 55px;
            border-radius: 3px;
            flex-shrink: 0;
        }
        .logo-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .header-text {
            flex: 1;
        }
        .header-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 1px;
        }
        .header-sub {
            font-size: 9px;
            margin-bottom: 0px;
        }
        .header-address {
            font-size: 8px;
            color: #555;
            margin-bottom: 1px;
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
        .intro-line {
            text-align: justify;
            font-size: 10px;
            line-height: 1.5;
            margin-bottom: 8px;
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
        .detail-box {
            background: #f5f5f5;
            border-left: 3px solid #666;
            padding: 6px 8px;
            margin: 8px 0;
            font-size: 10px;
            line-height: 1.4;
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
            background: #666666;
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
        @if(!empty($logo_base64))
            <div class="logo-image">
                <img src="{{ $logo_base64 }}" alt="Logo Desa" />
            </div>
        @else
            <div style="width:55px; height:55px; background:#f8f8f8; border:2px solid #666; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#666; font-weight:bold; font-size:18px;">{{ strtoupper(substr($village['nama_desa'] ?? 'D', 0, 1)) }}</div>
        @endif
        <div class="header-text">
            <div class="header-title">PEMERINTAH KABUPATEN SIDOARJO</div>
            <div class="header-title" style="font-size:12px; margin-top:1px;">DESA {{ strtoupper($village['nama_desa'] ?? 'WONOKASIAN') }}</div>
            <div class="header-sub">KECAMATAN {{ strtoupper($village['kecamatan'] ?? 'WONOAYU') }}</div>
            <div class="header-address">Jl. Desa No. 1 • Telepon: (0331) 123-4567</div>
        </div>
    </div>

    <!-- Nomor Surat -->
    <div class="letter-number">
        Nomor: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/LNY/{{ now()->format('m/Y') }}
    </div>

    <!-- Judul Surat -->
    <div class="letter-title">
        SURAT KETERANGAN LAINNYA
    </div>

    <!-- Pembuka -->
    <div class="intro-line">
        Yang bertanda tangan di bawah ini adalah Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan {{ $village['kecamatan'] ?? 'Wonoayu' }}, menerangkan bahwa:
    </div>

    <!-- Data Pemohon -->
    <div class="section-title">DATA PEMOHON</div>
    <table class="data-table">
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ strtoupper($surat->nama_pemohon ?? '—') }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>:</td>
            <td>{{ $surat->nik ?? '—' }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td>{{ $surat->alamat ?? '—' }}</td>
        </tr>
    </table>

    <!-- Detail Permintaan -->
    <div class="section-title">DETAIL PERMINTAAN</div>
    @if(!empty($kObj['detail_permintaan']))
    <div class="detail-box">
        {{ $kObj['detail_permintaan'] }}
    </div>
    @else
    <table class="data-table">
        <tr>
            <td>Keperluan</td>
            <td>:</td>
            <td>{{ $kObj['keperluan'] ?? '—' }}</td>
        </tr>
    </table>
    @endif

    <!-- Body Surat -->
    <div class="letter-body">
        <p>Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk Desa {{ $village['nama_desa'] ?? 'Wonokasian' }} dan telah melakukan verifikasi data dengan perangkat desa sesuai dengan persyaratan yang ditentukan.</p>
        
        <p>Surat keterangan ini diberikan berdasarkan hasil verifikasi dan penelusuran yang telah dilakukan untuk keperluan administrasi atau keperluan lainnya yang sah sesuai dengan ketentuan peraturan perundang-undangan yang berlaku di Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}.</p>
        
        <p>Demikian surat keterangan ini dibuat dengan sebenarnya agar dapat dipergunakan sebagaimana mestinya oleh yang bersangkutan dan pihak-pihak yang membutuhkan.</p>
    </div>

    <!-- Catatan Tambahan -->
    @if(!empty($kObj['catatan']))
    <div style="margin-top: 10px; border-top: 1px dotted #999; padding-top: 6px; font-size: 9px; color: #555;">
        <strong>Catatan:</strong> {{ $kObj['catatan'] }}
    </div>
    @endif

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
        Surat Keterangan Lainnya Resmi
    </div>

</body>
</html>
