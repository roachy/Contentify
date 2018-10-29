{!! Form::errors($errors) !!}

@if (isset($model))
    {!! Form::model($model, ['route' => ['admin.advertcats.update', $model->id], 'method' => 'PUT']) !!}
@else
    {!! Form::open(['url' => 'admin/advertcats']) !!}
@endif
    {!! Form::smartText('title', trans('app.title')) !!}
        
    {!! Form::actions() !!}
{!! Form::close() !!}