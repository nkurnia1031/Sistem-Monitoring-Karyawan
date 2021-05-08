@extends('layout.index') @section('js')
<script type="text/javascript">
$(document).ready(function() {




});
</script>
<script type="text/javascript">
var app = new Vue({
    el: '.app',
    data: {
        data1: [],
        prodi1: 'Semua',
        prodi2: 'Semua',
        prodi3: 'Semua',





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
                    app[table] = mydata;
                    $(".load").hide('slow', function() {
                        $('.isi').show('slow');
                    });






                },
                error: function() { alert('koneksi gagal') }
            });

        },
        gethome: function(primary, key, table) {


            jQuery.ajax({

                url: 'gethome',

                type: "GET",
                success: function(data) {

                    var mydata = JSON.parse(data);
                    app.data1 = mydata;




                },
                error: function() { alert('koneksi gagal') }
            });

        },
        tes: function() {
            window.open('wisudap?tahun=' + app.tahun, '_blank');

        },
        wisuda: function() {

            var queryString;
            queryString = 'prodi=' + app.prodi1;
            jQuery.ajax({

                url: 'wisuda',
                data: queryString,

                type: "GET",
                success: function(data) {

                    var mydata = JSON.parse(data);
                    app.data1 = mydata;
                    app.gethome();




                },
                error: function() { alert('koneksi gagal') }
            });

        },

    }
});
</script>
@endsection @section('modal') @endsection @section('isi')
<div class="col-lg-3">
    <div class="dash-widget dash-widget5">
        <span class="dash-widget-icon bg-info"><i class="fa fa-user-o" aria-hidden="true"></i></span>
        <div class="dash-widget-info">
            <h3>1072</h3>
            <span>Karyawan</span>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="dash-widget dash-widget5">
        <span class="dash-widget-icon bg-info"><i class="fa fa-user-o" aria-hidden="true"></i></span>
        <div class="dash-widget-info">
            <h3>1072</h3>
            <span>Dept. Head</span>
        </div>
    </div>
</div>
<div class="col-lg-3">
    <div class="dash-widget dash-widget5">
        <span class="dash-widget-icon bg-info"><i class="fa fa-user-o" aria-hidden="true"></i></span>
        <div class="dash-widget-info">
            <h3>1072</h3>
            <span>Sect. Head</span>
        </div>
    </div>
</div>

@endsection
