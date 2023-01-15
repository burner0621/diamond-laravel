<?php

namespace Database\Seeders;

use App\Models\SellerPaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SellerPaymentMethod::truncate();

        $arrPayments = array(
            array(
                'name' => 'Paypal',
                'question_1' => 'What is your paypal email?',
            ),
            array(
                'name' => 'Bitcoin',
                'question_1' => 'What your BTC address?',
            ),
            array(
                'name' => 'Check',
                'question_1' => 'Name on Check? Address to send check to?',
            ),
        );

        foreach ($arrPayments as $step) {
            SellerPaymentMethod::create($step);
        }
    }
}