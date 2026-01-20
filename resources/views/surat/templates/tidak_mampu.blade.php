<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Keterangan Tidak Mampu</title>
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
                <td style="width: 80px;"></td> <!-- Spacer -->
            </tr>
        </table>
    </div>

    <div style="margin: 0 40px;">
        <!-- Nomor Surat -->
        <div style="text-align: center; margin-bottom: 15px;">
            <div class="letter-title" style="margin-bottom: 2px;">SURAT KETERANGAN TIDAK MAMPU</div>
            <div
                style="font-size: 11pt; border-top: 2px solid #000; display: inline-block; padding-top: 2px; min-width: 250px;">
                Nomor: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/TM/{{ now()->format('m/Y') }}
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
                <td style="width: 150px;">Nama Lengkap</td>
                <td style="width: 20px; text-align: center;">:</td>
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
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $kObj['pekerjaan'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Penghasilan per Bulan</td>
                <td>:</td>
                <td>{{ $kObj['penghasilan_bulanan'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>{{ $kObj['alamat'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>RT / RW</td>
                <td>:</td>
                <td>{{ $kObj['rt_rw'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Keperluan</td>
                <td>:</td>
                <td>{{ $kObj['keperluan'] ?? '—' }}</td>
            </tr>
        </table>

        @if(!empty($kObj['data_keluarga']))
            <div class="section-title">II. DAFTAR ANGGOTA KELUARGA</div>
            <div style="margin-left: 15px; margin-top: 5px; font-size: 11pt; line-height: 1.5; margin-bottom: 15px;">
                {!! nl2br(e($kObj['data_keluarga'])) !!}
            </div>
        @endif


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
            <p>Dengan ini kami menerangkan bahwa keluarga tersebut di atas adalah benar penduduk Desa
                {{ $village['nama_desa'] ?? 'Wonokasian' }} yang termasuk dalam kategori keluarga kurang mampu / rentan
                miskin
                berdasarkan kriteria data terpadu kesejahteraan sosial kami.
            </p>

            <p>Surat keterangan ini diberikan agar dapat digunakan sebagai persyaratan mendapatkan bantuan sosial,
                beasiswa
                pendidikan, atau pengurangan biaya administrasi di lembaga terkait.</p>

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
    <div class="footer-banner" style="position: absolute; bottom: 0; left: 0; right: 0; background: #d9534f;">
        Dokumen Resmi Desa {{ $village['nama_desa'] ?? 'Wonokasian' }} - Surat Keterangan Tidak Mampu
    </div>

</body>

</html>