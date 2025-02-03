@extends('layouts.app')
@section('content')
    <div class="card">
        <div class="card-header">
            Tambah Administrasi
        </div>
        <div class="card-body">
            <form action="{{ route('administrasi.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal') ?? date('Y-m-d') }}">
                    <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                </div>
                {{-- <div class="form-group mt-3">
                    <label for="alamat">NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                    <span class="text-danger">{{ $errors->first('nik') }}</span>
                </div> --}}
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="pasien_id">Pilih Pasien atau <a href="/pasien/create" target="blank">Buat
                                Baru</a></label>
                        <select name="pasien_id" id="pasien_id" class="form-control">
                            @foreach ($list_pasien as $item)
                                <option value="{{ $item->id }}" @selected(old('pasien_id') == $item->id)>
                                    {{ $item->kode_pasien }} - {{ $item->nama_pasien }} - {{ $item->jenis_kelamin }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('pasien_id') }}</span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="poli_id">Pilih Poli Tujuan</label>
                        <select name="poli_id" id="poli_id" class="form-control">
                            {{-- @foreach ($list_poli as $item)
                                <option value="{{ $item->id }}" @selected(old('poli_id') == $item->id)>
                                     {{ $item->nama }} -
                                </option>
                            @endforeach --}}
                        </select>
                        <span class="text-danger">{{ $errors->first('poli_id') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="keluhan">Keluhan</label>
                    <textarea name="keluhan" rows="3" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">SIMPAN</button>
        </div>
    </div>
@endsection
    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
         $(document).ready(function() {
        $('#pasien_id').change(function() {
            var pasienId = $(this).val();
            if (pasienId) {
                $.ajax({
                    url: '/get-poli-by-pasien/' + pasienId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // Clear current options
                        $('#poli_id').empty();
                        
                        // Add the poli from the patient
                        if(response.poli) {
                            $('#poli_id').append(
                                $('<option>', {
                                    value: response.poli.id,
                                    text: response.poli.nama,
                                    selected: true
                                })
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }
        });
    });
        </script>
@endsection
