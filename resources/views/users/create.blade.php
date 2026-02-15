@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Create User</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" 
                   name="name" 
                   id="name"
                   class="form-control" 
                   placeholder="Enter Name" 
                   value="{{ old('name') }}" 
                   required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" 
                   name="email" 
                   id="email"
                   class="form-control" 
                   placeholder="Enter Email" 
                   value="{{ old('email') }}" 
                   required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" 
                   name="password" 
                   id="password"
                   class="form-control" 
                   placeholder="Enter Password" 
                   required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" 
                   name="password_confirmation" 
                   id="password_confirmation"
                   class="form-control" 
                   placeholder="Confirm Password" 
                   required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" 
                    id="role" 
                    class="form-control" 
                    required>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save User</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
