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

declare(strict_types=1);

namespace DarkWebDesign\SymfonyAddonTransformers\Tests;

use DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @covers \DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer
 */
class BooleanToValueTransformerTest extends TestCase
{
    /**
     * @param mixed $trueValue
     * @param mixed $falseValue
     *
     * @dataProvider providerTrueFalseValue
     */
    public function testTransform($trueValue, $falseValue): void
    {
        $transformer = new BooleanToValueTransformer($trueValue, $falseValue);

        $returnValue = $transformer->transform(true);

        $this->assertSame($trueValue, $returnValue);

        $returnValue = $transformer->transform(false);

        $this->assertSame($falseValue, $returnValue);
    }

    public function testTransformNull(): void
    {
        $transformer = new BooleanToValueTransformer();

        $returnValue = $transformer->transform(null);

        $this->assertNull($returnValue);
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoBool
     */
    public function testTransformNoBool($value): void
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('Expected a boolean.');

        $transformer = new BooleanToValueTransformer();

        $transformer->transform($value);
    }

    /**
     * @param mixed $trueValue
     * @param mixed $falseValue
     *
     * @dataProvider providerTrueFalseValue
     */
    public function testReverseTransform($trueValue, $falseValue): void
    {
        $transformer = new BooleanToValueTransformer($trueValue, $falseValue);

        $returnValue = $transformer->reverseTransform($trueValue);

        $this->assertTrue($returnValue);

        $returnValue = $transformer->reverseTransform($falseValue);

        $this->assertFalse($returnValue);
    }

    public function testReverseTransformNull(): void
    {
        $transformer = new BooleanToValueTransformer();

        $returnValue = $transformer->reverseTransform(null);

        $this->assertNull($returnValue);
    }

    public function testReverseTransformEmptyString(): void
    {
        $transformer = new BooleanToValueTransformer();

        $returnValue = $transformer->reverseTransform('');

        $this->assertNull($returnValue);
    }

    /**
     * @param mixed $value
     *
     * @dataProvider providerNoScalar
     */
    public function testReverseTransformNoScalar($value): void
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('Expected a scalar.');

        $transformer = new BooleanToValueTransformer();

        $transformer->reverseTransform($value);
    }

    /**
     * @param mixed $trueValue
     * @param mixed $falseValue
     *
     * @dataProvider providerTrueFalseValue
     */
    public function testReverseTransformInvalidValue($trueValue, $falseValue): void
    {
        $this->expectException(TransformationFailedException::class);
        $this->expectExceptionMessage('Expected true/false boolean value.');

        $transformer = new BooleanToValueTransformer($trueValue, $falseValue);

        $transformer->reverseTransform('foo');
    }

    public function providerTrueFalseValue(): array
    {
        return [
            'true/false' => [true, false],
            'yes/no' => ['yes', 'no'],
            'on/off' => ['on', 'off'],
            '1/0' => [1, 0],
        ];
    }

    public function providerNoBool(): array
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

    public function providerNoScalar(): array
    {
        return [
            'array' => [['foo', 'bar']],
            'object' => [new \stdClass],
            'resource' => [tmpfile()],
            'callable' => [function () {}],
        ];
    }
}
