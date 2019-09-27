@extends('layouts.app')

@section('content')
   @include('admin.users._nav')
    <h3 align="center">  Это админка  {{ Auth::user()->name }}   !!</h3>

   <p><a href="{{ route('users.create') }}" class="btn btn-success">Add User</a></p>

   <div class="card mb-3">
       <div class="card-header">Filter</div>
       <div class="card-body">
           <form action="?" method="GET">
               <div class="row">
                   <div class="col-sm-1">
                       <div class="form-group">
                           <label for="id" class="col-form-label">ID</label>
                           <input id="id" class="form-control" name="id" value="{{ request('id') }}">
                       </div>
                   </div>

                       <div class="col-sm-2">
                           <div class="form-group">
                               <label for="name" class="col-form-label">Name</label>
                               <input id="name" class="form-control" name="name" value="{{ request('name') }}">
                           </div>
                       </div>

                   <div class="col-sm-3">
                       <div class="form-group">
                           <label for="email" class="col-form-label">Email</label>
                           <input id="email" class="form-control" name="email" value="{{ request('email') }}">
                       </div>
                   </div>
                   <div class="col-sm-2">
                       <div class="form-group">
                           <label for="role" class="col-form-label">Role</label>
                           <select id="role" class="form-control" name="role">
                               <option value=""></option>
                               @foreach ($roles as $value => $label)
                                   <option value="{{ $value }}"{{ $value === request('role') ? ' selected' : '' }}>{{ $label }}</option>
                               @endforeach;
                           </select>
                       </div>
                   </div>
                   <div class="col-sm-2">
                       <div class="form-group">
                           <label class="col-form-label">&nbsp;</label><br />
                           <button type="submit" class="btn btn-primary">Search</button>
                       </div>
                   </div>
               </div>
           </form>
       </div>
   </div>


   <div>
    <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>E-mail</th>
            <th>Phone</th>
            <th>Role</th>
        </tr>
        </thead>
        <tbody>

        @foreach($user as $users)
            <tr>
                <td>{{$users->id}}</td>
                <td><a href="{{route('users.show',$users)}}"> {{$users->name}}</a></td>
                <td>{{$users->last_name}}</td>
                <td>{{$users->email}}</td>
                <td>{{$users->phone}}</td>
                <td>
                    @if ($users->isAdmin())
                        <span class="badge badge-danger">Admin</span>
                    @else
                        <span class="badge badge-secondary">User</span>
                    @endif
                </td>

            </tr>

    @endforeach
        </tfoot>
    </table>
    {{$user->links()}}
</div>
@endsection