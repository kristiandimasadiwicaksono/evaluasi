<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class MatkulControler extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = 'http://localhost:8080/matkul';
    }

    /**
     * Helper to get API URL.
     */
    private function getApiUrl($id = null)
    {
        return $id ? "{$this->apiUrl}/{$id}" : $this->apiUrl;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search'); // Ambil parameter search dari URL
        try {
            $response = Http::get($this->getApiUrl());
            $data = json_decode($response->getBody(), true);

            if ($search) {
                $data = array_filter($data, function ($user) use ($search) {
                    return stripos($user['nama_matkul'], $search) !== false;
                });
            }

            return view('admin.matkul.index', ['matkul' => $data]);
            } catch (RequestException $e) {
            return back()->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.matkul.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_matkul' => 'required|string|max:20',
            'nama_matkul' => 'required|string|max:100',
            'sks' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('matkul.create')
                    ->withErrors($validator)
                    ->withInput();
        }

        try {
            $response = Http::post($this->getApiUrl(), $request->all());

            if ($response->successful()) {
                return redirect()->route('matkul.index')->with('success', 'Data dosen berhasil ditambahkan!');
            }

            if ($response->status() === 422) {
                // Ambil error validasi dari backend
                $errors = $response->json()['message'];
                return redirect()->route('matkul.create')->withErrors($errors)->withInput();
            }

            return back()->with('error', 'Gagal menambahkan data matkul: ' . $response->status())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $response = Http::get($this->getApiUrl($id));

            if ($response->successful()) {
                $result = $response->json();

                $matkul = $result;

                return view('admin.matkul.show', compact('matkul'));
            

                return back()->with('error', 'Format data tidak valid');
            }

            return back()->with('error', 'Gagal memuat data dosen: ' . $response->status());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $response = Http::get($this->getApiUrl($id));

            if ($response->successful()) {
                $result = $response->json();
                
                $matkul = $result;

                if (is_array($matkul) || is_object($matkul)) {
                    return view('admin.matkul.edit', compact('matkul'));
                }

                return back()->with('error', 'Format data tidak valid');
            }

            return back()->with('error', 'Gagal memuat data dosen: ' . $response->status());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'kode_matkul' => 'required|string|max:20',
            'nama_matkul' => 'required|string|max:100',
            'sks' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->route('matkul.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $response = Http::put($this->getApiUrl($id), [
                'kode_matkul' => $request->kode_matkul,
                'nama_matkul' => $request->nama_matkul,
                'sks' => $request->sks,
            ]);

            if ($response->successful()) {
                return redirect()->route('matkul.index')->with('success', 'Data dosen berhasil diperbarui!');
            }

            return back()->with('error', 'Gagal memperbarui data dosen: ' . $response->status())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $response = Http::delete($this->getApiUrl($id));

            if ($response->successful()) {
                return redirect()->route('matkul.index')->with('success', 'Data dosen berhasil dihapus!');
            }

            return back()->with('error', 'Gagal menghapus data dosen: ' . $response->status());
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}