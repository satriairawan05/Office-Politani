@extends('admin.layout.app')

@php
    $create = 0;
    $read = 0;
    $update = 0;
    $delete = 0;
    $verifikasi = 0;

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

            if ($r->action == 'Verifikasi') {
                $verifikasi = $r->access;
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
            $('#status').select2();
        });

        const printDoc = (id) => {
            var contents = "";
            var url = "{{ route('surat_keluar.show', ':id') }}";
            url = url.replace(':id', id);
            $.get(url, function(data, status) {
                contents = data;
                var frame1 = $('<iframe />');
                frame1[0].name = "frame1";
                frame1.css({
                    "position": "absolute",
                    "top": "-1000000px"
                });
                $("body").append(frame1);
                var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument
                    .document ?
                    frame1[0].contentDocument.document : frame1[0].contentDocument;
                frameDoc.document.open();
                frameDoc.document.write(`
                <!DOCTYPE html>
                <html lang="en">

                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    <meta name="description" content="Sistem Informasi Akademik Politeknik Pertanian Negeri Samarinda">
                    <meta name="author" content="Deuwi Satriya Irawan">
                    <title>{{ env('APP_NAME') }} || Print</title>
                    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/x-icon">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
                    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap/css/bootstrap.min.css') }}">
                </head>

                <body id='bodycontent'>
            `);
                frameDoc.document.write(contents);
                frameDoc.document.write(`
                </body>
                </html>
            `);
                frameDoc.document.close();
                setTimeout(function() {
                    window.frames["frame1"].focus();
                    window.frames["frame1"].print();
                    frame1.remove();
                }, 1000);
            });
        }
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
                                <th>Program Studi</th>
                                <th>Perihal</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($surat as $s)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $s->js_name }}</td>
                                    <td>{{ $s->prodi_name }}</td>
                                    <td>{{ $s->sk_perihal }}</td>
                                    <td>{{ \Carbon\Carbon::parse($s->sk_tgl)->isoFormat('DD MMMM YYYY') }}</td>
                                    <td>{{ $s->sk_status ?? 'surat baru' }}</td>
                                    <td>
                                        <button onclick="return printDoc({{ $s->sk_id }})" {{-- href="{{ route('surat_keluar.show', $s->sk_id) }}" --}}
                                            class="btn btn-sm btn-info" target="__blank"><i
                                                class="fa fa-print"></i></button>
                                        @php
                                            $verify = \App\Models\Verifikasi::where('js_id',$s->js_id)->latest('created_at')->first();
                                        @endphp
                                        @if ($verifikasi == 1 && $verify->ver_step == $s->sk_step)
                                            <button type="button" data-toggle="modal"
                                                data-target="#exampleModal{{ $s->sk_id }}"
                                                class="btn btn-sm btn-secondary"><i class="ti ti-pencil"></i></button>

                                            <div class="modal fade" id="exampleModal{{ $s->sk_id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModal{{ $s->sk_id }}Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Verifikasi
                                                                {{ $s->sk_perihal }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('surat_keluar.verifikasi', $s->sk_id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('put')
                                                            <div class="modal-body">
                                                                <div class="form-group row mt-3">
                                                                    <div class="col-12">
                                                                        @php
                                                                            $status = ['Accepted', 'Rejected'];
                                                                        @endphp
                                                                        <select id="status" name="sk_status"
                                                                            class="form-control form-control-sm">
                                                                            @foreach ($status as $sta)
                                                                                @if (old('sk_status') == $sta)
                                                                                    <option value="{{ $sta }}"
                                                                                        selected>{{ $sta }}
                                                                                    </option>
                                                                                @else
                                                                                    <option value="{{ $sta }}">
                                                                                        {{ $sta }}
                                                                                    </option>
                                                                                @endif
                                                                            @endforeach
                                                                        </select>
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
                                        @if ($update == 1)
                                            <a href="{{ route('surat_keluar.edit', $s->sk_id) }}"
                                                class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                        @endif
                                        @if ($delete == 1)
                                            <form action="{{ route('surat_keluar.destroy', $s->sk_id) }}" method="post"
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
