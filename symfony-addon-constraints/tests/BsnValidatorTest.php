<?php
/**
 * Copyright (c) 2017 DarkWeb Design
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace DarkWebDesign\SymfonyAddonConstraints\Tests;

use DarkWebDesign\SymfonyAddonConstraints\Bsn;
use DarkWebDesign\SymfonyAddonConstraints\BsnValidator;
use DarkWebDesign\SymfonyAddonConstraints\Tests\Models\ToStringObject;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @covers \DarkWebDesign\SymfonyAddonConstraints\BsnValidator
 */
class BsnValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): BsnValidator
    {
        return new BsnValidator();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerValidBsn
     */
    public function testValidate($value): void
    {
        $this->validator->validate($value, new Bsn());

        $this->assertNoViolation();
    }

    public function testValidateInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate([], new Assert\NotNull());

        $this->assertNoViolation();
    }

    public function testValidateNull(): void
    {
        $this->validator->validate(null, new Bsn());

        $this->assertNoViolation();
    }

    public function testValidateEmptyString(): void
    {
        $this->validator->validate('', new Bsn());

        $this->assertNoViolation();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoScalar
     */
    public function testValidateNoScalar($value): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate($value, new Bsn());

        $this->assertNoViolation();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerInvalidBsn
     */
    public function testValidateViolation($value): void
    {
        $constraint = new Bsn();

        $this->validator->validate($value, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '"' . $value . '"')
            ->assertRaised();
    }

    public function providerValidBsn(): array
    {
        return [
            'valid1' => ['111222333'],
            'valid2' => ['123456782'],
            'objectToString' => [new ToStringObject('270590791')],
        ];
    }

    public function providerNoScalar(): array
    {
        return [
            'array' => [['foo', 'bar']],
            'object' => [new \stdClass()],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }

    public function providerInvalidBsn(): array
    {
        return [
            'zeros' => ['000000000'],
            'invalid1' => ['999999999'],
            'invalid2' => ['876543242'],
            'toStringObject' => [new ToStringObject('597944111')],
        ];
    }
}
