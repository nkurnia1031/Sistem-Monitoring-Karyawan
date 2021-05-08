<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\laporan;
use App\Models\sample;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class upload extends Controller
{

    public function tes(Request $Request)
    {
        config(['excel.import.dates.columns' => ['tang']]);

        $all = Excel::load($Request->file('file')->getRealPath(), function ($reader) {
        })->formatDates(true, 'd/m/Y');

        $key = $all->first()->keys()->toArray();

        $all = count($all->get());
        if ($all > 5000) {
            echo "<script> alert('Maaf file yang anda upload memiliki $all record. batas maksimal adalah 5000 Record')</script>";
            echo "<script>location.href='indisipliner'</script>";
        } else {
            $a = array();
            $b = array(
                0 => "a",
                1 => "b",

            );

            if ($key == $b) {
                $data = Excel::filter('chunk')->load($Request->file('file')->getRealPath())->formatDates(true, 'd/m/Y')->chunk(2500, function ($reader) use ($a) {
                    $key = $reader->first()->keys()->toArray();

                    foreach ($reader as $k) {
                        $a[] = array(

                            'npsn' => $k->a,
                            'nama_sklh' => $k->b,
                        );
                    }

                    DB::table('asal_sekolah')->insert($a);
                });
                echo "<script> alert('$all Record telah berhasil di tambahkan')</script>";
                echo "<script>location.href='alat'</script>";
            } else {
                echo '<script> alert("Maaf file yang anda upload tidak sesuai format\nsilahkan download sample format yang sudah di sediakan")</script>';
                echo "<script>location.href='alat'</script>";
            }
        }
    }
    public function sample(Request $Request)
    {
        config(['excel.import.dates.columns' => ['tanggal']]);

        $all = Excel::load($Request->file('file')->getRealPath(), function ($reader) {
        })->formatDates(true, 'd/m/Y');

        $key = $all->first()->keys()->toArray();

        $all = count($all->get());
        if ($all > 5000) {
            echo "<script> alert('Maaf file yang anda upload memiliki $all record. batas maksimal adalah 5000 Record')</script>";
            echo "<script>location.href='indisipliner'</script>";
        } else {
            $a = array();
            $b = array(
                0 => "id_trf",
                1 => "tanggal",
                2 => "h2",
                3 => "ch4",
                4 => "c2h2",
                5 => "c2h4",
                6 => "c2h6",
                7 => "co",
                8 => "co2",
                9 => "alat",
                10 => "tdcg",

            );

            if ($key == $b) {
                $data = Excel::filter('chunk')->load($Request->file('file')->getRealPath())->formatDates(true, 'd/m/Y')->chunk(2500, function ($reader) use ($a) {
                    $key = $reader->first()->keys()->toArray();

                    foreach ($reader as $k) {
                        $a[] = array(

                            'id_trf' => $k->id_trf,
                            'tanggal' => date('Y-m-d', strtotime($k->tanggal)),
                            'h2' => $k->h2,
                            'ch4' => $k->ch4,
                            'c2h2' => $k->c2h2,
                            'c2h4' => $k->c2h4,
                            'c2h6' => $k->c2h6,
                            'co' => $k->co,
                            'co2' => $k->co2,
                            'alat' => $k->alat,
                            'tdcg' => $k->tdcg,

                        );
                    }

                    sample::insert($a);
                });
                echo "<script> alert('$all Record telah berhasil di tambahkan')</script>";
                echo "<script>location.href='Sample'</script>";
            } else {
                echo '<script> alert("Maaf file yang anda upload tidak sesuai format\nsilahkan download sample format yang sudah di sediakan")</script>';
                echo "<script>location.href='Sample'</script>";
            }
        }
    }
    public function lap(Request $Request)
    {
        $id = $Request->id;

        $tag = $Request->tag;
        $tgl = $Request->sample;
        $tdcg = $Request->tdcg;
        $con = $Request->con;
        $interval = $Request->interval;
        $ope = $Request->ope;
        $roger1 = $Request->roger1;
        $co2 = $Request->co2;
        $roger2 = $Request->roger2;
        $duval = $Request->duval;

        $sample = laporan::where('id', $id)->get()->count();

        if ($sample > 0) {
            laporan::where('id', $id)->update([
                'tag' => $tag,
                'sample' => $tgl,
                'tdcg' => $tdcg,
                'con' => $con,
                'ope' => $ope,
                'roger1' => $roger1,
                'co2' => $co2,
                'interval' => $interval,
                'roger2' => $roger2,
                'duval' => $duval]);
            echo 'New record has been Updated';
        } else {
            laporan::create([
                'id' => $id,
                'tag' => $tag,
                'sample' => $tgl,
                'tdcg' => $tdcg,
                'con' => $con,
                'ope' => $ope,
                'roger1' => $roger1,
                'co2' => $co2,
                'interval' => $interval,
                'roger2' => $roger2,
                'duval' => $duval]);
            echo "New record has been Added";
        }
    }
    public function laporan(Request $Request)
    {
        $a = 0;
        $from = "All";
        $to = "All";
        if ($Request->all > 0) {
            $laporan = laporan::all();
            $a = 1;
            $from = "All";
            $to = "All";
        } else {
            $from = $Request->from;
            $a = 1;
            $to = $Request->to;
            $laporan = laporan::get()->where('sample', '>=', $from)->where('sample', '<=', $to);
        }

        return view('form.report', [
            'judul' => "REPORT INTERPRETATION DISSOLVED GAS IN OIL IMMERSED TRANSFORMER (DGA TEST)",
            'laporan' => $laporan,
            'a' => $a,
            'from' => $from,
            'to' => $to,
        ]);
    }
    public function laporanpdf(Request $Request)
    {

        if ($Request->all > 0) {
            $laporan = laporan::all();
            $a = 1;
            $from = "All";
            $to = "All";
        } else {
            $from = $Request->from;
            $a = 1;
            $to = $Request->to;
            $laporan = laporan::get()->where('sample', '>=', $from)->where('sample', '<=', $to);
        }

        $pdf = PDF::loadView('form.report', [
            'judul' => "REPORT INTERPRETATION DISSOLVED GAS IN OIL IMMERSED TRANSFORMER (DGA TEST)",
            'laporan' => $laporan,
            'a' => $a,
            'from' => $from,
            'to' => $to,
        ]);

        return $pdf->stream();
    }
}
