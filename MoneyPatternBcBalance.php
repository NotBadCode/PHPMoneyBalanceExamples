<?php

class Money
{
    public const int SCALE = 8;

    public const bool ALLOW_NEGATIVE = false;

    private string $amount;

    private string $currency;

    public function __construct(string $amount, string $currency)
    {
        if (!self::ALLOW_NEGATIVE && $this->isNegative($amount)) {
            throw new InvalidArgumentException('Amount is negative');
        }
        if ($this->isInvalid($amount)) {
            throw new InvalidArgumentException('Amount is invalid');
        }

        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(Money $money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new InvalidArgumentException('Invalid currency');
        }

        $newAmount = bcadd($this->amount, $money->getAmount(), self::SCALE);

        return new Money($newAmount, $this->currency);
    }

    public function subtract(Money $money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new InvalidArgumentException('Invalid currency');
        }

        if (!self::ALLOW_NEGATIVE && bccomp($this->amount, $money->getAmount(), self::SCALE) < 0) {
            throw new InvalidArgumentException('Insufficient money to subtract');
        }

        $newAmount = bcsub($this->amount, $money->getAmount(), self::SCALE);

        return new Money($newAmount, $this->currency);
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

class BalanceManager
{
    private Money $balance;

    public function __construct(Money $initialBalance)
    {
        $this->balance = $initialBalance;
    }

    public function debit(Money $amount): Money
    {
        $this->balance = $this->balance->subtract($amount);
        return $this->balance;
    }

    public function credit(Money $amount): Money
    {
        $this->balance = $this->balance->add($amount);
        return $this->balance;
    }

    public function getBalance(): Money
    {
        return $this->balance;
    }
}
