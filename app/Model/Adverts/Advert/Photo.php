<?php


namespace App\Model\Adverts\Advert;

use Illuminate\Database\Eloquent\Model;
class Photo extends Model
{
    protected $table = 'advert_advert_photos';

    public $timestamps = false;

    protected $fillable = ['file'];
}
