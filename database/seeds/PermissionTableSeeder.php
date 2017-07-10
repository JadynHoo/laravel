<?php

use Illuminate\Database\Seeder;
use App\Http\Model\User;
use App\Http\Model\Permission;
use App\Http\Model\Role;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //清空权限相关的数据
        Permission::truncate();
        Role::truncate();
        User::truncate();
        DB::table('role_user')->delete();
        DB::table('permission_role')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        //创建初始管理员用户
        $pilishen = User::create([
            'user_name' => 'jay',
            'user_pass' =>bcrypt('123')
        ]);

        //创建初始化role（初始的角色设定）
        $admin = Role::create([
            'name'=>'admin',
            'display_name'=>'管理员',
            'description'=>'super admin role'
        ]);

        //创建相应的初始化多权限
        $permissions = [
            [
                'name'=>'create_admin',
                'display_name'=>'创建用户',
                'description'=>'创建用户的权限'
            ],
            [
                'name'=>'edit_admin',
                'display_name'=>'编辑用户',
                'description'=>'编辑用户的权限'
            ],
            [
                'name'=>'delete_admin',
                'display_name'=>'删除用户',
                'description'=>'删除用户的权限'
            ]
        ];

        foreach($permissions as $permission){
            $manage_user = Permission::create($permission);

            //给角色赋予相应的权限
            $admin->attachPermission($manage_user);
        }


        //给用户赋予相应的角色
        $pilishen->attachRole($admin);





    }
}
