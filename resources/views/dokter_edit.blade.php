@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">EDIT DOKTER {{ $dokter->nama_dokter }}</div>
        <div class="card-body">
            <form action="/dokter/{{ $dokter->id }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group mt-1">
                    <label for="nama_dokter">Nama Dokter</label>
                    <input class="form-control" type="text" name="nama_dokter"
                        value="{{ $dokter->nama_dokter ?? old('nama_dokter') }}">
                    <span class="text-danger">{{ $errors->first('nama_dokter') }}</span>
                </div>
                <div class="form-group mt-1">
                    <label for="kampus">Kuliah Dokter</label>
                    <input class="form-control" type="text" name="kampus"
                        value="{{ $dokter->kampus ?? old('kampus') }}">
                    <span class="text-danger">{{ $errors->first('kampus') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="foto">Foto Dokter</label>
                    <input class="form-control" type="file" name="foto" value="{{ old('foto') }}">
                    <span class="text-danger">{{ $errors->first('foto') }}</span>
                </div>
                @if ($dokter->foto)
                    <img src="{{ Storage::url($dokter->foto) }}" width="100px" height="100px" alt="foto dokter">
                @endif
                <div class="form-group mt-3">
                    <label for="poli_id">Poli</label>
                    <select name="poli_id" class="form-control">
                        @foreach ($list_poli as $poli)
                            <option value="{{ $poli->id }}" @selected($dokter->poli_id == $poli->id)>
                                {{ $poli->nama }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger">{{ $errors->first('poli_id') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="nomor_hp">Nomor HP</label>
                    <input class="form-control" type="text" name="nomor_hp"
                        value="{{ $dokter->nomor_hp ?? old('nomor_hp') }}">
                    <span class="text-danger">{{ $errors->first('nomor_hp') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="twitter">Twitter</label>
                    <input class="form-control" type="text" name="twitter"
                        value="{{ $dokter->twitter ?? old('twitter') }}">
                    <span class="text-danger">{{ $errors->first('twitter') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="facebook">Facebook</label>
                    <input class="form-control" type="text" name="facebook"
                        value="{{ $dokter->facebook ?? old('facebook') }}">
                    <span class="text-danger">{{ $errors->first('facebook') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="instagram">Instagram</label>
                    <input class="form-control" type="text" name="instagram"
                        value="{{ $dokter->instagram ?? old('instagram') }}">
                    <span class="text-danger">{{ $errors->first('instagram') }}</span>
                </div>
                <div class="form-group mt-3">
                    <label for="tiktok">Tiktok</label>
                    <input class="form-control" type="text" name="tiktok"
                        value="{{ $dokter->tiktok ?? old('tiktok') }}">
                    <span class="text-danger">{{ $errors->first('tiktok') }}</span>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">UPDATE</button>
                </div>
            </form>
        </div>
    </div>
@endsection
