<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Surat Pengantar SKCK</title>
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
            gap: 15px;
            margin-bottom: 2px;
            align-items: center;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
        }

        .logo-image {
            width: 75px;
            height: 75px;
        }

        .logo-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .header-text {
            flex: 1;
            text-align: center;
        }

        .header-title {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-sub {
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header-address {
            font-size: 10pt;
            font-style: italic;
        }

        .letter-title-section {
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .letter-title {
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .letter-number {
            font-size: 11pt;
            margin-top: 2px;
        }

        .intro-text,
        .closing-text {
            text-align: justify;
            text-indent: 30px;
            margin-bottom: 10px;
        }

        .data-table {
            width: 100%;
            margin: 10px 0 10px 30px;
        }

        .data-table td {
            vertical-align: top;
            padding: 2px 0;
        }

        .data-table td:first-child {
            width: 150px;
        }

        .data-table td:nth-child(2) {
            width: 20px;
            text-align: center;
        }

        .signature-section {
            margin-top: 40px;
            float: right;
            width: 40%;
            text-align: center;
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 70px;
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
                <td style="width: 80px;"></td>
            </tr>
        </table>
    </div>

    <div style="margin: 0 40px;">
        <!-- Judul Surat -->
        <div class="letter-title-section" style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
            <div class="letter-title"
                style="font-size: 14pt; font-weight: bold; text-decoration: underline; text-transform: uppercase;">SURAT
                PENGANTAR CATATAN KEPOLISIAN</div>
            <div class="letter-number" style="font-size: 11pt; margin-top: 2px;">Nomor:
                {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/SKCK/{{ now()->format('m/Y') }}
            </div>
        </div>

        <!-- Pembuka -->
        <div class="intro-text" style="text-align: justify; text-indent: 30px; margin-bottom: 10px;">
            Yang bertanda tangan di bawah ini Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan
            {{ $village['kecamatan'] ?? 'Wonoayu' }}, Kabupaten Sidoarjo, menerangkan dengan sebenarnya bahwa:
        </div>

        <!-- Data Pemohon -->
        <table class="data-table" style="width: 100%; margin: 10px 0;">
            <tr>
                <td style="width: 150px;">Nama Lengkap</td>
                <td style="width: 20px; text-align: center;">:</td>
                <td><strong>{{ strtoupper($surat->nama_pemohon ?? '-') }}</strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>:</td>
                <td>{{ $surat->nik ?? '-' }}</td>
            </tr>
            <tr>
                <td>Nomor KK</td>
                <td>:</td>
                <td>{{ $kObj['no_kk'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>{{ $kObj['jenis_kelamin'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tempat/Tgl Lahir</td>
                <td>:</td>
                <td>{{ ($kObj['tempat_lahir'] ?? '-') . ', ' . ($kObj['tanggal_lahir'] ?? '-') }}</td>
            </tr>
            <tr>
                <td>Kewarganegaraan</td>
                <td>:</td>
                <td>{{ $kObj['kewarganegaraan'] ?? 'WNI' }}</td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>{{ $kObj['agama'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td>{{ $kObj['pekerjaan'] ?? '-' }}</td>
            </tr>
            <tr>
                <td>Status Perkawinan</td>
                <td>:</td>
                <td>{{ $kObj['status_perkawinan'] ?? '-' }}</td>
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

        <!-- Isi Utama SKCK -->
        <div class="intro-text" style="text-align: justify; text-indent: 30px; margin-bottom: 10px;">
            Orang tersebut di atas adalah benar-benar warga penduduk Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}
            dan
            sepengetahuan kami selama bermasyarakat berkelakuan <strong>BAIK</strong> serta tidak pernah tersangkut
            perkara
            Pidana.
        </div>

        <div class="intro-text" style="text-align: justify; text-indent: 30px; margin-bottom: 10px;">
            Surat Pengantar ini diberikan kepada yang bersangkutan untuk keperluan:
        </div>

        <div style="margin: 10px 0 10px 30px; font-weight: bold; text-transform: uppercase;">
            {{ $kObj['keperluan'] ?? $kObj['detail_permintaan'] ?? 'PENGURUSAN SKCK' }}
        </div>

        <div class="intro-text" style="text-align: justify; text-indent: 30px; margin-bottom: 10px;">
            Demikian Surat Pengantar ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
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

    </div>
</body>

</html>