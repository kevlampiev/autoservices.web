<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceTypesSeeder extends Seeder
{

    private $stdTypes =[
        'шиномонтаж',
        'автосервис',
        'автомойка',
        'плановое ТО'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_types')->insert($this->getData());
        //
    }

    private function getData(): array
    {
        $result = [];
        $faker = Faker\Factory::create('ru_RU');
        for ($i = 0; $i < 4; $i++) {
                $result[] = [
                    'name' => $this->stdTypes[$i],
                    'slug' => Str::slug($this->stdTypes[$i]),
                    'description' => $faker->realText(rand(100, 300)),
                ];
            }
        return $result;
    }
}