@extends('layouts.admin')

@section('title', 'FAQ')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">FAQ</h1>
    <p class="text-sm text-gray-500 mt-1">Kelola Pertanyaan yang Sering Diajukan</p>
</div>

<!-- Add Form -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah FAQ</h3>
    <form method="POST" action="{{ route('admin.faq.store') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan <span class="text-red-500">*</span></label>
                <input type="text" name="question" value="{{ old('question') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban <span class="text-red-500">*</span></label>
                <textarea name="answer" rows="3" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-primary focus:border-primary outline-none">{{ old('answer') }}</textarea>
            </div>
            <button type="submit" class="bg-primary hover:bg-purple-800 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition">Tambah FAQ</button>
        </div>
    </form>
</div>

<!-- List -->
<div class="space-y-3">
    @forelse($faqs ?? [] as $faq)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-accent flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                    </svg>
                    <h4 class="font-semibold text-gray-800 text-sm">{{ $faq->question }}</h4>
                </div>
                <p class="text-sm text-gray-600 ml-6">{{ $faq->answer }}</p>
            </div>
            <form method="POST" action="{{ route('admin.faq.destroy', $faq) }}" onsubmit="return confirm('Hapus FAQ ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.367m1.022 0a3 3 0 01-2.742-2.582l-.018-.044m-1.022 0a3 3 0 00-2.742 2.582l-.018.044m-9.478 0H21"/>
                    </svg>
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center text-gray-400">
        Belum ada FAQ. Tambahkan pertanyaan di atas.
    </div>
    @endforelse
</div>
@endsection
