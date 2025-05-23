<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class DashboardController extends Controller
{
    protected $client;
    protected $baseUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->baseUrl = 'http://localhost:8080';
    }

    public function index()
    {
        try {
            $matkulResponse = $this->client->request('GET', $this->baseUrl . '/matkul');
            $mahasiswaResponse = $this->client->request('GET', $this->baseUrl . '/mahasiswa');
            
            $matkul = json_decode($matkulResponse->getBody()->getContents(), true);
            $mahasiswa = json_decode($mahasiswaResponse->getBody()->getContents(), true);
            
            $matkulCount = is_array($matkul) ? count($matkul) : 0;
            $mahasiswaCount = is_array($mahasiswa) ? count($mahasiswa) : 0;
            
            return view('dashboard', compact('matkulCount', 'mahasiswaCount'));
        } catch (RequestException $e) {
            return view('dashboard')->with('error', 'Failed to fetch data: ' . $e->getMessage());
        }
    }
}
