@extends('layouts.app')

@section('content')
   @include('admin.regions._nav')
    <h3 align="center">  Это админка  {{ Auth::user()->name }}   !!</h3>



    <p><a href="{{ route('regions.create') }}" class="btn btn-success">Add Region</a></p>

    @include('admin.regions._list', ['regions' => $regions])
@endsection


