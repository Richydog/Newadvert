@extends('layouts.app')

@section('content')

    <ul class="nav nav-tabs mb-3">
        <li class="nav-item"><a class="nav-link active" href="{{route('admin.home')}}"> Приборная панель</a>

        </li>
        <li class="nav-item"><a class="nav-link " href="{{route('users.index')}}">User</a>
        </li>
        </li>
        <li class="nav-item"><a class="nav-link " href="{{route('admin/adverts.admin.index')}}">Advert</a>
        </li>
        <li class="nav-item"><a class="nav-link   " href="{{route('regions.index')}}">Region</a>
        </li>
        <li class="nav-item"><a class="nav-link   " href="{{route('categories.index')}}">Category</a>
        </li>
        <li class="nav-item"><a class="nav-link   " href="{{route('admin.pages.index')}}">Pages</a>
        </li>
        <li class="nav-item"><a class="nav-link   " href="{{ route('admin.banners.index') }}">Banners</a>
        </li>
        <li class="nav-item"><a class="nav-link"   href="{{ route('admin.tickets.index') }}">Tickets</a></li>
    </ul>

                      <h3 align="center">  Это админка  {{ Auth::user()->name }}   !!</h3>

@endsection
