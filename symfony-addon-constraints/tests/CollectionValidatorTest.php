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

use DarkWebDesign\SymfonyAddon\Constraint\Collection;
use DarkWebDesign\SymfonyAddon\Constraint\CollectionValidator;
use DarkWebDesign\SymfonyAddon\Constraint\Tests\Models\ToStringObject;
use DarkWebDesign\SymfonyAddon\Constraint\Tests\Models\TraversableObject;
use PHPUnit_Framework_TestCase;
use stdClass;
use Symfony\Component\Validator\Constraints as Assert;

class CollectionValidatorTest extends PHPUnit_Framework_TestCase
{
    /** @var \Symfony\Component\Validator\ExecutionContext */
    private $context;

    /** @var \DarkWebDesign\SymfonyAddon\Constraint\CollectionValidator */
    private $validator;

    protected function setUp()
    {
        $this->context = $this->getMock('Symfony\Component\Validator\ExecutionContext', array(), array(), '', false);
        $this->validator = new CollectionValidator();
        $this->validator->initialize($this->context);
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
                $this->context->expects($this->at($i++))
                    ->method('validateValue')
                    ->with($fieldValue, $constraint, '[' . $field . ']');
            }
        }

        $this->validator->validate($value, new Collection($constraints));
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testValidateNoCollectionConstraint()
    {
        $this->context
            ->expects($this->never())
            ->method('validateValue');

        $this->validator->validate(array(), new Assert\NotNull());
    }

    public function testValidateNull()
    {
        $this->context
            ->expects($this->never())
            ->method('validateValue');

        $this->validator->validate(null, new Collection(array(
            new Assert\NotBlank(),
        )));
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
        $this->context
            ->expects($this->never())
            ->method('validateValue');

        $this->validator->validate($value, new Collection(array(
            new Assert\NotBlank(),
        )));
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
            'object' => array(new stdClass()),
            'resource' => array(tmpfile()),
            'callable' => array(function () {})
        );
    }
}
