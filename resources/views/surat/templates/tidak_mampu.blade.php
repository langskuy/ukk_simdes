<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Tidak Mampu</title>
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
            background: #d9534f;
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
            <div style="width:55px; height:55px; background:#fef5f5; border:2px solid #d9534f; border-radius:4px; display:flex; align-items:center; justify-content:center; color:#d9534f; font-weight:bold; font-size:18px;">{{ strtoupper(substr($village['nama_desa'] ?? 'D', 0, 1)) }}</div>
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
        Nomor: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/TM/{{ now()->format('m/Y') }}
    </div>

    <!-- Judul Surat -->
    <div class="letter-title">
        SURAT KETERANGAN TIDAK MAMPU
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
            <td>Pekerjaan</td>
            <td>:</td>
            <td>{{ $kObj['pekerjaan'] ?? '—' }}</td>
        </tr>
        <tr>
            <td>Penghasilan Bulanan</td>
            <td>:</td>
            <td>{{ $kObj['penghasilan_bulanan'] ?? '—' }}</td>
        </tr>
        <tr>
            <td>Jumlah Anggota Keluarga</td>
            <td>:</td>
            <td>{{ $kObj['jumlah_anggota_keluarga'] ?? '—' }}</td>
        </tr>
        <tr>
            <td>Alasan Pengajuan</td>
            <td>:</td>
            <td>{{ $kObj['alasan_pengajuan'] ?? '—' }}</td>
        </tr>
    </table>

    <!-- Kondisi Khusus -->
    @if(!empty($kObj['kondisi_khusus']))
    <div class="section-title">KONDISI KHUSUS</div>
    <table class="data-table">
        <tr>
            <td>Keterangan</td>
            <td>:</td>
            <td>{{ $kObj['kondisi_khusus'] }}</td>
        </tr>
    </table>
    @endif

    <!-- Body Surat -->
    <div class="letter-body">
        <p>Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk Desa {{ $village['nama_desa'] ?? 'Wonokasian' }} yang termasuk dalam kategori tidak mampu/kurang mampu berdasarkan verifikasi data sosial ekonomi kami.</p>
        
        <p>Surat keterangan tidak mampu ini diberikan berdasarkan data dan penelusuran sosial oleh perangkat desa untuk keperluan administrasi, bantuan sosial, atau keperluan lainnya yang sah.</p>
        
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
        Surat Keterangan Tidak Mampu Resmi
    </div>

</body>
</html>
