<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class MahasiswaController extends Controller
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'http://localhost:8080';
    }

    public function index(Request $request)
    {
        $search = $request->query('search'); // Ambil parameter search dari URL

        try {
            $response = $this->client->get("{$this->baseUrl}/mahasiswa");
            $data = json_decode($response->getBody(), true);

            if ($search) {
                $data = array_filter($data, function ($user) use ($search) {
                    return stripos($user['nama_mahasiswa'], $search) !== false;
                });
            }

            return view('admin.mahasiswa.index', ['mahasiswa' => $data]);
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'npm' => 'required|string',
            'nama_mahasiswa' => 'required|string',
            'email' => 'required|string',
            'id_user' => 'required|string',
            'kode_kelas' => 'required|string'
        ]);

        try {
            $this->client->post("{$this->baseUrl}/mahasiswa", [
                'form_params' => $request->only(['npm', 'nama_mahasiswa', 'email', 'id_user', 'kode_kelas']),
            ]);

            return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to add data: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/user/{$id}");

            if ($response->getStatusCode() === 200) {
                $result = json_decode($response->getBody(), true);

                // Pastikan struktur JSON-nya langsung data user
                $user = $result['0'] ?? null;

                return view('admin.user.show', compact('user'));
            } else {
                return back()->with('error', 'Gagal memuat data user: ' . $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $response = $this->client->get("{$this->baseUrl}/user/{$id}");
            $data = json_decode($response->getBody(), true);

            return view('admin.user.edit', ['user' => $data[0] ?? []]);
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'level' => 'required|string'
        ]);

        try {
            $this->client->put("{$this->baseUrl}/user/{$id}", [
                'form_params' => $request->only(['username', 'password', 'level']),
            ]);

            return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to update data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->client->delete("{$this->baseUrl}/user/{$id}");

            return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
        } catch (RequestException $e) {
            return back()->with('error', 'Failed to delete data: ' . $e->getMessage());
        }
    }
}
