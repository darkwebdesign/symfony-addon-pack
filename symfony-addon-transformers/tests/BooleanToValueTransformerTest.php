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

namespace DarkWebDesign\SymfonyAddonTransformers\Tests;

use DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer;

class BooleanToValueTransformerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param string $trueValue
     * @param string $falseValue
     *
     * @dataProvider providerTrueFalseValue
     */
    public function testTransform($trueValue, $falseValue)
    {
        $transformer = new BooleanToValueTransformer($trueValue, $falseValue);

        $returnValue = $transformer->transform(true);

        $this->assertSame($trueValue, $returnValue);

        $returnValue = $transformer->transform(false);

        $this->assertSame($falseValue, $returnValue);
    }

    public function testTransformNull()
    {
        $transformer = new BooleanToValueTransformer();

        $returnValue = $transformer->transform(null);

        $this->assertNull($returnValue);
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoBool
     *
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Expected a boolean.
     */
    public function testTransformNoBool($value)
    {
        $transformer = new BooleanToValueTransformer();

        $transformer->transform($value);
    }

    /**
     * @param string $trueValue
     * @param string $falseValue
     *
     * @dataProvider providerTrueFalseValue
     */
    public function testReverseTransform($trueValue, $falseValue)
    {
        $transformer = new BooleanToValueTransformer($trueValue, $falseValue);

        $returnValue = $transformer->reverseTransform($trueValue);

        $this->assertTrue($returnValue);

        $returnValue = $transformer->reverseTransform($falseValue);

        $this->assertFalse($returnValue);
    }

    public function testReverseTransformNull()
    {
        $transformer = new BooleanToValueTransformer();

        $returnValue = $transformer->reverseTransform(null);

        $this->assertNull($returnValue);
    }

    public function testReverseTransformEmptyString()
    {
        $transformer = new BooleanToValueTransformer();

        $returnValue = $transformer->reverseTransform('');

        $this->assertNull($returnValue);
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoScalar
     *
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Expected a scalar.
     */
    public function testReverseTransformNoScalar($value)
    {
        $transformer = new BooleanToValueTransformer();

        $transformer->reverseTransform($value);
    }

    /**
     * @param string $trueValue
     * @param string $falseValue
     *
     * @dataProvider providerTrueFalseValue
     *
     * @expectedException \Symfony\Component\Form\Exception\TransformationFailedException
     * @expectedExceptionMessage Expected true/false boolean value.
     */
    public function testReverseTransformInvalidValue($trueValue, $falseValue)
    {
        $transformer = new BooleanToValueTransformer($trueValue, $falseValue);

        $transformer->reverseTransform('foo');
    }

    /**
     * @return array[]
     */
    public function providerTrueFalseValue()
    {
        return [
            'true/false' => [true, false],
            'yes/no' => ['yes', 'no'],
            'on/off' => ['on', 'off'],
            '1/0' => [1, 0],
        ];
    }

    /**
     * @return array[]
     */
    public function providerNoBool()
    {
        return [
            'int' => [1],
            'float' => [1.2],
            'string' => ['foo'],
            'array' => [['foo', 'bar']],
            'object' => [new \stdClass],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }

    /**
     * @return array[]
     */
    public function providerNoScalar()
    {
        return [
            'array' => [['foo', 'bar']],
            'object' => [new \stdClass],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }
}
