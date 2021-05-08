<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class vue extends Controller
{

    public function getall(Request $Request)
    {

        $key = $Request->key;
        $tb = $Request->tb;
        $data = $Request->data;
        $primary = $Request->primary;
        $primary2 = $Request->primary2;
        $table = $Request->table;
        $view = $Request->view;
        if ($tb > 0) {
            if ($key == null) {
                $tes = DB::table($view)->get()->toJson();

            } else {
                $tes = DB::table($view)->where($primary2, $key)->get()->toJson();

            }

            $tes = json_decode($tes, true);
            $jum = count($tes);
            for ($i = 0; $i < $jum; $i++) {
                $tes[$i]['set'] = "<div class='dropdown'>
                                <a href='#' class='action-icon dropdown-toggle' data-toggle='dropdown' aria-expanded='false'><i class='fa fa-ellipsis-v'></i></a>
                                <ul class='dropdown-menu pull-right'>
                                        <li><a href='#' class='text-info' data-toggle='modal' data-target='.modal-" . $table . "e' onclick='app.getall(\"$primary\",\"" . $tes[$i][$primary] . "\",\"$view\")' title='Edit'><i class='fa fa-pencil m-r-5'></i> Edit</a></li>
                                        <li><a href='#' class='text-danger' onclick='app.delete(\"$primary\",\"" . $tes[$i][$primary] . "\",\"$table\")'  title='Delete'><i class='fa fa-trash-o m-r-5'></i> Delete</a></li>
                                </ul>
                                </div>";
            }

        } else {

            if ($key == 'null') {
                $tes = DB::table($table)->get();

            } else {
                $tes = DB::table($table)->where($primary, $key)->get();

            }
        }
        if ($data > 0) {

        } else {
            $tes = array('data' => $tes);
        }

        $tes = collect($tes);
        return $tes->toJson();
    }

}
