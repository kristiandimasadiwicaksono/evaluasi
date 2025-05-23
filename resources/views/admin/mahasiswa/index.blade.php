@extends('layouts.app')

@section('content')
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Data Mahasiswa</h2>
            <a href="{{ route('mahasiswa.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                Tambah Mahasiswa
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left">NPM</th>
                        <th class="py-3 px-4 text-left">Nama Mahasiswa</th>
                        <th class="py-3 px-4 text-left">Email</th>
                        <th class="py-3 px-4 text-left">ID User</th>
                        <th class="py-3 px-4 text-left">Kode Kelas</th>
                        <th class="py-3 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($mahasiswa as $mahasiswa)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $mahasiswa['npm'] }}</td>
                        <td class="py-3 px-4">{{ $mahasiswa['nama_mahasiswa'] }}</td>
                        <td class="py-3 px-4">{{ $mahasiswa['email'] }}</td>
                        <td class="py-3 px-4">{{ $mahasiswa['id_user'] }}</td>
                        <td class="py-3 px-4">{{ $mahasiswa['kode_kelas'] }}</td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('matkul.show', $mahasiswa['npm']) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                    Detail
                                </a>
                                <a href="{{ route('matkul.edit', $mahasiswa['npm']) }}" class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                                <form action="{{ route('matkul.destroy', $mahasiswa['npm']) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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