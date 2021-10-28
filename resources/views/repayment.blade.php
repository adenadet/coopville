@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload</div>

                <div class="card-body">
                    @include('layouts.alerts')
                    <form action="/repayments-import" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                        <div class="row clearfix">
                            <div class="col-12">
                                <div class="form-group">                                            
                                    <input type="file" class="form-control-file" name="sample_file" id="sample_file" aria-describedby="fileHelp" required>
                                    <small id="fileHelp" class="form-text text-muted">This is some placeholder block-level help text for the above input. It's a bit lighter and easily wraps to a new line.</small>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Import"/>                
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection