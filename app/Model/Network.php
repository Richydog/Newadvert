<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
/**
 * @property int $user_id
 * @property string $network
 * @property string $identity
 */
class Network extends Model
{
    protected $table = 'user_networks';

    protected $fillable = ['network', 'identity'];

    public $timestamps = false;
}
