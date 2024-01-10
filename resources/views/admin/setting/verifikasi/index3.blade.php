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

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#user').select2();
            $('#jenis').select2();
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
                <li class="breadcrumb-item"><a href="{{ route('verifikasi.index') }}">{{ $name }}</a>
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
                                <th>Jenis Surat</th>
                                <th>User</th>
                                <th>Step</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($create == 1)
                                <tr>
                                    <form action="{{ route('verifikasi.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="jenis" value="{{ $selectJenis }}">
                                        <input type="hidden" name="prodi" value="{{ $selectProdi }}">
                                        <td>New Data</td>
                                        <td>
                                            <select id="jenis" name="js_id" class="form-control form-control-sm"
                                                disabled>
                                                @foreach ($jenis as $j)
                                                    @if (old('js_id', $selectJenis) == $j->js_id)
                                                        <option value="{{ $j->js_id }}" selected>{{ $j->js_name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $j->js_id }}">{{ $j->js_name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select id="user" name="user_id" class="form-control form-control-sm">
                                                @foreach ($user as $u)
                                                    @if (old('user_id') == $u->id)
                                                        <option value="{{ $u->id }}" selected>{{ $u->name }}
                                                        </option>
                                                    @else
                                                        <option value="{{ $u->id }}">{{ $u->name }}
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" name="ver_step" id="ver_step" class="form-control"
                                                min="1" step="1" max="3" value="{{ old('ver_step') }}">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-sm btn-success"><i
                                                    class="fa fa-save"></i></button>
                                        </td>
                                    </form>
                                </tr>
                            @endif
                            @foreach ($verifikasi as $ver)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @php
                                        $jenisSurat = \App\Models\JenisSurat::where('js_id', $ver->js_id)->first();
                                        $userVer = \App\Models\User::where('id', $ver->user_id)->first();
                                    @endphp
                                    <td>{{ $jenisSurat->js_name }}</td>
                                    <td>{{ $userVer->name }}</td>
                                    <td>{{ $ver->ver_step }}</td>
                                    <td>
                                        @if ($update == 1)
                                            <button type="button" data-toggle="modal"
                                                data-target="#exampleModal{{ $ver->ver_id }}"
                                                class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button>

                                            <div class="modal fade" id="exampleModal{{ $ver->ver_id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModal{{ $ver->ver_id }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                {{ $jenisSurat->js_name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('verifikasi.update', $ver->ver_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('put')
                                                            <input type="hidden" name="jenis" value="{{ $selectJenis }}">
                                                            <input type="hidden" name="prodi" value="{{ $selectProdi }}">
                                                            <div class="modal-body">
                                                                <div class="form-group row">
                                                                    <div class="col-6">
                                                                        <select id="jenisEdit" name="js_id"
                                                                            class="form-control form-control-sm" disabled>
                                                                            @foreach ($jenis as $j)
                                                                                @if (old('js_id', $selectJenis) == $j->js_id)
                                                                                    <option value="{{ $j->js_id }}"
                                                                                        selected>{{ $j->js_name }}
                                                                                    </option>
                                                                                @else
                                                                                    <option value="{{ $j->js_id }}">
                                                                                        {{ $j->js_name }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <select id="userEdit" name="user_id"
                                                                            class="form-control form-control-sm">
                                                                            @foreach ($user as $u)
                                                                                @if (old('user_id', $ver->user_id) == $u->id)
                                                                                    <option value="{{ $u->id }}"
                                                                                        selected>{{ $u->name }}
                                                                                    </option>
                                                                                @else
                                                                                    <option value="{{ $u->id }}">
                                                                                        {{ $u->name }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group row mt-3">
                                                                    <div class="col-12">
                                                                        <input type="number" name="ver_step" id="ver_step"
                                                                            class="form-control" min="1"
                                                                            step="1" max="3"
                                                                            placeholder="Masukan Step"
                                                                            value="{{ old('ver_step',$ver->ver_step) }}">
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
                                            <form action="{{ route('verifikasi.destroy', $ver->ver_id) }}" method="post"
                                                class="d-inline">
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
