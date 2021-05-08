<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class user extends Controller
{

    public function login(Request $Request)
    {
        session()->put('user', null);
        session()->put('pass', null);
        session()->put('admin', 0);
        return view('layout/login', [
            'judul' => "Login",

        ]);
    }
    public function reset(Request $Request)
    {
        $user = $Request->user;
        $tb = DB::table('admin')->where('user', $user)->get();

        return view('layout/login2', [
            'judul' => "Login",
            'tb' => $tb,

        ]);
    }
    public function loginp(Request $Request)
    {
        $user = $Request->user;
        $pass = $Request->pass;

        session()->put('user', $user);
        session()->put('pass', md5($pass));

        return redirect('/');
    }
    public function ganti(Request $Request)
    {
        $user = $Request->user;
        $pass = md5($Request->pass);
        $tanya = $Request->tanya;
        $jawab = $Request->jawab;
        $pass2 = $Request->pass2;
        $tb = DB::table('admin')->where('user', $user)->where('pass', $pass);
        $cek = $tb->get()->count();
        if ($cek == 1) {
            if ($pass2 == null) {
                $ubah = [
                    'jawab' => $jawab,
                    'tanya' => $tanya,
                ];
            } else {
                $ubah = [
                    'pass' => md5($pass2),
                    'jawab' => $jawab,
                    'tanya' => $tanya,
                ];
            }
            $tb->update($ubah);
            echo "<script>alert('Data berhasil di update, Silahkan Login Kembali')</script>";
        } else {
            echo "<script>alert('Password Anda salah, Silahkan Login Kembali')</script>";

        }
        echo "<script>location.href='logout'</script>";

    }
    public function reset2(Request $Request)
    {
        $user = $Request->user;
        $pass = md5($Request->pass);
        $tanya = $Request->tanya;
        $jawab = $Request->jawab;
        $tb = DB::table('admin')->where('user', $user)->where('tanya', $tanya)->where('jawab', $jawab);
        $cek = $tb->get()->count();
        if ($cek == 1) {
            $ubah = [
                'pass' => $pass,

            ];
            $tb->update($ubah);
            echo "<script>alert('Password Berhasil di Reset, Silahkan Login Kembali')</script>";
        } else {
            echo "<script>alert('Jawaban Anda Tidak Cocok, Silahkan Periksa Kembali')</script>";

        }
        echo "<script>location.href='login'</script>";

    }
}
