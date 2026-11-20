@extends('templates.layoutApp')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h1 class="fs-3">Edit User</h1>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit User Data</h3>
            </div>

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>

                </div>

                <div class="card-footer">
                    <a href="{{ route('users.index') }}"
                        class="btn btn-secondary">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Update User
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection