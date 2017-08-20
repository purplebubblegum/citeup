@extends('auth.register.formlayout')

@section('page-title')
    Pendaftaran Lomba Logika
@endsection

@section('form')

<div id="lomba-logika-form" class="registration-form">
    <form ref="form" class="panel panel-default form-horizontal" method="post" action="{{ route('register.lomba-logika') }}">
        {{ csrf_field() }}
        <div class="panel-body">
            <h3 class="form-title">
                <small><a href="{{ route('register.index') }}" class="pull-right"> Kembali</a></small>
                Data Tim
            </h3>
        </div>
        <div class="panel-body panel-body-form">
            <static-input name="entry_activity" :label-width="labelWidth" :control-width="controlWidth" :required="true" value="Lomba Logika">
                Acara
            </static-input>
            <text-input name="entry_name" :label-width="labelWidth" :control-width="controlWidth" :required="true" :autofocus="true">
                Nama Tim
            </text-input>
            <text-input name="entry_agency" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Sekolah Asal
            </text-input>
            <text-input name="entry_city" :label-width="labelWidth" :control-width="controlWidth" :required="true" placeholder="Contoh: Kota Bandung, Jawa Barat">
                Kota / Kabupaten &amp; Provinsi Sekolah
            </text-input>
        </div>
        <div class="panel-body">
            <h3 class="form-title">Biodata Ketua</h3>
        </div>
        <div class="panel-body panel-body-form">
            <text-input name="user_0_name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_0_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
                <p slot="help-block" class="help-block">Email ini digunakan untuk melakukan login.</p>
            </email-input>
            <password-input name="user_0_password" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Kata Sandi
            </password-input>
            <password-input name="user_0_password_confirmation" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Konfirmasi Kata Sandi
            </password-input>
            <text-input name="user_0_birthplace" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Tempat Lahir / Asal Kota
            </text-input>
            <date-time-input name="user_0_birthdate" :label-width="labelWidth" :control-width="controlWidth" format="YYYY-MM-DD" :required="true">
                Tanggal Lahir
            </date-time-input>
            <multiline-input name="user_0_address" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Tempat Tinggal
            </multiline-input>
            <text-input name="user_0_phone" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nomor Telepon
            </text-input>
        </div>
        <div class="panel-body">
            <h3 class="form-title">Biodata Anggota 1</h3>
        </div>
        <div class="panel-body panel-body-form">
            <text-input name="user_1_name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_1_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
            </email-input>
            <text-input name="user_1_birthplace" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Tempat Lahir / Asal Kota
            </text-input>
            <date-time-input name="user_1_birthdate" :label-width="labelWidth" :control-width="controlWidth" format="YYYY-MM-DD" :required="true">
                Tanggal Lahir
            </date-time-input>
            <multiline-input name="user_1_address" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Tempat Tinggal
            </multiline-input>
            <text-input name="user_1_phone" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nomor Telepon
            </text-input>
        </div>
        <div class="panel-body">
            <h3 class="form-title">Biodata Anggota 2</h3>
        </div>
        <div class="panel-body panel-body-form">
            <text-input name="user_2_name" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nama
            </text-input>
            <email-input name="user_2_email" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Email
            </email-input>
            <text-input name="user_2_birthplace" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Tempat Lahir / Asal Kota
            </text-input>
            <date-time-input name="user_2_birthdate" :label-width="labelWidth" :control-width="controlWidth" format="YYYY-MM-DD" :required="true">
                Tanggal Lahir
            </date-time-input>
            <multiline-input name="user_2_address" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Alamat Tempat Tinggal
            </multiline-input>
            <text-input name="user_2_phone" :label-width="labelWidth" :control-width="controlWidth" :required="true">
                Nomor Telepon
            </text-input>
        </div>
        <div class="panel-body text-center">
            <button type="submit" class="btn btn-primary btn-lg btn-submit">Ajukan Pendaftaran</button>
        </div>
    </form>
</div>

@endsection