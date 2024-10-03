<?php

class Money
{
    private \GMP $amount;

    private string $currency;

    public function __construct(\GMP $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): \GMP
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

        $newAmount = gmp_add($this->amount, $money->getAmount());

        return new Money($newAmount, $this->currency);
    }

    public function subtract(Money $money): Money
    {
        if ($this->currency !== $money->getCurrency()) {
            throw new InvalidArgumentException('Invalid currency');
        }

        $newAmount = gmp_sub($this->amount, $money->getAmount());

        return new Money($newAmount, $this->currency);
    }

    public function toFloat(): float
    {
        return gmp_intval($this->amount) / BalanceManager::PRECISION;
    }

    private function isNegative(\GMP $value): bool
    {
        return gmp_cmp($value, 0) < 0;
    }
}

class BalanceManager
{
    public const bool ALLOW_NEGATIVE = false;

    public const int PRECISION = 1000;

    /** @var Money[] */
    private array $transactions = [];

    private string $currency;

    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    public function debit(Money $amount): void
    {
        if ($this->currency !== $amount->getCurrency()) {
            throw new InvalidArgumentException('Invalid currency');
        }

        $balance = $this->getCurrentBalance();

        if (!self::ALLOW_NEGATIVE && gmp_cmp($balance->getAmount(), $amount->getAmount()) < 0) {
            throw new InvalidArgumentException('Insufficient money to debit the balance');
        }

        $this->transactions[] = $amount;
    }

    public function credit(Money $amount): void
    {
        if ($this->currency !== $amount->getCurrency()) {
            throw new InvalidArgumentException('Invalid currency');
        }

        $this->transactions[] = $amount;
    }

    public function getCurrentBalance(): Money
    {
        $balance = new Money(gmp_init(0), $this->currency);

        foreach ($this->transactions as $transaction) {
            $balance->add($transaction);
        }

        return $balance;
    }
}