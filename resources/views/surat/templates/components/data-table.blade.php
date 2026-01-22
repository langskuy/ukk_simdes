<!-- Reusable Data Table Component -->
<!-- Usage: @include('surat.templates.components.data-table', ['data' => ['Label' => 'value', ...], 'title' => 'optional']) -->

<style>
    .pdf-data-section {
        margin: 15px 0;
    }
    
    .pdf-data-title {
        font-weight: bold;
        font-size: 12px;
        margin-bottom: 8px;
        border-bottom: 1px solid #999;
        padding-bottom: 3px;
    }
    
    .pdf-data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        margin: 10px 0;
    }
    
    .pdf-data-table tr {
        border-bottom: 1px solid #e0e0e0;
    }
    
    .pdf-data-table td {
        padding: 6px 8px;
        vertical-align: top;
    }
    
    .pdf-data-table td:first-child {
        width: 35%;
        font-weight: bold;
        background-color: #f9f9f9;
    }
    
    .pdf-data-table td:nth-child(2) {
        width: 20px;
        text-align: center;
    }
</style>

<div class="pdf-data-section">
    @if(!empty($title))
        <div class="pdf-data-title">{{ $title }}</div>
    @endif
    
    <table class="pdf-data-table">
        @foreach($data as $label => $value)
            @if($value !== null && $value !== '')
                <tr>
                    <td>{{ $label }}</td>
                    <td>:</td>
                    <td>{{ $value ?? '—' }}</td>
                </tr>
            @endif
        @endforeach
    </table>
</div>
