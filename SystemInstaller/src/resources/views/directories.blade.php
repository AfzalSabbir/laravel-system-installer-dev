<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Init</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-6 offset-md-3">
				<div class="card mx-auto">
					<div class="card-header">
						Checking if directories exists
					</div>
					<ul class="list-group list-group-flush">
						@foreach ($directories as $key => $directory)
						@foreach ($directory as $k => $dir)
						@if($key == 'storage')
						@php
							$txt = "Jane Doe\n";
							dd(storage_path($dir));
							\File::put($dir.'/directory_test.txt', $txt);
							/*\Storage::putFile($directory.'/directory_test.txt', $txt);*/
						@endphp
						@endif
						@if (is_writable($directory)) @php($no_pass = true) @endif
						<li class="list-group-item p-0">
							<label class="d-flex justify-content-between px-3 pt-2 cursor-pointer">
								<span>
									<i class="fa {{ $directory['pass'] ? 'fa-check-square text-success':'fa-window-close text-danger' }} mr-2"></i>
									<span class="text-capitalize">{{ $key }}</span>
								</span>
								<span class="text-danger">
									{{ !$directory['pass'] && $directory['comment'] ? $directory['comment']:'' }}
								</span>
							</label>
						</li>
						@endforeach
						@endforeach
						@if(empty($no_pass))
							<a href="?passed=1" class="btn btn-success">Next</a>
							@php(\Session::put('directories', true))
						@else
							@php(\Session::put('directories', false))
							<a href="#" class="btn btn-light">Next</a>
						@endif
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