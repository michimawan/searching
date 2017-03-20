@extends('layout.base')
@section('content')
    {{ Form::open(['url' => 'store', 'files' => true]) }}
        <h2>Add Document</h2>
        <div class='form-group'>
        {{ Form::label('id', 'Id Document') }}
        {{ Form::number('id', '', ['required', 'placeholder' => 'some ID', 'class' => 'form-control']) }}
        </div>
        <div class='form-group'>
        {{ Form::label('pdf-file', 'Doc Content') }}
        {{ Form::file('pdf-file') }}
        </div>
        <div class='form-group'>
        {{ Form::submit('Add Doc !', ['class' => 'form-control btn btn-primary']) }}
        </div>
    {{ Form::close() }}
@stop