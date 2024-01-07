@extends('admin.layout.app')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#jurusan').select2();
        });
    </script>
@endpush

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
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ $name }}</a>
                <li class="breadcrumb-item">Create
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-body">
                <form action="{{ route('prodi.store') }}" method="post">
                    @csrf
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="prodi_name" class="form-label text-dark">Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control form-control-sm @error('prodi_name')
                                    is-invalid
                                @enderror"
                                id="prodi_name" placeholder="Masukan Nama" value="{{ old('prodi_name') }}" name="prodi_name"
                                required>
                            @error('prodi_name')
                                <div class="invalid-feedback">
                                    {{ $errors->first('prodi_name') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="prodi_jenjang" class="form-label text-dark">Jenjang <span
                                    class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control form-control-sm @error('prodi_jenjang')
                                    is-invalid
                                @enderror"
                                id="prodi_jenjang" placeholder="Masukan Jenjang ex: D3 D4"
                                value="{{ old('prodi_jenjang') }}" name="prodi_jenjang" required>
                            @error('prodi_jenjang')
                                <div class="invalid-feedback">
                                    {{ $errors->first('prodi_jenjang') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-12">
                            <label for="jurusan_id" class="form-label text-dark">Jurusan <span class="text-danger">*</span>
                            </label>
                            <select class="form-select form-control" id="jurusan" name="jurusan_id" aria-label="Select Jurusan">
                                @foreach ($jurusan as $j)
                                    @if (old('jurusan_id') == $j->jurusan_id)
                                        <option value="{{ $j->jurusan_id }}" selected>{{ $j->jurusan_name }}</option>
                                    @else
                                        <option value="{{ $j->jurusan_id }}">{{ $j->jurusan_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('prodi.index') }}" class="btn btn-sm btn-info mx-2"><i
                                    class="fa fa-reply-all"></i></a>
                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
