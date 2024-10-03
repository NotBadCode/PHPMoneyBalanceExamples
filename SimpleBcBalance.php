<?php

class BalanceManager
{
    public const int SCALE = 8;

    public const bool ALLOW_NEGATIVE = false;

    private string $balance;

    public function __construct(string $initialBalance)
    {
        if (!self::ALLOW_NEGATIVE && $this->isNegative($initialBalance)) {
            throw new InvalidArgumentException('Balance is negative');
        }
        if ($this->isInvalid($initialBalance)) {
            throw new InvalidArgumentException('Balance is invalid');
        }

        $this->balance = $initialBalance;
    }

    public function debit(string $amount): string
    {
        if ($this->isNegative($amount)) {
            throw new InvalidArgumentException('Amount is negative');
        }
        if ($this->isInvalid($amount)) {
            throw new InvalidArgumentException('Amount is invalid');
        }

        if (!self::ALLOW_NEGATIVE && bccomp($this->balance, $amount, self::SCALE) < 0) {
            throw new InvalidArgumentException('Insufficient money to debit the balance');
        }

        $this->balance = bcsub($this->balance, $amount, self::SCALE);

        return $this->balance;
    }

    public function credit(string $amount): string
    {
        if ($this->isNegative($amount)) {
            throw new InvalidArgumentException('Amount is negative');
        }
        if ($this->isInvalid($amount)) {
            throw new InvalidArgumentException('Amount is invalid');
        }

        $this->balance = bcadd($this->balance, $amount, self::SCALE);

        return $this->balance;
    }

    public function getBalance(): string
    {
        return $this->balance;
    }

    private function isNegative(string $value): bool
    {
        return bccomp($value, '0', self::SCALE) <= 0;
    }

    private function isInvalid(string $value): bool
    {
        return !is_numeric($value);
    }
}
