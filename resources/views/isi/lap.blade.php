@extends('layout.index') @section('js')
<script type="text/javascript">
$(document).ready(function() {
    @isset($Request->nik)
    $('#nik').val('{{$Request->nik}}');
ulangi()

    @endisset


    $(".nama").easyAutocomplete(options);



});
var interval = window.setInterval(ulangi, 1000000);


function ulangi() {
    $(".nama").easyAutocomplete(options);
    app.nik = $('#nik').val();
    app.getall(null, null, 'tipeewd');
    app.getall('nik2', app.nik, 'absen');
    app.getall('nik', app.nik, 'karyawan');
    app.getall('nik', app.nik, 'lembur2');

    app.getall(null, null, 'tipeewd');
    app.getwd();

}
</script>
<script type="text/javascript">
var app = new Vue({
    el: '.app',
    data: {
        nik: 0,
        thn2: 0,
        bln2: 0,
        absen: [],
        karyawan: [],
        wd: [],
        absentb: 0,
        lemburtb: 0,
        tipeewd: [],
        tipe: 0,
        n: 1,
        detail: 0,
        detaill: 0,
        judul: 0,
        tbabsen: 0,
        tbabsen2: [],
        tbabsenkey: [],
        tblembur: 0,
        lembur2: [],


    },
    methods: {

        getall: function(primary, key, table) {
            $('.app').loading({
                circles: 3,
                overlay: true
            });
            var queryString;
            queryString = 'primary=' + primary + '&key=' + key + '&table=' + table;

            jQuery.ajax({

                url: 'getall',
                data: queryString,
                type: "GET",
                success: function(data) {

                    var mydata = JSON.parse(data);
                    app[table] = collect(mydata['data']);
                    $('.app').loading({ destroy: true });


                },

                error: function() {
                    alert('koneksi gagal');
                    $('.app').loading({ destroy: true });
                }
            });

        },
        getwd: function() {


            jQuery.ajax({

                url: 'workday',
                type: "GET",
                success: function(data) {

                    var mydata = JSON.parse(data);
                    app['wd'] = collect(mydata);

                },
                error: function() { alert('koneksi gagal') }
            });

        },
        insert: function(table, modal) {
            if (modal > 0) {
                a = $('.' + table + ' *[name="input[]"]').map(
                    function() {
                        return $(this).val();
                    }).get();
                a = JSON.stringify(a);
                b = $('.' + table + ' *[name="tb[]"]').map(
                    function() {
                        return $(this).val();
                    }).get();
                b = JSON.stringify(b);

            } else {
                a = $('.modal-' + table + ' *[name="input[]"]').map(
                    function() {
                        return $(this).val();
                    }).get();
                a = JSON.stringify(a);
                b = $('.modal-' + table + ' *[name="tb[]"]').map(
                    function() {
                        return $(this).val();
                    }).get();
                b = JSON.stringify(b);

            }

            var queryString;
            queryString = 'input=' + a + '&tb=' + b + '&table=' + table;
            jQuery.ajax({

                url: 'create',
                data: queryString,

                type: "GET",
                success: function(data) {

                    alert(data);
                    app['tb' + table].ajax.reload();
                    if (modal > 0) {
                        $('.' + table + ' *[name="input[]"]').val('');
                    } else {
                        $('.modal-' + table + ' *[name="input[]"]').val('');
                    }





                },
                error: function() { alert('koneksi gagal') }
            });


        },
        update: function(primary, key, table) {
            a = $('.modal-' + table + 'e *[name="input[]"]').map(
                function() {
                    return $(this).val();
                }).get();
            a = JSON.stringify(a);
            b = $('.modal-' + table + 'e *[name="tb[]"]').map(
                function() {
                    return $(this).val();
                }).get();
            b = JSON.stringify(b);
            var queryString;
            queryString = 'primary=' + primary + '&key=' + key + '&input=' + a + '&tb=' + b + '&table=' + table;
            jQuery.ajax({

                url: 'update',
                data: queryString,
                type: "GET",
                success: function(data) {

                    alert(data);
                    app['tb' + table].ajax.reload();
                    $('.modal-' + table + 'e *[name="input[]"]').val('');




                },
                error: function() { alert('koneksi gagal') }
            });


        },
        delete: function(primary, key, table) {

            var queryString;
            queryString = 'primary=' + primary + '&key=' + key + '&table=' + table;

            jQuery.ajax({

                url: 'delete',
                data: queryString,
                type: "GET",
                success: function(data) {
                    alert(data);
                    app['tb' + table].ajax.reload();
                },
                error: function() { alert('koneksi gagal') }
            });

        },
        hitung: function(n, id, sum) {
            tes = app.absen.where('nik2', app.nik).where('thn', app.thn);

            if (n != 0) {
                tes = tes.where('bln', n);
            }
            if (id != 0) {
                tes = tes.where('tipe2', id);
            }
            if (sum == 1) {
                tes = tes.sum(function(product) {
                    return parseFloat(product.day);
                });
                return parseFloat(tes.toFixed(2));
            } else {
                app.detail = tes.all();
            }



        },

        hitungl: function(n, id, sum, jns) {
            tes = app.lembur2.where('nik', app.nik).where('thn', app.thn);

            if (n != 0) {
                tes = tes.where('bln', n);
            }

            tes = tes.where('type', parseInt(id));

            if (sum == 1) {
                tes = tes.sum(function(product) {
                    return parseFloat(product[jns]);
                });
                return parseFloat(tes.toFixed(2));
            } else {
                app.detaill = tes.all();
            }



        },
        ewd: function(n) {

            tesx = app.wd.where('thn', app.thn)
            if (n != 0) {
                tesx = tesx.where('bln', n).sum('wd');

            }

            tes1 = tesx - this.hitung(n, 1, 1) - this.hitung(n, 2, 1) - this.hitung(n, 3, 1) - this.hitung(n, 4, 1);
            tes1 = (tes1 / tesx) * 10



            return tes1.toFixed(2);


        },
        tbtoarr: function(table, ignore) {
            app[table + '2'] = []
            chart[table].data.datasets = app[table + '2'];

            chart[table].update();

            app[table] = $('#' + table).tableToJSON({ ignoreColumns: ignore });
            app[table + 'key'] = $('#' + table).tableToJSON({ ignoreColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13] });
            if (app[table].length > 0) {


                for (var i = 0; i < app[table].length; i++) {

                    app[table + '2'][i] = tipe[app[table + 'key'][i]['Tipe Absen']];


                    app[table + '2'][i]['label'] = app[table + 'key'][i]['Tipe Absen'];
                    app[table + '2'][i]['data'] = collect(app[table][i]).toArray();






                }

            } else {
                app[table + '2'] = [];
            }

            chart[table].data.datasets = app[table + '2'];

            chart[table].update();

        }





    },

    computed: {
        // a computed getter
        thn: function() {

            return parseInt(this.thn2)
        },
        bln: function() {

            return parseInt(this.bln2)
        },
        ewds: function() {
            h = 0;
            for (var i = 1; i < 13; i++) {
                h += parseFloat(this.ewd(i));
            }
            h = h / 12;

            return h.toFixed(2);
        },
        lemchart: function() {
            arr = [];
            kali = [{
                    head: 'x1.5',
                    key: 'x15'
                }, {
                    head: 'x2',
                    key: 'x2'
                }, {
                    head: 'x3',
                    key: 'x3'
                },
                {
                    head: 'x4',
                    key: 'x4'
                }
            ];
            for (var i = 0; i < kali.length; i++) {
                arr[i] = [kali[i]['head'], this.hitungl(this.bln, parseInt(this.tipe), 1, kali[i]['key'])];
            }
            return arr;


        }
    },
    beforeUpdate: function() {




    },
    updated: function() {

        this.tbtoarr('tbabsen', [13, 0]);
        if (app.tbabsen != 0) {
            app.absentb.destroy();

        }
        if (app.lemburtb != 0) {
            app.lemburtb.destroy();

        }

        app.absentb = $('#absentb').DataTable({

            "lengthMenu": [
                [5, 10, -1],
                [5, 10, "All"]
            ],
        });
        app.lemburtb = $('#lemburtb').DataTable({

            "lengthMenu": [
                [5, 10, -1],
                [5, 10, "All"]
            ],
        });

        var chart = c3.generate({
            bindto: '#chartlem',
            data: {
                columns: [],
                type: 'pie',
            },
            tooltip: {
                format: {
                    value: function(value, ratio, id, index) { return value + " Jam"; }
                }
            }
        });
        chart.load({
            columns: this.lemchart,

        });



    }

});
</script>
<script>
function getRandColor(brightness) {

    // Six levels of brightness from 0 to 5, 0 being the darkest
    var rgb = [Math.random() * 256, Math.random() * 256, Math.random() * 256];
    var mix = [brightness * 51, brightness * 51, brightness * 51]; //51 => 255/5
    var mixedrgb = [rgb[0] + mix[0], rgb[1] + mix[1], rgb[2] + mix[2]].map(function(x) { return Math.round(x / 2.0) })
    return "rgb(" + mixedrgb.join(",") + ")";
}

