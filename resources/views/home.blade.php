@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">               
                    <p>You are logged in!</p>
                    <button type="button" class="btn btn-primary" v-on:click="loadUser">
                        Click to Load Your Data
                    </button>
                    <p><pre>@{{ user }}</pre></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <api-box req-type="get" uri="/api/v1/users">
                    <template slot="header-text">GET User</template>
                    <template slot="result-area" scope="props">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="user in props.data.data.users">
                                <pre>@{{ user }}</pre>
                            </li>
                        </ul>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="post" uri="/api/v1/storage" multipart="true" file-upload-name="file">
                    <template slot="header-text">POST Storage</template>
                    <template slot="result-area" scope="props">
                        <div class="panel-body">
                            <pre>@{{ props.data.data }}</pre>
                        </div>
                    </template>
                </api-box>
            </div>
            <div class="col-md-4">
                <api-box req-type="get" uri="/api/v1/sponsors/3/edits">
                    <template slot="header-text">GET Sponsor/3/Edits</template>
                    <template slot="result-area" scope="props">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="edit in props.data.data.edits">
                                <pre>@{{ edit }}</pre>
                            </li>
                        </ul>
                    </template>
                </api-box>
            </div>
        </div>
    </div>
</div>
@endsection
