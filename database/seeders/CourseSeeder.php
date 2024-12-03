<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Campus;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $campus = Campus::create([
            'name'=>"ACCESS Campus",
            'latitude' => '6.669480793037186',
            'longitude' => '124.6296690088505',
            'radius' => '20',
    ]);

    $campus->courses()->create([
        'course_code' => 'BEED',
        'course_description'=>"Bachelor in Elementary Education"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-FIL',
        'course_description'=>"Bachelor in Secondary Education major in: Filipino"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-SCI',
        'course_description'=>"Bachelor in Secondary Education major in: Science"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-MTH',
        'course_description'=>"Bachelor in Secondary Education major in: Mathematics"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-SCS',
        'course_description'=>"Bachelor in Secondary Education major in: Social Studies"
    ]);
    $campus->courses()->create([
        'course_code' => 'BPHY-EDU',
        'course_description'=>"Bachelor in Physical Education"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-AGR',
        'course_description'=>"Bachelor of Science in Agriculture"
    ]);
        $campus = Campus::create([
            'name'=>"Isulan Campus",
            'latitude' => '6.637987312498821',
            'longitude' => '124.61010932768903',
            'radius' => '20',
        ]);

        $campus->courses()->create([
            'course_code' => 'BSECE',
            'course_description'=>"Bachelor of Science in Electronics and Communication Engineering"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSCE',
            'course_description'=>"Bachelor of Science in Computer Engineering"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSCS',
            'course_description'=>"Bachelor of Science in Computer Science"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIT',
            'course_description'=>"Bachelor of Science in Information Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIS',
            'course_description'=>"Bachelor of Science in Information System"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIT-DT',
            'course_description'=>"Bachelor of Science in Industrial Technology major in: Drafting Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIT-FT',
            'course_description'=>"Bachelor of Science in Industrial Technology major in: Food Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIT-AT',
            'course_description'=>"Bachelor of Science in Industrial Technology major in: Automotive Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIT-ET',
            'course_description'=>"Bachelor of Science in Industrial Technology major in: Electrical Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIT-ECT',
            'course_description'=>"Bachelor of Science in Industrial Technology major in: Electronics Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSIT-CT',
            'course_description'=>"Bachelor of Science in Industrial Technology major in: Civil Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BTVT-DT',
            'course_description'=>"Bachelor in Technical-Vocational Teacher Education major in: Drafting Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BTVT-FT',
            'course_description'=>"Bachelor in Technical-Vocational Teacher Education major in: Food Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BTVT-AT',
            'course_description'=>"Bachelor in Technical Teacher Education major in: Automotive Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BTVT-ET',
            'course_description'=>"Bachelor in Technical-Vocational Teacher Education major in: Electrical Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BTVT-ECT',
            'course_description'=>"Bachelor in Technical-Vocational Teacher Education major in: Electronics Technology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BTVT-CT',
            'course_description'=>"Bachelor in Technical-Vocational Teacher Education major in: Civil Technology"
        ]);

        $campus = Campus::create([
            'name'=>"Tacurong Campus",
            'latitude' => '6.694205747537995',
            'longitude' => '124.67848440112223',
            'radius' => '20',

        ]);
        $campus->courses()->create([
            'course_code' => 'BS-BIO',
            'course_description'=>"Bachelor of Science in Biology"
        ]);
        $campus->courses()->create([
            'course_code' => 'BA-E',
            'course_description'=>"Bachelor of Arts in Economics"
        ]);
        $campus->courses()->create([
            'course_code' => 'BA-PS',
            'course_description'=>"Bachelor of Arts in Political Science"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSHM',
            'course_description'=>"Bachelor of Science in Hospitality Management"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSE',
            'course_description'=>"Bachelor of Science in Entrepreneurship"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSA',
            'course_description'=>"Bachelor of Science in Accountancy"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSAT',
            'course_description'=>"Bachelor of Science in Accounting Information System"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSTM',
            'course_description'=>"Bachelor of Science in Tourism Management"
        ]);
        $campus->courses()->create([
            'course_code' => 'BSMA',
            'course_description'=>"Bachelor of Science in Management Accounting"
        ]);

    $campus = Campus::create([
        "name" => "Kalamansig Campus",
        'latitude' => '6.584881078337836',
        'longitude' => '124.04725369695205',
        'radius' => '20',
    ]);

    $campus->courses()->create([
        'course_code' => 'BSF',
        "course_description" => "Bachelor of Science in Fisheries"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-ENG-KAL',
        "course_description" => "Bachelor in Secondary Education major in: English"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-FIL-KAL',
        "course_description" => "Bachelor in Secondary Education major in: Filipino"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSED-SCI-KAL',
        "course_description" => "Bachelor in Secondary Education major in: Science"
    ]);
    $campus->courses()->create([
        'course_code' => 'BEED-KAL',
        "course_description" => "Bachelor in Elementary Education"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSIT-KAL',
        "course_description" => "Bachelor of Science in Information Technology"
    ]);
    $campus->courses()->create([
        'course_code' => 'BS-BIO-KAL',
        "course_description" => "Bachelor of Science in Biology"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSCJS-KAL',
        "course_description" => "Bachelor of Science in Criminal Justice System"
    ]);

    
    $campus = Campus::create([
        "name" => "Bagumbayan Campus",
        'latitude' => '6.531284096017933',
        'longitude' => '124.55112759535668',
        'radius' => '20',
    ]);
    $campus->courses()->create([
        'course_code' => 'BSAG-BUS',
        "course_description" => "Bachelor of Science in Agribusiness"
    ]);
    $campus->courses()->create([
        'course_code' => 'BTVT-CT-BAG',
        "course_description" => "Bachelor in Technology and Livelihood Education major in Agri-fishery"
    ]);


    $campus = Campus::create([
        "name" => "Palimbang Campus",
        'latitude' => '6.228625367275648',
        'longitude' => '124.19243139397024',
        'radius' => '20',
    ]);
    $campus->courses()->create([
        'course_code' => 'BEED-PAL',
        "course_description" => "Bachelor in Elementary Education"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSAGR-BUS-PAL',
        "course_description" => "Bachelor of Science in Agribusiness"
    ]);


    $campus = Campus::create([
        "name" => "Lutayan Campus",
        'latitude' => '6.57142659381559',
        'longitude' => '124.87655701070048',
        'radius' => '20',
    ]);
    $campus->courses()->create([
        'course_code' => 'BEED-LUT',
        "course_description" => " Bachelor in Elementary Education"
    ]);
    $campus->courses()->create([
        'course_code' => 'BSAGR-LUT',
        "course_description" => "Bachelor of Science in Agriculture"
    ]);
    }
}
