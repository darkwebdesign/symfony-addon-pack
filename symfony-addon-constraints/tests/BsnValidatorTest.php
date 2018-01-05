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

use DarkWebDesign\SymfonyAddonConstraints\Bsn;
use DarkWebDesign\SymfonyAddonConstraints\BsnValidator;
use DarkWebDesign\SymfonyAddonConstraints\Tests\Models\ToStringObject;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest;

class BsnValidatorTest extends AbstractConstraintValidatorTest
{
    /**
     * @return \DarkWebDesign\SymfonyAddonConstraints\BsnValidator
     */
    protected function createValidator()
    {
        return new BsnValidator();
    }

    /**
     * @param string $bsn
     *
     * @dataProvider providerValidBsn
     */
    public function testValidate($bsn)
    {
        $this->validator->validate($bsn, new Bsn());

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
        $this->validator->validate(null, new Bsn());

        $this->assertNoViolation();
    }

    public function testValidateEmptyString()
    {
        $this->validator->validate('', new Bsn());

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
        $this->validator->validate($bsn, new Bsn());

        $this->assertNoViolation();
    }

    /**
     * @param string $bsn
     *
     * @dataProvider providerInvalidBsn
     */
    public function testValidateViolation($bsn)
    {
        $constraint = new Bsn();

        $this->validator->validate($bsn, $constraint);

        $this->buildViolation($constraint->message)
            ->setParameter('{{ value }}', '"' . $bsn . '"')
            ->assertRaised();
    }

    /**
     * @return array[]
     */
    public function providerValidBsn()
    {
        return array(
            'valid1' => array('111222333'),
            'valid2' => array('123456782'),
            'objectToString' => array(new ToStringObject('270590791')),
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
    public function providerInvalidBsn()
    {
        return array(
            'zeros' => array('000000000'),
            'invalid1' => array('999999999'),
            'invalid2' => array('876543242'),
            'toStringObject' => array(new ToStringObject('597944111')),
        );
    }
}
