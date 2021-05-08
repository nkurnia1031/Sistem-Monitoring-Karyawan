<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/favicon.png" />
    <title></title>
    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />
    <link href="assets/css/datatables.css" rel="stylesheet" />
    <!--[if lt IE 9]>
        <script src="./assets/js/html5shiv.min.js"></script>
        <script src="./assets/js/respond.min.js"></script>
    <![endif]-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div class="main-wrapper">
        <div class="header">
            <div class="page-title-box pull-left">
                <h3>Sistem Monitoring Karyawan</h3>
            </div>
        </div>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">Menu</li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Form</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li> <a href="karyawan"> Karyawan </a></li>
                                <li><a data-toggle="modal" data-target=".modal-gol"> Absensi </a></li>
                                <li><a href="karyawan"> Lembur </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row app">
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
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./assets/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="assets/js/popper.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/js/jquery.slimscroll.js"></script>
    <script type="text/javascript" src="./assets/js/app.js"></script>
    <script type="text/javascript" src="assets/js/datatables.js"></script>
    <script type="text/javascript" src="./assets/js/vue.js"></script>
    @yield('js')
</body>

</html>
