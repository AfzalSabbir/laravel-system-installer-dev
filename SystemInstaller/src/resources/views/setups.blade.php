<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ env('APP_NAME') }} - Setup - Application</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-6 offset-md-3">
				<div class="card mx-auto mt-5">
					<div class="card-header">
						Application Setup
					</div>

					@php($keys = array_keys($setups))

					<ul class="list-group list-group-flush">
						<li class="list-group-item px-2 py-2 d-flex justify-content-between bg-light">
							<a href="#" title="Previous" data-step="prev" data-prev="setup-{{ $keys[0] }}" class="btn btn-outline-primary btn-sm change-step prev block" style="display: none;">
								<i class="fa fa-arrow-left"></i>
							</a>
							<a href="{{ route('system.installer.requirments') }}" class="btn btn-danger btn-sm prev-back">Back</a>

							<i id="axios-on" class="btn fa fa-refresh fa-pulse text-success" style="display: none"></i>

							<a href="#" title="Next" data-step="next" data-next="setup-{{ $keys[1] }}" class="btn btn-outline-primary btn-sm change-step next">
								<i class="fa fa-arrow-right"></i>
							</a>
							<button type="button" id="finish" class="btn btn-success btn-sm next-finish" style="display: none;">Finish</button>
						</li>
					</ul>
						
					<ul class="nav nav-pills my-2 justify-content-around pb-2 border-bottom">
						@foreach ($setups as $key => $setup)
						<li class="nav-item">
							<span data-id="setup-{{ $key }}" class="nav-link text-capitalize {{ array_key_first($setups) == $key ? 'active':'' }}">{{ $key }}</span>
						</li>
						@endforeach
					</ul>

					<p id="show-error-here-container" class="alert alert-danger px-2 mx-2 alert-dismissible fade show" style="display: none">
						<span></span>
						{{-- <button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<i aria-hidden="true">×</i>
						</button> --}}
					</p>

					<form action="{{ route('system.installer.finish') }}" id="save-setup" method="POST">
						@csrf
						@foreach ($setups as $key => $setup)
						<div class="setup-container">
							<div id="setup-{{ $key }}" style="{{ array_key_first($setups) != $key ? 'display:none':'' }}" class="px-2 setup-item">
								@foreach ($setup as $k => $set)
									<div class="form-row my-1">
										<label class="col-5">
											<span class="d-flex justify-content-between">
												<span>{{ $set['label'] }}</span>
												<span>:</span>
											</span>
										</label>
										<div class="col-7">
										@if(!is_array($set['value']))
											<input
												@foreach ($set['attr'] as $attrKey => $attr)
													{{ $attrKey.'='.$attr }}
												@endforeach
												type="{{ $set['type'] ? $set['type']:'text' }}"
												class="form-control form-control-sm"
												name="{{ $k }}"
												value="{{ $set['value'] }}">
										@else
											<select
												@foreach ($set['attr'] as $attrKey => $attr)
													{{ $attrKey.'='.$attr }}
												@endforeach
												class="form-control form-control-sm text-capitalize"
												name="{{ $k }}">
												@foreach ($set['value'] as $name => $value)
													<option class="text-capitalize" {{ env($k) == $value ? 'selected':'' }} value="{{ $value }}">{{ $name }}</option>
												@endforeach
											</select>
										@endif
										</div>
									</div>
								@endforeach
							</div>
						</div>
						@endforeach
						<button class="d-none" type="submit" id="save">Save</button>
					</form>
					{{-- <ul class="list-group list-group-flush">
						<li class="list-group-item px-2 py-2 d-flex justify-content-between">
							<a href="{{ route('system.installer.requirments') }}" class="btn btn-danger btn-sm">Back</a>
							@if(empty($no_pass))
								<button type="button" id="finish" class="btn btn-success btn-sm">Finish</button>
								@php(\Session::put('requirments', true))
							@else
								@php(\Session::put('requirments', false))
								<a href="#" class="btn btn-light btn-sm">Finish</a>
							@endif
						</li>
					</ul> --}}
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
	$(document).ready(function() {
		let first_key  = "{{ current($keys) }}";
		let second_key = "{{ $keys[1] }}";
		let last_key   = "{{ end($keys) }}";
		let step   = '';
		let target = '';
		let prev   = '';
		let next   = '';

		$('body').on('click', '#finish', function(event) {
			let env = [];
			$.each($('select, input'), (index, el) => {
				el.getAttribute('name') != '_token' ? env.push(
					{
						name: el.getAttribute('name'),
						value: el.value
					}
				):'';
			})
			$('#save').click();
			/*if(target == 'setup-'+last_key) {
			} else {
				alert('Please, complete all steps');
			    event.preventDefault();
			}*/
		});
		$('body').on('click', '.change-step', function(event) {
			event.preventDefault();
			$('#show-error-here-container').hide()

			step   = $(this).data('step');
			target = $(this).data(step);

			function changeStep() {
				$('.setup-container').find('.setup-item').hide();
				$('#'+target).show();

				$('.nav-pills').find('.active').removeClass('active');
				$(`span[data-id='${target}']`).addClass('active');

				$(`a[data-step='prev']`).data('prev', prev);
				$(`a[data-step='next']`).data('next', next);

				// console.log(target, prev, next, first_key);

				if('setup-'+first_key == target) {
					$('.prev').addClass('block')
					$('.prev').hide()
					$('.prev-back').show()
				}
				else {
					$('.prev').removeClass('block')
					$('.prev').show()
					$('.prev-back').hide()
				}

				if('setup-'+last_key == target){
					$('.next').addClass('block')
					$('.next').hide()
					$('.next-finish').show()
				}
				else {
					$('.next').removeClass('block')
					$('.next').show()
					$('.next-finish').hide()
				}
		    }

			prev = $(`span[data-id='${target}']`).closest('li').prev().find('span').attr('data-id');
			next = $(`span[data-id='${target}']`).closest('li').next().find('span').attr('data-id');

			if(prev == 'setup-database') {
				$('#axios-on').show();
				let database = {};
				$.each($(`#${prev}`).find('select, input'), (index, el) => {
					el.getAttribute('name') != '_token' ? database[el.getAttribute('name')]=el.value:'';
				})

				axios.get('{{ route('system.installer.check.database') }}', {
				  params: database,
				}).then((response) => {
					console.log(response);
					if(response.data.status) changeStep();
					else $('#show-error-here-container').show().find('span').text(response.data.message);
				}).catch((error) => {
				    console.error(error);
				}).finally(() => {
				    $('#axios-on').hide();
				});
			} else if(prev == 'setup-mail') {
				$('#axios-on').show();
				let mail = {};
				$.each($(`#${prev}`).find('select, input'), (index, el) => {
					el.getAttribute('name') != '_token' ? mail[el.getAttribute('name')]=el.value:'';
				})
				
				axios.get('{{ route('system.installer.check.mail') }}', {
				  params: mail,
				}).then((response) => {
					console.log(response);
					if(response.data.status) changeStep();
					else $('#show-error-here-container').show().find('span').text(response.data.message);
				}).catch((error) => {
				    console.error(error);
				}).finally(() => {
				    $('#axios-on').hide();
				});
			} else {
				changeStep();
			}
			
		});
		$('body').on('click', '.nav-link', function(event) {
			event.preventDefault();

			/*
				let thisId = $(this).data('id');

				$('.setup-container').find('.setup-item').hide();
				$('#'+thisId).show();

				$('.nav-pills').find('.active').removeClass('active');
				$(this).addClass('active');
			*/
		});
	});
</script>
<style>
	a.btn.prev.block,
	a.btn.next.block {
		background: #ddd;
		color: #fff;
		border: #4a4a4a;
	}
	/* span.nav-link:hover{
		border: 1px solid #ddd;
	}
	span.nav-link{
		border: 1px solid transparent;
	} */
</style>

</html>