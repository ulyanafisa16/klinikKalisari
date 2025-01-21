@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ $judul }}</div>
        <div class="card-body">
            <form action="/pasien/{{ $pasien->id }}" method="POST">
                @method('PUT')
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="nama_pasien">Nama Pasien</label>
                        <input type="text" name="nama_pasien" class="form-control"
                            value="{{ old('nama_pasien') ?? $pasien->nama_pasien }}" autofocus />
                        <span class="text-danger">{{ $errors->first('nama_pasien') }}</span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="nomor_hp">Nomor HP</label>
                        <input type="text" name="nomor_hp" class="form-control"
                            value="{{ old('nomor_hp') ?? $pasien->nomor_hp }}" />
                        <span class="text-danger">{{ $errors->first('nomor_hp') }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <div class="form-check">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-check-input"
                                id="lk" {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                            <label class="form-check-label" for="lk">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" class="form-check-input"
                                id="pr" {{ $pasien->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                            <label class="form-check-label" for="pr">
                                Perempuan
                            </label>
                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                            value="{{ old('tanggal_lahir') ?? $pasien->tanggal_lahir }}" required />
                        <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6 form-group">
                        <label for="nik">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') ?? $pasien->nik }}" required />
                        <span class="text-danger">{{ $errors->first('nik') }}</span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="dokter_id">Dokter</label>
                        <select name="dokter_id" class="form-control" required>
                            <option value="">Pilih Dokter</option>
                            @foreach($dokter as $item)
                                <option value="{{ $item->id }}" {{ $pasien->dokter_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_dokter }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{ $errors->first('dokter_id') }}</span>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" rows="3" class="form-control">{{ old('alamat') ?? $pasien->alamat }}</textarea>
                    <span class="text-danger">{{ $errors->first('alamat') }}</span>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="/pasien" class="btn btn-dark">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
