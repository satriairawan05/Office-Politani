@extends('admin.layout.app')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2/select2.min.css') }}">
    <style type="text/css">
        #showHidePassword {
            position: relative;
        }

        #togglePassword,
        #togglePasswordConfirm {
            position: absolute;
            top: 74%;
            right: 24px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
@endpush

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/js/select2/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#group').select2();

            $('#togglePassword i').click(function(event) {
                event.preventDefault();
                const passwordInput = $('#passwordInput');
                const togglePassword = $('#togglePassword i');

                if (passwordInput.attr('type') === 'text') {
                    passwordInput.attr('type', 'password');
                    togglePassword.removeClass('fa-eye-slash').addClass('fa-eye');
                } else if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    togglePassword.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });

            $('#togglePasswordConfirm i').click(function(event) {
                event.preventDefault();
                const passwordConfirmInput = $('#password-confirm');
                const toggleConfirmPassword = $('#togglePasswordConfirm i');

                if (passwordConfirmInput.attr('type') === 'text') {
                    passwordConfirmInput.attr('type', 'password');
                    toggleConfirmPassword.removeClass('fa-eye-slash').addClass('fa-eye');
                } else if (passwordConfirmInput.attr('type') === 'password') {
                    passwordConfirmInput.attr('type', 'text');
                    toggleConfirmPassword.removeClass('fa-eye').addClass('fa-eye-slash');
                }
            });
        });
    </script>
@endpush

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
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">{{ $name }}</a></li>
                <li class="breadcrumb-item">Edit</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="card col-12">
            <div class="card-body">
                <form action="{{ route('user.update',$user->id) }}" method="post">
                    @csrf
                    @method('put')
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="name" class="form-label text-dark">Name <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control form-control-sm @error('name')
                                    is-invalid
                                @enderror"
                                id="name" placeholder="Masukan Nama" value="{{ old('name',$user->name) }}" name="name"
                                required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="email" class="form-label text-dark">Email <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control form-control-sm @error('email')
                                    is-invalid
                                @enderror"
                                id="email" placeholder="Masukan Email" value="{{ old('email',$user->email) }}" name="email"
                                required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="password" class="form-label text-dark">Password <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control form-control-sm @error('password')
                                    is-invalid
                                @enderror"
                                id="passwordInput" placeholder="Masukan Password" value="{{ old('password') }}"
                                name="password" required>
                            <a href="javascript:;" id="togglePassword" class="bg-transparent"><i class="fa fa-eye"></i></a>
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="password_confirmation" class="form-label text-dark">Confirm Password<span
                                    class="text-danger">*</span></label>
                            <input type="password" id="password-confirm" name="password_confirmation"
                                class="form-control form-control-sm" placeholder="Masukan Confirm Password" required>
                            <a href="javascript:;" id="togglePasswordConfirm" class="bg-transparent"><i
                                    class="fa fa-eye"></i></a>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-6">
                            <label for="nomor_induk" class="form-label text-dark">Nomor Induk <span
                                    class="text-danger">*</span> </label>
                            <input type="text"
                                class="form-control form-control-sm @error('nomor_induk')
                                    is-invalid
                                @enderror"
                                id="nomor_induk" placeholder="Masukan Nomor Induk" value="{{ old('nomor_induk',$user->nomor_induk) }}"
                                name="nomor_induk" required>
                            @error('nomor_induk')
                                <div class="invalid-feedback">
                                    {{ $errors->first('nomor_induk') }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="login_as" class="form-label text-dark">Access <span
                                    class="text-danger">*</span> </label>
                            @php
                                $access = [['access' => 'admin'], ['access' => 'mahasiswa'], ['access' => 'akademik']];
                            @endphp
                            <select class="form-select form-control" name="login_as" aria-label="Default select example">
                                @foreach ($access as $acc)
                                    <option value="{{ $acc['access'] }}" @if (old('login_as',$user->login_as) == $acc['access']) selected @endif>
                                        {{ $acc['access'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-12">
                            <label for="group_id" class="form-label text-dark">Role <span class="text-danger">*</span>
                            </label>
                            <select id="group" name="group_id" class="form-control form-control-sm">
                                @foreach ($group as $g)
                                    @if (old('group_id') == $g->group_id)
                                        <option value="{{ $g->group_id }}" selected>{{ $g->group_name }}</option>
                                    @else
                                        <option value="{{ $g->group_id }}">{{ $g->group_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row mt-3">
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-info mx-2"><i
                                    class="fa fa-reply-all"></i></a>
                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
