<style type="text/css">
    :root {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
    }

    .tebal {
        display: block;
        border-bottom: 5px solid #000;
    }

    @media print {
        @page {
            size: A4;
        }
    }
</style>
<div class="container mt-3">
    <center>
        <table class="mt-3">
            <thead>
                <tr>
                    <td><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Cover"
                            style="width: 125px; height: 125px;" class="mx-2"></td>
                    <td align="center">
                        <font size="4" class="mt-0">Kementrian Pendidikan, Kebudayaan, Riset dan Teknologi
                        </font><br>
                        <font size="5" class="mt-0"><b>Politeknik Pertanian Negeri Samarinda</b></font><br>
                        <font size="1" class="mt-0" class="fs-2">Kampus Gunung Panjang Jl. Samratulangi
                            Samarinda 75131
                            Telepon.0541-260421, Fax.0541-260680</font><br>
                        <font size="1" class="mt-0" class="fs-2">email:
                            <u>info@politanisamarinda.ac.id</u>
                            dan
                            <u>politanismd@gmail.com</u> www.politanisamarinda.ac.id
                        </font>
                    </td>
                </tr>
            </thead>
        </table>
    </center>
    <span class="tebal mt-2"></span>
    <span style="display: block; border-bottom: 1px solid #000;" class="mt-1"></span>
    @if ($surat->js_id > 2 && $surat->js_id <= 5)
        <div class="mt-3">
            <center>
                <b class="text-uppercase">
                    <u>
                        @if ($surat->js_id == 3)
                            Surat Ijin Cuti
                        @else
                            Surat Keterangan
                        @endif
                    </u>
                </b>
                <p class="my-0 text-center">Nomor : {{ $surat->sk_nomor }}</p>
            </center>
        </div>
        <div class="mt-1">
            <div>
                <p style="text-align: justify; display: inline-block;">{!! $surat->sk_deskripsi !!}</p>
            </div>
            <div style="text-align: right">
                <p>{{ $surat->sk_tempat }} , {{ \Carbon\Carbon::parse($surat->sk_tgl)->isoFormat('DD MMMM YYYY') }}</p>
                <font size="4">Wakil Direktur I,</font><br>
                <br>
                <br>
                <br>
                <font size="3"><b><u>DR.Heriad Daud Salusu, S.Hut,MP</u></b></font><br>
                <font size="3"><b>NIP. 19700830 199703 1 00 1</b></font><br>
            </div>
        </div>
        @if ($surat->sk_tembusan != null)
            <div class="mt-1">
                <div style="text-align: left">
                    <font size="3">Tembusan : </font><br>
                    <font size="3">{!! $surat->sk_tembusan !!}</font>
                </div>
            </div>
        @endif
    @else
        <div class="mt-3">
            <font size="3">Nomor &nbsp;&nbsp;&nbsp;: {{ $surat->sk_nomor ? $surat->sk_nomor : '' }}</font><br>
            <font size="3">Lamp &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $surat->sk_lampiran }}</font><br>
            <font size="3">Perihal &nbsp;&nbsp;&nbsp;&nbsp;: {{ $surat->sk_perihal }}</font>
        </div>
        <div class="mt-1">
            <div style="text-align: center;">
                <p style="text-align: justify; display: inline-block;">{!! $surat->sk_deskripsi !!}</p>
            </div>
            <div style="text-align: right">
                <p>{{ $surat->sk_tempat }} , {{ \Carbon\Carbon::parse($surat->sk_tgl)->isoFormat('DD MMMM YYYY') }}</p>
                @if($signature != null)
                    <font size="4">{{ $signature->sign_jabatan }},</font><br>
                    <br>
                    <br>
                    <br>
                    <font size="3"><b><u>{{ $signature->sign_name }}</u></b></font><br>
                    <font size="3"><b>NIP. {{ $signature->sign_nip }}</b></font><br>
                @endif
            </div>
        </div>
        @if ($surat->sk_tembusan != null)
            <div class="mt-1">
                <div style="text-align: left">
                    <font size="3">Tembusan : </font><br>
                    <font size="3">{!! $surat->sk_tembusan !!}</font>
                </div>
            </div>
        @endif
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="{{ asset('assets/js/bootstrap/js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
    window.print();
</script>
