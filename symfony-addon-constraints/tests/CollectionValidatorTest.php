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

namespace DarkWebDesign\SymfonyAddonConstraints\Tests;

use DarkWebDesign\SymfonyAddonConstraints\Collection;
use DarkWebDesign\SymfonyAddonConstraints\CollectionValidator;
use DarkWebDesign\SymfonyAddonConstraints\Tests\Models\TraversableObject;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class CollectionValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * @return \DarkWebDesign\SymfonyAddonConstraints\CollectionValidator
     */
    protected function createValidator()
    {
        return new CollectionValidator();
    }

    /**
     * @param array $value
     *
     * @dataProvider providerValidCollection
     */
    public function testValidate($value)
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

    public function testValidateInvalidConstraint()
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate([], new Assert\NotNull());

        $this->assertNoViolation();
    }

    public function testValidateNull()
    {
        $this->validator->validate(null, new Collection([
            new Assert\NotBlank(),
        ]));

        $this->assertNoViolation();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoArray
     */
    public function testValidateNoArray($value)
    {
        $this->expectException(UnexpectedTypeException::class);

        $this->validator->validate($value, new Collection([
            new Assert\NotBlank(),
        ]));

        $this->assertNoViolation();
    }

    /**
     * @return array[]
     */
    public function providerValidCollection()
    {
        return [
            'empty' => [[]],
            'array' => [['my.email@address.com']],
            'traversableObject' => [new TraversableObject(['my.email@address.com'])],
        ];
    }

    /**
     * @return array[]
     */
    public function providerNoArray()
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
