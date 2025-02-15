<!DOCTYPE html>
<html>
<head>
    <title>Nomor Antrian - {{ $administrasi->pasien->nomor_antrian }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .ticket {
            width: 300px;
            padding: 20px;
            border: 1px solid #000;
            margin: 0 auto;
        }
        .ticket-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .ticket-number {
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .ticket-info {
            margin-bottom: 10px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h2>NOMOR ANTRIAN</h2>
            <p>{{ date('d/m/Y') }}</p>
        </div>
        
        <div class="ticket-number">
            {{ $administrasi->pasien->nomor_antrian }}
        </div>
        
        <div class="ticket-info">
            <p><strong>Nama:</strong> {{ $administrasi->pasien->nama_pasien }}</p>
            <p><strong>Poli:</strong> {{ $administrasi->dokter->poli->nama ?? 'Poli tidak ditemukan' }}</p>
            <p><strong>Dokter:</strong> {{ $administrasi->dokter->nama_dokter }}</p>
        </div>
    </div>
    
    <div class="text-center mt-3 no-print">
        <button onclick="window.print()" class="btn btn-primary">Cetak</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>
    
    <script>
        window.onload = function() {
            // Automatically open print dialog when page loads
            window.print();
        }
    </script>
</body>
</html>