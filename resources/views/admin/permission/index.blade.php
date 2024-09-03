@extends('layouts.admin')

@section('title', 'Phân quyền & vai trò')

@section('content')
    <div class="card mt-2">
        <div class="card-body">
            <div class="float-right mb-5">
                <a href="{{ route('admin.permission.create') }}" class="btn btn-outline-primary">Thêm tài khoản</a>
            </div>
            @if (session()->has('message'))
                <script>
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        text: '{{ session('message') }}',
                        showConfirmButton: false,
                        toast: true,
                        timer: 1200,
                        timerProgressBar: true,
                        width: 'auto',
                        padding: '0.7em'
                    })
                </script>
            @endif
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên tài khoản</th>
                        <th>Vai trò</th>
                        <th>Quyền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $key => $admin)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->roles->pluck('name')->implode(', ') }}</td>
                            <td>
                                @php
                                    $permissions = [];
                                    $permissions = array_merge($permissions, $admin->permissions->pluck('name')->toArray());
                                    foreach ($admin->roles as $role) {
                                        $permissions = array_merge($permissions, $role->permissions->pluck('name')->toArray());
                                    }
                                    
                                    $uniquePermissions = array_unique($permissions);
                                @endphp

                                {{ implode(', ', $uniquePermissions) }}
                            </td>
                            <td>


                                @if ($admin->id != 1)
                                    <a class="btn btn-sm btn-outline-warning"
                                        href="{{ route('admin.permission.update', ['id' => $admin->id]) }}">Chỉnh sửa vai trò
                                        &
                                        quyền</a>
                                    <a class="btn btn-sm btn-outline-danger" href="">Khóa Tài Khoản</a>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Không có tài khoản nào</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
@endsection
