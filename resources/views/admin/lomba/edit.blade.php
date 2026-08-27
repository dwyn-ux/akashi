@extends('layouts.admin')

@section('title', 'Edit Lomba: ' . ($lomba->name ?? ''))

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Edit Lomba</h1>
    <p class="text-sm text-gray-500 mt-1">Perbarui informasi kompetisi</p>
</div>

<form method="POST" action="{{ route('admin.lomba.update', $lomba) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include('admin.lomba._form', ['lomba' => $lomba])
</form>
@endsection
