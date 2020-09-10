<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Brand;
class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('brand')->insert([
        //     'brand_name' => str::random(10),
        //     'brand_url' => str::random(10).'@gmail.com',
        //     'brand_logo' => "http://uploads.laravel01.com/upload/jO4RTgp1IUEXMkfj5CwKWxlWCljertVDjhRO8nwJ.jpeg",
        //     'brand_desc' => str::random(10),
        //     'created_at' => date('Y-m-d H:i:s',time()),
        //     'updated_at' => date('Y-m-d H:i:s',time())
        // ]);

        factory(App\Models\Brand::class, 50)->create()->make();
    
    }
}
