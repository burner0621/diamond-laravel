<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Material::truncate();

        $arrMaterials = array(
            array(
                'id'			=>	1,
                'name'			=>	'Diamond',
                'created_at'	=>	'2021-11-20 17:09:29',
                'updated_at'	=>	'2021-11-20 17:09:29'
            ),
            array(
                'id'			=>	2,
                'name'			=>	'Metal',
                'created_at'	=>	'2021-11-20 17:11:01',
                'updated_at'	=>	'2021-11-20 17:11:01'
            )
        );
        
        foreach ($arrMaterials as $step) {
            Material::create($step);
        }
    }
}
