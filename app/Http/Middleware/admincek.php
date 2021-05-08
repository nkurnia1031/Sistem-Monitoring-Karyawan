<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class admincek
{
    /**
     * Handle an incoming request.
     *
     * @param
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $admin = DB::table('admin')->where('user', session()->get('user'))->where('pass', session()->get('pass'))->get();

        if (count($admin) == 1) {

            session()->put('admin', 1);
            session()->put('admin2', $admin->first());

            return $next($request);
        } elseif ($request->session()->get('user') == null) {
            session()->put('message', '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Gagal</span></button>
                               Anda Belum Login atau Sesi Anda Telah Berakhir Silahkan Login Kembali
                            </div>');
            return redirect('login');
        } else {
            session()->put('message', '<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Gagal</span></button>
                                UserName atau Password Salah Silahkan Coba lagi
                            </div>');
            return redirect('login');
        }
    }
}
