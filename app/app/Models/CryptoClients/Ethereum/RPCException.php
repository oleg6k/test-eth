<?php

namespace App\Models\CryptoClients\Ethereum;

use Exception;

/**
 * Class RPCException
 * @package App\Models\CryptoClients\Ethereum
 */
class RPCException extends Exception
{
    /**
     * RPCException constructor.
     * @param $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(
        string $message,
        int $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": ".(($this->code > 0)?"[{$this->code}]:":"")." {$this->message}\n";
    }
}
