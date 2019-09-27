@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <form method="POST" action="{{ route('users.store')}}">
        @csrf

        <div class="form-group">
            <label for="name" class="col-form-label">Name</label>
            <input id="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
            @if ($errors->has('name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="last_name" class="col-form-label">Last_Name</label>
            <input id="last_name" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
            @if ($errors->has('last_name'))
                <span class="invalid-feedback"><strong>{{ $errors->first('last_name') }}</strong></span>
            @endif
        </div>

        <div class="form-group">
            <label for="email" class="col-form-label">E-Mail Address</label>
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
            @if ($errors->has('email'))
                <span class="invalid-feedback"><strong>{{ $errors->first('email') }}</strong></span>
            @endif
        </div>
        <div class="form-group">
            <label for="role" class="col-form-label">Role</label>
            <input id="role" class="form-control{{ $errors->has('role') ? ' is-invalid' : '' }}" name="role" value="{{ old('role') }}" >
            @if ($errors->has('role'))
                <span class="invalid-feedback"><strong>{{ $errors->first('role') }}</strong></span>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
