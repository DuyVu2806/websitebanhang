<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }
    function index()
    {
        $authGuard = Auth::guard('admin');
        // dd($authGuard->user()->roles->pluck('name')->toArray());
        // dd(app('auth')->guard('admin')->user()->hasRole('admin'));
        //  Role::create(['name'=>'hello','guard_name'=>'admin']);
        //  Permission::create(['name' => 'add category','guard_name'=>'admin']);

        // $role = Role::find(3);
        // $permission = Permission::find(1);
        // $role->givePermissionTo($permission);//xác định quyền của vai trò
        //$permission->assignRole($role);//xác định vai trò của quyền
        // auth()->guard('admin')->user()->removeRole('admin');
        //  auth()->guard('admin')->user()->assignRole(['writer']);//gán vai trò trực tiếp cho người dùng
        // auth()->guard('admin')->user()->givePermissionTo('add product');//gán quyền trực tiếp cho người dùng
        // dd(auth()->guard('admin')->user()->hasAnyRole(['admin']));
        // dd(auth()->guard('admin')->user()->getDirectPermissions());

        $admins = Admin::with('roles', 'permissions')->orderBy('id', 'DESC')->get();
        return view('admin.permission.index', compact('admins'));
    }

    function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.permission.create', compact('roles', 'permissions'));
    }
    function post_create(Request $request)
    {
        $checkPermission = Role::find($request->roles)->first();
        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:admin',
            'password' => 'required|min:8',
            'roles' => 'required|array',
            'permissions' => 'array'
        ]);
        $request->merge(['password' => bcrypt($request->password)]);
        $admin = Admin::create([
            'code' => Helper::generate_unique_code('admin', 'code', 5),
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => $request->password,
        ]);
        $admin->assignRole($request->roles);

        // Gán permissions cho tài khoản (nếu cần)
        if (isset($request->permissions)) {
            foreach ($checkPermission->permissions as $value) {
                if ($value->id != $request->permissions) {
                    $admin->givePermissionTo($request->permissions);
                }
            }
        }
        return redirect()->back()->with('message', 'Register successfully');
    }

    function update($id)
    {
        $admin = Admin::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.permission.update', compact('admin', 'roles', 'permissions'));
    }
    function post_update(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required',
            'roles' => 'required|array',
            'permissions' => 'array'
        ]);
        $admin = Admin::findOrFail($id);
        $admin->update([
            'fullname' => $request->fullname,
        ]);
        $selectedRoles = $request->input('roles', []);
        $selectedPermissions = $request->input('permissions', []);

        $oldRoles = $admin->roles->pluck('id')->toArray();
        $oldPermissions = $admin->permissions->pluck('id')->toArray();
        // Xóa các vai trò cũ không được chọn
        $rolesToDelete = array_diff($oldRoles, $selectedRoles);
        $admin->roles()->detach($rolesToDelete);

        // Thêm các vai trò mới được chọn
        $rolesToAdd = array_diff($selectedRoles, $oldRoles);
        $admin->assignRole($rolesToAdd); // Sử dụng phương thức assignRole để thêm vai trò mới

        // Xóa các quyền cũ không được chọn
        $permissionsToDelete = array_diff($oldPermissions, $selectedPermissions);
        foreach ($permissionsToDelete as $permissionId) {
            $permission = Permission::findOrFail($permissionId);
            $admin->revokePermissionTo($permission);
        }
        // Thêm các quyền mới được chọn (nếu quyền không thuộc các vai trò cũ)
        $permissionsToAdd = array_diff($selectedPermissions, $oldPermissions);
        $admin->givePermissionTo($permissionsToAdd);
        return redirect()->route('admin.permission.index')->with('message', 'Cập nhật vai trò và quyền thành công');
    }
}
