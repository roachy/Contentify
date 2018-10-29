<h1 class="page-title">{{ trans_object('contact') }} World Super Leagues</h1>

{!! Form::errors($errors) !!}

{!! Form::open(array('url' => 'contact/store')) !!}
    {!! Form::timestamp() !!}

    {!! Form::smartText('username', trans('app.name'), user() ? user()->username : null) !!}

    {!! Form::smartEmail('email', trans('app.email'), user() ? user()->email : null) !!}

    {!! Form::smartGroupOpen('title', trans('app.subject')) !!}
        {!! Form::select('title', array('Enquiry' => 'General Enquiry', 'Dispute' => 'Match Dispute', 'Whining' => 'Complaint')) !!}
    {!! Form::smartGroupClose() !!}

    {!! Form::smartText('match_id', trans('Match ID')) !!}
	
    {!! Form::smartTextarea('text', trans('app.message')) !!}

    {!! Form::actions(['submit' => trans('app.send')], false) !!}
{!! Form::close() !!}