@extends('layouts.app')
@section('breadcrumbs', '')
@section('content')
    <p><a href="{{route('adverts.create')}}" class="btn btn-success">Add Advert</a></p>


    <div class="card card-default mb-3">
        <div class="card-header">
            All Categories
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                @foreach (array_chunk($categories,3) as $chunk)
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            @foreach ($chunk as $carrent)
                                <li><a href="{{ route('urad.index', adverts_path(null, $carrent)) }}">{{ $carrent->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card card-default mb-3">
        <div class="card-header">
            All Regions
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                @foreach (array_chunk($regions,3) as $chunk)
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            @foreach ($chunk as $carrent)
                                <li><a href="{{ route('urad.index', adverts_path($carrent, null)) }}">{{ $carrent->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">

            <div class="adverts-list">
                @foreach ($adverts as $advert)
                    <div class="advert">
                        <div class="row">
                            <div class="col-md-3">
                                <div style="height: 180px; background: #f6f6f6; border: 1px solid #ddd"></div>
                            </div>
                            <div class="col-md-9">
                                <span class="float-right">{{ $advert->price }}</span>
                                <div class="h4" style="margin-top: 0"><a href="{{ route('adverts.show', $advert) }}">{{ $advert->title }}</a></div>
                                <p>Region: <a href="">{{ $advert->region ? $advert->region->name : 'All' }}</a></p>
                                <p>Category: <a href="">{{ $advert->category->name }}</a></p>
                                <p>Date: {{ $advert->created_at }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
