<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\DonationType;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=Admin::create([
            'name'              =>  'admin',
            'phone'             =>  '123456',
            'national_number'   =>  '123456',
            'password'          =>  Hash::make('123456'),
        ]);
        $types=[
            [
                'ar'=>[
                    'name'=>'تبرع عام',
                    'desc'=>'الصدقات تحمي من الفقر',
                ],
                'en'=>[
                    'name'=>'general donation',
                    'desc'=>'desc of it',
                ],
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ]
        ];
        $categories=[
            [
                'ar'=>[
                'name'=>'أول نوع',
                'desc'=>'وصف',
                ],
                'en'=>[
                    'name'=>'first cat',
                    'desc'=>'desc',
                ],
                'type_id'=>1,
                'img'   =>'none',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ]
        ];
        foreach ($types as $type)
            DonationType::create($type);
        foreach ($categories as $category)
            Category::create($category);
            Setting::create([
                'name'  =>  'فريق حياة الخيري',
                'vision_ar'  =>  'رؤية فريق حياة الخيري',
                'vision_en'  =>  'hayah team vision',
                'goals_ar'  =>  'أهداف فريق حياة الخيري',
                'goals_en'  =>  'hayah team goals',
            ]);
    }
}
