<!-- Common Styles for All Surat Templates -->

<style>
    /* ========== BASE STYLES ========== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    @page {
        size: A4;
        margin: 2cm 2cm;
    }
    
    html, body {
        width: 100%;
    }
    
    body {
        font-family: 'Times New Roman', Times, serif;
        font-size: 12px;
        line-height: 1.5;
        color: #000;
        background: #fff;
    }
    
    /* ========== CONTAINER ========== */
    .pdf-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0;
    }
    
    /* ========== TYPOGRAPHY ========== */
    h1, h2, h3, h4, h5, h6 {
        margin: 0;
        font-weight: bold;
    }
    
    h1 { font-size: 18px; }
    h2 { font-size: 16px; }
    h3 { font-size: 14px; }
    h4 { font-size: 12px; }
    h5 { font-size: 11px; }
    h6 { font-size: 10px; }
    
    p {
        margin: 0 0 10px 0;
        line-height: 1.6;
        text-align: justify;
    }
    
    /* ========== SPACING UTILITIES ========== */
    .mt-1 { margin-top: 5px; }
    .mt-2 { margin-top: 10px; }
    .mt-3 { margin-top: 15px; }
    .mt-4 { margin-top: 20px; }
    
    .mb-1 { margin-bottom: 5px; }
    .mb-2 { margin-bottom: 10px; }
    .mb-3 { margin-bottom: 15px; }
    .mb-4 { margin-bottom: 20px; }
    
    .p-1 { padding: 5px; }
    .p-2 { padding: 10px; }
    .p-3 { padding: 15px; }
    .p-4 { padding: 20px; }
    
    /* ========== TEXT ALIGNMENT ========== */
    .text-left { text-align: left; }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-justify { text-align: justify; }
    
    /* ========== TEXT STYLING ========== */
    .text-bold { font-weight: bold; }
    .text-italic { font-style: italic; }
    .text-underline { text-decoration: underline; }
    .text-uppercase { text-transform: uppercase; }
    .text-lowercase { text-transform: lowercase; }
    
    .text-muted { color: #666; }
    .text-dark { color: #333; }
    .text-light { color: #999; }
    
    /* ========== BORDERS ========== */
    .border { border: 1px solid #000; }
    .border-top { border-top: 1px solid #000; }
    .border-bottom { border-bottom: 1px solid #000; }
    .border-dashed { border: 1px dashed #ccc; }
    .border-dotted { border: 1px dotted #999; }
    
    /* ========== DIVIDER ========== */
    hr {
        border: 0;
        border-top: 1px solid #000;
        margin: 10px 0;
    }
    
    /* ========== TABLES ========== */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
    }
    
    table td, table th {
        padding: 6px;
        border: 1px solid #ddd;
        vertical-align: top;
    }
    
    table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    
    /* ========== IMAGES ========== */
    img {
        max-width: 100%;
        height: auto;
    }
    
    /* ========== PAGE BREAKS ========== */
    .page-break {
        page-break-after: always;
        margin-bottom: 20px;
    }
    
    .page-break-before {
        page-break-before: always;
        margin-top: 20px;
    }
    
    /* ========== COLORS ========== */
    .bg-primary { background-color: #007bff; color: #fff; }
    .bg-success { background-color: #28a745; color: #fff; }
    .bg-danger { background-color: #dc3545; color: #fff; }
    .bg-warning { background-color: #ffc107; color: #000; }
    .bg-info { background-color: #17a2b8; color: #fff; }
    .bg-light { background-color: #f8f9fa; }
    .bg-dark { background-color: #343a40; color: #fff; }
    
    /* ========== SPECIAL ELEMENTS ========== */
    .badge {
        display: inline-block;
        padding: 3px 6px;
        border-radius: 3px;
        font-size: 10px;
        font-weight: bold;
    }
    
    .badge-primary { background-color: #007bff; color: #fff; }
    .badge-success { background-color: #28a745; color: #fff; }
    .badge-danger { background-color: #dc3545; color: #fff; }
    
    /* ========== PRINT OPTIMIZATION ========== */
    @media print {
        body {
            margin: 0;
            padding: 0;
        }
        
        .no-print {
            display: none !important;
        }
        
        page-break-inside {
            avoid;
        }
    }
</style>
