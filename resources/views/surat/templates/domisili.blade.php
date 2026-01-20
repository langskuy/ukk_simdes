<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Domisili</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4;
            margin: 1.5cm 1.5cm;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            line-height: 1.4;
            font-size: 11pt;
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

        .header-web {
            font-size: 8px;
            color: #666;
        }

        .letter-number {
            text-align: center;
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
            background: #3366cc;
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
    <div class="header-section" style="border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 80px; text-align: left;">
                    @if(!empty($logo_base64))
                        <img src="{{ $logo_base64 }}" style="width: 70px; height: auto;" alt="Logo Desa" />
                    @endif
                </td>
                <td style="text-align: center; vertical-align: middle;">
                    <div style="font-size: 14pt; font-weight: bold; line-height: 1.2;">PEMERINTAH KABUPATEN SIDOARJO
                    </div>
                    <div style="font-size: 16pt; font-weight: bold; line-height: 1.2;">DESA
                        {{ strtoupper($village['nama_desa'] ?? 'WONOKASIAN') }}
                    </div>
                    <div style="font-size: 12pt; font-weight: bold; line-height: 1.2;">KECAMATAN
                        {{ strtoupper($village['kecamatan'] ?? 'WONOAYU') }}
                    </div>
                    <div style="font-size: 10pt; font-style: italic; margin-top: 5px;">Jl. Desa No. 1 • Telepon: (0331)
                        123-4567 • Kode Pos: 61261</div>
                </td>
                <td style="width: 80px;"></td> <!-- Spacer for center alignment -->
            </tr>
        </table>
    </div>

    <div style="margin: 0 40px;">
        <!-- Nomor Surat -->
        <div style="text-align: center; margin-bottom: 15px;">
            <div class="letter-title" style="margin-bottom: 2px;">SURAT KETERANGAN DOMISILI</div>
            <div
                style="font-size: 11pt; border-top: 2px solid #000; display: inline-block; padding-top: 2px; min-width: 250px;">
                Nomor: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/DOM/{{ now()->format('m/Y') }}
            </div>
        </div>

        <!-- Pembuka -->
        <div class="intro-line" style="margin-top: 15px;">
            Yang bertanda tangan di bawah ini Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan
            {{ $village['kecamatan'] ?? 'Wonoayu' }}, menerangkan bahwa:
        </div>

        <!-- Data Pemohon -->
        <div class="section-title">I. DATA PEMOHON</div>
        <table class="data-table" style="width: 100%;">
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><strong>{{ strtoupper($surat->nama_pemohon ?? '—') }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $surat->nik ?? '—' }}</td>
            </tr>
            <tr>
                <td>Nomor KK</td>
                <td>:</td>
                <td>{{ $kObj['no_kk'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $kObj['jenis_kelamin'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Tempat/Tgl. Lahir</td>
                <td>:</td>
                <td>{{ ($kObj['tempat_lahir'] ?? '—') . ', ' . ($kObj['tanggal_lahir'] ?? '—') }}</td>
            </tr>
            <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td>{{ $kObj['kewarganegaraan'] ?? 'WNI' }}</td>
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
                <td>Alamat Asal (KTP)</td>
                <td>:</td>
                <td>{{ $kObj['alamat'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Alamat Domisili Sekarang</td>
                <td>:</td>
                <td>{{ $kObj['alamat_domisili'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Lama Tinggal</td>
                <td>:</td>
                <td>{{ $kObj['lama_tinggal'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>{{ $kObj['keperluan'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>RT / RW</td>
                <td>:</td>
                <td>{{ $kObj['rt_rw'] ?? '—' }}</td>
            </tr>
        </table>

        <!-- Body Surat -->
        <div class="letter-body">
            <p>Dengan ini kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk yang berdomisili di
                {{ str_starts_with(strtolower($village['nama_desa'] ?? ''), 'desa') ? ($village['nama_desa'] ?? 'Desa Wonokasian') : 'Desa ' . ($village['nama_desa'] ?? 'Wonokasian') }},
                Kecamatan {{ $village['kecamatan'] ?? 'Wonoayu' }}, Kabupaten Sidoarjo.
            </p>

            <p>Surat keterangan domisili ini diberikan berdasarkan data administrasi kependudukan dan registrasi
                penduduk
                yang tercatat di desa kami dan berlaku selama enam bulan sejak tanggal diterbitkan.</p>

            <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <!-- Tanda Tangan & QR Code -->
        <div style="margin-top: 20px; width: 100%; page-break-inside: avoid;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="width: 50%; text-align: center; vertical-align: top;">
                        <div style="margin-bottom: 5px;">
                            {{ $village['nama_desa'] ?? 'Wonokasian' }},
                            {{ now()->locale('id')->isoFormat('D MMMM Y') }}
                        </div>
                        <div style="font-weight: bold; margin-bottom: 5px;">
                            Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}
                        </div>

                        <!-- QR Code TTE -->
                        <div style="margin: 10px 0;">
                            <img src="{{ $qr_code }}" style="width: 85px; height: 85px;" />
                        </div>

                        <div
                            style="margin-bottom: 5px; color: #155724; font-size: 8pt; font-weight: bold; font-style: italic;">
                            [Tanda Tangan Elektronik]
                        </div>
                        <div style="font-weight: bold; text-decoration: underline;">
                            {{ strtoupper($village['nama_kades'] ?? '( __________________________ )') }}
                        </div>
                        @if(!empty($village['nip_kades']))
                            <div style="font-size: 10px;">NIP. {{ $village['nip_kades'] }}</div>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <!-- Footer Banner -->
    <div class="footer-banner" style="position: absolute; bottom: 0; left: 0; right: 0;">
        Dokumen ini diterbitkan secara resmi oleh Sistem Informasi Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}
    </div>

</body>

</html>