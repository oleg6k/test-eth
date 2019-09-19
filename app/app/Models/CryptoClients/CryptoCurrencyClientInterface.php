<?php

namespace App\Models\CryptoClients;

/**
 * Interface CryptoCurrencyClientInterface
 */
interface CryptoCurrencyClientInterface
{
        /**
     * @param string $address
     * @return integer|float
     */
    public function getAccountBalance(string $address);

    /**
     * @param string $address
     * @param array $lastTxId
     * @param string|null $passPhrase
     * @return array
     */
    public function getNewTransactions(string $address, array $lastTxId, string $passPhrase = null);

    /**
     * @param string $txid
     * @return mixed $transactionInfo
     */
    public function getTransactionInfo(string $txid);

    /**
     * @return mixed
     */
    public function getWalletBlockNumber();
}