function r() { return Math.floor(Math.random() * 255) }
chart = [];
var ctx = $('#myChart');
chart['tbabsen'] = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
<script type="text/javascript">
var tipe = []
tipe['Cuti (T)'] = {
    backgroundColor: "rgba(13, 242, 13, 0.3)",
    borderColor: "rgba(13, 242, 13, 0.70)",
    pointBorderColor: "rgba(13, 242, 13, 0.70)",
    pointBackgroundColor: "rgba(13, 242, 13, 0.70)",
    pointHoverBackgroundColor: "#fff",
    pointHoverBorderColor: "rgba(151,187,205,1)",
    pointBorderWidth: 1,
    label: null,
    data: null
}
tipe['Effective Working Days( % x 10 )'] = {
    backgroundColor: "rgba(13, 242, 13, 0.3)",
    borderColor: "rgba(13, 242, 13, 0.70)",
    pointBorderColor: "rgba(13, 242, 13, 0.70)",
    pointBackgroundColor: "rgba(13, 242, 13, 0.70)",
    pointHoverBackgroundColor: "#fff",
    pointHoverBorderColor: "rgba(151,187,205,1)",
    pointBorderWidth: 1,
    label: null,
    data: null
}
tipe['Datang Terlambat (DT)'] = {
    backgroundColor: "rgba(38, 185, 154, 0.31)",
    borderColor: "rgba(38, 185, 154, 0.7)",
    pointBorderColor: "rgba(38, 185, 154, 0.7)",
    pointBackgroundColor: "rgba(38, 185, 154, 0.7)",
    pointHoverBackgroundColor: "#fff",
    pointHoverBorderColor: "rgba(220,220,220,1)",
    pointBorderWidth: 1,
    label: null,
    data: null
}
tipe['Pulang Cepat (PC)'] = {
    backgroundColor: "rgba(3, 88, 106, 0.3)",
    borderColor: "rgba(3, 88, 106, 0.70)",
    pointBorderColor: "rgba(3, 88, 106, 0.70)",
    pointBackgroundColor: "rgba(3, 88, 106, 0.70)",
    pointHoverBackgroundColor: "#fff",
    pointHoverBorderColor: "rgba(151,187,205,1)",
    pointBorderWidth: 1,
    label: null,
    data: null
}
tipe['Mangkir (M)'] = {
    backgroundColor: "rgba(189, 189, 40, 0.3)",
    borderColor: "rgba(189, 189, 40, 0.70)",
    pointBorderColor: "rgba(189, 189, 40, 0.70)",
    pointBackgroundColor: "rgba(189, 189, 40, 0.70)",
    pointHoverBackgroundColor: "#fff",
    pointHoverBorderColor: "rgba(249, 249, 26,1)",
    pointBorderWidth: 1,
    label: null,
    data: null
}
tipe['Sakit (S)'] = {
    backgroundColor: "rgba(249, 26, 26, 0.3)",
    borderColor: "rgba(249, 26, 26, 0.70)",
    pointBorderColor: "rgba(249, 26, 26, 0.70)",
    pointBackgroundColor: "rgba(249, 26, 26, 0.70)",
    pointHoverBackgroundColor: "#fff",
    pointHoverBorderColor: "rgba(151,187,205,1)",
    pointBorderWidth: 1,
    label: null,
    data: null
}
</script>
@endsection @section('modal')
<div class="modal fade " id="modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">@{{judul}}</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box" v-if="detail!=0">
                                <table class="table table-striped " id="absentb" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Lama(hari)</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="a in detail">
                                            <td>@{{a.tgl}}</td>
                                            <td>@{{a.day}}</td>
                                            <td>@{{a.ket}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
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
<div class="modal fade " id="modal-detaill" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">@{{judul}}</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box" v-if="detaill!=0">
                                <table class="table table-striped " id="lemburtb" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>X1.5</th>
                                            <th>X2</th>
                                            <th>X3</th>
                                            <th>X4</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="a in detaill">
                                            <td>@{{a.tgl}}</td>
                                            <td>@{{a.x15}}</td>
                                            <td>@{{a.x2}}</td>
                                            <td>@{{a.x3}}</td>
                                            <td>@{{a.x4}}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
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
<div class="col-sm-12">
    <div class="panel ">
        <div class="panel-heading">
            <h3>{{$judul}}</h3>
        </div>
        <div class="panel-body" id="dam">
            <form action="tes" method="post" enctype="multipart/form-data">
                <div class="form-group col-sm-4">
                    <label class="form-label"> Pilih Karyawan<span class="form-required">*</span></label>
                    <input type="text" class="form-control nama"  id="nik" name="input[]">
                </div>
                <div class="form-group col-sm-4" v-if="nik>0">
                    <label class="form-label"> Pilih Tahun<span class="form-required">*</span></label>
                    <select v-model="thn2" id="thn" class="form-control">
                        @foreach ($thn as $e)
                        <option value={!!$e->thn!!}>{{$e->thn}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label class="form-label"><span class="form-required">*</span></label><br>
                    <button class="btn btn-info" type="button" onclick="ulangi()">Refresh Data</button>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>
<div id="print">
    <div class="col-sm-12" v-if="nik>0">
        <div class="panel " v-for="a in karyawan.where('nik',nik).all()">
            <div class="panel-heading">
                <h3>Data Diri Karyawan</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card-box ">
                            <ul class="list-group ">
                                <li class="list-group-item ">
                                    <span class="badge">@{{a.nama}}</span>
                                    Nama Lengkap
                                </li>
                                <li class="list-group-item ">
                                    <span class="badge">@{{a.nik}}</span>
                                    NIK
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">@{{a.gender}}</span>
                                    Gender
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">@{{a.level}}</span>
                                    Level
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">@{{a.status}}</span>
                                    Status
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card-box ">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <span class="badge">@{{a.dept_name}}</span>
                                    Department
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">@{{a.sect_name}}</span>
                                    Section
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">@{{a.subsect_name}}</span>
                                    Sub-Section
                                </li>
                                <li class="list-group-item">
                                    <span class="badge">@{{a.gol}}</span>
                                    Golongan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="panel ">
            <div class="panel-heading">
                <h3>Effective Working Days</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <canvas id="myChart" height="65px"></canvas>
                        </div>
                    </div>
                    <div class="col-sm-12" v-if="thn>0">
                        <div class="card-box ">
                            <table class="table table-bordered" id="tbabsen">
                                <thead>
                                    <tr>
                                        <th>Tipe Absen</th>
                                        @for ($i = 1; $i <13 ; $i++) <th>{{date_format(date_create("2019-$i-01"),'M')}}</th>
                                            @endfor
                                            <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="a in absen.where('nik2',nik).where('thn',thn).unique('tipe').all()">
                                        <td>@{{a.tipe}}</td>
                                        <td v-for="n in 12"><a href="#modal-detail" data-toggle="modal" v-on:click="hitung(n,a.tipe2);judul=a.tipe">@{{hitung(n,a.tipe2,1)}}</a></td>
                                        <td>@{{hitung(0,a.tipe2,1)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Effective Working Days( % x 10 )</td>
                                        <td v-for="n in 12">@{{ewd(n)}}</td>
                                        <td>@{{ewds}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6" v-if="thn>0">
        <div class="panel ">
            <div class="panel-heading">
                <h3>Lembur (jam)</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-sm-6" v-if="nik>0">
                        <select v-model="thn2" id="thn" class="form-control">
                            @foreach ($thn as $e)
                            <option value={!!$e->thn!!}>{{$e->thn}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6  form-group">
                        <select class="form-control" v-model="tipe">
                            <option value="0">SPL</option>
                            <option value="1">Tetap</option>
                        </select>
                    </div>
                </div>
                <div class="card-box ">
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>X1.5</th>
                                <th>X2</th>
                                <th>X3</th>
                                <th>X4</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 1; $i <13 ; $i++) <tr>
                                <td><a href="#modal-detaill" data-toggle="modal" v-on:click="hitungl({{$i}},tipe,'','x15');judul='Lembur {{date_format(date_create("1-$i-2017"),"M")}}'">{{date_format(date_create("1-$i-2017"),"M")}}</a></td>
                                <td v-html="hitungl({{$i}},tipe,1,'x15')"></td>
                                <td v-html="hitungl({{$i}},tipe,1,'x2')"></td>
                                <td v-html="hitungl({{$i}},tipe,1,'x3')"> </td>
                                <td v-html="hitungl({{$i}},tipe,1,'x4')"></td>
                                <td v-html="hitungl({{$i}},tipe,1,'x4')+hitungl({{$i}},tipe,1,'x3')+hitungl({{$i}},tipe,1,'x2')+hitungl({{$i}},tipe,1,'x15')"></td>
                                </tr>
                                @endfor
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th v-html="hitungl(0,tipe,1,'x15')"></th>
                                <th v-html="hitungl(0,tipe,1,'x2')"></th>
                                <th v-html="hitungl(0,tipe,1,'x3')"></th>
                                <th v-html="hitungl(0,tipe,1,'x4')"></th>
                                <th v-html="hitungl(0,tipe,1,'x4')+hitungl(0,tipe,1,'x3')+hitungl(0,tipe,1,'x2')+hitungl(0,tipe,1,'x15')"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6" v-if="thn>0">
        <div class="panel ">
            <div class="panel-heading">
                <h3>Grafik Lembur (%)</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="form-group col-sm-4" v-if="nik>0">
                        <select v-model="thn2" id="thn" class="form-control">
                            @foreach ($thn as $e)
                            <option value={!!$e->thn!!}>{{$e->thn}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4  form-group">
                        <select class="form-control" v-model="tipe">
                            <option value="0">SPL</option>
                            <option value="1">Tetap</option>
                        </select>
                    </div>
                    <div class="col-sm-4 form-group">
                        <select class="form-control" v-model="bln2">
                            <option value="0">Total</option>
                            @for ($i = 1; $i <13 ; $i++) <option value="{{$i}}">{{date_format(date_create("1-$i-2017"),"M")}}</option>
                                @endfor
                        </select>
                    </div>
                </div>
                <div class="card-box ">
                    <div id="chartlem" style="height: 300px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
