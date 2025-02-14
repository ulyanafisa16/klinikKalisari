<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Laporan Administrasi</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <style>
       body {
           background: white;
           font-family: Arial, sans-serif;
           padding: 20px;
       }
       .report-header {
           margin-bottom: 30px;
           text-align: center;
       }
       .report-header h3 {
           margin-bottom: 10px;
           font-weight: bold;
           color: #333;
       }
       .report-date {
           color: #666;
           font-size: 14px;
           margin-bottom: 20px;
       }
       .table {
           border: 1px solid #dee2e6;
           margin-bottom: 30px;
           width: 100%;
       }
       .table th {
           background-color: #343a40;
           color: white;
           font-weight: 600;
           padding: 12px;
           vertical-align: middle;
       }
       .table td {
           padding: 12px;
           vertical-align: top;
           border-bottom: 2px solid #dee2e6;
       }
       .patient-info {
           margin: 0;
       }
       .info-row {
           display: flex;
           margin-bottom: 5px;
       }
       .info-label {
           font-weight: 600;
           color: #495057;
           width: 100px;
       }
       .info-value {
           color: #212529;
       }
       .medical-info {
           margin-bottom: 8px;
       }
       .medical-info strong {
           color: #495057;
       }
       .status-badge {
           padding: 6px 12px;
           border-radius: 20px;
           font-weight: 500;
           text-transform: uppercase;
           font-size: 12px;
       }
       .status-badge.baru {
           background-color: #cfe2ff;
           color: #084298;
       }
       .status-badge.selesai {
           background-color: #d1e7dd;
           color: #0f5132;
       }
       .price {
           font-weight: 600;
           color: #198754;
       }
   </style>
</head>

<body>
   <div class="container-fluid p-0">
       <div class="report-header">
           <h3>LAPORAN ADMINISTRASI</h3>
           <div class="report-date">
               Periode: {{ request('tanggal_awal') }} - {{ request('tanggal_akhir') }}
           </div>
       </div>

       <div class="table-responsive">
           <table class="table table-bordered">
               <thead>
                   <tr>
                       <th style="width: 5%">ID</th>
                       <th style="width: 35%">Data Pasien</th>
                       <th style="width: 30%">Keluhan & Diagnosa</th>
                       <th style="width: 15%">Biaya</th>
                       <th style="width: 15%">Status</th>
                   </tr>
               </thead>
               <tbody>
                   @foreach ($adm as $item)
                   <tr>
                       <td class="text-center">{{ $item->id }}</td>
                       <td>
                           <div class="info-row">
                               <span class="info-label">Nama:</span>
                               <span class="info-value">{{ $item->pasien->nama_pasien }}</span>
                           </div>
                           <div class="info-row">
                               <span class="info-label">Nomor HP:</span>
                               <span class="info-value">{{ $item->pasien->nomor_hp }}</span>
                           </div>
                           <div class="info-row">
                               <span class="info-label">Tujuan Poli:</span>
                               <span class="info-value">{{ $item->dokter->poli->nama }}</span>
                           </div>
                           <div class="info-row">
                               <span class="info-label">Dokter:</span>
                               <span class="info-value">{{ $item->dokter->nama_dokter }}</span>
                           </div>
                       </td>
                       <td>
                           <div class="medical-info">
                               <strong>Keluhan:</strong> {{ $item->keluhan }}
                           </div>
                           @if($item->diagnosis)
                           <div class="medical-info">
                               <strong>Diagnosa:</strong> {{ $item->diagnosis }}
                           </div>
                           @endif
                       </td>
                       <td class="price">
                           Rp. {{ number_format($item->biaya, 0, ',', '.') }}
                       </td>
                       <td class="text-center">
                           <span class="status-badge {{ $item->status }}">
                               {{ $item->status }}
                           </span>
                       </td>
                   </tr>
                   @endforeach
               </tbody>
           </table>
       </div>
   </div>
</body>
</html>