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

use DarkWebDesign\SymfonyAddonConstraints\Collection;
use DarkWebDesign\SymfonyAddonConstraints\CollectionValidator;
use DarkWebDesign\SymfonyAddonConstraints\Tests\Models\TraversableObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 * @template-extends ConstraintValidatorTestCase<CollectionValidator>
 *
 * @internal
 */
#[CoversClass(CollectionValidator::class)]
#[UsesClass(Collection::class)]
class CollectionValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): CollectionValidator
    {
        return new CollectionValidator();
    }

    /**
     * @param string[]|iterable $value
     */
    #[DataProvider('providerValidCollection')]
    public function testValidate(iterable $value): void
    {
        $constraints = [
            new Assert\Email(),
            new Assert\NotBlank(),
        ];

        $i = 0;

        foreach ($value as $field => $fieldValue) {
            foreach ($constraints as $constraint) {
                $this->expectValidateValueAt($i++, '[' . $field . ']', $fieldValue, $constraint);
            }
        }

        $this->validator->validate($value, new Collection($constraints));

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
        $this->validator->validate(null, new Collection([
            new Assert\NotBlank(),
        ]));

        $this->assertNoViolation();
    }

    #[DataProvider('providerNoArray')]
    public function testValidateNoArray(mixed $value): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate($value, new Collection([
            new Assert\NotBlank(),
        ]));

        $this->assertNoViolation();
    }

    /**
     * @return array<string, array{string[]|iterable}>
     */
    public static function providerValidCollection(): array
    {
        return [
            'empty' => [[]],
            'array' => [['my.email@address.com']],
            'traversableObject' => [new TraversableObject(['my.email@address.com'])],
        ];
    }

    /**
     * @return array<string, array{mixed}>
     */
    public static function providerNoArray(): array
    {
        return [
            'bool' => [true],
            'int' => [1],
            'float' => [1.2],
            'string' => ['foo'],
            'object' => [new \stdClass()],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }
}
