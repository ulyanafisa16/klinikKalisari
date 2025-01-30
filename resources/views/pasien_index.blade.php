@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ $judul }}
        </div>
        <div class="card-body">
            <a href="/pasien/create" class="btn btn-primary mb-2">Tambah Pasien</a>
            <div class="row mb-2">
                <div class="col">
                    <form method="GET">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari data pasien"
                                value="{{ request('q') }}">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">Cari</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Dokter</th>
                            <th>Nama</th>
                            <th>Nik</th>
                            <th>Jenis Kelamin</th>
                            <th>Tanggal lahir</th>
                            <th>Nomor HP</th>
                            <th>Alamat</th>
                            <th>No Antrian</th>
                            <th>Tanggal Buat</th>
                            <th width="18%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasien as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->kode_pasien }}</td>
                                <td>{{ $item->dokter->nama_dokter ?? 'Tidak ada dokter' }}</td>
                                <td>{{ $item->nama_pasien }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ $item->jenis_kelamin }}</td>
                                <td>{{ $item->tanggal_lahir }}</td>
                                <td>{{ $item->nomor_hp }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>{{ $item->nomor_antrian }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="/pasien/{{ $item->id }}/edit" class="btn btn-primary">
                                        Edit
                                    </a>
                                    <form action="/pasien/{{ $item->id }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Data tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
