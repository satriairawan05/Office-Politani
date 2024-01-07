@extends('auth.layout.app')

@section('auth')
    <section class="login-block">
        <!-- Container-fluid starts -->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <!-- Authentication card start -->
                    <form class="md-float-material form-material" method="post" action="{{ route('login_store') }}">
                        @csrf
                        <div class="text-center">
                            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="logo.png" class="w-25 h-25">
                        </div>
                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-center">Sign In</h3>
                                    </div>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="email" class="form-control">
                                    <span class="form-bar"></span>
                                    <label class="float-label" for="email">Your Email Address / Nomor Induk</label>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" id="passwordInput" name="password" class="form-control">
                                    <a href="javascript:;" id="togglePassword" class="bg-transparent"><i
                                            class="fa fa-eye"></i></a>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Password</label>
                                </div>
                                <div class="form-group form-primary">
                                    <label for="login_as" class="form-label text-dark">Access </label>
                                    @php
                                        $access = [['access' => 'admin'], ['access' => 'mahasiswa'], ['access' => 'akademik']];
                                    @endphp
                                    <select class="form-select form-control" name="login_as"
                                        aria-label="Default select example">
                                        @foreach ($access as $acc)
                                            <option value="{{ $acc['access'] }}"
                                                @if (old('login_as') == $acc['access']) selected @endif>
                                                {{ $acc['access'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="row m-t-25 text-left">
                                    <div class="col-12">
                                        <div class="checkbox-fade fade-in-primary d-">
                                            <label>
                                                <input type="checkbox" value="">
                                                <span class="cr"><i
                                                        class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">Remember me</span>
                                            </label>
                                        </div>
                                        <div class="forgot-phone f-right text-right">
                                            <a href="auth-reset-password.html" class="f-w-600 text-right"> Forgot
                                                Password?</a>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect waves-light m-b-20 text-center">Sign
                                            in</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end of form -->
                </div>
                <!-- end of col-sm-12 -->
            </div>
            <!-- end of row -->
        </div>
        <!-- end of container-fluid -->
    </section>
@endsection
