@extends('layouts.app')

@section('styles')
<!-- Include CSS for TinyMCE or other WYSIWYG editor -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.css" rel="stylesheet">
<style>
    .trix-content {
        min-height: 300px;
    }
    .thumbnail-preview {
        max-width: 100%;
        max-height: 200px;
        display: block;
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Artikel</h5>
            <a href="{{ route('blog.show', $article->slug) }}" class="btn btn-sm btn-info" target="_blank">
                <i class="bi bi-eye"></i> Lihat Artikel
            </a>
        </div>
        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('artikel.update', $article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" 
                                value="{{ old('title', $article->title) }}" required placeholder="Masukkan judul artikel...">
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <div class="input-group">
                                <span class="input-group-text">{{ config('app.url') }}/blog/</span>
                                <input type="text" class="form-control" id="slug" name="slug" 
                                    value="{{ old('slug', $article->slug) }}" placeholder="judul-artikel">
                            </div>
                            <div class="form-text">Biarkan kosong untuk membuat slug otomatis.</div>
                        </div>

                        <!-- Content Editor -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Konten Artikel <span class="text-danger">*</span></label>
                            <input id="content" type="hidden" name="content" value="{{ old('content', $article->content) }}">
                            <trix-editor input="content" class="trix-content"></trix-editor>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <!-- Publish Settings Card -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Pengaturan Publikasi</h6>
                            </div>
                            <div class="card-body">
                                <!-- Status -->
                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="status" id="statusDraft" 
                                                value="draft" {{ old('status', $article->status) == 'draft' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusDraft">
                                                Draft
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="statusPublished" 
                                                value="published" {{ old('status', $article->status) == 'published' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusPublished">
                                                Published
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Published Date -->
                                <div class="mb-3" id="publishDateContainer">
                                    <label for="published_at" class="form-label">Tanggal Publikasi</label>
                                    <input type="datetime-local" class="form-control" id="published_at" name="published_at" 
                                        value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                                    <div class="form-text">Kosongkan untuk menggunakan waktu saat ini.</div>
                                </div>

                                <!-- Kategori -->
                                <div class="mb-3">
                                    <label for="kategori_id" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" id="kategori_id" name="kategori_id" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('kategori_id', $article->kategori_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Info</label>
                                    <div class="text-muted small">
                                        <p>Dibuat: {{ $article->created_at->format('d M Y H:i') }}</p>
                                        <p>Terakhir diperbarui: {{ $article->updated_at->format('d M Y H:i') }}</p>
                                        <p>Jumlah dilihat: {{ $article->view_count }} kali</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail Card -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Gambar Thumbnail</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <input class="form-control" type="file" id="thumbnail" name="thumbnail" accept="image/*">
                                    <div class="form-text">Ukuran optimal: 1200x800 pixel</div>
                                    
                                    <div class="mt-2" id="thumbnailPreview">
                                        @if($article->thumbnail)
                                            <img src="{{ Storage::url($article->thumbnail) }}" class="thumbnail-preview" alt="{{ $article->title }}">
                                            <div class="form-text">Thumbnail saat ini. Unggah yang baru untuk mengganti.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Summary Card -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0">Ringkasan</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <textarea class="form-control" id="ringkasan" name="ringkasan" rows="4" 
                                        placeholder="Ringkasan artikel yang akan ditampilkan di halaman blog">{{ old('ringkasan', $article->ringkasan) }}</textarea>
                                    <div class="form-text">Jika kosong, ringkasan akan dibuat otomatis dari konten.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('artikel.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <div>
                                <button type="submit" name="action" value="draft" class="btn btn-outline-primary me-2">
                                    <i class="bi bi-save"></i> Simpan sebagai Draft
                                </button>
                                <button type="submit" name="action" value="publish" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Publish
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Include JS for TinyMCE or other WYSIWYG editor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.min.js"></script>
<script>
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('keyup', function() {
        // Only generate slug if it's empty or hasn't been manually changed
        if (!document.getElementById('slug').value || document.getElementById('slug').dataset.auto === 'true') {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            document.getElementById('slug').value = slug;
            document.getElementById('slug').dataset.auto = 'true';
        }
    });
    
    // Mark slug as manually edited when changed
    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.auto = 'false';
    });

    // Show/hide publish date based on status
    const statusDraft = document.getElementById('statusDraft');
    const statusPublished = document.getElementById('statusPublished');
    const publishDateContainer = document.getElementById('publishDateContainer');

    function togglePublishDate() {
        if (statusPublished.checked) {
            publishDateContainer.style.display = 'block';
        } else {
            publishDateContainer.style.display = 'none';
        }
    }

    statusDraft.addEventListener('change', togglePublishDate);
    statusPublished.addEventListener('change', togglePublishDate);
    
    // Call once to set initial state
    togglePublishDate();

    // Image preview
    document.getElementById('thumbnail').addEventListener('change', function() {
        const file = this.files[0];
        const preview = document.getElementById('thumbnailPreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" class="thumbnail-preview">`;
            }
            reader.readAsDataURL(file);
        } else {
            // If no new file is selected, show the existing thumbnail if available
            @if($article->thumbnail)
                preview.innerHTML = `<img src="{{ Storage::url($article->thumbnail) }}" class="thumbnail-preview" alt="{{ $article->title }}">
                                    <div class="form-text">Thumbnail saat ini. Unggah yang baru untuk mengganti.</div>`;
            @else
                preview.innerHTML = '';
            @endif
        }
    });
</script>
@endsection