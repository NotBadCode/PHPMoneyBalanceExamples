# PHP Money Balance Examples

This repository demonstrates different ways to manage monetary balances in PHP, using [BCMath](https://www.php.net/manual/en/book.bc.php) and [GMP](https://www.php.net/manual/ru/book.gmp.php).

_These are the simplest examples, real world use will require the use of an external database and more advanced data validation._

### 1. [Simple Balance (SimpleBcBalance.php)](https://github.com/NotBadCode/PHPMoneyBalanceExamples/blob/master/SimpleBcBalance.php)
A basic example that uses [BCMath](https://www.php.net/manual/en/book.bc.php) for precise addition and subtraction of balances.

### 2. [Money Pattern with BCMath (MoneyPatternBcBalance.php)](https://github.com/NotBadCode/PHPMoneyBalanceExamples/blob/master/MoneyPatternBcBalance.php)
Introduces the [Money Pattern](https://verraes.net/2011/04/fowler-money-pattern-in-php/), encapsulating monetary values and ensuring safe operations.

### 3. [Money Pattern with transactions and integer storage (MoneyPatternGmpBalanceTransactions.php)](https://github.com/NotBadCode/PHPMoneyBalanceExamples/blob/master/MoneyPatternGmpBalanceTransactions.php)
Combines the [Money Pattern](https://verraes.net/2011/04/fowler-money-pattern-in-php/) with transaction logging and [GMP](https://www.php.net/manual/ru/book.gmp.php) for large integer handling.
