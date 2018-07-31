<?php

use Illuminate\Database\Seeder;

class GalleryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gallery')->insert([
        	'imgsrc' => "../gallery/gallery1.jpg",
        ]);
        DB::table('gallery')->insert([
        	'imgsrc' => "../gallery/gallery2.jpg",
        ]);
        DB::table('gallery')->insert([
        	'imgsrc' => "../gallery/gallery3.jpg",
        ]);
        DB::table('gallery')->insert([
        	'imgsrc' => "../gallery/gallery4.jpg",
        ]);
        DB::table('gallery')->insert([
        	'imgsrc' => "../gallery/gallery5.jpg",
        ]);
        DB::table('gallery')->insert([
        	'imgsrc' => "../gallery/gallery6.jpg",
        ]);
    }
}
