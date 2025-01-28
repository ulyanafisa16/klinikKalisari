@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Jadwal Dokter</h4>
        </div>
        <div class="card-body">
            <a href="/jadwal/create" class="btn btn-primary mb-2">Tambah Jadwal</a>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kode Jadwal</th>
                            <th>Poli</th>
                            <th>Nama Dokter</th>
                            <th>Hari</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                            <th>Tanggal Buat</th>
                            <th width="18%">Aksi</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        @forelse ($jadwal as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->kode_jadwal }}</td>
                                <td>{{ $item->poli }}</td>
                                <td>{{ $item->kode_dokter }}</td>
                                <td>{{ $item->hari }}</td>
                                <td>{{ $item->jam_mulai }}</td>
                                <td>{{ $item->jam_selesai }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <a href="/jadwal/{{ $item->id }}/edit" class="btn btn-warning btn-sm">
                                        Edit
                                    </a>
                                    <form action="/jadwal/{{ $item->id }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Data tidak ada</td>
                            </tr>
                        @endforelse
                    </tbody> --}}
                </table>
            </div>
        </div>
    </div>
@endsection
