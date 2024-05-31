<?php


namespace Support\ValueObjects;


use InvalidArgumentException;
use Support\Traits\Makeable;

class Price implements \Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];
    public function __construct (
        private int $value,
        private string $currency = 'RUB',
        private int $precision = 100,
    )
    {
        if ($this->value < 0) {
            throw new InvalidArgumentException('Не верное значение');
        }

        if (!isset($this->currencies[$this->currency])) {
            throw new InvalidArgumentException('Не верное значение');
        }
    }

    public function value() :float|int
    {
        return $this->value / $this->precision;
    }

    public function raw() :float|int
    {
        return $this->value;
    }

    public function currency() :string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return $this->currencies[$this->currency];
    }

    public function __toString()
    {
        return number_format($this->value(), 2, ',', ' ') . ' '. $this->symbol();
    }
}
