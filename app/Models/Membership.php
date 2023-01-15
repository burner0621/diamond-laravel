<?php

namespace App\Models;

use App\Models\Traits\FormatPrices;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use FormatPrices;

    protected $fillable = [
        'name', 'slug', 'price', 'price_monthly', 'included_downloads',
        'included_downloads_monthly', 'unlimited_downloads', 'thumbnail'
    ];

    public function setPricesToFloat()
    {
        $this->price = number_format($this->price / 100, 2);
        $this->price_monthly = number_format($this->price_monthly / 100, 2);
        return $this;
    }

    public function uploads()
    {
        return $this->belongsTo(Upload::class, 'thumbnail' , 'id')->withDefault([
            'file_name' => "none.png",
            'id' => null
        ]);
    }
}
