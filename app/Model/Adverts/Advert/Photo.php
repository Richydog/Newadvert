<?php


namespace App\Model\Adverts\Advert;

use Illuminate\Database\Eloquent\Model;
class Photo
{
    protected $table = 'advert_advert_photos';

    public $timestamps = false;

    protected $fillable = ['file'];
}