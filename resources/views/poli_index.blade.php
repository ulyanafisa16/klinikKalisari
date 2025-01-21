@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <a href="/poli/create" class="btn btn-primary mb-3">Tambah Data</a>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th width="1%">ID</th>
                        <th>Nama Poli</th>
                        <th width="16%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($poli as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <div>Nama Poli: <b>{{ $item->nama }}</b></div>
                                <div>Deskripsi: {{ $item->deskripsi }}</div>
                            </td>
                            <td class="text-center">
                                <a href="/poli/{{ $item->id }}/edit" class="btn btn-primary btn-sm">Edit</a>
                                <form action="/poli/{{ $item->id }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
