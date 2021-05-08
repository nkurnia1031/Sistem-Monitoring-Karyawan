<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class crud extends Controller
{

    public function create(Request $Request)
    {

        $table = $Request->table;
        $tb = json_decode($Request->tb, true);
        $input = json_decode($Request->input, true);

        add($tb, $input, $table);
        return "Data berhasil di simpan";

    }

    public function delete(Request $Request)
    {

        $key = $Request->key;
        $primary = $Request->primary;
        $table = $Request->table;
        hapus($table, $primary, $key);
        return "Data dengan Primary Key $key telah berhasil di hapus";

    }
    public function update(Request $Request)
    {
        $tb = json_decode($Request->tb, true);
        $input = json_decode($Request->input, true);
        $table = $Request->table;
        $key = $Request->key;
        $primary = $Request->primary;
        $link = $Request->link;
        edit($tb, $input, $key, $primary, $table);
        return "Data berhasil di edit";

    }

}
function add($tb, $input, $table)
{
    $tes = collect($tb);
    $ar = $tes->combine($input)->toArray();
    DB::table($table)->insert($ar);
}
function edit($tb, $input, $key, $primary, $table)
{
    $tes = collect($tb);
    $ar = $tes->combine($input)->toArray();
    DB::table($table)->where($primary, $key)->update($ar);

}
function hapus($table, $primary, $key)
{
    DB::table($table)->where($primary, $key)->delete();
}
