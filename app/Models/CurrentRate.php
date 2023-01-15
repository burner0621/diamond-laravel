<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CurrentRate extends Model
{
    protected $table = 'current_rate';

    protected $fillable = [
        'base', 'USD', 'unit', 'XAG', 'XAU',
        'XPT', '24k', '22k', '18k', '14k',
        '10k', 'silver_gram', 'platinum_gram'
    ];

    public static function getLastRate() {
        if (self::count() == 0) {
            return null;
        }

        return CurrentRate::orderByDesc('created_at')
            ->take(1)->get()[0];
    }

    public static function getCurrentRate() {
        try {
            $exist = CurrentRate::whereDate('created_at', Carbon::today())->first();
            if (empty($exist)) {

                $access_key = '6x1839egsq5inwz1ig1vqq8zgrniqs28wr85l3ngin89g3e7gw1rqydxmdri';
                $url = 'https://www.metals-api.com/api/latest?access_key='
                    . $access_key . '&base=USD&symbols=XAG%2CXPT%2CXAU';
                $data = Http::get($url);
                
                $xau = 1 / (float)$data['rates']['XAU'];
                $xag = 1 / (float)$data['rates']['XAG'];
                $xpt = 1 / (float)$data['rates']['XPT'];
                $k24 = $xau / 31.1034768;
                $create = [
                    'base'=>$data['base'],
                    'USD'=>$data['rates']['USD'],
                    'XAG'=>$xag,
                    'XAU'=>$xau,
                    'XPT'=>$xpt,
                    '24k'=>$k24,
                    '22k'=>($k24 * 91.70)/100,
                    '18k'=> ($k24 * 75)/100,
                    '14k'=> ($k24 * 58.3)/100,
                    '10k'=> ($k24 * 41.7)/100,
                    'silver_gram'=>($xag / 31.1034768),
                    'platinum_gram'=>($xpt / 31.1034768),
                    'unit'=>'Troy Ounce'
                ];
                CurrentRate::create($create);
            } else {
                echo 'Already stored today data';
            }
        } catch (\Throwable $th) {
            dump($th);
        }
    }
}
