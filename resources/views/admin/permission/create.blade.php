@extends('layouts.admin')

@section('title', 'Thêm tài khoản')

@section('content')
    @push('style')
        <style>
            .hidden {
                display: none
            }
        </style>
    @endpush
    <div class="card mt-2">
        <div class="card-body">
            <div class="float-right mb-5">
                <a href="{{ route('admin.permission.index') }}" class="btn btn-outline-primary">Quay lại</a>
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
            <br>
            <br>
            <form action="{{ route('admin.permission.post_create') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" value="{{ old('fullname') }}">
                    @error('fullname')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="mr-5" for="">Vai trò:</label>
                    @foreach ($roles as $role)
                        <div class="form-check-inline">
                            <input class="form-check-input role-checkbox" type="checkbox" id="role{{ $role->id }}"
                                value="{{ $role->id }}" name="roles[]">
                            <label class="form-check-label" for="role{{ $role->id }}">{{ $role->name }}</label>
                        </div>
                    @endforeach
                    <br>
                    @error('roles')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="mr-5" for="">Quyền:</label>
                    @foreach ($permissions as $permission)
                        <div class="form-check-inline permission-checkbox"
                            data-role-ids="{{ implode(',', $permission->roles->pluck('id')->toArray()) }}">
                            <input class="form-check-input" type="checkbox" id="permission{{ $permission->id }} "
                                data-role="{{ $permission->role_id }}" value="{{ $permission->id }}" name="permissions[]">
                            <label class="form-check-label"
                                for="permission{{ $permission->id }}">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                    <br>
                    @error('permissions')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit" class="btn btn-outline-primary float-right">Lưu</button>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script>
        $(document).ready(function() {
            $('.role-checkbox').on('change', function() {
                const roleId = $(this).val();

                if ($(this).is(':checked')) {
                    $.map({!! json_encode($roles) !!}, function(value, index) {
                        if (value.id == roleId) {
                            $.map({!! json_encode($permissions) !!}, function(oldArrayValue, indexOfArray) {
                                $.map(oldArrayValue.roles, function(val, ind) {
                                    if (val.id == value.id) {
                                        console.log(oldArrayValue.id);
                                        $(`.permission-checkbox${oldArrayValue.id}`)
                                            .addClass(
                                                'hidden');
                                    }

                                });
                            });
                        }
                    });
                } else {
                    $.map({!! json_encode($roles) !!}, function(value, index) {
                        if (value.id == roleId) {
                            $.map({!! json_encode($permissions) !!}, function(oldArrayValue, indexOfArray) {
                                $.map(oldArrayValue.roles, function(val, ind) {
                                    if (val.id == value.id) {
                                        // console.log(oldArrayValue.id);
                                        $(`.permission-checkbox${oldArrayValue.id}`)
                                            .removeClass(
                                                'hidden');
                                    }

                                });
                            });
                        }
                    });
                }
            });
        });
    </script> --}}
    <script>
        $(document).ready(function() {
            $('.role-checkbox').on('change', function() {
                const roleId = $(this).val();
                const permissionCheckboxes = $('.permission-checkbox');

                if ($(this).is(':checked')) {
                    permissionCheckboxes.each(function() {
                        const roleIds = $(this).data('role-ids').split(',').map(Number);

                        if (roleIds.includes(parseInt(roleId))) {
                            $(this).addClass('hidden');
                        }
                    });
                } else {
                    permissionCheckboxes.each(function() {
                        const roleIds = $(this).data('role-ids').split(',').map(Number);
                        if (roleIds.includes(parseInt(roleId))) {
                            $(this).removeClass('hidden');
                        }
                    });
                }
            });
        });
    </script>
@endpush
