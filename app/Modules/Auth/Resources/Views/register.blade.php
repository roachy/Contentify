<h1 class="page-title">{{ trans_object('registration') }}</h1>

{!! Form::errors($errors) !!}

{!! Form::open(array('url' => 'auth/registration/create')) !!}
    {!! Form::smartText('username', trans('app.username')) !!}

    <div id="username_info" class="help-block text-right hidden" style='color:red'>
    	{!! HTML::fontIcon('info-circle') !!} {{ trans('auth::username_taken') }}
    </div>

    {!! Form::smartEmail() !!}

    {!! Form::smartPassword() !!}    
	
	{!! Form::helpBlock(trans('auth::password_length')) !!}

    {!! Form::smartPassword('password_confirmation', 'Confirm Password') !!}
	
    {!! Form::smartCaptcha() !!}

	<hr/>
	<b> By clicking on submit and creating an account on World Super Leagues you are stating that you adhere to our 
	<a href="{{ url('terms-conditions') }}"> Terms &amp; Conditions </a></b><br />
	<br />
    {!! Form::actions(['submit'], false) !!}
{!! Form::close() !!}

<script>
	$(document).ready(function()
	{
		$('#username').blur(function(event) {
			$.get(contentify.baseUrl + 'auth/username/check/' + $(this).val(), function(data)
            {
                if (data == 1) {
                	$('#username_info').removeClass('hidden');
                } else {
                	$('#username_info').addClass('hidden');
                }
            });
		});
	});
</script>