<?php

namespace Database\Seeders;

use App\Models\Step;
use Illuminate\Database\Seeder;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Step::truncate();

        $arrSteps = array(
            array(
                'id'			=>	1,
                'name'			=>	'Design',
                'description'	=>	'Purchase a 3D model or have a custom one created.',
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-10 22:18:33',
                'updated_at'	=>	'2022-04-14 00:46:53'
            ),
            array(
                'id'			=>	2,
                'name'			=>	'3D Printing',
                'description'	=>	'This process turns your 3d model into a wax model which will be used to make a mold for casting.',
                'link'			=>	'https://districtties.com/blog/what-is-a-cad-how-is-it-used-to-create-jewelry',
                'created_at'	=>	'2022-04-10 22:18:48',
                'updated_at'	=>	'2022-04-14 00:47:47'
            ),
            array(
                'id'			=>	3,
                'name'			=>	'Casting',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:41:39',
                'updated_at'	=>	'2022-04-12 20:41:39'
            ),
            array(
                'id'			=>	4,
                'name'			=>	'Sprues Removal',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:41:56',
                'updated_at'	=>	'2022-04-12 20:42:37'
            ),
            array(
                'id'			=>	5,
                'name'			=>	'Tumbling',
                'description'	=>	'Tumble finishing, also known as tumbling or rumbling, is a technique for smoothing and polishing a rough surface on relatively small parts.',
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:42:47',
                'updated_at'	=>	'2022-04-13 15:40:00'
            ),
            array(
                'id'			=>	6,
                'name'			=>	'Stone Setting',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:43:04',
                'updated_at'	=>	'2022-04-12 20:43:04'
            ),
            array(
                'id'			=>	7,
                'name'			=>	'Enamel',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:43:08',
                'updated_at'	=>	'2022-04-12 20:43:08'
            ),
            array(
                'id'			=>	8,
                'name'			=>	'Soldering',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:43:24',
                'updated_at'	=>	'2022-04-12 20:43:24'
            ),
            array(
                'id'			=>	9,
                'name'			=>	'Pre-Polishing',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:43:58',
                'updated_at'	=>	'2022-04-12 20:43:58'
            ),
            array(
                'id'			=>	10,
                'name'			=>	'Polishing',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:44:11',
                'updated_at'	=>	'2022-04-12 20:44:11'
            ),
            array(
                'id'			=>	11,
                'name'			=>	'Assembly',
                'description'	=>	NULL,
                'link'			=>	NULL,
                'created_at'	=>	'2022-04-12 20:44:20',
                'updated_at'	=>	'2022-04-12 20:44:20'
            )
        );

        foreach ($arrSteps as $step) {
            Step::create($step);
        }
    }
}
