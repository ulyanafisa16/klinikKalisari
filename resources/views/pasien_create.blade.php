@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ $judul }}</div>
        <div class="card-body">
            <form action="/pasien" method="POST">
                @method('POST')
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 form-group ">
                        <label for="nama_pasien">Nama Pasien</label>
                        <input type="text" name="nama_pasien" class="form-control" value="{{ old('nama_pasien') }}"
                            autofocus />
                        <span class="text-danger">{{ $errors->first('nama_pasien') }}</span>
                    </div>
                    <div class="col-md-6 form-group ">
                        <label for="nomor_hp">Nomor HP</label>
                        <input type="text" name="nomor_hp" class="form-control" value="{{ old('nomor_hp') }}"
                            autofocus />
                        <span class="text-danger">{{ $errors->first('nomor_hp') }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="jj">Jenis Kelamin</label>
                        <div class="form-check ml-3">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-check-input"
                                id="lk" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
                            <label class="form-check-label" for="lk">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check ml-3">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" class="form-check-input"
                                id="pr" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pr">
                                Perempuan
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <label for="alamat">NIK</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                    <span class="text-danger">{{ $errors->first('nik') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="tanggal_lahir">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" 
                           class="form-control" 
                           value="{{ old('tanggal_lahir') }}" 
                           required>
                    <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="poli_id">Poli</label>
                    <select name="poli_id" class="form-control" required >
                        <option value="">Pilih Poli</option>
                        @foreach($poli as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('poli_id') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="dokter_id">Dokter</label>
                    <select name="dokter_id" class="form-control" required>
                        <option value="">Pilih Dokter</option>
                        {{-- @foreach($dokter as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_dokter }}</option>
                        @endforeach --}}
                    </select>
                    <span class="text-danger">{{ $errors->first('dokter_id') }}</span>
                </div>
                
                <div class="form-group mt-3">
                    <label for="jadwal_id">Jadwal</label>
                    <select name="jadwal_id" class="form-control" required>
                        <option value="">Pilih Jadwal</option>
                        {{-- @foreach($jadwals as $item)
                            <option value="{{ $item->id }}">{{ $item->tanggal }} - {{ $item->jam_mulai }} s/d {{ $item->jam_selesai }}</option>
                        @endforeach --}}
                    </select>
                    <span class="text-danger">{{ $errors->first('jadwal_id') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="jam_kunjungan">Jam Kunjungan</label>
                    <input type="time" name="jam_kunjungan" class="form-control" value="{{ old('jam_kunjungan') }}" />
                    <span class="text-danger">{{ $errors->first('jam_kunjungan') }}</span>
                </div>

                <div class="form-group mt-3">
                    <label for="tipe_pemeriksaan">Tipe Pemeriksaan</label>
                    <select name="tipe_pemeriksaan" class="form-control" required>
                        <option value="Klinik" {{ old('tipe_pemeriksaan') == 'Klinik' ? 'selected' : '' }}>Klinik</option>
                        <option value="Homecare" {{ old('tipe_pemeriksaan') == 'Homecare' ? 'selected' : '' }}>Homecare</option>
                    </select>
                    <span class="text-danger">{{ $errors->first('tipe_pemeriksaan') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') }}</textarea>
                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const poliSelect = document.querySelector('select[name="poli_id"]');
    const dokterSelect = document.querySelector('select[name="dokter_id"]');
    const jadwalSelect = document.querySelector('select[name="jadwal_id"]');

    // Reset dropdown yang tergantung
    function resetDokter() {
        dokterSelect.innerHTML = '<option value="">Pilih Dokter</option>';
        resetJadwal();
    }

    function resetJadwal() {
        jadwalSelect.innerHTML = '<option value="">Pilih Jadwal</option>';
    }

    // Menangani pemilihan Poli
    poliSelect.addEventListener('change', function() {
        const poliId = this.value;
        resetDokter();

        if (!poliId) return;

        fetch(`/getDokterByPoli/${poliId}`)
            .then(response => response.json())
            .then(data => {
                data.dokters.forEach(dokter => {
                    const option = document.createElement('option');
                    option.value = dokter.id;
                    option.textContent = dokter.nama_dokter;
                    dokterSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });

    // Menangani pemilihan Dokter
    dokterSelect.addEventListener('change', function() {
        const dokterId = this.value;
        resetJadwal();

        if (!dokterId) return;

        fetch(`/getJadwalByDokter/${dokterId}`)
            .then(response => response.json())
            .then(data => {
                data.jadwals.forEach(jadwal => {
                    const option = document.createElement('option');
                    option.value = jadwal.id;
                    // Format tanggal dengan baik
                    option.textContent = `${jadwal.hari} - ${jadwal.jam_mulai} s/d ${jadwal.jam_selesai}`;
                jadwalSelect.appendChild(option);
                    });
                    option.textContent = `${tanggal} - ${jadwal.jam_mulai} s/d ${jadwal.jam_selesai}`;
                    jadwalSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });

    // Reset field yang tergantung pada saat halaman dimuat
    resetDokter();
</script>
@endsection