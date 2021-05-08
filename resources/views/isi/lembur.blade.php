@extends('layout.index') @section('js')
<script type="text/javascript">
$(document).ready(function() {

    $(".nama").easyAutocomplete(options);
    app.getall(null, null, 'tipeewd');

    app.tbovertime = $('.overtime').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=id&primary2=tgl&key='+ app.tgl +'&table=overtime&view=lembur",
        "columns": [
            { "data": "nik" },
            { "data": "tipe" },
            { "data": "x15" },
            { "data": "x2" },
            { "data": "x3" },
            { "data": "x4" },

            { "data": "set" },

        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });




    $('.modal-kar').on('shown.bs.modal', function(e) {
        app.getall(null, null, 'gol');
        app.getall(null, null, 'dept');
        app.getall(null, null, 'sect');
        app.getall(null, null, 'subsect');

    });
    $('.modal-overtimee').on('shown.bs.modal', function(e) {
        $(".nama").easyAutocomplete(options);


    });
     $('.modal-overtimee').on('hidden.bs.modal', function(e) {
        app.lembur=null;
        $(".nama").easyAutocomplete(options);


    });


});
</script>
<script type="text/javascript">
var app = new Vue({
    el: '.app',
    data: {

        lembur: [],
        tbovertime: [],

        karyawan: [],
        dept: [],
        sect: [],
        subsect: [],
        gol: [],
        tgl: "{{date('Y-m-d')}}",




    },
    methods: {

        getall: function(primary, key, table) {
            var queryString;
            queryString = 'primary=' + primary + '&key=' + key + '&table=' + table;

            jQuery.ajax({

                url: 'getall',
                data: queryString,
                type: "GET",
                success: function(data) {

                    var mydata = JSON.parse(data);
                    app[table] = mydata['data'];

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

    }
});
</script>
@endsection @section('modal')
<div class="modal fade modal-kar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Karyawan</h4>
            </div>
            <div class="modal-body" v-for="b in karyawan">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-6 ">
                            <div class=" card-box">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">NIK<span class="form-required">*</span></label>
                                        <input type="number" readonly="" v-model="b.nik" class="form-control" required="" name="input[]">
                                        <input type="hidden" class="form-control" value="nik" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Jenis Kelamin<span class="form-required">*</span></label>
                                        <div class="selectgroup selectgroup-pills">
                                            <select name="input[]" disabled="" v-model="b.gender" required="" class="form-control custom-select">
                                                <option>M</option>
                                                <option>L</option>
                                            </select>
                                            <input type="hidden" class="form-control" value="gender" name="tb[]">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Nama<span class="form-required">*</span></label>
                                        <input type="text" readonly="" v-model="b.nama" class="form-control" required="" name="input[]">
                                        <input type="hidden" class="form-control" value="nama" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Level<span class="form-required">*</span></label>
                                        <select name="input[]" disabled="" v-model="b.level" required="" class="form-control custom-select">
                                            <option>Non Staff</option>
                                            <option>Staff</option>
                                        </select>
                                        <input type="hidden" class="form-control" value="level" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Status<span class="form-required">*</span></label>
                                        <select name="input[]" disabled="" v-model="b.status" required="" class="form-control custom-select">
                                            <option>PKWT</option>
                                            <option>Permanent</option>
                                        </select>
                                        <input type="hidden" class="form-control" value="status" name="tb[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 ">
                            <div class=" card-box">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Department<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" disabled="" v-model="b.dept_id2" class="form-control custom-select">
                                                <option v-for="a in dept" :value="a.dept_id">@{{a.dept_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Section<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" disabled="" v-model="b.sect_id2" class="form-control custom-select">
                                                <option v-for="a in sect" :value="a.sect_id">@{{a.sect_name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Sub-Section<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" disabled="" name="input[]" v-model="b.subsect_id2" class="form-control custom-select">
                                                <option v-for="a in subsect" :value="a.subsect_id">@{{a.subsect_name}}</option>
                                            </select>
                                        </div>
                                        <input type="hidden" class="form-control" value="subsect_id2" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Gol<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" disabled="" name="input[]" v-model="b.gola" class="form-control custom-select">
                                                <option v-for="a in gol" :value="a.idgol">@{{a.gol}}</option>
                                            </select>
                                        </div>
                                        <input type="hidden" class="form-control" value="gola" name="tb[]">
                                    </div>
                                </div>
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
<div class="modal fade modal-overtimee" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="list" v-for="b in lembur">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Lembur</h4>
            </div>
            <div class="modal-body" >
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-6 ">
                            <div class=" card-box">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">NIK<span class="form-required">*</span></label>
                                        <input type="text" class="form-control nama" v-model="b.nik2" name="input[]">
                                        <input type="hidden" class="form-control" value="nik" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Tanggal<span class="form-required">*</span></label>
                                        <input type="date" v-model="b.tgl" class="form-control " name="input[]">
                                        <input type="hidden" class="form-control" value="tgl" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Level<span class="form-required">*</span></label>
                                        <select required="" v-model="b.type" name="input[]" class="form-control custom-select">
                                            <option value="0">SPL</option>
                                            <option value="1">Wajib</option>
                                        </select>
                                        <input type="hidden" class="form-control" value="type" name="tb[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 ">
                            <div class=" card-box">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">x1.5<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <input type="number" v-model="b.x15" min="0" step="any" class="form-control" required="" name="input[]">
                                            <input type="hidden" class="form-control" value="x15" name="tb[]">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">x2<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <input type="number" v-model="b.x2" min="0" step="any" class="form-control" required="" name="input[]">
                                            <input type="hidden" class="form-control" value="x2" name="tb[]">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">x3<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <input type="number" v-model="b.x3" min="0" step="any" class="form-control" required="" name="input[]">
                                            <input type="hidden" class="form-control" value="x3" name="tb[]">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">x4<span class="form-required">*</span></label>
                                        <input type="number" v-model="b.x4" min="0" step="any" class="form-control" required="" name="input[]">
                                        <input type="hidden" class="form-control" value="x4" name="tb[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <span v-on:click="update('id',b.id,'overtime')" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span>
            </div>
        </div>
    </div>
</div>
@endsection @section('isi')
<div class="col-sm-12">
    <div class="panel ">
        <div class="panel-heading">
            <h3>Data Lembur</h3>
        </div>
        <div class="panel-body">
            <div class="form-group col-sm-4">
                <label class="form-label"> Pilih Tanggal<span class="form-required">*</span></label>
                <input type="date" v-model="tgl" v-on:change="tbovertime.ajax.url('getall?tb=1&primary=id&primary2=tgl&key='+ tgl +'&table=overtime&view=lembur').load()" class="form-control">
            </div>
            <div class="clearfix"></div>
            <table class="table table-border table-striped custom-table m-b-0 overtime">
                <thead>
                    <tr>
                        <th style="width: 30%;">Nama (Nik)</th>
                        <th style="width: 20%;">Tipe</th>
                        <th>x1.5</th>
                        <th>x2</th>
                        <th>x3</th>
                        <th>x4</th>
                        <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td>
                            <input type="text" class="form-control nama" name="input[]">
                            <input type="hidden" class="form-control" value="nik" name="tb[]">
                            <input type="hidden" v-model="tgl" class="form-control " name="input[]">
                            <input type="hidden" class="form-control" value="tgl" name="tb[]">
                        </td>
                        <td>
                            <select required="" name="input[]" class="form-control custom-select">
                                <option value="0">SPL</option>
                                <option value="1">Wajib</option>
                            </select>
                            <input type="hidden" class="form-control" value="type" name="tb[]">
                        </td>
                        <td>
                            <input type="number" min="0" step="any" value="0" class="form-control" required="" name="input[]">
                            <input type="hidden" class="form-control" value="x15" name="tb[]">
                        </td>
                        <td>
                            <input type="number" min="0" step="any" value="0" class="form-control" required="" name="input[]">
                            <input type="hidden" class="form-control" value="x2" name="tb[]">
                        </td>
                        <td>
                            <input type="number" min="0" step="any" value="0" class="form-control" required="" name="input[]">
                            <input type="hidden" class="form-control" value="x3" name="tb[]">
                        </td>
                        <td>
                            <input type="number" min="0" step="any" value="0" class="form-control" required="" name="input[]">
                            <input type="hidden" class="form-control" value="x4" name="tb[]">
                        </td>
                        <td> <span v-on:click="insert('overtime',1)" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
