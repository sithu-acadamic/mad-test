@extends('admin.layouts.master-without_nav')

@section('title') Login @endsection

<style>
    .centered-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .centered-container img {
        max-width: 100%;
    }

    .login-input {
        background: #fff;
        border: 1px solid #c9cfdb;
        border-radius: 6px;
        color: #000c37;
        font-size: 14px;
        font-weight: 400;
        min-height: 48px;
        padding: 12.5px 16px;
        transition: border-color .2s linear;
        width: 100%;
    }

    .password-input {
        background: #fff;
        border: 1px solid #c9cfdb;
        border-radius: 6px;
        color: #000c37;
        font-size: 14px;
        font-weight: 400;
        min-height: 48px;
        padding: 12.5px 16px;
        padding-right: 16px;
        transition: border-color .2s linear;
        width: 100%;
    }

    .forgot-password {
        color: #000c37;
        font-size: 10px;
        letter-spacing: .6px;
        line-height: 1.2;
        text-transform: uppercase;
        cursor: pointer;
    }

    .login-custom-width {
        width: 100%;
    }

    .login-main-card {
        width: 100%;
        height: 150%;
    }

    .logo-img {
        border-radius: 1rem 0 0 1rem;
        margin-top: 60px;
        width: 90%;
    }
</style>
@section('content')
    <div class="container login-custom-width">
        <!-- Section: Design Block -->
        <section class="vh-100 login-main-card">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100 login-main-card">
                    <div class="col col-xl-10 login-main-card-body">
                        <div class="card" style="border-radius: 1rem;">
                            <div class="row g-0 login-card-custom"
                                 style="box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);border-radius: 1rem 1rem 1rem 1rem;">
                                <div class="col-md-6 col-lg-6 d-none d-md-block centered-container mt-5"
                                     style="border-right: 1px solid rgba(0, 0, 0, 0.2);">
                                    <div class="container d-flex justify-content-center">
                                        <div class="col-lg-9  d-flex justify-content-center mt-1">
                                            <img src="{{asset('admin/images/system/VXL_new_logo.png')}}" alt="login form" class="img-fluid logo-img"/>
                                        </div>
                                    </div>


                                </div>


                                <div class="col-md-6 col-lg-6 d-flex align-items-center mt-3">
                                    <div class="card-body p-4 p-lg-5 text-black mt-5">

                                        <form class="form-horizontal auth-form" method="POST"
                                              action="{{ route('login') }}">
                                            @csrf

                                            <div class="form-group mb-2">
                                                <div class="input-group">
                                                    <input name="email" type="email"
                                                           class="form-control @error('email') is-invalid @enderror login-input"
                                                           value="{{ old('email') }}" id="username"
                                                           placeholder="ENTER EMAIL" autocomplete="email" autofocus>
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @else
                                                        <span class="help-text">
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-outline mb-4">

                                                <input type="password" name="password"
                                                       class="form-control  @error('password') is-invalid @enderror password-input"
                                                       id="userpassword" placeholder="ENTER PASSWORD"
                                                       aria-label="Password" aria-describedby="password-addon">
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @else
                                                    <span class="help-text"></span>
                                                @endif

                                            </div>

                                            {{--<div class="form-group row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control col-md-4 login-input"
                                                           placeholder="TYPE IMAGE TEXT" name="captcha_text">
                                                </div>

                                                <div class="col-md-6 text-end">
                                                    {!!captcha_img()!!}
                                                    <a href="#" class="btn btn-default btn-sm" id="regen-captcha">
                                                  <span
                                                          class="glyphicon glyphicon-refresh"></span>
                                                        <svg class="svg-icon"
                                                             xmlns="http://www.w3.org/2000/svg"
                                                             height="24" viewBox="0 0 24 24"
                                                             width="24">
                                                            <path
                                                                    d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z"/>
                                                            <path d="M0 0h24v24H0z"
                                                                  fill="none"/>
                                                        </svg>
                                                    </a>
                                                </div>


                                            </div>--}}

                                            {{--<div class="form-group row">
                                                <table class="login-custom-width">
                                                    <tr>
                                                        <td style="width: 52%;"></td>
                                                        <td>
                                                            <strong style="color:#f5325c;">{{ $errors->first('captcha_text') }}</strong>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>--}}

                                            <div class="pt-1 mb-4  d-flex justify-content-center">

                                                <button class="btn btn-primary btn-lg btn-block"
                                                        style="border-color: #3863b3; background-color: #3863b3;width:80%"
                                                        type="submit">LOG IN <i class="fas fa-sign-in-alt ms-1"></i>
                                                </button>

                                            </div>
                                            {{--<div class="pt-1 mb-4  d-flex justify-content-center">

                                                <span class="forgot-password mt-2"><a
                                                            href="#">Forgot Password?</a></span>

                                            </div>--}}
                                        </form>
                                        <div class="d-flex justify-content-center">
                                                <span class="text-muted d-none d-sm-inline-block text-center"
                                                      style="position: absolute;">{{date('Y')}}
                                                    © VXL Education</span>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>
        <!-- Section: Design Block -->
    </div>
    <div>

    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('admin/assets/js/login/login.js')}}"></script>
@endsection
