<?php

namespace App\Console\Commands;

use App\LastCheckedBlock;
use App\Models\CryptoClients\Ethereum\Client;
use App\Models\CryptoClients\Ethereum\RPCException;
use App\Wallet;
use App\WalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Mockery\Exception;

class CheckForNewTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check-for-new-transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check new ETH transactions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('CRON-START: Check new ETH transaction');
        $this->checkNewTransactions();
    }

    private function checkNewTransactions()
    {
        try {
            $apiKey = env('ETHERSCAN_APIKEY');
            $ethClient = new Client(env('GETH_URL'), env('GETH_PORT'));

            /** @var LastCheckedBlock $lastCheckedBlock */
            $lastCheckedBlock = LastCheckedBlock::where('currency', '=', 'ETH')->first();
            $lastCheckedBlockNumber = $lastCheckedBlock->block_number;

            $currentBlockNumber = $ethClient->decodeHex($ethClient->getBlockNumberEtherScanIO($apiKey));

            /** @var Wallet[] $wallets */
            $wallets = Wallet::all();

            DB::beginTransaction();
            foreach ($wallets as $wallet) {
                $newTransactions = $ethClient->getAddressTransactionsEtherScanIO($wallet->address, $apiKey, $lastCheckedBlockNumber, $currentBlockNumber);
                if (!is_null($newTransactions)) {
                    foreach ($newTransactions as $newTransaction) {
                        $to_wallet = $newTransaction->to;
                        $confirmations = $newTransaction->confirmations;
                        $amount = $ethClient->wei2Eth(intval($newTransaction->value));
                        $txid = $newTransaction->hash;
                        if ($wallet->address === $to_wallet) {
                            $walletTransaction = new WalletTransaction();
                            $walletTransaction->wallet_id = $wallet->id;
                            $walletTransaction->amount = $amount;
                            $walletTransaction->txid = $txid;
                            $walletTransaction->confirmations = $confirmations;
                            $walletTransaction->save();
                        }
                    }
                }
            }

            $lastCheckedBlock->block_number = $currentBlockNumber;
            $lastCheckedBlock->save();

            DB::commit();
        } catch (RPCException $e) {
            DB::rollBack();
            $this->error('Error on ETH client');
            $this->error($e->getMessage());
        } catch (Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }
    }
}
