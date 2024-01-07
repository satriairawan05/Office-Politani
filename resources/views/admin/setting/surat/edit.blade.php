@extends('admin.layout.app')

@section('breadcrumb')
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
                <p class="mb-0">{{ $name }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"> <i class="fa fa-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('jenis_surat.index') }}">{{ $name }}</a>
                <li class="breadcrumb-item">Edit
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-body">
                <form action="{{ route('jenis_surat.update', $surat->js_id) }}" method="post">
                    @csrf
                    <div class="form-group row mt-3">
                        <div class="col-2">
                            <label for="js_name">Name</label>
                        </div>
                        <div class="col-10">
                            <input type="text"
                                class="form-control form-control-sm @error('js_name')
                                    is-invalid
                                @enderror"
                                name="js_name" id="js_name" value="{{ old('js_name', $surat->js_name) }}"
                                placeholder="Masukan Nama" required>
                            @error('js_name')
                                <div class="invalid-feedback">
                                    {{ $errors->first('js_name') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('jenis_surat.index') }}" class="btn btn-sm btn-info mx-2"><i
                                    class="fa fa-reply-all"></i></a>
                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
