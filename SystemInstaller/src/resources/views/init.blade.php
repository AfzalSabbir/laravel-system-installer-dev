<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ env('APP_NAME') }} - Setup - Init</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	{{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
</head>
<body>
	<div class="container">
        <div class="row align-items-center" id="h-full">
            <div class="col-12 mx-auto">
                <div class="h-100 justify-content-center text-center">
                    @if(env('APP_NAME') == 'Installer')
                        <a class="btn btn-primary" href="{{ route('system.installer.requirments') }}">
                            <i class="fa fa-cogs"></i> Start
                        </a>
                    @else
                        <a class="btn btn-primary" href="{{ route('system.installer.requirments') }}">
                            <i class="fa fa-cogs"></i> Re-Install
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
<script>
    $('#h-full').css('height', innerHeight);
</script>
</html>
