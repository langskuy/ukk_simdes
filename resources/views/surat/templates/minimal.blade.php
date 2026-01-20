<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat {{ $surat->jenis_surat }}</title>
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
            margin-bottom: 20px;
        }

        .letter-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .data-table {
            width: 100%;
            margin: 15px 0;
            font-size: 11pt;
        }

        .data-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .data-table td:first-child {
            width: 180px;
        }

        .data-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 15px;
            margin-bottom: 10px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        .letter-body {
            text-align: justify;
            margin: 20px 0;
        }

        .letter-body p {
            margin-bottom: 10px;
            text-indent: 40px;
        }

        .footer-banner {
            text-align: center;
            background: #0ea5a4;
            color: #fff;
            padding: 8px;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
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
            <div class="letter-title" style="margin-bottom: 2px;">SURAT KETERANGAN {{ strtoupper($surat->jenis_surat) }}
            </div>
            <div
                style="font-size: 11pt; border-top: 2px solid #000; display: inline-block; padding-top: 2px; min-width: 250px;">
                Nomor: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/SK/{{ now()->format('m/Y') }}
            </div>
        </div>

        <!-- Pembuka -->
        <div class="intro-line" style="margin-top: 20px;">
            Yang bertanda tangan di bawah ini Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan
            {{ $village['kecamatan'] ?? 'Wonoayu' }}, menerangkan bahwa:
        </div>

        <!-- Data Pemohon -->
        <table class="data-table">
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
                <td>Tempat, Tgl Lahir</td>
                <td>:</td>
                <td>{{ ($kObj['tempat_lahir'] ?? '—') . ', ' . ($kObj['tanggal_lahir'] ?? '—') }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $kObj['pekerjaan'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>Alamat Lengkap</td>
                <td>:</td>
                <td>{{ $kObj['alamat'] ?? '—' }}</td>
            </tr>
            <tr>
                <td>RT / RW</td>
                <td>:</td>
                <td>{{ $kObj['rt_rw'] ?? '—' }}</td>
            </tr>
        </table>

        <!-- Body Surat -->
        <div class="letter-body">
            <p>Dengan ini kami menerangkan bahwa orang yang namanya tersebut di atas adalah benar penduduk Desa
                {{ $village['nama_desa'] ?? 'Wonokasian' }} yang berkelakuan baik dan tercatat dalam register
                kependudukan
                kami.
            </p>

            <p>Surat keterangan ini diberikan atas permintaan yang bersangkutan untuk dipergunakan sebagai persyaratan
                administrasi yang sah.</p>

            <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
        </div>

        <!-- Tanda Tangan & QR Code -->
        <div style="margin-top: 20px; width: 100%;">
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

        <!-- Footer Banner -->
        <div class="footer-banner" style="position: absolute; bottom: 0; left: 0; right: 0;">
            Dokumen Resmi Desa {{ $village['nama_desa'] ?? 'Wonokasian' }} - Sistem Informasi Desa
        </div>

    </div>
</body>

</html>