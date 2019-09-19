<?php

namespace App;

use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WalletTransaction
 * @package App
 *
 * @property int $id
 * @property int $wallet_id
 * @property float $amount
 * @property string $txid
 * @property int $confirmations
 * @property DateTime $created_at
 * @property DateTime $updated_at
 *
 */
class WalletTransaction extends Model
{
    protected $table = 'wallets_transactions';

    public function wallet(){
        return $this->belongsTo(Wallet::class);
    }
}
