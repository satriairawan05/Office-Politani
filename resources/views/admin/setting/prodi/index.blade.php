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
            @if ($create == 1)
                <div class="d-flex justify-content-end mt-3">
                    <a href="{{ route('prodi.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></a>
                </div>
            @endif
            @if ($read == 1)
                <div class="card-body">
                    <table class="table table-responsive">
                        <thead class="table-primary table-hover text-white">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Jenjang</th>
                                <th>Jurusan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prodi as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $p->prodi_name }}</td>
                                    <td>{{ $p->prodi_jenjang }}</td>
                                    <td>{{ $p->jurusan_name }}</td>
                                    <td>
                                        @if($update == 1)
                                        <a href="{{ route('prodi.edit', $p->prodi_id) }}" class="btn btn-sm btn-warning"><i
                                                class="fa fa-edit"></i></a>
                                        @endif
                                        @if ($delete == 1)
                                            <form action="{{ route('prodi.destroy', $p->prodi_id) }}" method="post"
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
                </div>
            @endif
        </div>
    </div>
@endsection
