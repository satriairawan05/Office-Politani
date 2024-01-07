@extends('admin.layout.app')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script src="{{ asset('assets/js/ckeditor4/ckeditor.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#jenis').select2();
            CKEDITOR.replace('.ckeditor');
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
                <form action="{{ route('surat_keluar.update',$surat->sk_id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="sk_nomor" class="form-label text-dark">Nomor </label>
                            <input type="text"
                                class="form-control form-control-sm @error('sk_nomor')
                                    is-invalid
                                @enderror"
                                id="sk_nomor" placeholder="Masukan Nomor Surat ex: 001" value="{{ old('sk_nomor',$surat->sk_nomor) }}"
                                name="sk_nomor">
                            @error('sk_nomor')
                                <div class="invalid-feedback">
                                    {{ $errors->first('sk_nomor') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="sk_lampiran" class="form-label text-dark">Lampiran </label>
                            <input type="text"
                                class="form-control form-control-sm @error('sk_lampiran')
                                    is-invalid
                                @enderror"
                                id="sk_lampiran" placeholder="Masukan Lampiran" value="{{ old('sk_lampiran',$surat->sk_lampiran) }}"
                                name="sk_lampiran">
                            @error('sk_lampiran')
                                <div class="invalid-feedback">
                                    {{ $errors->first('sk_lampiran') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="sk_perihal" class="form-label text-dark">Perihal </label>
                            <input type="text"
                                class="form-control form-control-sm @error('sk_perihal')
                                    is-invalid
                                @enderror"
                                id="sk_perihal" placeholder="Masukan Perihal" value="{{ old('sk_perihal',$surat->sk_perihal) }}"
                                name="sk_perihal">
                            @error('sk_perihal')
                                <div class="invalid-feedback">
                                    {{ $errors->first('sk_perihal') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="sk_tujuan" class="form-label text-dark">Tujuan </label>
                            <input type="text"
                                class="form-control form-control-sm @error('sk_tujuan')
                                    is-invalid
                                @enderror"
                                id="sk_tujuan" placeholder="Masukan Tujuan ex: Nanda" value="{{ old('sk_tujuan',$surat->sk_tujuan) }}"
                                name="sk_tujuan">
                            @error('sk_tujuan')
                                <div class="invalid-feedback">
                                    {{ $errors->first('sk_tujuan') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="sk_tempat" class="form-label text-dark">Tempat Tujuan </label>
                            <input type="text"
                                class="form-control form-control-sm @error('sk_tempat')
                                    is-invalid
                                @enderror"
                                id="sk_tempat" placeholder="Masukan Tempat Tujuan ex: Samarinda"
                                value="{{ old('sk_tempat',$surat->sk_tempat) }}" name="sk_tempat">
                            @error('sk_tempat')
                                <div class="invalid-feedback">
                                    {{ $errors->first('sk_tempat') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="sk_deskripsi">Deskripsi</label>
                            <textarea class="ckeditor form-control" name="sk_deskripsi" id="sk_deskripsi" cols="50" rows="10">{{ old('sk_deskripsi',$surat->sk_deskripsi) }}</textarea>
                            @error('sk_deskripsi')
                                <div class="invalid-feedback">
                                    {{ $errors->first('sk_deskripsi') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="sk_tembusan">Tembusan</label>
                            <textarea class="ckeditor form-control" name="sk_tembusan" id="sk_tembusan" cols="50" rows="10">{{ old('sk_tembusan',$surat->sk_tembusan) }}</textarea>
                            @error('sk_tembusan')
                                <div class="invalid-feedback">
                                    {{ $errors->first('sk_tembusan') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="js_id" class="form-label text-dark">Jenis <span class="text-danger">*</span>
                            </label>
                            <select id="jenis" name="js_id" class="form-control form-control-sm">
                                @foreach ($jenis as $j)
                                    @if (old('js_id',$surat->js_id) == $j->js_id)
                                        <option value="{{ $j->js_id }}" selected>{{ $j->js_name }}</option>
                                    @else
                                        <option value="{{ $j->js_id }}">{{ $j->js_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="prodi_id" class="form-label text-dark">Prodi <span class="text-danger">*</span>
                            </label>
                            <select id="prodi" name="prodi_id" class="form-control form-control-sm">
                                @foreach ($prodi as $p)
                                    @if (old('prodi_id') == $p->prodi_id)
                                        <option value="{{ $p->prodi_id }}" selected>{{ $p->prodi_name }}</option>
                                    @else
                                        <option value="{{ $p->prodi_id }}">{{ $p->prodi_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('surat_keluar.index') }}" class="btn btn-sm btn-info mx-2"><i
                                    class="fa fa-reply-all"></i></a>
                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
