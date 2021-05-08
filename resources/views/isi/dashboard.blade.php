@extends('layout.index') @section('js')
@php
$warna=["panel panel-primary","panel panel-info","panel panel-warning","panel panel-danger"];
@endphp
<style type="text/css">
    .card-box{
        zooomin:76%;
    }
</style>
<script type="text/javascript">
$(document).ready(function() {

    $(".nama").easyAutocomplete(options);

    app.getall(null, null, 'tipeewd');
    app.getall(null, null, 'karyawan');
    app.getall(null, null, 'dept');
    app.getall(null, null, 'sect');
    app.getall(null, null, 'subsect');
    app.getgraf()









});

function ulangi() {
    $(".nama").easyAutocomplete(options);
    app.getgraf()

    app.getall(null, null, 'tipeewd');
    app.getall(null, null, 'karyawan');
    app.getall(null, null, 'dept');
    app.getall(null, null, 'sect');
    app.getall(null, null, 'subsect');


}
</script>
<script type="text/javascript">
var app = new Vue({
    el: '.app',
    data: {
        kucing: [],
        lain: [],
        graf: 0,
        bln2: 0,
        thn2: 0,




    },
    methods: {

        getall: function(primary, key, table) {

            var queryString;
            queryString = 'primary=' + primary + '&key=' + key + '&table=' + table;
 $('.app').loading({
                circles: 3,
                overlay: true
            });
            jQuery.ajax({


                url: 'getall',
                data: queryString,
                type: "GET",
                success: function(data) {

                    var mydata = JSON.parse(data);
                    Vue.set(app.kucing, table, collect(mydata['data']));
                    $('.app').loading({ destroy: true });


                },

                error: function() {
                    alert('koneksi gagal');
                    $('.app').loading({ destroy: true });
                    this.getall(primary,key,table)
                }
            });
                    $('.app').loading({ destroy: true });




        },
        getgraf: function() {

            $('.app').loading({
                circles: 3,
                overlay: true
            });
            jQuery.ajax({

                url: 'graf',
                type: "GET",
                success: function(data) {

                    var mydata = JSON.parse(data);
                    app['graf'] = collect(mydata);
                 $('.app').loading({ destroy: true });


                },
                error: function() { alert('koneksi gagal')
                 $('.app').loading({ destroy: true });
                 this.getgraf()
            }
            });



        },

        abchart: function(tipe, a) {

             hasil = this.graf.where('tipe', tipe)
                hasil=hasil.where('thn', this.thn).where('bln', this.bln);

             hasil=hasil.sortByDesc('rata').slice(0, 3).all();

            if (a === 0) {
                as = [];
                for (var i = 0; i < hasil.length; i++) {

                    as[i] = [hasil[i].dept_name, hasil[i].rata];


                }
                hasil = as

            }

            return hasil;


        }




    },

    computed: {
        thn: function() {

            return parseInt(this.thn2)
        },
        bln: function() {

            return parseInt(this.bln2)
        },


    },
    mounted: function() {
        this.$set(this.lain, 'dept', "kucing")
        this.$set(this.lain, 'sect', "kucing")
        this.$set(this.lain, 'subsect', "kucing")

        @foreach($tipeewd as $e)
        this.$set(this.lain, 'chart{{$e->id}}', 0)
        @endforeach

    },
    beforeUpdate: function() {

        if (app.lain.tb != 0) {
            app.lain.tb.destroy();


        }


    },
    updated: function() {


        app.lain.tb = $('.tb').DataTable({
            "lengthChange": false,

            "lengthMenu": [
                [5, 10, -1],
                [5, 10, "All"]
            ],
            "dom": "fltip"
        });
        @foreach($tipeewd as $e)

        var chart{{$e->id}} = c3.generate({
            bindto: '.grafik{{$e->id}}',
            data: {
                columns: [],
                labels: true,
                type: 'bar'
            },
            grid: {
                y: {
                    show: true
                },
            },
            axis: {

                y: {
                    tick: {
                        format: function(d) { return d + " Days"; }
                    }
                },

            }
        });
        if (app.graf!=0) {
        chart{{$e->id}}.load({
            columns: this.abchart({{$e->id}},0),

        });
        }
        @endforeach






    }


});
</script>
@endsection @section('modal')
<div class="modal fade " id="modal-detail" v-if="kucing.karyawan !== undefined" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">@{{lain.subsectn}}</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table  table-hover custom-table m-b-0 tb">
                                    <thead>
                                        <tr>
                                            <th>Nik</th>
                                            <th>Nama</th>
                                            <th>Gender</th>
                                            <th>Level</th>
                                            <th>Status</th>
                                            <th>Golongan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="a in kucing.karyawan.where('subsect_id',lain.subsect).all()">
                                            <td v-html="a.nik"></td>
                                            <td><a :href="'lap?nik='+a.nik" v-html="a.nama" class="badge badge-success"></a></td>
                                            <td v-html="a.gender"></td>
                                            <td v-html="a.level"></td>
                                            <td v-html="a.status"></td>
                                            <td v-html="a.gol"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection @section('isi')
