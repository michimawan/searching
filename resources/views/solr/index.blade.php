@extends('layout.base')

@section('content')

<div class='row'>
    <a href="{{ route('solr.create') }}">Add Document</a>
    <a href="{{ route('solr.search') }}">Search Document</a>
</div>
<div class='row'>
    <div class='col-sm-12 col-md-12'>
    {!! Form::open(['url' => 'search', 'method'=>'get']) !!}
    <div class='form-group'>
        {!! Form::text('content', '', ['required', 'placeholder' => 'searched text', 'class' => 'form-control']) !!}
    </div>

    <div class='form-group'>
        {!! Form::submit('Search !', ['class' => 'form-control btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
    </div>
</div>
<div class='row'>
    <h2>There are {{ $results->getNumFound() }} row</h2>
    <div class="row">
    @foreach ($results as $result)
        <div class="col-sm-12 col-md-12">
            <h3>{{ $result->id }}</h3>
            <p>{{ $result->content }}</p>
        </div>
    @endforeach
    </div>
@stop