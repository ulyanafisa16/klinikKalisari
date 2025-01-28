@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Ubah Jadwal Dokter {{$jadwal->kode_jadwal}}</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="mb-3">
                    <label for="poli_id" class="form-label">Poli</label>
                    <select class="form-control" id="poli_id" name="poli_id" required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach ($polis as $poli)
                            <option value="{{ $poli->id }}" 
                                {{ $jadwal->poli_id == $poli->id ? 'selected' : '' }}>
                                {{ $poli->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dokter_id" class="form-label">Nama Dokter</label>
                    <select class="form-control" id="dokter_id" name="dokter_id" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach ($dokters as $dokter)
                            <option value="{{ $dokter->id }}"
                                {{ $jadwal->dokter_id == $dokter->id ? 'selected' : '' }}>
                                {{ $dokter->nama_dokter }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="hari" class="form-label">Hari</label>
                    <select class="form-control" id="hari" name="hari" required>
                        <option value="">-- Pilih Hari --</option>
                        <option value="Senin" {{ $jadwal->hari == 'Senin' ? 'selected' : '' }}>Senin</option>
                        <option value="Selasa" {{ $jadwal->hari == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                        <option value="Rabu" {{ $jadwal->hari == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                        <option value="Kamis" {{ $jadwal->hari == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                        <option value="Jumat" {{ $jadwal->hari == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                        <option value="Sabtu" {{ $jadwal->hari == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                        <option value="Minggu" {{ $jadwal->hari == 'Minggu' ? 'selected' : '' }}>Minggu</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jam_mulai" class="form-label">Jam Mulai</label>
                    <input type="time" class="form-control" id="jam_mulai" name="jam_mulai" value="{{ $jadwal->jam_mulai }}" required>
                </div>

                <div class="mb-3">
                    <label for="jam_selesai" class="form-label">Jam Selesai</label>
                    <input type="time" class="form-control" id="jam_selesai" name="jam_selesai" value="{{ $jadwal->jam_selesai }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Jadwal</button>
                <a href="/jadwal" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
@endsection
