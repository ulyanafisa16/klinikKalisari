@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Manajemen Artikel</h5>
            <a href="{{ route('artikel.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Artikel
            </a>
        </div>
        <div class="card-body">
            <!-- Search and Filter -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ route('artikel.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Cari artikel..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-outline-primary">Cari</button>
                    </form>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="kategoriFilter" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter" name="status">
                        <option value="">Semua Status</option>
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>
            </div>

            <!-- Articles Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th width="15%">Thumbnail</th>
                            <th width="25%">Judul</th>
                            <th width="15%">Kategori</th>
                            <th width="10%">Status</th>
                            <th width="10%">Views</th>
                            <th width="10%">Tgl Publikasi</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td class="text-center">
                                @if($article->thumbnail)
                                    <img src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}" 
                                         class="img-thumbnail" style="max-height: 80px">
                                @else
                                    <div class="bg-light text-center p-3">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $article->title }}</strong>
                                <div class="small text-muted">{{ Str::limit($article->ringkasan, 50) }}</div>
                            </td>
                            <td>{{ $article->category->name ?? 'Tidak ada kategori' }}</td>
                            <td>
                                @if($article->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ $article->view_count }}</td>
                            <td>{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('blog.show', $article->slug) }}" class="btn btn-sm btn-info" target="_blank">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="{{ route('artikel.edit', $article->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('artikel.destroy', $article->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">Belum ada artikel</div>
                                <a href="{{ route('artikel.create') }}" class="btn btn-sm btn-primary mt-2">
                                    Tambah Artikel Baru
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $articles->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle filters
    document.getElementById('kategoriFilter').addEventListener('change', function() {
        applyFilters();
    });
    
    document.getElementById('statusFilter').addEventListener('change', function() {
        applyFilters();
    });
    
    function applyFilters() {
        const kategori = document.getElementById('kategoriFilter').value;
        const status = document.getElementById('statusFilter').value;
        const searchParams = new URLSearchParams(window.location.search);
        
        if (kategori) searchParams.set('kategori', kategori);
        else searchParams.delete('kategori');
        
        if (status) searchParams.set('status', status);
        else searchParams.delete('status');
        
        window.location.search = searchParams.toString();
    }
</script>
@endpush
@endsection