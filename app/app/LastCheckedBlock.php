<?php

namespace App;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LastCheckedBlock
 * @package App
 *
 * @property int $id
 * @property int $block_number
 * @property string $currency
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 */
class LastCheckedBlock extends Model
{
    protected $table = 'last_checked_block';
}
