<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $surat->jenis_surat }} - {{ $village['nama_desa'] ?? 'Wonokasian' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        @page {
            size: A4;
            margin: 2cm 2cm;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12px;
            line-height: 1.5;
            color: #000;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }
        
        .logo {
            width: 60px;
            height: 60px;
        }
        
        .logo img {
            max-width: 100%;
            height: auto;
        }
        
        .header-text {
            flex: 1;
            text-align: center;
        }
        
        .header-text h1 {
            font-size: 16px;
            margin-bottom: 3px;
            text-transform: uppercase;
            font-weight: bold;
        }
        
        .header-text p {
            font-size: 11px;
            margin: 2px 0;
        }
        
        .judul-surat {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 20px;
            margin-top: 15px;
        }
        
        .no-surat {
            text-align: center;
            font-size: 11px;
            margin-bottom: 20px;
        }
        
        .content {
            text-align: justify;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .content p {
            margin-bottom: 10px;
            text-indent: 1cm;
        }
        
        .data-section {
            margin: 15px 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
        }
        
        .data-table tr {
            border-bottom: 1px solid #ddd;
        }
        
        .data-table td {
            padding: 6px 8px;
            vertical-align: top;
        }
        
        .data-table td:first-child {
            width: 35%;
            font-weight: bold;
            background-color: #f0f0f0;
        }
        
        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }
        
        .ttd-section {
            display: flex;
            gap: 30px;
            justify-content: space-between;
            margin-top: 50px;
            padding-top: 20px;
        }
        
        .ttd-box {
            text-align: center;
            flex: 1;
        }
        
        .ttd-box p {
            margin: 3px 0;
            font-size: 11px;
        }
        
        .ttd-nama {
            margin-top: 40px;
            font-weight: bold;
            text-decoration: underline;
            min-height: 20px;
        }
        
        .qr-code {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        
        .qr-code img {
            width: 100px;
            height: 100px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 12px;
            margin-top: 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #999;
            padding-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            @if($logo_base64)
                <div class="logo">
                    <img src="{{ $logo_base64 }}" alt="Logo Desa">
                </div>
            @endif
            <div class="header-text">
                <h1>{{ $village['nama_desa'] ?? 'Wonokasian' }}</h1>
                <p>Kecamatan {{ $village['kecamatan'] ?? '' }} - {{ $village['kabupaten'] ?? '' }}</p>
                <p>Provinsi {{ $village['provinsi'] ?? '' }}</p>
            </div>
        </div>

        <!-- Judul Surat -->
        <div class="judul-surat">
            {{ $surat->jenis_surat }}
        </div>

        <!-- Nomor Surat -->
        <div class="no-surat">
            Nomor: {{ $surat->id }}/{{ strtoupper($village['kecamatan'] ?? 'KECAMATAN') }}/{{ date('Y', strtotime($surat->created_at)) }}
        </div>

        <!-- Isi Surat -->
        <div class="content">
            <p>
                Yang bertanda tangan di bawah ini, Kepala {{ $village['nama_desa'] ?? 'Wonokasian' }} Kecamatan {{ $village['kecamatan'] ?? '' }} 
                Kabupaten {{ $village['kabupaten'] ?? '' }}, dengan ini menerangkan:
            </p>

            <!-- Data Pemohon -->
            @if(!empty($kObj))
                <div class="section-title">Data Pemegang Surat</div>
                <div class="data-section">
                    <table class="data-table">
                        <tr>
                            <td>Nama Lengkap</td>
                            <td>:</td>
                            <td>{{ $kObj['nama'] ?? $surat->user->name ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>No. Kartu Keluarga</td>
                            <td>:</td>
                            <td>{{ $kObj['no_kk'] ?? $surat->user->no_kk ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>NIK</td>
                            <td>:</td>
                            <td>{{ $kObj['nik'] ?? $surat->user->nik ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>Tempat/Tanggal Lahir</td>
                            <td>:</td>
                            <td>{{ ($kObj['tempat_lahir'] ?? '—') }} / {{ ($kObj['tanggal_lahir'] ?? '—') }}</td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <td>{{ $kObj['jenis_kelamin'] ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>Agama</td>
                            <td>:</td>
                            <td>{{ $kObj['agama'] ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td>{{ $kObj['pekerjaan'] ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>{{ $kObj['alamat'] ?? $kObj['alamat_lengkap'] ?? $surat->user->alamat ?? '—' }}</td>
                        </tr>
                        @if(!empty($kObj['rt']) || !empty($kObj['rw']))
                        <tr>
                            <td>RT/RW</td>
                            <td>:</td>
                            <td>
                                @if(!empty($kObj['rt']) && !empty($kObj['rw']))
                                    RT. {{ str_pad($kObj['rt'], 3, '0', STR_PAD_LEFT) }} / RW. {{ str_pad($kObj['rw'], 3, '0', STR_PAD_LEFT) }}
                                @else
                                    {{ $kObj['rt'] ?? '' }}{{ !empty($kObj['rt']) && !empty($kObj['rw']) ? ' / ' : '' }}{{ $kObj['rw'] ?? '' }}
                                @endif
                            </td>
                        </tr>
                        @endif
                    </table>
                </div>
            @endif

            <!-- Detail Pengajuan -->
            @if(!empty($surat->detail_data))
                <p style="margin-top: 15px;">
                    <strong>Keterangan Pengajuan:</strong>
                </p>
                <div class="data-section">
                    <table class="data-table">
                        @php
                            $detailData = is_array($surat->detail_data) ? $surat->detail_data : json_decode($surat->detail_data, true);
                            if (!empty($detailData)) {
                                foreach ($detailData as $key => $value) {
                                    $displayKey = ucfirst(str_replace('_', ' ', $key));
                                    $displayValue = is_array($value) ? implode(', ', $value) : $value;
                                    echo "<tr><td>$displayKey</td><td>:</td><td>$displayValue</td></tr>";
                                }
                            }
                        @endphp
                    </table>
                </div>
            @endif

            <p style="margin-top: 15px;">
                Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagai bukti yang sah menurut hukum.
            </p>
        </div>

        <!-- Tanda Tangan -->
        <div class="ttd-section">
            <div class="ttd-box">
                <p>Diajukan oleh,</p>
                <div class="ttd-nama"></div>
                <p>{{ $surat->user->name ?? '—' }}</p>
            </div>
            <div class="ttd-box">
                <p>{{ $village['nama_desa'] ?? 'Wonokasian' }}, {{ date('d F Y') }}</p>
                <p style="font-weight: bold;">Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}</p>
                <div class="ttd-nama"></div>
                <!-- QR Code -->
                @if($qr_code)
                    <div style="text-align: center; margin: 20px 0 15px 0;">
                        <img src="{{ $qr_code }}" alt="QR Code Verifikasi" style="width: 75px; height: 75px; display: block; margin: 0 auto;">
                        <p style="font-size: 8px; color: #666; margin-top: 5px;">Verifikasi Dokumen</p>
                    </div>
                @endif
                <p style="margin-top: 10px;">________________________</p>
                <p style="margin-top: 5px; font-size: 10px; font-weight: bold;">{{ strtoupper($village['nama_kades'] ?? '( Nama Kepala Desa )') }}</p>
                @if(!empty($village['nip_kades']))
                    <p style="font-size: 9px;">NIP. {{ $village['nip_kades'] }}</p>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align: center; margin-top: 30px; font-size: 10px; color: #999;">
            <p>Dokumen ini dihasilkan oleh Sistem Informasi Desa Wonokasian</p>
            <p>Dicetak: {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
