<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <link rel="shortcut icon" type="image/x-icon" href="./assets/img/favicon.png" />
    <title>{{$judul}}</title>
    <link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css" />
    <link href="assets/css/datatables.css" rel="stylesheet" />
    <link href="assets/css/easy-autocomplete.min.css" rel="stylesheet">
    <link href="c3.min.css" rel="stylesheet">
    <link href="jquery-loading.min.css" rel="stylesheet">
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
                        <li>
                            <a href="dashboard"><i class="fa fa-desktop" aria-hidden="true"></i> <span>Dashboard</span> </a>
                        </li>
                        <li class="submenu">
                            <a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <span>Form</span> <span class="menu-arrow"></span></a>
                            <ul class="list-unstyled" style="display: none;">
                                <li> <a class="@if ($link==" karyawan") active @endif" href="karyawan"> Karyawan </a></li>
                                <li><a class="@if ($link==" absensi") active @endif" href="absensi"> Absensi </a></li>
                                <li><a class="@if ($link==" lembur") active @endif" href="lembur"> Lembur </a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="lap"><i class="fa fa-file-text-o" aria-hidden="true"></i> <span>Laporan Karyawan</span> </a>
                        </li>
                        <li>
                            <a href="set"><i class="fa fa-wrench" aria-hidden="true"></i> <span>Pengaturan</span> </a>
                        </li>
                        <li>
                            <a href="logout"><i class="fa fa-sign-out" aria-hidden="true"></i> <span>Logout</span> </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">
                <div class="row app">
                    @yield('modal') @yield('isi')
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
    <script src="assets/js/jquery.easy-autocomplete.min.js"></script>
    <script type="text/javascript" src="./assets/js/vue.js"></script>
    <script type="text/javascript" src="collect.min.js"></script>
    <script type="text/javascript" src="jquery.tabletojson.min.js"></script>
    <script type="text/javascript" src="Chart.min.js"></script>
    <script type="text/javascript" src="jQuery.print.js"></script>
    <script type="text/javascript" src="jquery-loading.js"></script>
    <script type="text/javascript" src="d3.v5.min.js"></script>
    <script type="text/javascript" src="c3.min.js"></script>
    <script type="text/javascript">
    var options = {
        url: "getall?data=1&tb=1&primary=nik&table=kar&view=karyawan",


        getValue: function(item) {

            return item.nik + item.nama + item.sect_name + item.dept_name + item.subsect_name;
        },
        list: {
            maxNumberOfElements: 5,
            match: {
                enabled: true
            },
            onSelectItemEvent: function() {
                var value = $(".nama").getSelectedItemData().nik;

                $(".nama").val(value).trigger("change");

            },
            showAnimation: {
                type: "slide", //normal|slide|fade
                time: 400,
                callback: function() {}
            },

            hideAnimation: {
                type: "slide", //normal|slide|fade
                time: 400,
                callback: function() {}
            },
            sort: {
                enabled: true
            }
        },

        template: {
            type: "custom",
            method: function(value, item) {
                return item.nama + "<small> (" + item.nik + ") </small> " +
                    "<br/> <small> " + item.dept_name + "</small> | <small> " + item.sect_name + "</small> | <small> " + item.subsect_name + "</small>";
            }
        }
    };
    </script>
    @yield('js')
</body>

</html>
