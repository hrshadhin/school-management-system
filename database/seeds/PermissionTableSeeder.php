<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commonPermissionList = [
            [
                "slug" => "change_password",
                "name" => "Change Password",
                "group" => "Common"
            ],
            [
                "slug" => "user.dashboard",
                "name" => "Dashboard",
                "group" => "Common"
            ],
            [
                "slug" => "lockscreen",
                "name" => "Lock Screen",
                "group" => "Common"
            ],
            [
                "slug" => "logout",
                "name" => "Logout",
                "group" => "Common"
            ],
            [
                "slug" => "profile",
                "name" => "Profile",
                "group" => "Common"
            ],
            [
                "slug" => "user.notification_unread",
                "name" => "Notification View",
                "group" => "Common"
            ],
            [
                "slug" => "user.notification_read",
                "name" => "Notification View",
                "group" => "Common"
            ],
            [
                "slug" => "user.notification_all",
                "name" => "Notification View",
                "group" => "Common"
            ]

        ];

        $administratorPermissionList = [

            [   "slug" => "user.store",
                "name" => "User Create",
                "group" => "Administration"
            ],
            [   "slug" => "user.index",
                "name" => "User View",
                "group" => "Administration"
            ],
            [   "slug" => "user.create",
                "name" => "User Create",
                "group" => "Administration"
            ],
            [   "slug" => "user.status",
                "name" => "User Edit",
                "group" => "Administration"
            ],
            [   "slug" => "user.show",
                "name" => "User View",
                "group" => "Administration"
            ],
            [   "slug" => "user.update",
                "name" => "User Edit",
                "group" => "Administration"
            ],
            [   "slug" => "user.destroy",
                "name" => "User Delete",
                "group" => "Administration"
            ],
            [   "slug" => "user.edit",
                "name" => "User Edit",
                "group" => "Administration"
            ],
            [   "slug" => "user.permission",
                "name" => "User Edit",
                "group" => "Administration"
            ]
        ];

        $onlyAdminPermissions = [
            [
                "slug" => "administrator.academic_year_destroy",
                "name" => "Academic Year Delete",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.academic_year",
                "name" => "Academic Year View",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.academic_year_store",
                "name" => "Academic Year Create",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.academic_year_create",
                "name" => "Academic Year Create",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.academic_year_edit",
                "name" => "Academic Year Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.academic_year_status",
                "name" => "Academic Year Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.academic_year_update",
                "name" => "Academic Year Edit",
                "group" => "Admin Only"
            ],
            [ "slug" => "settings.institute",
                "name" => "Institute Edit",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_index",
                "name" => "Role View",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_destroy",
                "name" => "Role Delete",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_create",
                "name" => "Role Create",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_store",
                "name" => "Role Create",
                "group" => "Admin Only"
            ],
            [   "slug" => "user.role_update",
                "name" => "Role Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_index",
                "name" => "System Admin View",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_create",
                "name" => "System Admin Create",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_status",
                "name" => "System Admin Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_store",
                "name" => "System Admin Create",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_update",
                "name" => "System Admin Edit",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_destroy",
                "name" => "System Admin Delete",
                "group" => "Admin Only"
            ],
            [
                "slug" => "administrator.user_edit",
                "name" => "System Admin Edit",
                "group" => "Admin Only"
            ],
            [   "slug" => "administrator.user_password_reset",
                "name" => "User Password Reset",
                "group" => "Admin Only"
            ]
        ];

        $academicPermissionList = [
            [
                "slug" => "academic.class_destroy",
                "name" => "Class Delete",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.class",
                "name" => "Class View",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.class_store",
                "name" => "Class Create",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.class_create",
                "name" => "Class Create",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.class_edit",
                "name" => "Class Edit",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.class_status",
                "name" => "Class Edit",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.class_update",
                "name" => "Class Edit",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.section_destroy",
                "name" => "Section Delete",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.section",
                "name" => "Section View",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.section_store",
                "name" => "Section Create",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.section_create",
                "name" => "Section Create",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.section_edit",
                "name" => "Section Edit",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.section_status",
                "name" => "Section Edit",
                "group" => "Academic"
            ],
            [
                "slug" => "academic.section_update",
                "name" => "Section Edit",
                "group" => "Academic"
            ],
            [   "slug" => "student.store",
                "name" => "Student Create",
                "group" => "Academic"
            ],
            [   "slug" => "student.index",
                "name" => "Student View",
                "group" => "Academic"
            ],
            [   "slug" => "student.create",
                "name" => "Student Create",
                "group" => "Academic"
            ],
            [   "slug" => "student.status",
                "name" => "Student Edit",
                "group" => "Academic"
            ],
            [   "slug" => "student.destroy",
                "name" => "Student Delete",
                "group" => "Academic"
            ],
            [   "slug" => "student.update",
                "name" => "Student Edit",
                "group" => "Academic"
            ],
            [   "slug" => "student.show",
                "name" => "Student View",
                "group" => "Academic"
            ],
            [   "slug" => "student.edit",
                "name" => "Student Edit",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.index",
                "name" => "Teacher View",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.store",
                "name" => "Teacher Create",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.create",
                "name" => "Teacher Create",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.status",
                "name" => "Teacher Edit",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.destroy",
                "name" => "Teacher Delete",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.update",
                "name" => "Teacher Edit",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.show",
                "name" => "Teacher View",
                "group" => "Academic"
            ],
            [   "slug" => "teacher.edit",
                "name" => "Teacher Edit",
                "group" => "Academic"
            ]
        ];

        $websitePermissionList = [
            [
                "slug" => "class_profile.index",
                "name" => "Class Profile View",
                "group" => "Website"
            ],
            [
                "slug" => "class_profile.store",
                "name" => "Class Profile Create",
                "group" => "Website"
            ],
            [
                "slug" => "class_profile.create",
                "name" => "Class Profile Create",
                "group" => "Website"
            ],
            [
                "slug" => "class_profile.show",
                "name" => "Class Profile View",
                "group" => "Website"
            ],
            [
                "slug" => "class_profile.update",
                "name" => "Class Profile Edit",
                "group" => "Website"
            ],
            [
                "slug" => "class_profile.destroy",
                "name" => "Class Profile Delete",
                "group" => "Website"
            ],
            [
                "slug" => "class_profile.edit",
                "name" => "Class Profile Edit",
                "group" => "Website"
            ],
            [   "slug" => "event.index",
                "name" => "Event View",
                "group" => "Website"
            ],
            [   "slug" => "event.store",
                "name" => "Event Create",
                "group" => "Website"
            ],
            [   "slug" => "event.create",
                "name" => "Event Create",
                "group" => "Website"
            ],
            [   "slug" => "event.destroy",
                "name" => "Event Delete",
                "group" => "Website"
            ],
            [   "slug" => "event.show",
                "name" => "Event View",
                "group" => "Website"
            ],
            [   "slug" => "event.update",
                "name" => "Event Edit",
                "group" => "Website"
            ],
            [   "slug" => "event.edit",
                "name" => "Event Edit",
                "group" => "Website"
            ],
            [   "slug" => "teacher_profile.index",
                "name" => "Teacher Profile View",
                "group" => "Website"
            ],
            [   "slug" => "teacher_profile.store",
                "name" => "Teacher Profile Create",
                "group" => "Website"
            ],
            [   "slug" => "teacher_profile.create",
                "name" => "Teacher Profile Create",
                "group" => "Website"
            ],
            [   "slug" => "teacher_profile.update",
                "name" => "Teacher Profile Edit",
                "group" => "Website"
            ],
            [   "slug" => "teacher_profile.show",
                "name" => "Teacher Profile View",
                "group" => "Website"
            ],
            [   "slug" => "teacher_profile.destroy",
                "name" => "Teacher Profile Delete",
                "group" => "Website"
            ],
            [   "slug" => "teacher_profile.edit",
                "name" => "Teacher Profile Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.about_content",
                "name" => "Site About Content Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.about_content",
                "name" => "Site About Content Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.about_content_image",
                "name" => "Site About Content Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.about_content_image",
                "name" => "Site About Content Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.about_content_image_delete",
                "name" => "Site About Content Delete",
                "group" => "Website"
            ],
            [   "slug" => "site.analytics",
                "name" => "Site Analytics Setting Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.analytics",
                "name" => "Site Analytics Setting Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.contact_us",
                "name" => "Site Contact Us Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.contact_us",
                "name" => "Site Contact Us Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.dashboard",
                "name" => "Site Dashboard View",
                "group" => "Website"
            ],
            [   "slug" => "site.faq_delete",
                "name" => "Site FAQ Delete",
                "group" => "Website"
            ],
            [   "slug" => "site.faq",
                "name" => "Site FAQ Create",
                "group" => "Website"
            ],
            [   "slug" => "site.faq",
                "name" => "Site FAQ Create",
                "group" => "Website"
            ],
            [   "slug" => "site.gallery",
                "name" => "Site Gallery View",
                "group" => "Website"
            ],
            [   "slug" => "site.gallery_image",
                "name" => "Site Gallery Create",
                "group" => "Website"
            ],
            [   "slug" => "site.gallery_image",
                "name" => "Site Gallery Create",
                "group" => "Website"
            ],
            [   "slug" => "site.gallery_image_delete",
                "name" => "Site Gallery Delete",
                "group" => "Website"
            ],
            [   "slug" => "site.service",
                "name" => "Site Service Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.service",
                "name" => "Site Service Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.settings",
                "name" => "Site Settings Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.settings",
                "name" => "Site Settings Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.statistic",
                "name" => "Site Statistic Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.statistic",
                "name" => "Site Statistic Edit",
                "group" => "Website"
            ],
            [   "slug" => "site.subscribe",
                "name" => "Site Subscriber View",
                "group" => "Website"
            ],
            [   "slug" => "site.testimonial",
                "name" => "Site Testimonial View",
                "group" => "Website"
            ],
            [   "slug" => "site.testimonial_delete",
                "name" => "Site Testimonial Delete",
                "group" => "Website"
            ],
            [   "slug" => "site.testimonial_create",
                "name" => "Site Testimonial Create",
                "group" => "Website"
            ],
            [   "slug" => "site.testimonial_create",
                "name" => "Site Testimonial Create",
                "group" => "Website"
            ],
            [   "slug" => "site.timeline",
                "name" => "Site Timeline Create",
                "group" => "Website"
            ],
            [   "slug" => "site.timeline",
                "name" => "Site Timeline Create",
                "group" => "Website"
            ],
            [   "slug" => "site.timeline_delete",
                "name" => "Site Timeline Delete",
                "group" => "Website"
            ],
            [   "slug" => "slider.index",
                "name" => "Slider View",
                "group" => "Website"
            ],
            [   "slug" => "slider.store",
                "name" => "Slider Create",
                "group" => "Website"
            ],
            [   "slug" => "slider.create",
                "name" => "Slider Create",
                "group" => "Website"
            ],
            [   "slug" => "slider.destroy",
                "name" => "Slider Delete",
                "group" => "Website"
            ],
            [   "slug" => "slider.update",
                "name" => "Slider Edit",
                "group" => "Website"
            ],
            [   "slug" => "slider.show",
                "name" => "Slider View",
                "group" => "Website"
            ],
            [   "slug" => "slider.edit",
                "name" => "Slider Edit",
                "group" => "Website"
            ]
        ];

        //merge all permissions and insert into db
        $permissions = array_merge($commonPermissionList, $administratorPermissionList, $onlyAdminPermissions, $academicPermissionList, $websitePermissionList);

        echo PHP_EOL , 'seeding permissions...';

        Permission::insert($permissions);


        echo PHP_EOL , 'seeding role permissions...';
        //now add admin role permissions
        $admin = Role::where('name', 'admin')->first();
        $permissions = Permission::get();
        $admin->permissions()->saveMany($permissions);

        //now add other roles common permissions
        $slugs = array_map(function ($permission){
            return $permission['slug'];
        }, $commonPermissionList);

        $permissions = Permission::whereIn('slug', $slugs)->get();

        $roles = Role::where('name', '!=', 'admin')->get();
        foreach ($roles as $role){
            echo PHP_EOL , 'seeding '.$role->name.' permissions...';
            $role->permissions()->saveMany($permissions);
        }



    }
}
