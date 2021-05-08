<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Calculation\DateTime;

class form extends Controller
{

    public function karyawan(Request $Request)
    {
        $judul = "Data Karayawan";
        $link = "karyawan";

        return view('isi.karyawan', [
            'judul' => $judul,
            'link' => $link,

        ]);

    }
    public function set(Request $Request)
    {
        $judul = "Pengaturan User";
        $link = "set";

        return view('isi.set', [
            'judul' => $judul,
            'link' => $link,

        ]);

    }
    public function dashboard(Request $Request)
    {
        $judul = "Data Karayawan";
        $link = "dashboard";
        $tipeewd = DB::table('tipeewd')->where('id', '!=', 5)->get();
        $thn = DB::table('thn')->get();

        return view("isi.$link", [
            'judul' => $judul,
            'link' => $link,
            'thn' => $thn,
            'tipeewd' => $tipeewd,

        ]);

    }
    public function absensi(Request $Request)
    {
        $judul = "Data Absensi";
        $link = "absensi";
        return view('isi.absensi', [
            'judul' => $judul,
            'link' => $link,

        ]);

    }
    public function lembur(Request $Request)
    {
        $judul = "Data Lembur";
        $link = "lembur";

        return view('isi.lembur', [
            'judul' => $judul,
            'link' => $link,

        ]);

    }
    public function lap(Request $Request)
    {
        $judul = "Laporan Karyawan";
        $link = "lap";
        $thn = DB::table('thn')->get();

        return view('isi.lap', [
            'judul' => $judul,
            'link' => $link,
            'thn' => $thn,
            'Request' => $Request,

        ]);

    }
    public function workday(Request $Request)
    {

        $libur = DB::table('libur')->get()->map(function ($item, $key) {
            return $item->tanggal;
        })->toArray();

        $thn = DB::table('thn')->get();
        $tes = [];
        foreach ($thn as $k) {

            for ($i = 1; $i < 13; $i++) {
                $awal = "$k->thn-$i-01";
                $akhir = date_format(date_create($awal), 'Y-m-t');
                $array = ['wd' => DateTime::NETWORKDAYS($awal, $akhir, $libur), 'thn' => $k->thn, 'bln' => $i];
                array_push($tes, $array);

            }
        }

        return json_encode($tes);

    }
    public function graf(Request $Request)
    {

        $karyawan = DB::table('karyawan')->get();
        $dept = DB::table('dept')->get();
        $thn = DB::table('thn')->get();
        $absen = DB::table('absen')->get();
        $tipeewd = DB::table('tipeewd')->where('id', '!=', 5)->get();
        $tes = [];
        foreach ($thn as $k) {
            $absen2 = $absen->where('thn', $k->thn);
            foreach ($dept as $d) {
                $absen3 = $absen2->where('dept_id', $d->dept_id);
                // $karyawan2 = $karyawan->where('dept_id', $d->dept_id)->count();

                for ($i = 1; $i < 13; $i++) {
                    $absen4 = $absen3->where('bln', $i);

                    foreach ($tipeewd as $t) {
                        $absen5 = round($absen4->where('tipe2', $t->id)->sum('day'), 2);
                        if ($absen5 > 0) {
                            # code...
                            $karyawan2 = $absen4->where('tipe2', $t->id)->unique('nik2')->count();
                            $rata = round($absen5 / $karyawan2, 2);

                            $x = ['thn' => $k->thn, 'bln' => $i, 'dept_id' => $d->dept_id, 'dept_name' => $d->dept_name, 'tipe' => $t->id, 'only' => $absen5, 'all' => $karyawan2, 'rata' => $rata];
                            array_push($tes, $x);
                        }

                    }
                }

            }

        }
        $tes = collect($tes)->sortByDesc('rata');

        return json_encode($tes);

    }

    public function tes(Request $Request)
    {
        $file = $Request->file('file');

        $tes = Storage::disk('scan')->get('image001.png');
        $tes = encrypt($tes);
        Storage::put('file.docx', $tes);
        $tes = decrypt($tes);
        Storage::put('file2.docx', $tes);

    }

}
