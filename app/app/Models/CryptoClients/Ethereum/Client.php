<?php

namespace App\Models\CryptoClients\Ethereum;

use App\Models\CryptoClients\CryptoCurrencyClientInterface;
use Illuminate\Support\Facades\Log;

/**
 * Class Client
 * @package App\Models\CryptoClients\Ethereum
 */
class Client implements CryptoCurrencyClientInterface
{
    /** @var string */
    protected $host;
    /** @var string */
    protected $port;
    /** @var string */
    protected $version;
    /** @var integer */
    protected $id = 0;

    /**
     * @param string $host
     * @param string $port
     * @param string $version
     */
    public function __construct(
        string $host,
        string $port,
        string $version = "2.0"
    )
    {
        $this->host = $host;
        $this->port = $port;
        $this->version = $version;

    }

    /**
     * @param string $account
     * @return string
     * @throws RPCException
     */
    public function createNewAccount(string $account): string
    {
        return $this->request('personal_newAccount', [md5($account)]);
    }

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws RPCException
     */
    private function request(string $method, array $params = [])
    {
        $data = [];
        $data['jsonrpc'] = $this->version;
        $data['id'] = $this->id++;
        $data['method'] = $method;
        $data['params'] = $params;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->host);
        curl_setopt($ch, CURLOPT_PORT, $this->port);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        Log::info("Data to method $method: " . json_encode($data));

        $ret = curl_exec($ch);
        if ($ret === false) {
            Log::error("Server did not respond");
            throw new RPCException("Server did not respond");
        }
        $formatted = json_decode($ret);
        if (isset($formatted->error)) {
            Log::error("Method: $method. " . json_encode($formatted->error));
            throw new RPCException($formatted->error->message, $formatted->error->code);
        }

        Log::info("Method: $method. " . $formatted->result);
        return $formatted->result;
    }

    /**
     * @param string $address
     * @return float
     * @throws RPCException
     */
    public function getAccountBalance(string $address)
    {
        return
            $this->wei2Eth((int)
            $this->decodeBigHexNumber(
                $this->request('eth_getBalance', [$address, 'latest'])
            )
            );
    }

    /**
     * @param int $weiAmount
     * @return string|null
     */
    public function wei2Eth(int $weiAmount)
    {
        return bcdiv($weiAmount, '1000000000000000000', 18);
    }

    /**
     * @param string $input
     * @return string
     */
    public function decodeBigHexNumber(string $input)
    {
        return gmp_strval("$input", 10);
    }

    /**
     * @return string
     */
    public function generateNewAddress(): string
    {
        // TODO: Implement generateNewAddress() method.
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
     * @return integer $count
     * @throws RPCException
     */
    public function getWalletBlockNumber(): int
    {
        return $this->decodeHex($this->request('eth_blockNumber'));
    }

    /**
     * @param string $input
     * @return boolean|float|integer|string
     */
    public function decodeHex(string $input)
    {
        if (substr($input, 0, 2) == '0x') {
            $input = substr($input, 2);
        }
        if (preg_match('/[a-f0-9]+/', $input)) {
            return hexdec($input);
        }

        return $input;
    }

    /**
     * @param float $ethAmount
     * @return string
     */
    public function eth2Wei(float $ethAmount)
    {
        return bcmul((string)$ethAmount, '1000000000000000000');
    }


    /**
     * @param string $address
     * @param string $apiKey
     * @param int $startBlockNumber
     * @param string|int $endBlockNumber
     * @return mixed
     * @throws RPCException
     */
    public function getAddressTransactionsEtherScanIO(string $address, string $apiKey, int $startBlockNumber, $endBlockNumber='latest')
    {
        $url = "http://api.etherscan.io/api?" .
            "module=account&" .
            "action=txlist&" .
            "address=$address&" .
            "startblock=$startBlockNumber&" .
            "endblock=$endBlockNumber&" .
            "sort=asc&" .
            "apikey=$apiKey";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new RPCException("etherscan.io did not respond");
        }

        $formatted = json_decode($response);
        if ($formatted->status === 0) {
            throw new RPCException($formatted->message, $formatted->status);
        }

        return $formatted->result;
    }


    /**
     * @param string $apiKey
     * @return mixed
     * @throws RPCException
     */
    public function getBlockNumberEtherScanIO(string $apiKey)
    {
        $url = "https://api.etherscan.io/api?".
        "module=proxy&".
        "action=eth_blockNumber&".
        "apikey=$apiKey";

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new RPCException("etherscan.io did not respond");
        }

        $formatted = json_decode($response);
        if (property_exists($formatted,'status') && $formatted->status === 0) {
            throw new RPCException($formatted->message, $formatted->status);
        }

        return $formatted->result;
    }

}
