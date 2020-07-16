<?php

use Illuminate\Database\Seeder;
use App\SiteMeta;
use App\Testimonial;
use App\AboutContent;
use App\AboutSlider;
use App\Slider;
use App\ClassProfile;
use App\TeacherProfile;
use App\Event;
use Carbon\Carbon;

class DemoSiteDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //truncate previous data
        echo PHP_EOL, 'deleting old data.....';
        $this->deletePreviousData();

        //seed common settings
        echo PHP_EOL , 'seeding settings...';
        $this->settingsData();

        //time line data
        echo PHP_EOL , 'seeding timeline...';
        $this->timelineData();

        //faq
        echo PHP_EOL , 'seeding faq...';
        $this->faqs();

        //contact details
        echo PHP_EOL , 'seeding contact info...';
        $this->contactData();

        //gallery data
        echo PHP_EOL , 'seeding gallery images...';
        $this->galleryData();

        // testimonial
        echo PHP_EOL , 'seeding gallery testimonials...';
        $this->testimonialData();

        //statistic data
        echo PHP_EOL , 'seeding statistic...';
        $this->statisticData();

        //service data
        echo PHP_EOL , 'seeding service...';
        $this->serviceTextData();

        //about us data
        echo PHP_EOL , 'seeding about us...';
        $this->aboutSectionData();

        // slider data
        echo PHP_EOL , 'seeding sliders...';
        $this->sliderData();

        // class profile
        echo PHP_EOL , 'seeding class...';
        $this->classProfileData();


        // teacher profile
        echo PHP_EOL , 'seeding teachers...';
        $this->teacherProfileData();

        // events
        echo PHP_EOL , 'seeding events...';
        $this->eventData();


        echo PHP_EOL , 'seeding completed.', PHP_EOL;

    }


    private function deletePreviousData(){
        /***
         * This code is MYSQL specific
         */
        DB::statement("SET foreign_key_checks=0");
        SiteMeta::truncate();
        Testimonial::truncate();
        AboutContent::truncate();
        AboutSlider::truncate();
        Slider::truncate();
        ClassProfile::truncate();
        TeacherProfile::truncate();
        Event::truncate();
        DB::statement("SET foreign_key_checks=1");

        //delete images
        $storagePath = storage_path('app/public');
        $dirs = [
            $storagePath.'/sliders',
            $storagePath.'/about',
            $storagePath.'/class',
            $storagePath.'/teacher',
            $storagePath.'/gallery',
            $storagePath.'/events',
            $storagePath.'/site',
        ];

        foreach ($dirs as $dir){
            system("rm -rf ".escapeshellarg($dir));
        }
    }


    private function settingsData()
    {
        $originFilePath = resource_path('assets/frontend/demo/site/');
        $destinationPath = storage_path('app').'/public/site/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileName = 'logo.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['logo'] = $fileName;

        $fileName = 'logo@2x.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['logo2x'] = $fileName;

        $fileName = 'favicon.png';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['favicon'] = $fileName;

        $data['name'] = 'Cloud School';
        $data['short_name'] = 'CloudSchool';
        $data['facebook'] = '#';
        $data['instagram'] = '#';
        $data['twitter'] = '#';
        $data['youtube'] = '#';

        //now crate
        SiteMeta::updateOrCreate(
            ['meta_key' => 'settings'],
            ['meta_value' => json_encode($data)]
        );
    }
    private function timelineData()
    {

        $data = [
            't' => 'We Start Here',
            'd' => 'Lorem ipsum',
            'y' => '2006'
        ];

        $data2 = [
            't' => 'Top Score',
            'd' => 'We achive top result score in the state',
            'y' => '2010'
        ];
        //now crate
        SiteMeta::create(
            [
                'meta_key' => 'timeline',
                'meta_value' => json_encode($data)
            ]
        );
        SiteMeta::create(
            [
                'meta_key' => 'timeline',
                'meta_value' => json_encode($data2)
            ]
        );
    }
    private function faqs()
    {
        $data = [
            'q' => 'How to apply for adminission?',
            'a' => 'Just e-mail us, or contact on hot line.'
        ];
        //now crate
        SiteMeta::create(
            [
                'meta_key' => 'faq',
                'meta_value' => json_encode($data)
            ]
        );
    }
    private function contactData()
    {
        //now crate or update model
        SiteMeta::updateOrCreate(
            ['meta_key' => 'contact_address'],
            [ 'meta_value' => 'Dhaka-1207']
        );
        SiteMeta::updateOrCreate(
            ['meta_key' => 'contact_phone'],
            [ 'meta_value' => '+880258685']
        );
        SiteMeta::updateOrCreate(
            ['meta_key' => 'contact_email'],
            [ 'meta_value' => 'contact@cloudschoolbd.com']
        );
        SiteMeta::updateOrCreate(
            ['meta_key' => 'contact_latlong'],
            [ 'meta_value' => '23.7340076,90.3841824']
        );
    }
    private function galleryData()
    {

        //now crate
        SiteMeta::create(
            [
                'meta_key' => 'gallery',
                'meta_value' => '1.jpg'
            ]
        );
        $originFilePath = resource_path('assets/frontend/demo/gallery/');
        $destinationPath = storage_path('app').'/public/gallery/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileName = '1.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        SiteMeta::create(
            [
                'meta_key' => 'gallery',
                'meta_value' => '2.jpg'
            ]
        );

        $fileName = '2.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        SiteMeta::create(
            [
                'meta_key' => 'gallery',
                'meta_value' => '3.jpg'
            ]
        );

        $fileName = '3.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
    }
    private function testimonialData()
    {
        $data = [
            'writer' => 'Shadhin',
            'comments' => 'Awesome Academy',
            'avatar'    => null,
            'order'     => 1,
        ];

        Testimonial::create($data);

        $data = [
            'writer' => 'HRS',
            'comments' => 'Great school',
            'avatar'    => null,
            'order'     => 2,
        ];

        Testimonial::create($data);
    }
    private function statisticData()
    {
        $values = '4000,150,18000,9800';
        //now crate or update model
        SiteMeta::updateOrCreate(
            ['meta_key' => 'statistic'],
            ['meta_value' => $values]
        );
    }
    private function serviceTextData()
    {
        SiteMeta::updateOrCreate(
            ['meta_key' => 'our_service_text'],
            ['meta_value' => 'Lorem ipsum']
        );
    }
    private function aboutSectionData()
    {

        $data = [
            'why_content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy.',
            'key_point_1_title' => 'Key point 1',
            'key_point_1_content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock',
            'key_point_2_title' => 'Key point 2',
            'key_point_2_content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock',
            'about_us' => 'it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
            'who_we_are' => 'it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution',
            'intro_video_embed_code' => '<iframe src="https://www.youtube.com/embed/6sa1G_9jCb0" frameborder="0"  allowfullscreen></iframe>',
            'video_site_link' => 'https://www.youtube.com',

        ];

        //now crate or update model
        AboutContent::updateOrCreate(
            ['id' => 1],
           $data
        );

        $data = [];

        $originFilePath = resource_path('assets/frontend/demo/about/');
        $destinationPath = storage_path('app').'/public/about/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileName = '1.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);

        $data['image'] = $fileName;
        $data['order'] = 1;
        AboutSlider::create($data);

        $fileName = '2.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);

        $data['image'] = $fileName;
        $data['order'] = 2;
        AboutSlider::create($data);
    }

    private function sliderData()
    {


        $data = [
            'title' => 'First slider image',
            'subtitle' => 'This is subtitle 1',
            'order' => 1
        ];

        $originFilePath = resource_path('assets/frontend/demo/slider/');
        $destinationPath = storage_path('app').'/public/sliders/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileName = '1.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['image'] = $fileName;

        Slider::create($data);

        $data = [
            'title' => 'Second slider image',
            'subtitle' => 'This is subtitle 2',
            'order' => 2
        ];

        $fileName = '2.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['image'] = $fileName;

        Slider::create($data);

    }

    private function classProfileData()
    {

        $originFilePath = resource_path('assets/frontend/demo/class/');
        $destinationPath = storage_path('app').'/public/class_profile/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $fileNameSm = '1-sm.jpg';
        $fileNameLg = '1-lg.jpg';
        copy($originFilePath.$fileNameSm, $destinationPath.$fileNameSm);
        copy($originFilePath.$fileNameLg, $destinationPath.$fileNameLg);

        $data = [
            'name' => 'Class Three',
            'image_sm' => '',
            'image_lg' => '',
            'teacher' => 'MC Smith',
            'room_no' => 'R301-R302',
            'capacity' => 60,
            'shift' => 'Morning',
            'short_description' => 'Lorem ipsum text'
        ];
        $data['slug'] = strtolower(str_replace(' ','-', $data['name']));
        $data['image_sm'] = $fileNameSm;
        $data['image_lg'] = $fileNameLg;
        ClassProfile::create($data);

        $fileNameSm = '2-sm.jpg';
        $fileNameLg = '2-lg.jpg';
        copy($originFilePath.$fileNameSm, $destinationPath.$fileNameSm);
        copy($originFilePath.$fileNameLg, $destinationPath.$fileNameLg);

        $data = [
            'name' => 'Class Four',
            'image_sm' => '',
            'image_lg' => '',
            'teacher' => 'Jhon Doe',
            'room_no' => 'R401-R402',
            'capacity' => 70,
            'shift' => 'Morning',
            'short_description' => 'Lorem ipsum text'
        ];
        $data['slug'] = strtolower(str_replace(' ','-', $data['name']));
        $data['image_sm'] = $fileNameSm;
        $data['image_lg'] = $fileNameLg;
        ClassProfile::create($data);
    }

    private function teacherProfileData()
    {

        $originFilePath = resource_path('assets/frontend/demo/teacher/');
        $destinationPath = storage_path('app').'/public/teacher_profile/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $data = [
            'name' => 'Fakir Chand',
            'image' => '',
            'designation' => 'Headmaster',
            'qualification' => 'M.A in English',
            'description' => 'Super cool boy!',
            'facebook' => '#',
            'instagram' => '#',
            'twitter' => '#',
        ];

        $fileName = '1.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['image'] = $fileName;
        TeacherProfile::create($data);

        $data = [
            'name' => 'Nosimon Beagum',
            'image' => '',
            'designation' => 'Class Teacher',
            'qualification' => 'Hons in English',
            'description' => '',
            'facebook' => '#',
            'instagram' => '#',
            'twitter' => '#',
        ];

        $fileName = '2.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['image'] = $fileName;
        TeacherProfile::create($data);
    }

    private function eventData()
    {
        $originFilePath = resource_path('assets/frontend/demo/events/');
        $destinationPath = storage_path('app').'/public/events/';

        if(!is_dir($destinationPath)) {
            mkdir($destinationPath);
        }

        $data = [
            'title' => 'Annual function '.date('Y'),
            'event_time' =>  Carbon::createFromFormat('d/m/Y h:i a', '20/12/'.date('Y').' 03:00 pm'),
            'cover_photo' => '',
            'slider_1' => '',
            'slider_2' => '',
            'slider_3' => '',
            'description' => 'it is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution',
            'tags' => 'annual,function',
            'cover_video' => ''
        ];


        $data['slug'] = strtolower(str_replace(' ','-', $data['title']));


        $fileName = '1.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['cover_photo'] = $fileName;

        $fileName = '11.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['slider_1'] = $fileName;

        $fileName = '22.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['slider_2'] = $fileName;

        $fileName = '33.jpg';
        copy($originFilePath.$fileName, $destinationPath.$fileName);
        $data['slider_3'] = $fileName;

        Event::create($data);


        $data['title'] = 'Farewell Party';
        $data['event_time'] = Carbon::now()->addDays(15);
        $data['cover_photo'] = null;
        $data['tags'] = 'farewell,party';
        $data['cover_video'] = '<iframe src="https://www.youtube.com/embed/pXfqbimmBhE" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        $data['description'] = "<p><b>Details:</b><br><ul><li><p>What restrooms are available prior to gates opening?</p><div>Angel Stadium restrooms are available prior to the gates opening; they are located in the parking lot near the Orangewood entrance.</div></li><li><div>Can I bring food or drinks into the stadium?</div><div>You can bring one unopened bottle of water per person into the stadium. No other food or drinks are permitted.</div></li><li><div>Will food be available for sale inside the stadium?</div><div>Yes. Concession stands will be open until Greg Laurie speaks. Alcohol will not be available.</div></li><li><div>Can I reserve or save seats?</div><div>No. Seating is first-come, first-served.</div></li></ul><br></p>";
        $data['slug'] = strtolower(str_replace(' ','-', $data['title']));

        Event::create($data);



    }
}