<div class="row">
    <div class="col-lg-12">
        <button class="btn btn-success pull-right" onclick="ulangi()">Refresh</button>
    </div>
</div>
<div class="row" v-if="kucing.karyawan !== undefined">
    <div class="col-lg-4">
        <div class="dash-widget clearfix card-box">
            <span class="dash-widget-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
            <div class="dash-widget-info">
                <h3>@{{kucing.karyawan.count()}}</h3>
                <span>karyawan</span>
            </div>
        </div>
    </div>
    <div class=" col-lg-4">
        <div class="dash-widget dash-widget4">
            <span class="dash-widget-icon bg-info"><i class="fa fa-user-o" aria-hidden="true"></i></span>
            <div class="dash-widget-info">
                <h3>@{{kucing.karyawan.where('gender','M').count()}}</h3>
                <span>Pria</span>
            </div>
        </div>
    </div>
    <div class=" col-lg-4">
        <div class="dash-widget dash-widget4">
            <span class="dash-widget-icon bg-danger"><i class="fa fa-user-o" aria-hidden="true"></i></span>
            <div class="dash-widget-info">
                <h3>@{{kucing.karyawan.where('gender','F').count()}}</h3>
                <span>Wanita</span>
            </div>
        </div>
    </div>
</div>
<div class="row" v-if="false">
    <div class="col-sm-4" v-if="kucing.dept !== undefined">
        <div class="dash-widget dash-widget4">
            <table class="table table-striped table-hover tb">
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>karyawan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="a in kucing.dept.all()">
                        <td><a class="badge badge-info" href="javascript:;" v-on:click="lain.dept=a.dept_id" v-html="a.dept_name"></a></td>
                        <td v-html="kucing.karyawan.where('dept_id',a.dept_id).count()"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-4" v-if="kucing.sect !== undefined">
        <div class="dash-widget dash-widget4">
            <table class="table table-striped table-hover tb">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>karyawan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="a in kucing.sect.where('dept_id2',lain.dept).all()">
                        <td><a class="badge badge-info" href="javascript:;" v-on:click="lain.sect=a.sect_id" v-html="a.sect_name"></a></td>
                        <td v-html="kucing.karyawan.where('sect_id',a.sect_id).count()"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-4" v-if="kucing.subsect !== undefined">
        <div class="dash-widget dash-widget4">
            <table class="table table-striped table-hover tb">
                <thead>
                    <tr>
                        <th>Sub-Section</th>
                        <th>karyawan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="a in kucing.subsect.where('sect_id2',lain.sect).all()">
                        <td><a class="badge badge-info" data-toggle="modal" href="#modal-detail" v-on:click="lain.subsect=a.subsect_id;lain.subsectn=a.subsect_name" v-html="a.subsect_name"></a></td>
                        <td v-html="kucing.karyawan.where('subsect_id',a.subsect_id).count()"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    @foreach ($tipeewd as $e)
    {{-- expr --}}
    <div class="col-sm-6">
        <div class="{{$warna[$e->id-1]}}">
            <div class="panel-heading text-center">
                <h3 class="panel-title">{{$e->ket}} <strong>[{{$e->kode}}]</strong></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <select v-model="thn2" id="thn" class="form-control">
                            @foreach ($thn as $x)
                            <option value={!!$x->thn!!}>{{$x->thn}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 form-group">
                        <select class="form-control" v-model="bln2">

                            @for ($i = 1; $i <13 ; $i++) <option value="{{$i}}">{{date_format(date_create("1-$i-2017"),"M")}}</option>
                                @endfor
                        </select>
                    </div>
                </div>
                <div class="grafik{{$e->id}}" style="height: 300px"></div>
                <div class="card-box">
                    <table class="table table-hover ">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Hari</th>
                                <th>Karyawan</th>
                                <th>Average</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="a in abchart({{$e->id}},1)">
                               <td ><span class="badge" v-html="a.dept_name"></span></td>
                               <td  v-html="a.only" ></td>
                               <td  v-html="a.all" ></td>
                               <td  v-html="a.rata" ></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
