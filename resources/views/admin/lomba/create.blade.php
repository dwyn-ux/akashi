@extends('layouts.admin')

@section('title', 'Tambah Lomba')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Tambah Lomba</h1>
    <p class="text-sm text-gray-500 mt-1">Buat kompetisi baru</p>
</div>

<form method="POST" action="{{ route('admin.lomba.store') }}" enctype="multipart/form-data">
    @csrf
    @include('admin.lomba._form')
</form>
@endsection
