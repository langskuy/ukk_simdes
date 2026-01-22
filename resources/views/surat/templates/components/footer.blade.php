<!-- Reusable Footer Component with Signature and QR Code -->
<!-- Usage: @include('surat.templates.components.footer', ['village' => $village, 'qr_code' => $qr_code, 'surat' => $surat]) -->

<style>
    .pdf-footer {
        margin-top: 40px;
    }
    
    .pdf-qr-code {
        text-align: center;
        margin: 20px 0;
    }
    
    .pdf-qr-code img {
        width: 100px;
        height: 100px;
    }
    
    .pdf-signature-section {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        padding-top: 20px;
    }
    
    .pdf-signature-box {
        width: 45%;
        text-align: center;
    }
    
    .pdf-signature-box p {
        font-size: 11px;
        margin: 3px 0;
    }
    
    .pdf-signature-date {
        font-weight: bold;
        margin-bottom: 40px;
    }
    
    .pdf-signature-name {
        border-top: 1px solid #000;
        padding-top: 5px;
        font-weight: bold;
    }
</style>

<div class="pdf-footer">
    <!-- QR Code for Verification -->
    @if($qr_code)
        <div class="pdf-qr-code">
            <img src="{{ $qr_code }}" alt="QR Code Verifikasi">
        </div>
    @endif
    
    <!-- Signature Section -->
    <div class="pdf-signature-section">
        <!-- Pemohon -->
        <div class="pdf-signature-box">
            <p>Diajukan oleh,</p>
            <div class="pdf-signature-date">
                {{ now()->format('d/m/Y') }}
            </div>
            <div class="pdf-signature-name">
                {{ $surat->user->name ?? '(Nama Pemohon)' }}
            </div>
        </div>
        
        <!-- Kepala Desa -->
        <div class="pdf-signature-box">
            <p>Kepala {{ $village['nama_desa'] ?? 'Desa' }},</p>
            <div style="margin-bottom: 40px;"></div>
            <div class="pdf-signature-name">
                (...........................)
            </div>
            <p style="font-size: 9px; margin-top: 5px;">Kepala Desa</p>
        </div>
    </div>
</div>
