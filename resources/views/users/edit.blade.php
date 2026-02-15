@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" 
                   name="name" 
                   class="form-control" 
                   id="name" 
                   value="{{ old('name', $user->name) }}" 
                   required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   id="email" 
                   value="{{ old('email', $user->email) }}" 
                   required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password <small>(leave blank to keep current)</small></label>
            <input type="password" 
                   name="password" 
                   class="form-control" 
                   id="password">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" 
                   name="password_confirmation" 
                   class="form-control" 
                   id="password_confirmation">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control" id="role" required>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
