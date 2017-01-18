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

namespace DarkWebDesign\SymfonyAddon\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * Transforms between a boolean and a string.
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class BooleanToStringTransformer implements DataTransformerInterface
{
    /** @var string */
    private $trueValue;

    /** @var string */
    private $falseValue;

    /**
     * Constructor.
     *
     * @param string $trueValue
     * @param string $falseValue
     */
    public function __construct($trueValue = 'true', $falseValue = 'false')
    {
        $this->trueValue = $trueValue;
        $this->falseValue = $falseValue;
    }

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * @param bool $value
     *
     * @return string
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function transform($value)
    {
        if (null === $value) {
            return null;
        }

        if (!is_bool($value)) {
            throw new TransformationFailedException('Expected a boolean.');
        }

        return $value ? $this->trueValue : $this->falseValue;
    }

    /**
     * Transforms a value from the transformed representation to its original representation.
     *
     * @param string $value
     *
     * @return bool
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     */
    public function reverseTransform($value)
    {
        if (null === $value || '' === $value) {
            return null;
        }

        if (!is_scalar($value)) {
            throw new TransformationFailedException('Expected a scalar.');
        }

        $value = (string) $value;

        if (!($value === $this->trueValue || $value === $this->falseValue)) {
            throw new TransformationFailedException(
                sprintf('Expected a string "%s" or "%s".', $this->trueValue, $this->falseValue)
            );
        }

        return $value === $this->trueValue;
    }
}
