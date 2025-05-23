@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Matkul</h2>
            <a href="{{ route('matkul.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                Tambah Mahasiswa
            </a>
        </div>

        <form action="{{ route('matkul.index') }}" method="GET" class="mb-4 flex space-x-2">
                <input type="text" name="search" placeholder="Cari username..." value="{{ request('search') }}"
                    class="px-4 py-2 border rounded w-1/3 focus:outline-none focus:ring focus:border-blue-300">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                    Cari
                </button>
            </form>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left">Kode Matkul</th>
                        <th class="py-3 px-4 text-left">Nama Matkul</th>
                        <th class="py-3 px-4 text-left">SKS</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($matkul as $matkul)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $matkul['kode_matkul'] }}</td>
                        <td class="py-3 px-4">{{ $matkul['nama_matkul'] }}</td>
                        <td class="py-3 px-4">{{ $matkul['sks'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('matkul.show', $matkul['kode_matkul']) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                    Detail
                                </a>
                                <a href="{{ route('matkul.edit', $matkul['kode_matkul']) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                                <form action="{{ route('matkul.destroy', $matkul['kode_matkul']) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-3 px-4 text-center text-gray-500">Tidak ada data mahasiswa</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection