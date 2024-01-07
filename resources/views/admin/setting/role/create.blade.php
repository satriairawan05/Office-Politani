@extends('admin.layout.app')

@section('breadcrumb')
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
                <p class="m-b-0">{{ $name }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"> <i class="fa fa-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('role.index') }}">{{ $name }}</a></li>
                <li class="breadcrumb-item">Create</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-body">
                <form action="{{ route('role.store') }}" method="post">
                    @csrf
                    <div class="form-group row mt-3">
                        <div class="col-2">
                            <label for="group_name" class="col-form-label text-dark">Role Name <span
                                    class="text-danger">*</span> </label>
                        </div>
                        <div class="col-10">
                            <input type="text"
                                class="form-control form-control-sm @error('group_name')
                                    is-invalid
                                @enderror"
                                id="group_name" placeholder="Masukan Role Name" value="{{ old('group_name') }}"
                                name="group_name" required>
                            @error('group_name')
                                <div class="invalid-feedback">
                                    {{ $errors->first('group_name') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 my-3">
                            <table class="table-light table">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th class="text-center">Pages</th>
                                        <th class="text-center">Access</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($page_distincts as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center">{!! str_replace('_', ' ', $d->page_name) !!}</td>
                                            <td class="text-center">
                                                @foreach ($pages as $p)
                                                    @if (str_replace('_', ' ', $p->page_name) == str_replace('_', ' ', $d->page_name))
                                                        <div class="d-inline">
                                                            <input type="checkbox" id="{!! $p->page_id !!}"
                                                                name="{!! $p->page_id !!}">
                                                            <label for="{!! $p->page_id !!}">
                                                                {{ $p->action }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('role.index') }}" class="btn btn-sm btn-info mx-2"><i
                                    class="fa fa-reply-all"></i></a>
                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
