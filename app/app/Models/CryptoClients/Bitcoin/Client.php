<?php

namespace App\Models\CryptoClients\Bitcoin;

use App\Models\CryptoClients\CryptoCurrencyClientInterface;

/**
 * Class Client
 * @package App\Models\CryptoClients\Bitcoin
 */
class Client implements CryptoCurrencyClientInterface
{

    /**
     * @param string $address
     * @return integer|float
     */
    public function getAccountBalance(string $address)
    {
        // TODO: Implement getAccountBalance() method.
    }

    /**
     * @param string $address
     * @param array $lastTxId
     * @param string|null $passPhrase
     * @return array
     */
    public function getNewTransactions(string $address, array $lastTxId, string $passPhrase = null)
    {
        // TODO: Implement getNewTransactions() method.
    }

    /**
     * @param string $txid
     * @return mixed $transactionInfo
     */
    public function getTransactionInfo(string $txid)
    {
        // TODO: Implement getTransactionInfo() method.
    }

    /**
     * @return mixed
     */
    public function getWalletBlockNumber()
    {
        // TODO: Implement getWalletBlockNumber() method.
    }
}

