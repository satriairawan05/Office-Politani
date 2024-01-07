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
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="d-flex justify-content-end mt-3">
                <a href="{{ route('role.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead class="table-primary table-hover text-white">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group as $g)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $g->group_name }}</td>
                                <td>
                                    <a href="{{ route('role.edit', $g->group_id) }}" class="btn btn-sm btn-warning"><i
                                            class="fa fa-edit"></i></a>
                                    @if ($g->group_id != 1)
                                        <form action="{{ route('role.destroy', $g->group_id) }}" method="post"
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
        </div>
    </div>
@endsection
