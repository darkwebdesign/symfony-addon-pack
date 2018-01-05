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
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

class CollectionValidatorTest extends AbstractConstraintValidatorTest
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
        $constraints = array(
            new Assert\Email(),
            new Assert\NotBlank(),
        );

        $i = 0;

        foreach ($value as $field => $fieldValue) {
            foreach ($constraints as $constraint) {
                $this->expectValidateValueAt($i++, '[' . $field . ']', $fieldValue, $constraint);
            }
        }

        $this->validator->validate($value, new Collection($constraints));

        $this->assertNoViolation();
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testValidateInvalidConstraint()
    {
        $this->validator->validate(array(), new Assert\NotNull());

        $this->assertNoViolation();
    }

    public function testValidateNull()
    {
        $this->validator->validate(null, new Collection(array(
            new Assert\NotBlank(),
        )));

        $this->assertNoViolation();
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoArray
     *
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testValidateNoArray($value)
    {
        $this->validator->validate($value, new Collection(array(
            new Assert\NotBlank(),
        )));

        $this->assertNoViolation();
    }

    /**
     * @return array[]
     */
    public function providerValidCollection()
    {
        return array(
            'empty' => array(array()),
            'array' => array(array('my.email@address.com')),
            'traversableObject' => array(new TraversableObject(array('my.email@address.com'))),
        );
    }

    /**
     * @return array[]
     */
    public function providerNoArray()
    {
        return array(
            'bool' => array(true),
            'int' => array(1),
            'float' => array(1.2),
            'string' => array('foo'),
            'object' => array(new \stdClass()),
            'resource' => array(tmpfile()),
            'callable' => array(function () {})
        );
    }
}
