<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\CategoryOption;
use App\Models\DonationType;
use App\Models\Portfolio;
use App\Models\Setting;
use App\Models\WebsiteSlider;
use DirectoryIterator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\Concerns\Has;
use Nette\Utils\Random;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $directories = Storage::disk('local')->directories('setup_img');
        $directories = array_diff($directories, ['.', '..']);
        foreach ($directories as $index=>$dir) {
            $pasthItem = str_replace("\\",'/',storage_path('app/' . $dir));
            File::copyDirectory($pasthItem, public_path('/images/'.substr($directories[$index],strpos($directories[$index],'/'),strlen($directories[$index]))));
        }

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
                'img'       =>'images/donations-types/1.png',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                    'name'=>'عقيقة',
                    'desc'=>'العقيقة تبارك في عمر الابناء',
                ],
                'en'=>[
                    'name'=>'aqeqa',
                    'desc'=>'aqeqa good for childes',
                ],
                'img'       =>'images/donations-types/2.png',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                    'name'=>'التعليم',
                    'desc'=>'ساعد لتعليم جميع أطفال العالم',
                ],
                'en'=>[
                    'name'=>'education',
                    'desc'=>'help to educate every child',
                ],
                'img'       =>'images/donations-types/3.png',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                    'name'=>'الزبائح',
                    'desc'=>'الزبائح تكفر السيئات',
                ],
                'en'=>[
                    'name'=>'zabeha',
                    'desc'=>'zabeha desc',
                ],
                'img'       =>'images/donations-types/4.png',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                    'name'=>'كفارات',
                    'desc'=>'كفر عن ذنوبك',
                ],
                'en'=>[
                    'name'=>'kafarat',
                    'desc'=>'kafarat desc',
                ],
                'img'       =>'images/donations-types/5.jpeg',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
        ];
        $categories=[
            [
                'ar'=>[
                'name'=>'إفطار صائم',
                'desc'=>'لك مثل أجر الصائم',
                ],
                'en'=>[
                    'name'=>'eftar',
                    'desc'=>'desc eftar',
                ],
                'type_id'=>1,
                'img'       =>'images/categories/1.1.jpg',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                'name'=>'تصدق بالمال',
                'desc'=>'وصف للصدقة',
                ],
                'en'=>[
                    'name'=>'tasadk',
                    'desc'=>'money tasdk',
                ],
                'type_id'=>1,
                'img'       =>'images/categories/1.2.jpg',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                'name'=>'عقيقة ولد',
                'desc'=>'وصف للعقيقة ولد',
                ],
                'en'=>[
                    'name'=>'aqeqa boy',
                    'desc'=>'desc aqeqa',
                ],
                'type_id'=>2,
                'img'       =>'images/categories/2.1.png',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                'name'=>'عقيقة بنت',
                'desc'=>'وصف للعقيقة',
                ],
                'en'=>[
                    'name'=>'aqeqa girl',
                    'desc'=>'desc aqeqa girl',
                ],
                'type_id'=>2,
                'img'       =>'images/categories/2.2.png',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                'name'=>'تعليم الولد',
                'desc'=>'وصف للتعليم ولد',
                ],
                'en'=>[
                    'name'=>'education boy',
                    'desc'=>'desc education',
                ],
                'type_id'=>3,
                'img'       =>'images/categories/3.1.jpg',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                'name'=>'تعليم البنت',
                'desc'=>'وصف للتعليم',
                ],
                'en'=>[
                    'name'=>'education girl',
                    'desc'=>'desc education girl',
                ],
                'type_id'=>3,
                'img'       =>'images/categories/3.2.jpg',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                'name'=>'ذبائح خروف',
                'desc'=>'وصف للذبائح الخروف',
                ],
                'en'=>[
                    'name'=>'zabehaa 1',
                    'desc'=>'desc zabehaa',
                ],
                'type_id'=>4,
                'img'       =>'images/categories/4.1.jpg',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
            [
                'ar'=>[
                'name'=>'ذبائح الوليمة',
                'desc'=>'وصف للذبيحة الوليمة',
                ],
                'en'=>[
                    'name'=>'zabehaa walema',
                    'desc'=>'desc zabehaa walema',
                ],
                'type_id'=>4,
                'img'       =>'images/categories/4.2.jpg',
                'status'    =>'enabled',
                'admin_id'  =>$admin->id,
            ],
        ];
        foreach ($types as $type)
            DonationType::create($type);
        foreach ($categories as $category)
            Category::create($category);
        foreach ($categories as $index=>$category) {
            CategoryOption::create([
                'ar' => [
                    'name' => "خيار مادي  $index ",
                ],
                'en' => [
                    'name' => "option physical $index",
                ],
                'category_id'   => $index+1,
                'type'          => 'physical',
                'default_value' => 1,
                'accept_any_value' => 1,
                'admin_id' => $admin->id
            ]);
            CategoryOption::create([
                'ar' => [
                    'name' => "خيار مالي  $index ",
                ],
                'en' => [
                    'name' => "option financial $index",
                ],
                'category_id'   => $index+1,
                'type'          => 'financial',
                'default_value' => rand(0, 1000),
                'accept_any_value' => true,
                'admin_id' => $admin->id
            ]);
        }
        for($i=1;$i<7;$i++){
            WebsiteSlider::create([
                'img'=>"images\website-slider\\$i.jpg"
            ]);
            Portfolio::create([
                'ar'        =>[
                    'name'      =>"سابقة أعمال $i ",
                    'desc'      =>"وصف سابقة أعمال $i ",
                ],

                'en'        =>[
                    'name'      =>"portfolio $i",
                    'desc'      =>"desc portfolio $i",
                ],
                'img'=>"images\portfolio\\$i.jpg"
            ]);
        }
        Setting::create([
            'name'  =>  'فريق حياة الخيري',
            'ar'        =>[
                'about'     =>'عن فريق حياة الخيري',
                'vision'    =>'رؤية فريق حياة الخيري',
                'goals'     =>'أهداف فريق حياة الخيري',
            ],

            'en'        =>[
                'about'         =>"about hayah team",
                'vision'        =>"hayah team vision",
                'goals'         =>"hayah team goals",
            ],

        ]);
    }
}
