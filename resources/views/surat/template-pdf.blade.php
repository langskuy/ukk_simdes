<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Surat {{ $surat->jenis_surat }}</title>
    <style>
        /* Base styles - Optimized for single page */
        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 16px 24px;
            padding: 0;
            color: #222;
            font-size: 12px;
            line-height: 1.35;
        }

        /* Header variants */
        .top-band { margin-bottom: 6px; }

        /* Official / Default */
        .header-official { border-bottom: 3px solid #222; padding-bottom: 6px; }
        .header-official .org-name { font-size: 18px; font-weight:700; text-transform:uppercase; margin: 0 0 2px 0; }
        .header-official .org-sub { font-size: 11px; color: #555; margin: 0; }

        /* Religious style */
        .header-religious { border-bottom: 2px solid #4b5563; padding-bottom: 6px; text-align:center; }
        .header-religious .bismillah { font-style: italic; font-size: 16px; color:#1f2937; margin-bottom:4px; }
        .header-religious .org-name { font-size: 18px; font-weight:800; letter-spacing:0.5px; margin: 0; }
        .header-religious .org-sub { font-size: 10px; color: #555; margin: 0; }

        /* Modern style with logo image */
        .header-modern { display:flex; align-items:center; gap:10px; border-bottom:4px solid #0ea5a4; padding:8px 8px; }
        .header-modern .logo { width:60px; height:60px; flex-shrink:0; overflow:hidden; border-radius:4px; }
        .header-modern .logo img { width:100%; height:100%; object-fit:contain; background:#f0f9f9; }
        .header-modern .org { flex:1; }
        .header-modern .org-name { font-family: Arial, Helvetica, sans-serif; font-size:16px; font-weight:800; text-transform:uppercase; margin:0; }
        .header-modern .org-sub { color:#334155; font-size:11px; margin:2px 0 0 0; }
        .header-modern .sim-label { text-align:right; font-size:10px; color:#0ea5a4; font-weight:600; }

        .meta { margin:6px 0; display:flex; justify-content:space-between; align-items:center; }
        .letter-number { font-weight:600; font-size:11px; }
        .title { text-align:center; margin:10px 0 8px 0; font-size:14px; font-weight:700; text-decoration:underline; }

        .data-box { border:1px solid #ddd; background:#f9f9f9; padding:8px; margin-bottom:8px; }
        .data-box .box-title { font-weight:700; margin-bottom:6px; font-size:11px; }
        .data-row { margin-bottom:5px; }
        .data-label { display:inline-block; width:140px; font-weight:600; font-size:11px; }
        .data-value { display:inline-block; font-size:11px; }

        .content { text-align:justify; margin:6px 0; font-size:11px; }
        .content p { margin-bottom:6px; }
        
        .signature-section { margin-top:16px; display:flex; justify-content:space-between; }
        .signature-box { width:40%; text-align:center; font-size:11px; }
        .signature-line { margin-top:40px; border-top:1px solid #000; padding-top:4px; font-weight:600; }

        .footer { margin-top:12px; font-size:9px; color:#666; text-align:center; }
        .note { font-size:10px; color:#555; }

        /* Prevent page breaks in critical sections */
        .data-box, .signature-section, .content { page-break-inside: avoid; }

        /* small responsive adjustments for PDF rendering */
        @media print {
            body { margin: 12mm 16mm; }
        }
    </style>
</head>
<body>
    @php
        // determine style: prefer explicitly provided $style, then a DB field, then keyword mapping, then rotate by id
        $style = $style ?? ($surat->template_style ?? null);
        if (! $style) {
            $jen = strtolower($surat->jenis_surat ?? '');
            if (str_contains($jen, 'usaha') || str_contains($jen, 'izin') || str_contains($jen, 'usaha')) {
                $style = 'modern';
            } elseif (str_contains($jen, 'nikah') || str_contains($jen, 'keagamaan') || str_contains($jen, 'doa')) {
                $style = 'religious';
            } else {
                // fallback: cycle to ensure different look across letters
                $cycle = $surat->id % 3;
                $style = $cycle === 0 ? 'official' : ($cycle === 1 ? 'modern' : 'religious');
            }
        }

        // decode keterangan if it's JSON
        $keteranganObj = null;
        if (! empty($surat->keterangan)) {
            $decoded = json_decode($surat->keterangan, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $keteranganObj = $decoded;
            }
        }

        // Try to get logo as base64
        $logoBase64 = '';
        $logoPath = public_path('images/logo-desa.png');
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }
    @endphp

    {{-- Header variants --}}
    @if ($style === 'religious')
        <div class="top-band header-religious">
            <div class="bismillah">Bismillahirrahmanirrahim</div>
            <div class="org-name">{{ $village->nama_desa ?? 'Desa' }}</div>
            <div class="org-sub">{{ $village->kecamatan ?? '' }} · Kabupaten {{ $village->kabupaten ?? 'Sidoarjo' }} · {{ $village->provinsi ?? 'Jawa Timur' }}</div>
        </div>
    @elseif ($style === 'modern')
        <div class="top-band header-modern">
            <div class="logo">
                @if (!empty($logoBase64))
                    <img src="{{ $logoBase64 }}" alt="Logo Desa" />
                @else
                    <div style="display:flex; align-items:center; justify-content:center; width:60px; height:60px; background:#0ea5a4; color:#fff; font-weight:700; border-radius:4px;">{{ strtoupper(substr(($village->nama_desa ?? 'D'),0,1)) }}</div>
                @endif
            </div>
            <div class="org">
                <div class="org-name">{{ $village->nama_desa ?? 'Desa' }}</div>
                <div class="org-sub">{{ $village->kecamatan ?? '' }} · Kabupaten {{ $village->kabupaten ?? 'Sidoarjo' }}</div>
            </div>
            <div class="sim-label">SIM Desa</div>
        </div>
    @else
        <div class="top-band header-official">
            <div class="org-name">{{ $village->nama_desa ?? 'Desa' }}</div>
            <div class="org-sub">{{ $village->kecamatan ?? '' }} · Kabupaten {{ $village->kabupaten ?? 'Sidoarjo' }} · {{ $village->provinsi ?? 'Jawa Timur' }}</div>
        </div>
    @endif

    <div class="meta">
        <div class="note">Sistem Informasi Manajemen Desa</div>
        <div class="letter-number">Nomor: {{ $surat->id }}/SK/{{ now()->format('m/Y') }}</div>
    </div>

    <div class="title">SURAT KETERANGAN {{ strtoupper($surat->jenis_surat) }}</div>

    <div class="data-box">
        <div class="box-title">DATA PEMOHON</div>
        <div class="data-row"><span class="data-label">Nama</span><span class="data-value">{{ $surat->nama_pemohon ?? '—' }}</span></div>
        <div class="data-row"><span class="data-label">NIK</span><span class="data-value">{{ $surat->nik ?? '—' }}</span></div>
        <div class="data-row"><span class="data-label">No. HP</span><span class="data-value">{{ $surat->no_hp ?? '—' }}</span></div>
        <div class="data-row"><span class="data-label">Tanggal Pengajuan</span><span class="data-value">{{ $surat->created_at?->format('d-m-Y H:i') ?? '—' }}</span></div>
    </div>

    @if ($surat->keterangan)
    <div class="data-box">
        <div class="box-title">KETERANGAN</div>
        @if ($keteranganObj)
            <div>
                @foreach ($keteranganObj as $key => $val)
                    <div style="margin-bottom:4px;"><strong style="font-size:10px;">{{ ucwords(str_replace('_',' ',$key)) }}:</strong> <span style="font-size:11px;">{{ is_array($val) ? json_encode($val) : $val }}</span></div>
                @endforeach
            </div>
        @else
            <div style="white-space: pre-wrap; font-size:11px;">{{ $surat->keterangan }}</div>
        @endif
    </div>
    @endif

    <div class="content">
        <p>
            Dengan rahmat Tuhan Yang Maha Esa, kami menerangkan bahwa orang yang tersebut di atas adalah benar penduduk <strong>{{ $village->nama_desa ?? 'Desa' }}</strong>
            dan berdasarkan data administrasi kependudukan desa, data tersebut adalah sah dan dapat digunakan sebagaimana mestinya.
        </p>

        <p>
            Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya. Semoga mendapat keberkahan.
        </p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <div style="font-weight:600;">Diajukan Oleh</div>
            <div class="signature-line">{{ $surat->nama_pemohon ?? '—' }}</div>
        </div>

        <div class="signature-box">
            <div style="font-weight:600;">Kepala {{ $village->nama_desa ?? 'Desa' }}</div>
            <div class="signature-line">&nbsp;</div>
        </div>
    </div>

    <div class="footer">
        <div>Surat ini digenerate otomatis pada {{ now()->format('d-m-Y H:i:s') }}</div>
        <div style="margin-top:2px;">© {{ $village->nama_desa ?? 'Desa' }} • Sistem Informasi Manajemen Desa</div>
    </div>
</body>
</html>
