<?php

namespace Tests\Unit;

use App\Money\Currency\Pln;
use App\Money\Exceptions\CurrencyException;
use App\Money\Money;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use TypeError;

class MoneyTest extends TestCase
{
    use DatabaseTransactions;

    public function testShouldCorrectParsePLNFormat()
    {
        // Given
        $pln_cents = 9899;
        $pln_expect_format = '98,99 zł';

        // When
        $money = new Money($pln_cents);

        //Then
        $this->assertEquals($pln_expect_format, $money->getPrice(Pln::class)->getPriceWithSymbol());
    }

    public function testShouldCorrectMultiplyPrice()
    {
        // Given
        $pln_to_multiply = 101;
        $expect = 235.33;
        $money = new Money($pln_to_multiply);

        // When
        $result = $money->multiplyPrice(2.33);

        //Then
        $this->assertEquals($expect, $result);
    }

    public function testShouldReturnCorrectFractionalValue()
    {
        // Given
        $expect_cents = 6667885;

        // When
        $money = new Money($expect_cents);

        //Then
        $this->assertEquals($expect_cents, $money->getPriceAsFractionalUnits());
    }

    public function testShouldThrowExceptionWhenIPassWrongMoneyValue()
    {
        // Expect
        $this->expectException(TypeError::class);

        //Then
        new Money('someWrongPrice');
    }

    public function testShouldThrowExceptionWhenIPassBiggerIntValue()
    {
        // Expect
        $this->expectException(TypeError::class);

        //Then
        new Money(12345678765432367867868768767868764567);
    }

    public function testShouldVerifyIfCorrectCurrencyWillReturn()
    {
        // Expect
        $this->expectException(CurrencyException::class);
        $this->expectExceptionMessage('Wrong currency class given. Currency class must be implement Money\Contracts\CurrencyInterface interface');

        // Given
        $money = new Money(5578);

        //Then
        $money->getPrice('SOME_WRONG_class');
    }

}
