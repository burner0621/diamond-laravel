<?php

namespace Database\Seeders;

use App\Models\MaterialType;
use Illuminate\Database\Seeder;

class MaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaterialType::truncate();

        $arrMaterialTypes = array(
            array(
                'id'			=>	1,
                'material_id'   =>	1,
                'type'			=>	'Round',
                'created_at'	=>	'2021-11-20 17:20:49',
                'updated_at'	=>	'2021-11-20 17:20:49'
            ),
            array(
                'id'			=>	2,
                'material_id'   =>	1,
                'type'			=>	'Pear',
                'created_at'	=>	'2021-11-20 17:20:59',
                'updated_at'	=>	'2021-11-20 17:20:59'
            ),
            array(
                'id'			=>	3,
                'material_id'   =>	1,
                'type'			=>	'Emerald',
                'created_at'	=>	'2021-11-20 17:21:08',
                'updated_at'	=>	'2021-11-20 17:21:08'
            ),
            array(
                'id'			=>	4,
                'material_id'   =>	1,
                'type'			=>	'Heart',
                'created_at'	=>	'2021-11-20 17:21:12',
                'updated_at'	=>	'2021-11-20 17:21:12'
            ),
            array(
                'id'			=>	5,
                'material_id'   =>	1,
                'type'			=>	'Oval',
                'created_at'	=>	'2021-11-20 17:21:23',
                'updated_at'	=>	'2021-11-20 17:21:23'
            ),
            array(
                'id'			=>	6,
                'material_id'   =>	1,
                'type'			=>	'Princess',
                'created_at'	=>	'2021-11-20 17:21:29',
                'updated_at'	=>	'2021-11-20 17:21:29'
            ),
            array(
                'id'			=>	7,
                'material_id'   =>	1,
                'type'			=>	'Baguette',
                'created_at'	=>	'2021-11-20 17:21:46',
                'updated_at'	=>	'2021-11-20 17:21:46'
            ),
            array(
                'id'			=>	8,
                'material_id'   =>	1,
                'type'			=>	'Radiant',
                'created_at'	=>	'2021-11-20 17:22:04',
                'updated_at'	=>	'2021-11-20 17:22:04'
            ),
            array(
                'id'			=>	9,
                'material_id'   =>	1,
                'type'			=>	'Cushion',
                'created_at'	=>	'2021-11-20 17:22:22',
                'updated_at'	=>	'2021-11-20 17:22:22'
            ),
            array(
                'id'			=>	10,
                'material_id'   =>	1,
                'type'			=>	'Marquise',
                'created_at'	=>	'2021-11-20 17:23:41',
                'updated_at'	=>	'2021-11-20 17:23:41'
            ),
            array(
                'id'			=>	11,
                'material_id'   =>	2,
                'type'			=>	'10K Yellow Gold',
                'created_at'	=>	'2021-11-20 17:24:37',
                'updated_at'	=>	'2021-11-28 14:53:55'
            ),
            array(
                'id'			=>	12,
                'material_id'   =>	2,
                'type'			=>	'14K Yellow Gold',
                'created_at'	=>	'2021-11-20 17:24:46',
                'updated_at'	=>	'2021-11-28 14:54:05'
            ),
            array(
                'id'			=>	13,
                'material_id'   =>	2,
                'type'			=>	'18K Yellow Gold',
                'created_at'	=>	'2021-11-20 17:24:54',
                'updated_at'	=>	'2021-11-28 14:54:12'
            ),
            array(
                'id'			=>	14,
                'material_id'   =>	2,
                'type'			=>	'Silver 925',
                'created_at'	=>	'2021-11-20 17:25:07',
                'updated_at'	=>	'2021-11-20 17:25:07'
            )
        );

        foreach ($arrMaterialTypes as $material_type) {
            MaterialType::create($material_type);
        }
    }
}
