@extends('templates.layoutApp')

@section('content')
<div>
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="mb-0 fs-3">Users</h1>
                </div>
                <div class="col-sm-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-12">
                    <!--begin::Card-->
                    <div class="card mb-4">
                        <!--begin::Card Header-->
                        <div class="card-header">
                            <div class="row g-2 align-items-center">
                                <div class="col-12 col-md-4">
                                    <h3 class="card-title">User Directory</h3>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                        <div class="input-group input-group-sm w-auto">
                                            <span class="input-group-text">
                                                <i class="bi bi-search" aria-hidden="true"></i>
                                            </span>
                                            <input
                                                type="search"
                                                id="user-search"
                                                class="form-control"
                                                placeholder="Search users"
                                                aria-label="Search users"
                                                style="width: 180px" />
                                        </div>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-add-user">
                                            <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                                            New user
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Card Header-->
                        <!--begin::Card Body-->
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Email</th>
                                            <th>Created</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>
                                                <span class="fw-medium">{{ $user->name }}</span>
                                            </td>

                                            <td>{{ $user->email }}</td>

                                            <td>{{ $user->created_at->format('d M Y') }}</td>

                                            <td class="text-end">
                                                <div class="d-flex justify-content-end gap-1">

                                                    <!-- Tombol Edit -->
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>

                                                    <!-- Tombol Hapus -->
                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>

                                                    </form>

                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!--end::Card Body-->
                        <!--begin::Card Footer-->
                        <div class="card-footer clearfix">
                            <div class="float-start pt-1 fs-7 text-body-secondary">
                                Showing 1 to 9 of 42 users
                            </div>
                            <ul class="pagination pagination-sm m-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" aria-label="Previous"> &laquo; </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">4</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">5</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next"> &raquo; </a>
                                </li>
                            </ul>
                        </div>
                        <!--end::Card Footer-->
                    </div>
                    <!--end::Card-->
                </div>
                <!-- /.col -->
            </div>
            <!--end::Row-->


            <!--begin::Add User Modal-->
            <div
                class="modal fade"
                id="modal-add-user"
                tabindex="-1"
                aria-labelledby="modal-add-user-label"
                aria-hidden="true">

                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Form tambah user -->
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-add-user-label">
                                    Add new user
                                </h5>

                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close">
                                </button>
                            </div>

                            <div class="modal-body">

                                <!-- Input nama -->
                                <div class="mb-3">
                                    <label for="new-user-name" class="form-label">
                                        Full name
                                    </label>

                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        id="new-user-name"
                                        placeholder="e.g. Jane Doe"
                                        required />
                                </div>

                                <!-- Input email -->
                                <div class="mb-3">
                                    <label for="new-user-email" class="form-label">
                                        Email address
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        id="new-user-email"
                                        placeholder="name@example.com"
                                        required />
                                </div>

                                <!-- Input password -->
                                <div class="mb-3">
                                    <label for="new-user-password" class="form-label">
                                        Password
                                    </label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        id="new-user-password"
                                        placeholder="Minimum 8 characters"
                                        minlength="8"
                                        required />
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">
                                    Cancel
                                </button>

                                <button type="submit" class="btn btn-primary">
                                    Create user
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
            <!--end::Add User Modal-->


            <!--begin::Delete User Modal-->
            <div
                class="modal fade"
                id="modal-delete-user"
                tabindex="-1"
                aria-labelledby="modal-delete-user-label"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modal-delete-user-label">Delete user</h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">
                                Are you sure you want to delete this user? All content owned by the account
                                will be reassigned to the site administrator. This action cannot be undone.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Delete user
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Delete User Modal-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</div>
@endsection