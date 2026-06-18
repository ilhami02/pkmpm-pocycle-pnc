@extends('admin.layouts.admin')

@section('title', $isEdit ? 'Edit Artikel' : 'Tambah Artikel Baru')

@section('content')
<div class="max-w-4xl bg-white rounded-2xl border border-earth-200 shadow-sm overflow-hidden">
    <form action="{{ $isEdit ? route('admin.articles.update', $article) : route('admin.articles.store') }}" 
          method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="space-y-6">
            {{-- Judul --}}
            <div>
                <label for="title" class="block text-sm font-medium text-earth-700 mb-1">Judul Artikel *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $article->title) }}" required
                       class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Ringkasan --}}
            <div>
                <label for="excerpt" class="block text-sm font-medium text-earth-700 mb-1">Ringkasan (Excerpt)</label>
                <textarea id="excerpt" name="excerpt" rows="2"
                          class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900"
                          placeholder="Ringkasan singkat untuk ditampilkan di daftar artikel">{{ old('excerpt', $article->excerpt) }}</textarea>
                @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Body (Markdown) --}}
            <div>
                <label for="body" class="block text-sm font-medium text-earth-700 mb-1">Konten Artikel (Bisa gunakan HTML/Markdown) *</label>
                <textarea id="body" name="body" rows="15" required
                          class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900 font-mono text-sm"
                          placeholder="Tulis konten artikel di sini...">{{ old('body', $article->body) }}</textarea>
                @error('body') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                <p class="mt-1 text-xs text-earth-500">Anda dapat menggunakan tag HTML dasar seperti &lt;h2&gt;, &lt;p&gt;, &lt;strong&gt;, dll.</p>
            </div>

            {{-- Cover Image --}}
            <div>
                <label for="cover_image" class="block text-sm font-medium text-earth-700 mb-1">Cover Image</label>
                @if($isEdit && $article->cover_image)
                    <div class="mb-3">
                        <img src="{{ Storage::url($article->cover_image) }}" alt="Cover" class="h-32 rounded-lg object-cover border border-earth-200">
                    </div>
                @endif
                <input type="file" id="cover_image" name="cover_image" accept="image/*"
                       class="w-full px-4 py-2 border border-earth-300 rounded-xl focus:ring-leaf-500 focus:border-leaf-500 text-earth-900 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-leaf-50 file:text-leaf-700 hover:file:bg-leaf-100">
                @error('cover_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            {{-- Published Status --}}
            <div class="flex items-center gap-3 bg-earth-50 p-4 rounded-xl border border-earth-100">
                <input type="checkbox" id="is_published" name="is_published" value="1" 
                       {{ old('is_published', $article->is_published) ? 'checked' : '' }}
                       class="w-5 h-5 text-leaf-600 border-earth-300 rounded focus:ring-leaf-500">
                <label for="is_published" class="text-sm font-medium text-earth-800">
                    Publish Artikel Ini Sekarang
                    <span class="block text-xs text-earth-500 font-normal">Jika tidak dicentang, artikel akan disimpan sebagai draft.</span>
                </label>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="submit" class="btn-primary px-6">
                {{ $isEdit ? 'Simpan Perubahan' : 'Buat Artikel' }}
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn-secondary px-6">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
