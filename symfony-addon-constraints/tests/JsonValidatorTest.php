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
use PHPUnit_Framework_TestCase;
use stdClass;

class JsonValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @var \Symfony\Component\Validator\ExecutionContext */
    private $context;

    /** @var \DarkWebDesign\SymfonyAddon\Constraint\JsonValidator */
    private $validator;

    /** @var \DarkWebDesign\SymfonyAddon\Constraint\Json */
    private $constraint;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new JsonValidator();
        $this->validator->initialize($this->context);
        $this->constraint = new Json();
    }

    /**
     * @param string $json
     *
     * @dataProvider providerValidJson
     */
    public function testIsValid($json)
    {
        $this->context
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->validate($json, $this->constraint);
    }

    public function testValidateNull()
    {
        $this->context
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->validate(null, $this->constraint);
    }

    public function testValidateEmptyString()
    {
        $this->context
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->validate('', $this->constraint);
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
        $this->context
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->validate($bsn, $this->constraint);
    }

    /**
     * @param string $json
     *
     * @dataProvider providerInvalidJson
     */
    public function testValidateViolation($json)
    {
        $this->context
            ->expects($this->once())
            ->method('addViolation')
            ->with(
                $this->identicalTo($this->constraint->message),
                $this->identicalTo(array('{{ value }}' => (string) $json))
            );

        $this->validator->validate($json, $this->constraint);
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
            'array'    => array(array('foo', 'bar')),
            'object'   => array(new stdClass()),
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
