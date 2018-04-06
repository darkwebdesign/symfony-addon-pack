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
use Symfony\Component\Validator\Constraints as Assert;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        new Collection([
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
    }

    public function testConstructDefaultOption()
    {
        new Collection([
            new Assert\NotBlank(),
        ]);
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\MissingOptionsException
     */
    public function testConstructMissingRequiredConstraintsOption()
    {
        new Collection();
    }

    /**
     * @param mixed $constraints
     *
     * @dataProvider providerNoArray
     *
     * @expectedException \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     */
    public function testConstructConstraintsOptionNoArray($constraints)
    {
        new Collection([
            'constraints' => $constraints,
        ]);
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     */
    public function testConstructNoConstraint()
    {
        new Collection([
            'constraints' => [
                'foo',
            ],
        ]);
    }

    /**
     * @expectedException \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     */
    public function testConstructValidConstraint()
    {
        new Collection([
            'constraints' => [
                new Assert\Valid(),
            ],
        ]);
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
