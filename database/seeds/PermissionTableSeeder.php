<?php

use Illuminate\Database\Seeder;
use App\Permission;
use Carbon\Carbon;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $now = Carbon::now('Asia/Dhaka')->toDateTimeString();

        $academicPermissionList = [
            [
                "slug" => "academic.class_destroy",
                "name" => "Class Delete",
                "group" => "Academic",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "slug" => "academic.class",
                "name" => "Class View",
                "group" => "Academic",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "slug" => "academic.class_store",
                "name" => "Class Create",
                "group" => "Academic",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "slug" => "academic.class_create",
                "name" => "Class Create",
                "group" => "Academic",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "slug" => "academic.class_edit",
                "name" => "Class Edit",
                "group" => "Academic",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "slug" => "academic.class_status",
                "name" => "Class Edit",
                "group" => "Academic",
                "created_at" => $now,
                "updated_at" => $now
            ],
            [
                "slug" => "academic.class_update",
                "name" => "Class Edit",
                "group" => "Academic",
                "created_at" => $now,
                "updated_at" => $now
            ],
//            [
//                "slug" => "academic.section_destroy",
//                "name" => " ",
//                "group" => "Academic"
//            ],
//            [
//                "slug" => "academic.section",
//                "name" => " ",
//                "group" => "Academic"
//            ],
//            [
//                "slug" => "academic.section_store",
//                "name" => " ",
//                "group" => "Academic"
//            ],
//            [
//                "slug" => "academic.section_create",
//                "name" => " ",
//                "group" => "Academic"
//            ],
//            [
//                "slug" => "academic.section_edit",
//                "name" => " ",
//                "group" => "Academic"
//            ],
//            [
//                "slug" => "academic.section_status",
//                "name" => " ",
//                "group" => "Academic"
//            ],
//            [
//                "slug" => "academic.section_update",
//                "name" => " ",
//                "group" => "Academic"
//            ]
        ];


//
//administrator.academic_year_destroy
//administrator.academic_year
//administrator.academic_year_store
//administrator.academic_year_create
//administrator.academic_year_edit
//administrator.academic_year_status
//administrator.academic_year_update
//administrator.user_index
//administrator.user_create
//administrator.user_status
//administrator.user_store
//administrator.user_update
//administrator.user_destroy
//administrator.user_edit
//change_password
//change_password
//class_profile.index
//class_profile.store
//class_profile.create
//class_profile.show
//class_profile.update
//class_profile.destroy
//class_profile.edit
//user.dashboard
//event.index
//event.store
//event.create
//event.destroy
//event.show
//event.update
//event.edit
//lockscreen
//logout
//profile
//profile
//user.role_index
//user.role_destroy
//user.role_create
//user.role_store
//setLocale
//settings.institute
//settings.institute
//site.about_content
//site.about_content
//site.about_content_image
//site.about_content_image
//site.about_content_image_delete
//site.analytics
//site.analytics
//site.contact_us
//site.contact_us
//site.dashboard
//site.faq_delete
//site.faq
//site.faq
//site.gallery
//site.gallery_image
//site.gallery_image
//site.gallery_image_delete
//site.service
//site.service
//site.settings
//site.settings
//site.statistic
//site.statistic
//site.subscribe
//site.testimonial
//site.testimonial
//site.testimonial_create
//site.testimonial_create
//site.timeline
//site.timeline
//site.timeline_delete
//slider.index
//slider.store
//slider.create
//slider.destroy
//slider.update
//slider.show
//slider.edit
//student.store
//student.index
//student.create
//student.status
//student.destroy
//student.update
//student.show
//student.edit
//teacher.index
//teacher.store
//teacher.create
//teacher.status
//teacher.destroy
//teacher.update
//teacher.show
//teacher.edit
//teacher_profile.index
//teacher_profile.store
//teacher_profile.create
//teacher_profile.update
//teacher_profile.show
//teacher_profile.destroy
//teacher_profile.edit
//user.store
//user.index
//user.create
//user.status
//user.show
//user.update
//user.destroy
//user.edit

        Permission::insert($academicPermissionList);



    }
}
