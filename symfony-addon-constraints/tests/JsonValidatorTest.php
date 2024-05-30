<?php
/**
 * Copyright (c) 2017 DarkWeb Design.
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

use DarkWebDesign\SymfonyAddonConstraints\Json;
use DarkWebDesign\SymfonyAddonConstraints\JsonValidator;
use DarkWebDesign\SymfonyAddonConstraints\Tests\Models\ToStringObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @template-extends ConstraintValidatorTestCase<JsonValidator>
 *
 * @internal
 */
#[CoversClass(JsonValidator::class)]
class JsonValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): JsonValidator
    {
        return new JsonValidator();
    }

    #[DataProvider('providerValidJson')]
    public function testValidate(mixed $value): void
    {
        $this->validator->validate($value, new Json());

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
        $this->validator->validate(null, new Json());

        $this->assertNoViolation();
    }

    public function testValidateEmptyString(): void
    {
        $this->validator->validate('', new Json());

        $this->assertNoViolation();
    }

    #[DataProvider('providerNoScalar')]
    public function testValidateNoScalar(mixed $value): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate($value, new Json());

        $this->assertNoViolation();
    }

    #[DataProvider('providerInvalidJson')]
    public function testValidateViolation(string $value): void
    {
        $constraint = new Json();

        $this->validator->validate($value, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '"' . $value . '"')
            ->assertRaised();
    }

    /**
     * @return array<string, array{mixed}>
     */
    public static function providerValidJson(): array
    {
        return [
            'bool' => [true],
            'int' => [123],
            'float' => [10.99],
            'stringInt' => ['123'],
            'stringArray' => ['[1, 2, 3]'],
            'stringObject' => ['{"a": 1, "b": 2}'],
            'objectToString' => [new ToStringObject('123')],
        ];
    }

    /**
     * @return array<string, array{mixed}>
     */
    public static function providerNoScalar(): array
    {
        return [
            'array' => [['foo', 'bar']],
            'object' => [new \stdClass()],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }

    /**
     * @return array<string, array{string}>
     */
    public static function providerInvalidJson(): array
    {
        return [
            'string' => ['json'],
            'stringArray' => ['[1, 2, 3'],
            'stringObject' => ['{"a": 1, "b": 2'],
        ];
    }
}
