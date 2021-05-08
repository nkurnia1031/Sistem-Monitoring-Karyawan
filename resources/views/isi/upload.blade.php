@extends('layout.index') @section('header')
<h3 class="page-header"> Data Alat Berat </h3> @endsection @section('js')
<script type="text/javascript">
$(document).ready(function() {
    $('.tb-alat').DataTable({

    });
});
</script>
@endsection @section('modal')
<div class="modal fade modal-alat" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="list">
            <div class="modal-header">
                <h4 class="modal-title">Form Alat Berat</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"></span>
                </button>
            </div>
            <form action="upload"  enctype="multipart/form-data" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <fieldset class="form-fieldset">
                        <div class="form-group">
                            <label class="form-label">File<span class="form-required">*</span></label>
                            <input type="file" class="form-control" required="" name="file">
                        </div>

                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection @section('isi')
<div class="row row-cards row-deck">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <button type="button" class="btn btn-pill btn-success " title="Tambah Alat Berat" data-toggle="modal" data-target=".modal-alat"> <i class="fa fa-plus-circle">  </i> Tambah Alat Berat </button>
            </div>
        </div>
    </div>
</div>
@endsection
