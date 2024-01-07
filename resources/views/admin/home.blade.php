@extends('admin.layout.app')

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"
        integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/chartjs/chartjs.min.css') }}">
@endpush

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
        integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/js/chartjs/chartjs.min.jss') }}"></script>
    <script type="text/javascript">
        var ctx = document.getElementById('myChart').getContext('2d');
        const dataPie = {
            datasets: [{
                data: <?php echo json_encode($total_surat); ?>,
                backgroundColor: [
                    'rgb(255, 99, 132)', // Merah
                    'rgb(54, 162, 235)', // Biru
                    'rgb(255, 205, 86)', // Kuning
                    'rgb(75, 192, 192)', // Hijau
                    'rgb(153, 102, 255)', // Ungu
                    'rgb(255, 159, 64)', // Oranye
                    'rgb(94, 199, 221)', // Biru Tua
                    'rgb(207, 114, 207)', // Ungu Muda
                    'rgb(128, 0, 128)', // Ungu Gelap
                    'rgb(255, 0, 255)', // Magenta
                    'rgb(0, 255, 255)', // Cyan
                    'rgb(0, 128, 0)', // Hijau Gelap
                    'rgb(255, 0, 0)' // Merah Terang
                ]
            }],
            labels: <?php echo json_encode($nama_surat); ?>
        }
        const optionPieChart = {
            legend: {
                labels: {
                    fontColor: 'black'
                }
            },
            responsive: true,
        }
        const PieChart = new Chart(ctx, {
            type: 'pie',
            data: dataPie,
            options: optionPieChart
        });
    </script>
@endpush

@section('breadcrumb')
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="page-header-title">
                <h5 class="m-b-10">Dashboard</h5>
                <p class="m-b-0">Welcome to Sistem Informasi Pengajuan Surat Akademik Politeknik Pertanian Negeri Samarinda
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}"> <i class="fa fa-home"></i> </a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-body">
                <h1 class="text-center">Actual Data Periode <b>{!! \Carbon\Carbon::now()->isoFormat('MMMM') !!}</b> {!! \Carbon\Carbon::now()->isoFormat('YYYY')!!}</h1>
                <canvas id="myChart" height="100" width="400"></canvas>
            </div>
        </div>
    </div>
@endsection
