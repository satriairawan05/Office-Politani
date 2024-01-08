@extends('admin.layout.app')

@push('js')
    <script type="text/javascript">
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
                <li class="breadcrumb-item"><a href="{{ route('archive') }}">{{ $name }}</a>
                </li>
                <li class="breadcrumb-item"><a
                        href="{{ route('archive', ['prodi_id' => $prodi->prodi_id]) }}">{{ $prodi->prodi_name }}</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-body">
                <table class="table-responsive table">
                    <thead class="table-primary table-hover text-white">
                        <tr>
                            <th>No</th>
                            <th>Jenis Surat</th>
                            <th>Perihal</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($surat as $s)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $s->js_name }}</td>
                                <td>{{ $s->sk_perihal }}</td>
                                <td>{{ \Carbon\Carbon::parse($s->sk_tgl)->isoFormat('DD MMMM YYYY') }}</td>
                                <td>
                                    <button onclick="return printDoc({{ $s->sk_id }})" {{-- href="{{ route('surat_keluar.show', $s->sk_id) }}" --}}
                                        class="btn btn-sm btn-info" target="__blank"><i class="fa fa-print"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
