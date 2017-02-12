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
use DarkWebDesign\SymfonyAddon\Constraint\Tests\AbstractValidatorTestCase;
use DarkWebDesign\SymfonyAddon\Constraint\Tests\Models\TraversableObject;
use stdClass;
use Symfony\Component\Validator\Constraints as Assert;

class CollectionValidatorTest extends AbstractValidatorTestCase
{
    /** @var \Symfony\Component\Validator\ExecutionContext */
    private $context;

    /** @var \DarkWebDesign\SymfonyAddon\Constraint\CollectionValidator */
    private $validator;

    protected function setUp()
    {
        $this->context = $this->createContext();
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

        $contextualValidator = $this->context->getValidator()->inContext($this->context);

        foreach ($value as $field => $fieldValue) {
            foreach ($constraints as $constraint) {
                $contextualValidator->expects($this->at($i++))
                    ->method('atPath')
                    ->with('[' . $field . ']')
                    ->will($this->returnValue($contextualValidator));

                $contextualValidator->expects($this->at($i++))
                    ->method('validate')
                    ->with($fieldValue, $constraint);
            }
        }

        $this->validator->validate($value, new Collection($constraints));
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function testValidateNoCollectionConstraint()
    {
        $this->validator->validate(array(), new Assert\NotNull());

        $this->assertCount(0, $this->context->getViolations());
    }

    public function testValidateNull()
    {
        $this->validator->validate(null, new Collection(array(
            new Assert\NotBlank(),
        )));

        $this->assertCount(0, $this->context->getViolations());
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

        $this->assertCount(0, $this->context->getViolations());
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
