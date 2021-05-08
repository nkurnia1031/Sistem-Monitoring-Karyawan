@extends('layout.index') @section('js')
<script type="text/javascript">
$(document).ready(function() {



});
</script>
@endsection @section('modal')
@endsection @section('isi')
<div class="col-sm-12">
    <div class="panel ">
        <div class="panel-heading">
            <h3>{{$judul}}</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8">
                    <div class="card-box">
                        <form class="form-horizontal" action="ganti" method="post" />
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-lg-3">Username</label>
                            <div class="col-md-9">
                                @php
                                $admin=session()->get('admin2');
                                @endphp
                                <input type="text" readonly="" value="{{$admin->user}}" name="user" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Password Lama</label>
                            <div class="col-md-9">
                                <input type="password" name="pass" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Password Baru</label>
                            <div class="col-md-9">
                                <input type="password" name="pass2" class="form-control" />
                                <small>Kosongkan jika tidak ingin mengganti password</small>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Pertanyaan Keamanan</label>
                            <div class="col-md-9">
                                <input type="text" name="tanya" autocomplete="off" value="{{$admin->tanya}}" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3">Jawaban</label>
                            <div class="col-md-9">
                                <input type="text" name="jawab" autocomplete="off" value="{{$admin->jawab}}" class="form-control" />
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label col-lg-9"></label>
                            <div class="col-md-3">
                        <button type="submit" class="btn btn-success pull-right">Simpan</button>

                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
