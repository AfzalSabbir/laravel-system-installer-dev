<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ env('APP_NAME') }} - Setup - Checking System Requirments</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-6 offset-md-3">
				<div class="card mx-auto mt-5">
					<div class="card-header">
						Checking System Requirments
					</div>
					<ul class="list-group list-group-flush">
						<li class="list-group-item px-2 py-2 d-flex justify-content-between bg-light">
							<a href="{{ route('system.installer.init') }}" class="btn btn-danger btn-sm">Back</a>
							@if(empty($no_pass))
								<a href="{{ route('system.installer.setups') }}" class="btn btn-success btn-sm">Next</a>
								@php(\Session::put('requirments', true))
							@else
								@php(\Session::put('requirments', false))
								<a href="#" class="btn btn-light btn-sm">Next</a>
							@endif
						</li>
						@foreach ($requirments as $key => $requirment)
						@if (!$requirment['pass']) @php($no_pass = true) @endif
						<li class="list-group-item p-0">
							<label class="d-flex justify-content-between px-3 pt-2 cursor-pointer">
								<span>
									<i class="fa {{ $requirment['pass'] ? 'fa-check-square text-success':'fa-window-close text-danger' }} mr-2"></i>
									<span class="text-capitalize">{{ $key }}</span>
								</span>
								<span class="text-danger">
									{{ !$requirment['pass'] && $requirment['comment'] ? $requirment['comment']:'' }}
								</span>
							</label>
						</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

</html>