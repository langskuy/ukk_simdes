<!-- QR Code Component -->
<!-- Usage: @include('surat.templates.components.qr-code', ['qr_code' => $qr_code]) -->

<style>
    .pdf-qr-container {
        display: flex;
        justify-content: center;
        margin: 20px 0;
        padding: 10px 0;
        border-top: 1px dashed #ccc;
        border-bottom: 1px dashed #ccc;
    }
    
    .pdf-qr-wrapper {
        text-align: center;
    }
    
    .pdf-qr-wrapper p {
        font-size: 9px;
        color: #666;
        margin: 5px 0;
    }
    
    .pdf-qr-image {
        width: 100px;
        height: 100px;
    }
    
    .pdf-qr-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
</style>

@if($qr_code)
    <div class="pdf-qr-container">
        <div class="pdf-qr-wrapper">
            <p>Scan untuk verifikasi:</p>
            <div class="pdf-qr-image">
                <img src="{{ $qr_code }}" alt="QR Code Verifikasi">
            </div>
            <p style="font-size: 8px; color: #999;">Kode verifikasi otomatis</p>
        </div>
    </div>
@endif
