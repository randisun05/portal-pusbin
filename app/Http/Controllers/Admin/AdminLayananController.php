<?php

namespace App\Http\Controllers\Admin;

use GuzzleHttp\Client;
use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminLayananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.layanan.index', [
            "layanans" => Layanan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.layanan.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "*" => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('image')->store('post-image');
        $validatedData['image'] = $file;
        Layanan::create($validatedData);

        return redirect()->to('/admin/layanan')->with('success', 'Layanan Berhasil Dibuat');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Layanan $layanan)
    { {
            return view('admin.layanan.show', [
                'layanans' => Layanan::all(),
                'layanan' => $layanan
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', [
            'layanans' => Layanan::all(),
            'layanan' => $layanan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Layanan $layanan)
    {

        $validateData = $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'link' => 'required',
            'image' => 'image|file|max:1024',
            'status' => 'required',

        ]);

        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }

        Layanan::where('id', $layanan->id)
            ->update($validateData);

        return redirect('/admin/layanan')->with('success', 'Layanan Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Layanan $layanan)
    {
        if ($layanan->image) {
            Storage::delete($layanan->image);
        }
        Layanan::destroy($layanan->id);
        return redirect('/admin/layanan')->with('success', 'Layanan Berhasil Dihapus');
    }

    public function inputData(Request $request)
    {

        return view('admin.layanan.input', []);
    }

    public function getData(Request $request)
    {
        $ProdToken = $this->getProdtoken();
        $AuthToken = $this->getAuthtoken();

        // Inisialisasi Guzzle client
        $client = new Client();

        try {
            // Lakukan HTTP GET request ke URL API dengan header yang diperlukan
            $response = $client->request('GET', 'https://apimws.bkn.go.id:8243/pusbin/1/pns/data-utama/' . $request->nama, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $ProdToken, // Gunakan $ProdToken untuk ProdToken
                    'Auth' => 'Bearer ' . $AuthToken // Gunakan $AuthToken untuk AuthToken
                ]
            ]);

            // Ambil data JSON dari response
            $data = json_decode($response->getBody(), true);

            // Lakukan operasi selanjutnya sesuai kebutuhan Anda, misalnya menampilkan data
            dd($data);
        } catch (\Exception $e) {
            // Tangani jika terjadi error dalam melakukan request
            dd($e->getMessage());
        }
    }

    public function getProdtoken()
    {
        $client = new Client();

        // Lakukan HTTP POST request ke URL API dengan header yang diperlukan
        $response = $client->request('POST', 'https://apimws.bkn.go.id/oauth2/token', [
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode('cTfJosEeHmdA2Xc7mh2a7R6aE18a:SOau2ggf0fFvv7ibJa7LRM27e88a')
            ],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);

        // Ambil data JSON dari response
        $data = json_decode($response->getBody(), true);

        // Ambil nilai access_token dari respons
        $access_token = $data['access_token'];

        return $access_token;
    }

    public function getAuthtoken()
    {
        $client = new Client();

        // Lakukan HTTP POST request ke URL API dengan header yang diperlukan
        $response = $client->request('POST', 'https://sso-siasn.bkn.go.id/auth/realms/public-siasn/protocol/openid-connect/token', [
            'form_params' => [
                'client_id' => 'internalpusbinjf',
                'grant_type' => 'password',
                'username' => '199501052022031003',
                'password' => 'Jakarta123'
            ]
        ]);

        // Ambil data JSON dari response
        $data = json_decode($response->getBody(), true);

        // Ambil nilai access_token dari respons
        $access_token = $data['access_token'];

        return $access_token;
    }
}
