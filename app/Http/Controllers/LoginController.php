<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
    public function index()
    {
        //Tampilkan from login
        $data = [
            'title' => 'Halaman Login Aplikasi Barang',
            'appTitle' => 'SimBarang'
        ];
        return view('login', $data);
    }

    public function check(Request $request)
    {
        $postData = $request->validate(
            [
                'username' => ['required'],
                'password' => ['required']
            ]
        );

        if (Auth::attempt($postData)) :
            //Jika login berhasil maka generate session dan redirect kehalaman dashboard
            $request->session()->regenerate();
            if (Auth::user()->level === 'admin') :
                return response(
                    [
                        'success' => true,
                        'redirect_url' => '/barang'
                    ],
                    200
                );
            elseif (Auth::user()->level == 'barang') :
                return response(
                    [
                        'success' => true,
                        'redirect_url' => '/barang'
                    ],
                    200
                );
            elseif (Auth::user()->level == 'jual') :
                return response(
                    [
                        'success' => true,
                        'redirect_url' => '/jual'
                    ],
                    200
                );
            elseif (Auth::user()->level == 'beli') :
                return response(
                    [
                        'success' => true,
                        'redirect_url' => '/beli'
                    ],
                    200
                );


            else :
                return response(
                    [
                        'success' => false,
                    ],
                    401
                );
            endif;
        else :

        endif;
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/login', 302);
    }
}
