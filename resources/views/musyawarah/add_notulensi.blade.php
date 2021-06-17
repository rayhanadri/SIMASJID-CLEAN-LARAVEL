@include('layouts.header')
@include('layouts.navbar')

<?php
/* PHP UNTUK PENGATURAN VIEW */
//anggota terautentikasi
$authUser = Auth::user();
//hide untuk selain sekretaris dan ketua
$sekretaris = array(1, 2);
$inside_sekretaris = in_array($authUser->id_jabatan, $sekretaris);
?>

<form id="form_notulensi" action="{{ route('musyawarahStoreNotulensi') }}" method="post" class="needs-validation" novalidate="">
@csrf
<div class="main-content">
    <section class="section">
        <div class="row">
            <ol class="breadcrumb float-sm-left" style="margin-bottom: 10px; margin-left: 15px;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}"><i
                            class="fas fa-mosque"></i> Home</a></li>
                <li class="breadcrumb-item active">Tambah Notulensi Musyawarah</li>
            </ol>
        </div>
        <!-- @include('musyawarah.menu_musyawarah') -->
        <div class="section-header">
            <div class="row" style="margin:auto;">
                <div class="col-12">
                    <h1><i class="fa fa-address-book"></i> Notulensi Musyawarah</h1>
                    <div></div>
                </div>
            </div>
        </div>
        
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-body pb-0">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" name="judul_musyawarah" class="form-control" required="" value="{{ $notulensi->judul_musyawarah ?? '' }}">
                                <input type="text" id="id_notulensi" name="id_notulensi" class="form-control" required="" value="{{ $notulensi->id ?? '' }}" hidden>
                            </div>
                            <div class="form-group hide-at-edit">
                                <label>Amir Musyawarah</label>
                                <select id="select_amir" name="amir_musyawarah" class="form-control select2">
                                    @foreach ($anggotaGroup as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group hide-at-edit">
                                <label onclick='alert("Selected value is: "+$("#kehadiran_musyawarah").select2("val"));
'>Daftar Kehadiran</label>
                                <select id="kehadiran_musyawarah" name="kehadiran_musyawarah" class="form-control select2" multiple="">
                                    @foreach ($anggotaGroup as $anggota)
                                        <option value="{{ $anggota->id }}">{{ $anggota->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group hide-at-edit">
                                <label>Tanggal Musyawarah</label>
                                <input id="tanggal_musyawarah" name="tanggal_musyawarah" type="text" class="form-control datepicker" value="">
                            </div>
                        </div>
                        
                        <div class="card-footer pt-0">
                            <button id="submit-notulensi" class="btn btn-primary">Simpan</button>
                            <input id="all_kehadiran_id" name="all_kehadiran_id" type="text" hidden>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Progress</h4>
                            <div class="card-header-action hide-at-edit">
                                <button type="button" data-toggle="modal" data-target="#selectPekerjaan" class="btn btn-danger"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div id="body_progress" class="card-body pb-0">
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Masukkan</h4>
                        </div>
                        <div id="body_masukkan" class="card-body pb-0">
                            
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Keputusan</h4>
                        </div>
                        <div id="body_keputusan" class="card-body pb-0">
                            
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
</form>

<div class="modal fade" tabindex="-1" role="dialog" id="selectPekerjaan">
    <div class="modal-dialog custom-modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tambah Baru</h4>
                                <div class="card-header-action">
                                    <button id="createPekerjaanBtn" class="btn btn-danger"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label>Judul Pekerjaan</label>
                                    <input name="nama_pekerjaan" id="nama_pekerjaan" class="form-control" required />
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi Pekerjaan</label>
                                    <input name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" class="form-control" required />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-md-8 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Pilih</h4>
                                <div class="card-header-action">
                                    <!-- <button data-toggle="modal" data-target="#selectPekerjaan" class="btn btn-danger"><i class="fas fa-plus"></i></button> -->
                                </div>
                            </div>
                            <div class="card-body pb-0">
                                <label>Judul Pekerjaan</label>
                                <div class="form-group">
                                    
                                    <select id="option_pekerjaan" style="width:100%" class="form-control select2">
                                        @foreach ($pekerjaanGroup as $pekerjaan)
                                        <option value="{{ $pekerjaan->id }}">{{ $pekerjaan->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button id="select_pekerjaan" class="btn btn-block btn-primary">Pilih</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- <input type="text" id="id" name="id" value="" hidden/> -->
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        let id_notulensi = $("#id_notulensi").val()
        if (id_notulensi != ""){
            $(".hide-at-edit").hide();
            
            getProgressNotulensi(id_notulensi)
        }
    });
</script>
@include('layouts.footer')
