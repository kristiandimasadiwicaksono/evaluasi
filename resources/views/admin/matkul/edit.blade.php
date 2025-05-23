@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Data User</h2>
        </div>

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('matkul.update', $matkul['kode_matkul']) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="kode_matkul" class="block text-sm font-medium text-gray-700 mb-1">Kode Matkul</label>
                    <input type="text" name="kode_matkul" id="kode_matkul" value="{{ old('kode_matkul', $matkul['kode_matkul']) }}" class="w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:outline-none" required>
                    @error('kode_matkul')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nama_matkul" class="block text-sm font-medium text-gray-700 mb-1">Nama Matkul</label>
                    <input type="text" name="nama_matkul" id="nama_matkul" value="{{ old('nama_matkul', $matkul['nama_matkul']) }}" class="w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    @error('nama_matkul')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sks" class="block text-sm font-medium text-gray-700 mb-1">SKS</label>
                    <input type="text" name="sks" id="sks" value="{{ old('sks', $matkul['sks']) }}" class="w-full rounded-md border-gray-300 bg-gray-100 p-2 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    @error('sks')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ route('matkul.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection