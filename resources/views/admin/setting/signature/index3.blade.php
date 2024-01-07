@extends('admin.layout.app')

@php
    $create = 0;
    $read = 0;
    $update = 0;
    $delete = 0;

    foreach ($pages as $r) {
        if ($r->page_name == $name) {
            if ($r->action == 'Create') {
                $create = $r->access;
            }

            if ($r->action == 'Read') {
                $read = $r->access;
            }

            if ($r->action == 'Update') {
                $update = $r->access;
            }

            if ($r->action == 'Delete') {
                $delete = $r->access;
            }
        }
    }
@endphp

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
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-body">
                @if ($read == 1)
                    <table class="table-responsive table">
                        <thead class="table-primary table-hover text-white">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Nip</th>
                                <th>Jabatan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($create == 1)
                                <tr>
                                    <form action="{{ route('signature.store') }}" method="post">
                                        @csrf
                                        <td>New Data</td>
                                        <input type="hidden" name="prodi_id" value="{{ $prodi }}">
                                        <input type="hidden" name="js_id" value="{{ $jenis }}">
                                        <td>
                                            <input type="text" name="sign_name" id="sign_name" class="form-control"
                                                placeholder="Masukan Nama" value="{{ old('sign_name') }}">
                                        </td>
                                        <td>
                                            <input type="text" name="sign_nip" id="sign_nip" class="form-control"
                                                placeholder="Masukan Nip" value="{{ old('sign_nip') }}">
                                        </td>
                                        <td>
                                            <input type="text" name="sign_jabatan" id="sign_jabatan" class="form-control"
                                                placeholder="Masukan Jabatan" value="{{ old('sign_jabatan') }}">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-success"><i
                                                    class="fa fa-save"></i></button>
                                        </td>
                                    </form>
                                </tr>
                            @endif
                            @foreach ($signature as $sign)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sign->sign_name }}</td>
                                    <td>{{ $sign->sign_nip }}</td>
                                    <td>{{ $sign->sign_jabatan }}</td>
                                    <td>
                                        @if ($update == 1)
                                            <button type="button" data-toggle="modal"
                                                data-target="#exampleModal{{ $sign->sign_id }}"
                                                class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>

                                            <div class="modal fade" id="exampleModal{{ $sign->sign_id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModal{{ $sign->sign_id }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                {{ $sign->sign_name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('signature.update', $sign->sign_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('put')
                                                            <input type="hidden" name="prodi_id"
                                                                value="{{ $prodi }}">
                                                            <input type="hidden" name="js_id"
                                                                value="{{ $jenis }}">
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <div class="col-6">
                                                                        <label for="sign_name"
                                                                            class="form-label text-dark">Name
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm @error('sign_name')
                                    is-invalid
                                @enderror"
                                                                            id="sign_name" placeholder="Masukan Nama"
                                                                            value="{{ old('sign_name', $sign->sign_name) }}"
                                                                            name="sign_name">
                                                                        @error('sign_name')
                                                                            <div class="invalid-feedback">
                                                                                {{ $errors->first('sign_name') }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="sign_nip"
                                                                            class="form-label text-dark">Nip
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm @error('sign_nip')
                                    is-invalid
                                @enderror"
                                                                            id="sign_nip" placeholder="Masukan Nip"
                                                                            value="{{ old('sign_nip', $sign->sign_nip) }}"
                                                                            name="sign_nip">
                                                                        @error('sign_nip')
                                                                            <div class="invalid-feedback">
                                                                                {{ $errors->first('sign_nip') }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mt-3">
                                                                    <div class="col-12">
                                                                        <label for="sign_jabatan"
                                                                            class="form-label text-dark">Jabatan
                                                                        </label>
                                                                        <input type="text"
                                                                            class="form-control form-control-sm @error('sign_jabatan')
                                    is-invalid
                                @enderror"
                                                                            id="sign_jabatan"
                                                                            placeholder="Masukan Jabatan"
                                                                            value="{{ old('sign_jabatan', $sign->sign_jabatan) }}"
                                                                            name="sign_jabatan">
                                                                        @error('sign_jabatan')
                                                                            <div class="invalid-feedback">
                                                                                {{ $errors->first('sign_jabatan') }}
                                                                            </div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Save
                                                                    changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($delete == 1)
                                            <form action="{{ route('signature.destroy', $sign->sign_id) }}"
                                                method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fa fa-trash"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
