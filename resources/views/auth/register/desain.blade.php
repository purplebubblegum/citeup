@extends('auth.register.layout')

@section('page-title')
    Pendaftaran Lomba Desain Grafis
@endsection

@section('view')

<div id="lomba-logika-form" class="registration-form">
    <form ref="form" class="panel panel-default form-horizontal" method="post" action="{{ route('register.lomba-desain') }}">
        {{ csrf_field() }}
        <div class="panel-body">
            <h3 class="form-title">
                <small><a href="{{ route('register.index') }}" class="pull-right"> Kembali</a></small>
                Data Pendaftaran
            </h3>
        </div>
        <div class="panel-body panel-body-form">
            <static-input name="entry_activity" :label-width="labelWidth" :control-width="controlWidth" :required="true" value="Lomba Desain Grafis">
                Acara
            </static-input>
            <text-input name="entry_agency" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Sekolah Asal
            </text-input>
            <text-input name="entry_city" :label-width="labelWidth" :control-width="controlWidth" :required="true" placeholder="Contoh: Kota Bandung, Jawa Barat">
                Kota / Kabupaten &amp; Provinsi Asal
            </text-input>
            <multiline-input name="entry_address" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Sekolah
            </multiline-input>
            <text-input name="entry_phone" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nomor Telepon
                <p slot="help-block" class="help-block">Pastikan nomor telepon Anda aktif!</p>
            </text-input>
        </div>
        <div class="panel-body">
            <h3 class="form-title">Biodata Peserta</h3>
        </div>
        <div class="panel-body panel-body-form">
            <text-input name="name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
            </email-input>
            <password-input name="user_password" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Kata Sandi
            </password-input>
        </div>
        <div class="panel-body text-center">
            <button type="submit" class="btn btn-primary btn-lg btn-submit">Ajukan Pendafatran</button>
        </div>
    </form>
</div>

@endsection
