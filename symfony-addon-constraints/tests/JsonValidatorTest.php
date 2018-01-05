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

namespace DarkWebDesign\SymfonyAddon\Constraint\Tests;

use DarkWebDesign\SymfonyAddon\Constraint\Json;
use DarkWebDesign\SymfonyAddon\Constraint\JsonValidator;
use DarkWebDesign\SymfonyAddon\Constraint\Tests\Models\ToStringObject;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

class JsonValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @return \DarkWebDesign\SymfonyAddon\Constraint\JsonValidator
     */
    protected function createValidator()
    {
        return new JsonValidator();
    }

    /**
     * @param string $json
     *
     * @dataProvider providerValidJson
     */
    public function testValidate($json)
    {
        $this->validator->validate($json, new Json());

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
        $this->validator->validate(null, new Json());

        $this->assertNoViolation();
    }

    public function testValidateEmptyString()
    {
        $this->validator->validate('', new Json());

        $this->assertNoViolation();
    }

    /**
     * @param string $bsn
     *
     * @dataProvider providerNoScalar
     *
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testValidateNoScalar($bsn)
    {
        $this->validator->validate($bsn, new Json());

        $this->assertNoViolation();
    }

    /**
     * @param string $json
     *
     * @dataProvider providerInvalidJson
     */
    public function testValidateViolation($json)
    {
        $constraint = new Json();

        $this->validator->validate($json, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '"' . $json . '"')
            ->assertRaised();
    }

    /**
     * @return array[]
     */
    public function providerValidJson()
    {
        return array(
            'bool' => array(true),
            'int' => array(123),
            'float' => array(10.99),
            'stringInt' => array('123'),
            'stringArray' => array('[1, 2, 3]'),
            'stringObject' => array('{"a": 1, "b": 2}'),
            'objectToString' => array(new ToStringObject('123')),
        );
    }

    /**
     * @return array[]
     */
    public function providerNoScalar()
    {
        return array(
            'array' => array(array('foo', 'bar')),
            'object' => array(new \stdClass()),
            'resource' => array(tmpfile()),
            'callable' => array(function () {}),
        );
    }

    /**
     * @return array[]
     */
    public function providerInvalidJson()
    {
        return array(
            'string' => array('json'),
            'stringArray' => array('[1, 2, 3'),
            'stringObject' => array('{"a": 1, "b": 2'),
        );
    }
}
