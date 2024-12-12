@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Account Security</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('account.update.password') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>
@endsection
