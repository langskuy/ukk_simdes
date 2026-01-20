<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan - {{ $village['nama_desa'] ?? 'Wonokasian' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { size: A4; margin: 1.5cm 1.5cm; }
        body { font-family: 'Times New Roman', Times, serif; color: #000; line-height: 1.4; font-size: 11pt; }
        
        /* Layout Utilities */
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .text-uppercase { text-transform: uppercase; }
        .text-underline { text-decoration: underline; }
        .text-justify { text-align: justify; }
        .mb-1 { margin-bottom: 2px; }
        .mb-2 { margin-bottom: 5px; }
        .mb-3 { margin-bottom: 10px; }
        .mb-4 { margin-bottom: 15px; }
        .mt-4 { margin-top: 20px; }

        /* Header */
        .header-section { display: flex; gap: 10px; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header-text { flex: 1; text-align: center; }
        
        /* Tables */
        .data-table { width: 100%; margin: 5px 0; font-size: 10pt; }
        .data-table td { padding: 2px 0; vertical-align: top; }
        .data-table td:first-child { width: 160px; } /* Label width */
        .data-table td:nth-child(2) { width: 20px; text-align: center; } /* Separator */
        
        /* Sections */
        .section-title { 
            font-weight: bold; text-transform: uppercase; margin-top: 10px; margin-bottom: 5px; 
            border-bottom: 1px dotted #999; font-size: 10pt; 
        }
        
        /* Footer Banner */
        .footer-banner { 
            position: absolute; bottom: 0; left: 0; right: 0; 
            padding: 5px; color: white; font-size: 8pt; text-align: center; font-weight: bold; 
        }

        /* Specific Colors per Type */
        .bg-usaha { background: #228b22; }
        .bg-skck { background: #333; }
        .bg-kelahiran { background: #ff69b4; }
        .bg-domisili { background: #3366cc; }
        .bg-pindah { background: #663399; }
        .bg-tidak_mampu { background: #d9534f; }
        .bg-default { background: #555; }
    </style>
</head>
<body>

@php
    // Determine Type Properties
    $type = strtolower($surat->jenis_surat);
    $title = 'SURAT KETERANGAN';
    $code = 'KET';
    $footerClass = 'bg-default';
    
    // Normalization map
    if (str_contains($type, 'usaha')) { 
        $type = 'usaha'; $title = 'SURAT KETERANGAN USAHA'; $code = 'USH'; $footerClass = 'bg-usaha';
    } elseif (str_contains($type, 'skck') || str_contains($type, 'catatan kepolisian')) { 
        $type = 'skck'; $title = 'SURAT PENGANTAR CATATAN KEPOLISIAN'; $code = 'SKCK'; $footerClass = 'bg-skck';
    } elseif (str_contains($type, 'kelahiran')) { 
        $type = 'kelahiran'; $title = 'SURAT KETERANGAN KELAHIRAN'; $code = 'KLH'; $footerClass = 'bg-kelahiran';
    } elseif (str_contains($type, 'domisili')) { 
        $type = 'domisili'; $title = 'SURAT KETERANGAN DOMISILI'; $code = 'DOM'; $footerClass = 'bg-domisili';
    } elseif (str_contains($type, 'pindah')) { 
        $type = 'pindah'; $title = 'SURAT KETERANGAN PINDAH / DATANG'; $code = 'PINDAH'; $footerClass = 'bg-pindah';
    } elseif (str_contains($type, 'tidak mampu')) { 
        $type = 'tidak_mampu'; $title = 'SURAT KETERANGAN TIDAK MAMPU'; $code = 'TM'; $footerClass = 'bg-tidak_mampu';
    }
@endphp

<!-- Header -->
<div class="header-section">
    <table style="width: 100%;">
        <tr>
            <td style="width: 80px;">
                @if(!empty($logo_base64))
                    <img src="{{ $logo_base64 }}" style="width: 70px; height: auto;" />
                @endif
            </td>
            <td class="text-center">
                <div style="font-size: 14pt; font-weight: bold;">PEMERINTAH KABUPATEN SIDOARJO</div>
                <div style="font-size: 16pt; font-weight: bold;">DESA {{ strtoupper($village['nama_desa'] ?? 'WONOKASIAN') }}</div>
                <div style="font-size: 12pt; font-weight: bold;">KECAMATAN {{ strtoupper($village['kecamatan'] ?? 'WONOAYU') }}</div>
                <div style="font-size: 10pt; font-style: italic;">Jl. Desa No. 1 • Telepon: (0331) 123-4567 • Kode Pos: 61261</div>
            </td>
            <td style="width: 80px;"></td>
        </tr>
    </table>
</div>

<div style="margin: 0 40px;">

    <!-- Title & Number -->
    <div class="text-center mb-4">
        <div class="text-bold text-underline text-uppercase" style="font-size: 13pt;">{{ $title }}</div>
        <div style="font-size: 11pt; border-top: 2px solid #000; display: inline-block; min-width: 250px;">
            Nomor: {{ str_pad($surat->id, 6, '0', STR_PAD_LEFT) }}/{{ $code }}/{{ now()->format('m/Y') }}
        </div>
    </div>

    <!-- Intro -->
    <div class="text-justify mb-2">
        Yang bertanda tangan di bawah ini Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}, Kecamatan {{ $village['kecamatan'] ?? 'Wonoayu' }}, menerangkan bahwa:
    </div>

    <!-- MAIN CONTENT SWITCH -->
    @switch($type)
        
        @case('kelahiran')
            <!-- === KELAHIRAN: DATA ANAK FIRST === -->
            <div class="section-title">I. DATA ANAK</div>
            <table class="data-table">
                <tr><td>Nama Anak</td><td>:</td><td><strong>{{ strtoupper($kObj['nama_anak'] ?? '-') }}</strong></td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td>{{ ucfirst($kObj['jenis_kelamin_anak'] ?? '-') }}</td></tr>
                <tr><td>Tempat/Tgl Lahir</td><td>:</td><td>{{ ($kObj['tempat_lahir_anak'] ?? '-') . ', ' . ($kObj['tanggal_lahir_anak'] ? \Carbon\Carbon::parse($kObj['tanggal_lahir_anak'])->locale('id')->isoFormat('D MMMM Y') : '-') }}</td></tr>
                <tr><td>Waktu Lahir</td><td>:</td><td>{{ $kObj['waktu_lahir'] ?? '-' }} WIB</td></tr>
                <tr><td>Anak Ke</td><td>:</td><td>{{ $kObj['anak_ke'] ?? '-' }}</td></tr>
            </table>

            <div class="section-title">II. DATA ORANG TUA</div>
            <table class="data-table">
                <tr><td colspan="3" style="font-style: italic;">Ayah:</td></tr>
                <tr><td>Nama</td><td>:</td><td>{{ strtoupper($kObj['nama_ayah'] ?? '-') }}</td></tr>
                <tr><td>NIK</td><td>:</td><td>{{ $kObj['nik_ayah'] ?? '-' }}</td></tr>
                <tr><td colspan="3" style="font-style: italic; padding-top:5px;">Ibu:</td></tr>
                <tr><td>Nama</td><td>:</td><td>{{ strtoupper($kObj['nama_ibu'] ?? '-') }}</td></tr>
                <tr><td>NIK</td><td>:</td><td>{{ $kObj['nik_ibu'] ?? '-' }}</td></tr>
            </table>
            
            <div class="text-justify mt-4">
                Dengan ini menerangkan bahwa anak tersebut di atas telah dilahirkan dari pasangan suami-istri yang sah di wilayah kami.
            </div>
            @break

        @case('usaha')
            <!-- === USAHA === -->
            <div class="section-title">I. DATA PEMOHON</div>
            <table class="data-table">
                <tr><td>Nama Lengkap</td><td>:</td><td><strong>{{ strtoupper($surat->nama_pemohon ?? '-') }}</strong></td></tr>
                <tr><td>NIK</td><td>:</td><td>{{ $surat->nik ?? '-' }}</td></tr>
                <tr><td>Alamat</td><td>:</td><td>{{ $kObj['alamat'] ?? '-' }}</td></tr>
            </table>

            <div class="section-title">II. INFORMASI USAHA</div>
            <table class="data-table">
                <tr><td>Nama Usaha</td><td>:</td><td><strong>{{ strtoupper($kObj['nama_usaha'] ?? '-') }}</strong></td></tr>
                <tr><td>Jenis Usaha</td><td>:</td><td>{{ $kObj['jenis_usaha'] ?? '-' }}</td></tr>
                <tr><td>Alamat Usaha</td><td>:</td><td>{{ $kObj['alamat_usaha'] ?? '-' }}</td></tr>
                <tr><td>Lama Usaha</td><td>:</td><td>{{ $kObj['lama_usaha'] ?? '-' }}</td></tr>
                @if(!empty($kObj['modal_usaha']))
                    <tr><td>Modal Usaha</td><td>:</td><td>{{ $kObj['modal_usaha'] }}</td></tr>
                @endif
            </table>

            <div class="text-justify mt-4">
                Benar bahwa yang bersangkutan memiliki usaha tersebut di wilayah Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}.
                Surat ini diberikan untuk keperluan administrasi/perizinan.
            </div>
            @break

        @default
            <!-- === STANDARD (DOMISILI, SKCK, PINDAH, TIDAK MAMPU, ETC) === -->
            
            <div class="section-title">I. DATA PEMOHON</div>
            <table class="data-table">
                <tr><td>Nama Lengkap</td><td>:</td><td><strong>{{ strtoupper($surat->nama_pemohon ?? '-') }}</strong></td></tr>
                <tr><td>NIK</td><td>:</td><td>{{ $surat->nik ?? '-' }}</td></tr>
                <tr><td>No KK</td><td>:</td><td>{{ $kObj['no_kk'] ?? '-' }}</td></tr>
                <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $kObj['jenis_kelamin'] ?? '-' }}</td></tr>
                <tr><td>Tempat/Tgl Lahir</td><td>:</td><td>{{ ($kObj['tempat_lahir'] ?? '-') . ', ' . ($kObj['tanggal_lahir'] ?? '-') }}</td></tr>
                <tr><td>Pekerjaan</td><td>:</td><td>{{ $kObj['pekerjaan'] ?? '-' }}</td></tr>
                <tr><td>Alamat</td><td>:</td><td>{{ $kObj['alamat'] ?? '-' }}</td></tr>
                
                @if($type == 'pindah')
                    <tr><td>Alamat Tujuan</td><td>:</td><td>{{ $kObj['alamat_tujuan'] ?? '-' }}</td></tr>
                    <tr><td>Anggota Pindah</td><td>:</td><td>{{ ($kObj['jumlah_pengikut'] ?? 0) + 1 }} Orang</td></tr>
                @endif
                
                @if($type == 'domisili')
                    <tr><td>Alamat Domisili</td><td>:</td><td>{{ $kObj['alamat_domisili'] ?? '-' }}</td></tr>
                @endif
            </table>

            <!-- EXTRA SECTIONS PER TYPE -->
            @if($type == 'pindah' && !empty($kObj['daftar_pengikut']))
                <div class="section-title">II. DAFTAR PENGIKUT</div>
                <div style="margin-left: 10px;">{!! nl2br(e($kObj['daftar_pengikut'])) !!}</div>
            @endif

            @if($type == 'tidak_mampu')
                @if(!empty($kObj['data_keluarga']))
                    <div class="section-title">II. ANGGOTA KELUARGA</div>
                    <div style="margin-left: 10px;">{!! nl2br(e($kObj['data_keluarga'])) !!}</div>
                @endif
                <div class="text-justify mt-4">
                    Keluarga tersebut adalah benar penduduk kami yang tergolong <strong>KURANG MAMPU</strong>.
                    Surat ini digunakan untuk persyaratan bantuan/beasiswa.
                </div>
            @elseif($type == 'skck')
                <div class="text-justify mt-4">
                    Orang tersebut adalah warga kami yang berkelakuan <strong>BAIK</strong> dan tidak pernah tersangkut perkara pidana.
                    Surat ini diberikan untuk keperluan: <strong>{{ strtoupper($kObj['keperluan'] ?? 'PENGURUSAN SKCK') }}</strong>.
                </div>
            @elseif($type == 'domisili')
                <div class="text-justify mt-4">
                    Benar berdomisili di wilayah kami. Surat ini berlaku 6 bulan sejak diterbitkan.
                </div>
            @elseif($type == 'pindah')
                <div class="text-justify mt-4">
                    Benar akan melakukan perpindahan penduduk sesuai data di atas.
                </div>
            @endif

    @endswitch

    <!-- Closing -->
    <div class="text-justify mt-4">
        Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.
    </div>

    <!-- Signature -->
    <div style="margin-top: 30px; page-break-inside: avoid;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;"></td>
                <td style="width: 50%; text-align: center;">
                    <div class="mb-1">{{ $village['nama_desa'] ?? 'Wonokasian' }}, {{ now()->locale('id')->isoFormat('D MMMM Y') }}</div>
                    <div class="text-bold mb-3">Kepala Desa {{ $village['nama_desa'] ?? 'Wonokasian' }}</div>
                    
                    <!-- QR Code (SVG) -->
                    <div style="margin: 10px 0;">
                        <img src="{{ $qr_code }}" style="width: 85px; height: 85px;" />
                    </div>

                    <div style="font-size: 8pt; color: #155724; font-weight: bold; font-style: italic;">[Tanda Tangan Elektronik]</div>
                    <div class="text-bold text-underline">{{ strtoupper($village['nama_kades'] ?? '( __________________________ )') }}</div>
                    @if(!empty($village['nip_kades']))
                        <div style="font-size: 10pt;">NIP. {{ $village['nip_kades'] }}</div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</div>

<!-- Dynamic Footer Banner -->
<div class="footer-banner {{ $footerClass }}">
    Dokumen Resmi Desa {{ $village['nama_desa'] ?? 'Wonokasian' }} - {{ $title }}
</div>

</body>
</html>
