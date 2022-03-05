<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/theme/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/theme/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="/js/html5shiv.min.js"></script>
    <script src="/js/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>Log</b> in
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="/login" method="post">
            {{ csrf_field() }}

            {{--<div class="form-group has-error">--}}
                {{--<label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> Input with--}}
                    {{--error</label>--}}
                {{--<input type="text" class="form-control" id="inputError" placeholder="Enter ...">--}}
                {{--<span class="help-block">Help block with error</span>--}}
            {{--</div>--}}

            <div class="form-group has-feedback{{ $errors->has('username') ? ' has-error' : '' }}">
                @if ($errors->has('username'))
                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('username') }}</label>
                @endif
                <input id="username" placeholder="Username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>

            {{--<div class="form-group has-feedback">--}}
                {{--<input type="email" class="form-control" placeholder="Email">--}}
                {{--<span class="glyphicon glyphicon-envelope form-control-feedback"></span>--}}
            {{--</div>--}}
            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                @if ($errors->has('password'))
                    <label class="control-label" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('password') }}</label>
                @endif
                <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> Ingat saya
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="/theme/plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>