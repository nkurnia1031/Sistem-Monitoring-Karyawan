@extends('layout.index') @section('js')
<script type="text/javascript">
$(document).ready(function() {

    app.tbdept = $('.dept').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=dept_id&table=dept&view=dept",
        "columns": [
            { "data": "dept_id" },
            { "data": "dept_name" },
            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });
    app.tbsect = $('.sect').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=sect_id&table=sect&view=section",
        "columns": [
            { "data": "sect_id" },
            { "data": "dept_name" },
            { "data": "sect_name" },
            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });
    app.tbsubsect = $('.subsect').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=subsect_id&table=subsect&view=bagian",
        "columns": [
            { "data": "subsect_id" },
            { "data": "dept_name" },
            { "data": "sect_name" },
            { "data": "subsect_name" },
            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });
    app.tbgol = $('.gol').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=idgol&table=gol&view=gol",
        "columns": [
            { "data": "idgol" },
            { "data": "gol" },
            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });
    app.tbkar = $('.kar').DataTable({
        "processing": true,
        'ajax': "getall?tb=1&primary=nik&table=kar&view=karyawan",
        "columns": [
            { "data": "nik" },
            { "data": "nama" },
            { "data": "gender" },
            { "data": "level" },
            { "data": "status" },
            { "data": "dept_name" },
            { "data": "sect_name" },
            { "data": "subsect_name" },
            { "data": "gol" },

            { "data": "set" },
        ],
        "lengthMenu": [
            [5, 10, -1],
            [5, 10, "All"]
        ],
    });



    $('.modal-depte').on('hidden.bs.modal', function(e) {
        $('.modal-dept').modal('show');
    });
    $('.modal-secte').on('hidden.bs.modal', function(e) {
        $('.modal-sect').modal('show');
    });
    $('.modal-subsecte').on('hidden.bs.modal', function(e) {
        $('.modal-subsect').modal('show');
    });
    $('.modal-gole').on('hidden.bs.modal', function(e) {
        $('.modal-gol').modal('show');
    });

    $('.modal-kar').on('shown.bs.modal', function(e) {
        app.getall(null, null, 'gol');
        app.getall(null, null, 'dept');

    });
    $('.modal-kare').on('show.bs.modal', function(e) {
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
        data1: [],
        prodi1: 'Semua',
        prodi2: 'Semua',
        prodi3: [],
        dept: [],
        tbdept: [],
        deptc: [],
        edit: [],
        sect: [],
        tbsect: [],
        sectc: [],
        subsect: [],
        tbsubsect: [],

        gol: [],
        karyawan: [],
        tbgol: [],




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
        insert: function(table) {
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
            var queryString;
            queryString = 'input=' + a + '&tb=' + b + '&table=' + table;
            jQuery.ajax({

                url: 'create',
                data: queryString,

                type: "GET",
                success: function(data) {

                    alert(data);
                    app['tb' + table].ajax.reload();
                    $('.modal-' + table + ' *[name="input[]"]').val('');




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
                <h4 class="modal-title">Form Karyawan</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-6 ">
                            <div class=" card-box">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">NIK<span class="form-required">*</span></label>
                                        <input type="number" class="form-control" required="" name="input[]">
                                        <input type="hidden" class="form-control" value="nik" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Gender<span class="form-required">*</span></label>
                                        <div class="selectgroup selectgroup-pills">
                                            <select name="input[]" required="" class="form-control custom-select">
                                                <option>M</option>
                                                <option>L</option>
                                            </select>
                                            <input type="hidden" class="form-control" value="gender" name="tb[]">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Nama<span class="form-required">*</span></label>
                                        <input type="text" class="form-control" required="" name="input[]">
                                        <input type="hidden" class="form-control" value="nama" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Level<span class="form-required">*</span></label>
                                        <select name="input[]" required="" class="form-control custom-select">
                                            <option>Non Staff</option>
                                            <option>Staff</option>
                                        </select>
                                        <input type="hidden" class="form-control" value="level" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Status<span class="form-required">*</span></label>
                                        <select name="input[]" required="" class="form-control custom-select">
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
                                            <select required="" v-on:change="getall('dept_id2',deptc,'sect')" v-model="deptc" class="form-control custom-select">
                                                <option v-for="a in dept" :value="a.dept_id">@{{a.dept_name}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-dept"><i class="fa fa-plus-square-o "></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Section<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" v-on:change="getall('sect_id2',sectc,'subsect')" v-model="sectc" class="form-control custom-select">
                                                <option v-for="a in sect" :value="a.sect_id">@{{a.sect_name}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-sect"><i class="fa fa-plus-square-o "></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Sub-Section<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" name="input[]" class="form-control custom-select">
                                                <option v-for="a in subsect" :value="a.subsect_id">@{{a.subsect_name}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-subsect"><i class="fa fa-plus-square-o "></i></span>
                                        </div>
                                        <input type="hidden" class="form-control" value="subsect_id2" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Gol<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" name="input[]" class="form-control custom-select">
                                                <option v-for="a in gol" :value="a.idgol">@{{a.gol}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-gol"><i class="fa fa-plus-square-o "></i></span>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">batal</button>
                <button type="button" v-on:click="insert('kar')" data-dismiss="modal" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-kare" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" v-for="b in karyawan">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Karyawan</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-6 ">
                            <div class=" card-box">
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">NIK<span class="form-required">*</span></label>
                                        <input type="number" v-model="b.nik" class="form-control" required="" name="input[]">
                                        <input type="hidden" class="form-control" value="nik" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Gender<span class="form-required">*</span></label>
                                        <div class="selectgroup selectgroup-pills">
                                            <select name="input[]" v-model="b.gender" required="" class="form-control custom-select">
                                                <option>M</option>
                                                <option>L</option>
                                            </select>
                                            <input type="hidden" class="form-control" value="gender" name="tb[]">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label class="form-label">Nama<span class="form-required">*</span></label>
                                        <input type="text" v-model="b.nama" class="form-control" required="" name="input[]">
                                        <input type="hidden" class="form-control" value="nama" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Level<span class="form-required">*</span></label>
                                        <select name="input[]" v-model="b.level" required="" class="form-control custom-select">
                                            <option>Non Staff</option>
                                            <option>Staff</option>
                                        </select>
                                        <input type="hidden" class="form-control" value="level" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Status<span class="form-required">*</span></label>
                                        <select name="input[]" v-model="b.status" required="" class="form-control custom-select">
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
                                            <select required="" v-on:change="getall('dept_id2',b.dept_id2,'sect')" v-model="b.dept_id2" class="form-control custom-select">
                                                <option v-for="a in dept" :value="a.dept_id">@{{a.dept_name}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-dept"><i class="fa fa-plus-square-o "></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Section<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" v-on:change="getall('sect_id2',b.sect_id2,'subsect')" v-model="b.sect_id2" class="form-control custom-select">
                                                <option v-for="a in sect" :value="a.sect_id">@{{a.sect_name}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-sect"><i class="fa fa-plus-square-o "></i></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Sub-Section<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" name="input[]" v-model="b.subsect_id2" class="form-control custom-select">
                                                <option v-for="a in subsect" :value="a.subsect_id">@{{a.subsect_name}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-subsect"><i class="fa fa-plus-square-o "></i></span>
                                        </div>
                                        <input type="hidden" class="form-control" value="subsect_id2" name="tb[]">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label class="form-label">Gol<span class="form-required">*</span></label>
                                        <div class="input-group">
                                            <select required="" name="input[]" v-model="b.gola" class="form-control custom-select">
                                                <option v-for="a in gol" :value="a.idgol">@{{a.gol}}</option>
                                            </select>
                                            <span class="input-group-addon btn btn-info" data-toggle="modal" data-target=".modal-gol"><i class="fa fa-plus-square-o "></i></span>
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
                <button type="button" class="btn btn-default" data-dismiss="modal">batal</button>
                <button type="button" v-on:click="update('nik',b.nik,'kar')" data-dismiss="modal" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-dept" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-toggle="modal" data-target=".modal-kar"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Department</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped dept" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id Department</th>
                                            <th>Department</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <input type="text" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="dept_name" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="insert('dept')" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target=".modal-kar">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-depte" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Department</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped " width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id Department</th>
                                            <th>Department</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr v-for="a in dept">
                                            <td colspan="2">
                                                <input type="text" v-model="a.dept_name" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="dept_name" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="update('dept_id',a.dept_id,'dept')" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
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
<div class="modal fade modal-sect" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-toggle="modal" data-target=".modal-kar"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Section</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped sect" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id Section</th>
                                            <th>Department</th>
                                            <th>Section</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <select required="" name="input[]" class="form-control custom-select">
                                                    <option v-for="a in dept" :value="a.dept_id">@{{a.dept_name}}</option>
                                                </select>
                                                <input type="hidden" class="form-control" value="dept_id2" name="tb[]">
                                            </td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="sect_name" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="insert('sect')" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target=".modal-kar">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-secte" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Section</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped " width="100%">
                                    <thead>
                                        <tr>
                                            <th>Department</th>
                                            <th>Section</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr v-for="a in sect">
                                            <td>
                                                <select required="" v-model="a.dept_id2" name="input[]" class="form-control custom-select">
                                                    <option v-for="a in dept" :value="a.dept_id">@{{a.dept_name}}</option>
                                                </select>
                                                <input type="hidden" class="form-control" value="dept_id2" name="tb[]">
                                            </td>
                                            <td>
                                                <input type="text" v-model="a.sect_name" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="sect_name" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="update('sect_id',a.sect_id,'sect')" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
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
<div class="modal fade modal-subsect" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-toggle="modal" data-target=".modal-kar"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Sub-Section</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped subsect" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Id Sub-Section</th>
                                            <th>Department</th>
                                            <th>Section</th>
                                            <th>Sub-Section</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <select required="" v-on:change="getall('dept_id2',deptc,'sect')" v-model="deptc" class="form-control custom-select">
                                                    <option v-for="a in dept" :value="a.dept_id">@{{a.dept_name}}</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select required="" name="input[]" class="form-control custom-select">
                                                    <option v-for="a in sect" :value="a.sect_id">@{{a.sect_name}}</option>
                                                </select>
                                                <input type="hidden" class="form-control" value="sect_id2" name="tb[]">
                                            </td>
                                            <td colspan="2">
                                                <input type="text" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="subsect_name" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="insert('subsect')" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target=".modal-kar">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-gol" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-toggle="modal" data-target=".modal-kar"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Golongan</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped gol" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID Golongan</th>
                                            <th>Golongan</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <input type="text" class="form-control" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="gol" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="insert('gol')" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target=".modal-kar">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-gole" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Form Edit Golongan</h4>
            </div>
            <div class="modal-body">
                <div class="content container-fluid">
                    <div class="row ">
                        <div class="col-sm-12 ">
                            <div class=" card-box">
                                <table class="table table-striped " width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID Golongan</th>
                                            <th>Golongan</th>
                                            <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr v-for="b in gol">
                                            <td colspan="2">
                                                <input type="text" class="form-control" v-model="b.gol" required="" name="input[]">
                                                <input type="hidden" class="form-control" value="gol" name="tb[]">
                                            </td>
                                            <td> <span v-on:click="update('idgol',b.idgol,'gol')" data-dismiss="modal" class="btn btn-success"><i class="fa fa-plus-square-o "></i> Simpan</span></td>
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
            <h3>Data Karyawan <div class="pull-right">
                    <div class="">
                        <span class=" btn btn-success " data-toggle="modal" data-target=".modal-kar" v-on:click="getall(null, null, 'dept')">
                            Tambah Karyawan
                        </span>
                    </div>
                </div>
            </h3>
        </div>
        <div class="panel-body">
            <table class="table  table-hover custom-table m-b-0 kar">
                <thead>
                    <tr>
                        <th>Nik</th>
                        <th>Nama</th>
                        <th>Gender</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Sub-Section</th>
                        <th>Golongan</th>
                        <th class="text-center"><i class="fa fa-gears fa-spin"></i></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
