<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<%= app.description %>">
  <meta name="keywords" content="<%= app.keywords %>">
  <meta name="author" content="<%= app.author %>">
  <title>{{ config('app.name') }} | @yield('title_name')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">

   <!-- Custom Style -->

  @yield('custom_style')
  
  <!-- Theme style -->
  <link rel="stylesheet" href="/theme/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/theme/dist/css/skins/_all-skins.min.css">
  <!-- Pace style -->
  <link rel="stylesheet" href="/theme/plugins/pace/pace.min.css">
  
 

    <link rel="stylesheet" href="/css/style.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
<input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

  @include('layouts.header')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ config('app.name') }}
        <small id="datawaktu"></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        @yield('active_page')
      </ol>
    </section>

    @yield('content')
    </div>
  <!-- /.content-wrapper -->

    <!-- /.content-wrapper -->
  @include('layouts.footer')
</div>

<div class="modal fade" id="modalPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ganti Password User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idpassword">
                <form role="form">
                    <fieldset>
                        <div class="col-md-12">
                            <div class="form-group">
                                    {!! Form::label('password-lama', 'Password Lama') !!}
                                    {!! Form::password('password-lama', ['class' => 'form-control', 'placeholder' => 'Masukan Password Saat Ini']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password-baru', 'Password Baru') !!}
                                    {!! Form::password('password-baru', ['class' => 'form-control', 'placeholder' => 'Ketikkan Password Baru']) !!}
                                </div>
                                <div class="form-group">
                                    {!! Form::label('validate_password', 'Validasi Password Baru') !!}
                                    {!! Form::password('validate_password', ['class' => 'form-control', 'placeholder' => 'Ketikkan Password Baru sekali Lagi']) !!}
                                </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                {!! link_to('#', $title='Simpan Password', $attributes=['id'=>'simpanpassword', 'class'=>'btn btn-primary']) !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="/theme/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/theme/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="/theme/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/theme/plugins/fastclick/fastclick.js"></script>
<!-- PACE -->
<script src="/theme/plugins/pace/pace.min.js"></script>
<!-- Custom Script -->

@yield('custom_script')

<!-- AdminLTE App -->
<script src="/theme/dist/js/app.min.js"></script>
<script src="/theme/dist/js/demo.js"></script>
<script src="/plugins/Datejs-master/build/date.js"></script>
<script src="/js/phoneshope.js"></script>

@yield('custom_script_footer')

</body>
</html>