@extends('layouts.admin')

@section('title', 'Chỉnh sửa vai trò và quyền')

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
            <br>
            <br>
            <form action="{{ route('admin.permission.post_update', ['id' => $admin->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="">Họ và tên</label>
                    <input type="text" name="fullname" class="form-control" value="{{ $admin->fullname }}">
                    @error('fullname')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $admin->email }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label class="mr-5" for="">Vai trò:</label>
                    @foreach ($roles as $role)
                        <div class="form-check-inline">
                            <input class="form-check-input role-checkbox" type="checkbox" id="role{{ $role->id }}"
                                value="{{ $role->id }}" name="roles[]"
                                {{ $admin->hasRole($role->name) ? 'checked' : '' }}>
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
                                data-role="{{ $permission->role_id }}" value="{{ $permission->id }}" name="permissions[]"
                                {{ $admin->hasPermission($permission->name) ? 'checked' : '' }}>
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
    <script>
        $(document).ready(function() {
            var selectedRoles = [];
            $('.role-checkbox:checked').each(function() {
                selectedRoles.push($(this).val());
                hidePermissionsForRole(selectedRoles);
            });

            $('.role-checkbox').on('change', function() {
                const roleId = $(this).val();

                if ($(this).is(':checked')) {
                    selectedRoles.push(roleId);
                    hidePermissionsForRole(selectedRoles);
                } else {
                    selectedRoles = selectedRoles.filter(role => role != roleId);
                    hidePermissionsForRole(selectedRoles);
                }
            });

            function hidePermissionsForRole(selectedRoles) {
                $('.permission-checkbox').removeClass('hidden'); 

                selectedRoles.forEach(roleId => {
                    $(`.permission-checkbox[data-role-ids*="${roleId}"]`).addClass('hidden');
                });
            }
        });
    </script>
@endpush
