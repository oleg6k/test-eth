<?php

namespace App;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 * @package App
 *
 * @property int $id
 * @property string $address
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 */
class Wallet extends Model
{
    protected $table = 'wallets';
}
