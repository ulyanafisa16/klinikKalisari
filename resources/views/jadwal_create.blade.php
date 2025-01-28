@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tambah Jadwal Dokter</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="mb-3">
                    <label for="poli" class="form-label">Poli</label>
                    <select class="form-control" id="poli_id" name="poli_id" required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}">{{ $poli->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dokter" class="form-label">Nama Dokter</label>
                    <select class="form-control" id="dokter_id" name="dokter_id" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}">{{ $dokter->nama_dokter }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <select class="form-control" id="hari" name="hari" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                        <option value="Minggu">Minggu</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" required>
                </div>

                <div class="mb-3">
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                <a href="/jadwal" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
