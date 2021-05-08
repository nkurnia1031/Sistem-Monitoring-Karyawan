@extends('layout.index') @section('js')
<script type="text/javascript">
$(document).ready(function() {

    $(".nama").easyAutocomplete(options);
    app.getall(null, null, 'tipeewd');

    app.tbewd = $('.ewd').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=id&table=ewd&view=absen&primary2=tgl&key="+ app.tgl,
        "columns": [
            { "data": "nik" },
            { "data": "tipe" },
            { "data": "day" },
            { "data": "ket" },
            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });
    app.tbtipeewd = $('.tipeewd').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=id&table=tipeewd&view=tipeewd",
        "columns": [
            { "data": "kode" },
            { "data": "ket" },

            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });
    app.tblibur = $('.libur').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=id&table=libur&view=libur",
        "columns": [
            { "data": "tanggal" },
            { "data": "ket" },

            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });
    $('.modal-ewde').on('shown.bs.modal', function(e) {
        $(".nama").easyAutocomplete(options);


    });
    $('.modal-ewde').on('hidden.bs.modal', function(e) {
        app.ewd = null;
        $(".nama").easyAutocomplete(options);



    });

    $('.modal-tipeewde').on('hidden.bs.modal', function(e) {
        $('.modal-tipeewd').modal('show');
        app.getall(null, null, 'tipeewd');

    });
    $('.modal-libure').on('hidden.bs.modal', function(e) {
        $('.modal-libur').modal('show');

    });

    $('.modal-kar').on('shown.bs.modal', function(e) {
        app.getall(null, null, 'gol');
        app.getall(null, null, 'dept');
        app.getall(null, null, 'sect');
        app.getall(null, null, 'subsect');

    });


});
</script>
<script type="text/javascript">
var app = new Vue({
    el: '.app',
    data: {

        absen: [],
        tbewd: [],
        tipeewd: [],
        tbtipeewd: [],
        libur: [],
        tblibur: [],
        karyawan: [],
        dept: [],
        sect: [],
        subsect: [],
        gol: [],
        tgl: '{{date('Y-m-d')}}',




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
<div class="modal fade modal-tipeewd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Tipe Absensi</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped tipeewd" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Keterangan</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="kode" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="ket" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="insert('tipeewd')" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
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
<div class="modal fade modal-tipeewde" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Tipe</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped " width="100%">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Keterangan</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr v-for="b in tipeewd">
                                            <td>
                                                <input type="text" class="form-control" v-model="b.kode" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="kode" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" required="" v-model="b.ket" name="input[]">
                                                <input type="hidden" class="form-control" value="ket" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="update('id',b.id,'tipeewd')" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
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
<div class="modal fade modal-libur" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Hari Libur</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped libur" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <input type="date" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="tanggal" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="ket" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="insert('libur')" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
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
<div class="modal fade modal-libure" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Hari Libur</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr v-for="b in libur">
                                            <td>
                                                <input type="date" class="form-control" v-model="b.tanggal" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="tanggal" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" required="" v-model="b.ket" name="input[]">
                                                <input type="hidden" class="form-control" value="ket" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="update('id',b.id,'libur')" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
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
<div class="modal fade modal-ewde" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Absensir</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nama (Nik)</th>
                                            <th>Tanggal</th>
                                            <th style="width:20%;">Tipe</th>
                                            <th>Lama hari</th>
                                            <th>Keterangan</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr v-for="b in absen">
                                            <td>
                                                <input type="text" class="form-control nama" v-model="b.nik2" name="input[]">
                                                <input type="hidden" class="form-control" value="nik" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="date" v-model="b.tgl" class="form-control " name="input[]">
                                                <input type="hidden" class="form-control" value="tgl" name="tb[]">
                                            </td>
                                            <td>
                                                <select required="" name="input[]" v-model="b.tipe2" class="form-control custom-select">
                                                    <option v-for="a in tipeewd" :value="a.id">@{{a.kode}}</option>
                                                </select>
                                                <input type="hidden" class="form-control" value="tipe" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="number" min="0" step="any" v-model="b.day" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="day" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control" v-model="b.ket" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="ket" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="update('id',b.id,'ewd')" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
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
            <h3>Data Absensi</h3>
        </div>
        <div class="panel-body">
            <div class="form-group col-sm-4">
                <label class="form-label"> Pilih Tanggal<span class="form-required">*</span></label>
                <input type="date" v-model="tgl" v-on:change="tbewd.ajax.url('getall?tb=1&primary=id&primary2=tgl&key='+ tgl +'&table=ewd&view=absen').load()" class="form-control">
            </div>
            <div class="form-group col-sm-2">
                <label class="form-label"><span class="form-required">*</span></label>
                <div class="clearfix"></div>
                <span class=" btn btn-success " data-toggle="modal" data-target=".modal-tipeewd" v-on:click="tbtipeewd.ajax.reload();">
                    Tambah Tipe Absensi
                </span>
            </div>
            <div class="form-group col-sm-2">
                <label class="form-label"><span class="form-required">*</span></label>
                <div class="clearfix"></div>
                <span class=" btn btn-danger " data-toggle="modal" data-target=".modal-libur" v-on:click="tblibur.ajax.reload();">
                    Tambah Hari Libur
                </span>
            </div>
            <div class="clearfix"></div>
            <table class="table table-border table-striped custom-table m-b-0 ewd">
                <thead>
                    <tr>
                        <th>Nama (Nik)</th>
                        <th>Tipe</th>
                        <th>Lama hari</th>
                        <th>Keterangan</th>
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
                                <option v-for="a in tipeewd" :value="a.id">@{{a.kode}}</option>
                            </select>
                            <input type="hidden" class="form-control" value="tipe" name="tb[]">
                        </td>
                        <td>
                            <input type="number" min="0" step="any" placeholder="Dalam Satuan Hari" class="form-control" required="" name="input[]">
                            <input type="hidden" class="form-control" value="day" name="tb[]">
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Keterangan" required="" name="input[]">
                            <input type="hidden" class="form-control" value="ket" name="tb[]">
                        </td>
                        <td> <span v-on:click="insert('ewd',1)" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
