<?php
/**
 * Copyright (c) 2016 DarkWeb Design
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

namespace DarkWebDesign\SymfonyAddon\Validator\Tests\Constraints;

use DarkWebDesign\SymfonyAddon\Validator\Constraints\Bsn;
use DarkWebDesign\SymfonyAddon\Validator\Constraints\BsnValidator;
use PHPUnit_Framework_TestCase;
use stdClass;

class BsnValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @var \Symfony\Component\Validator\ExecutionContext */
    private $context;

    /** @var \DarkWebDesign\SymfonyAddon\Validator\Constraints\BsnValidator */
    private $validator;

    /** @var \DarkWebDesign\SymfonyAddon\Validator\Constraints\Bsn */
    private $constraint;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new BsnValidator();
        $this->validator->initialize($this->context);
        $this->constraint = new Bsn();
    }

    /**
     * @param string $bsn
     *
     * @dataProvider providerIsValid
     */
    public function testIsValid($bsn)
    {
        $this->context
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->isValid($bsn, $this->constraint);
    }

    /**
     * @return array[]
     */
    public function providerIsValid()
    {
        return array(
            'valid1' => array('111222333'),
            'valid2' => array('123456782'),
        );
    }

    public function testIsValidNull()
    {
        $this->context
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->isValid(null, $this->constraint);
    }

    public function testIsValidEmptyString()
    {
        $this->context
            ->expects($this->never())
            ->method('addViolation');

        $this->validator->isValid('', $this->constraint);
    }

    /**
     * @param string $bsn
     *
     * @dataProvider providerIsValidViolation
     */
    public function testIsValidViolation($bsn)
    {
        $this->context
            ->expects($this->once())
            ->method('addViolation')
            ->with(
                $this->identicalTo($this->constraint->message),
                $this->identicalTo(array()),
                $this->identicalTo($bsn)
            );

        $this->validator->isValid($bsn, $this->constraint);
    }

    /**
     * @return array[]
     */
    public function providerIsValidViolation()
    {
        return array(
            'zeros'    => array('000000000'),
            'invalid1' => array('999999999'),
            'invalid2' => array('876543242'),
            'bool'     => array(true),
            'string'   => array('mybsn'),
            'array'    => array(array('foo', 'bar')),
            'object'   => array(new stdClass()),
            'resource' => array(tmpfile()),
            'callable' => array(function () {}),
        );
    }
}
