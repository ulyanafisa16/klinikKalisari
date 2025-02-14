@extends('layouts.medilab')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        PENDAFTARAN PASIEN
                    </div>
                    <div class="card-body">
                        <form action="{{ route('registrasipasien.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6 form-group">
                                    <label for="nama_pasien">Nama Pasien</label>
                                    <input type="text" name="nama_pasien" class="form-control" 
                                        value="{{ old('nama_pasien') }}" autofocus required/>
                                    <span class="text-danger">{{ $errors->first('nama_pasien') }}</span>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="nomor_hp">Nomor HP</label>
                                    <input type="text" name="nomor_hp" class="form-control" 
                                        value="{{ old('nomor_hp') }}" required/>
                                    <span class="text-danger">{{ $errors->first('nomor_hp') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <div class="form-check ml-3">
                                        <input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-check-input"
                                            id="lk" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="lk">Laki-laki</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input type="radio" name="jenis_kelamin" value="Perempuan" class="form-check-input"
                                            id="pr" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="pr">Perempuan</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="nik">NIK</label>
                                <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                                <span class="text-danger">{{ $errors->first('nik') }}</span>
                            </div>

                            <div class="form-group mt-3">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" 
                                    value="{{ old('tanggal_lahir') }}" required>
                                <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                            </div>

                            <div class="form-group mt-3">
                                <label for="tanggal">Rencana Tanggal Berobat</label>
                                <input type="date" name="tanggal" class="form-control" 
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                <span class="text-danger">{{ $errors->first('tanggal') }}</span>
                            </div>

                            <div class="form-group mt-3">
                                <label for="poli_id">Poli</label>
                                <select name="poli_id" id="poli_id" class="form-control" required>
                                    <option value="">Pilih Poli</option>
                                    @foreach($poli as $item)
                                        <option value="{{ $item->id }}" {{ old('poli_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="dokter_id">Dokter</label>
                                <select name="dokter_id" id="dokter_id" class="form-control" required>
                                    <option value="">Pilih Dokter</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="jadwal_id">Jadwal</label>
                                <select name="jadwal_id" id="jadwal_id" class="form-control" required>
                                    <option value="">Pilih Jadwal</option>
                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="jam_kunjungan">Jam Kunjungan</label>
                                <input type="time" name="jam_kunjungan" class="form-control" 
                                    value="{{ old('jam_kunjungan') }}" required>
                                <span class="text-danger">{{ $errors->first('jam_kunjungan') }}</span>
                            </div>
                            <div class="form-group mt-3">
                                <label for="keluhan">Keluhan Pasien</label>
                                <textarea name="keluhan" class="form-control" rows="3">{{ old('keluhan') }}</textarea>
                                <span class="text-danger">{{ $errors->first('keluhan') }}</span>
                            </div>

                            <div class="form-group mt-3">
                                <label for="tipe_pemeriksaan">Tipe Pemeriksaan</label>
                                <select name="tipe_pemeriksaan" class="form-control" required>
                                    <option value="Klinik" {{ old('tipe_pemeriksaan') == 'Klinik' ? 'selected' : '' }}>Klinik</option>
                                    <option value="Homecare" {{ old('tipe_pemeriksaan') == 'Homecare' ? 'selected' : '' }}>Homecare</option>
                                </select>
                            </div>

                            <div class="form-group mt-3">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" rows="3" class="form-control" required>{{ old('alamat') }}</textarea>
                            </div>

                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-primary">DAFTAR</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const poliSelect = document.getElementById('poli_id');
    const dokterSelect = document.getElementById('dokter_id');
    const jadwalSelect = document.getElementById('jadwal_id');

    function resetDropdown(select, placeholder) {
        select.innerHTML = `<option value="">${placeholder}</option>`;
    }

    poliSelect.addEventListener('change', function() {
        const poliId = this.value;
        resetDropdown(dokterSelect, "Pilih Dokter");
        resetDropdown(jadwalSelect, "Pilih Jadwal");

        if (!poliId) return;

        fetch(`/getDokterByPoli/${poliId}`)
            .then(response => response.json())
            .then(data => {
                data.dokters.forEach(dokter => {
                    let option = new Option(dokter.nama_dokter, dokter.id);
                    dokterSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });

    dokterSelect.addEventListener('change', function() {
        const dokterId = this.value;
        resetDropdown(jadwalSelect, "Pilih Jadwal");

        if (!dokterId) return;

        fetch(`/getJadwalByDokter/${dokterId}`)
            .then(response => response.json())
            .then(data => {
                data.jadwals.forEach(jadwal => {
                    let option = new Option(`${jadwal.hari} - ${jadwal.jam_mulai} s/d ${jadwal.jam_selesai}`, jadwal.id);
                    jadwalSelect.add(option);
                });
            })
            .catch(error => console.error('Error:', error));
    });
});
</script>
@endsection
