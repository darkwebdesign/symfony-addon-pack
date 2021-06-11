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

namespace DarkWebDesign\SymfonyAddonFormTypes\Tests;

use DarkWebDesign\SymfonyAddonFormTypes\BooleanType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @covers \DarkWebDesign\SymfonyAddonFormTypes\BooleanType
 *
 * @uses \DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer
 */
class BooleanTypeTest extends TypeTestCase
{
    /**
     * @param mixed $valueTrue
     * @param mixed $valueFalse
     *
     * @dataProvider providerValueTrueFalse
     */
    public function test($valueTrue, $valueFalse): void
    {
        $options = [
            'value_true' => $valueTrue,
            'value_false' => $valueFalse,
        ];

        $form = $this->factory->create(BooleanType::class, null, $options);
        $form->submit($valueTrue);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->getData());

        $form = $this->factory->create(BooleanType::class, null, $options);
        $form->submit($valueFalse);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->getData());
    }

    /**
     * @param mixed $valueTrue
     * @param mixed $valueFalse
     *
     * @dataProvider providerValueTrueFalse
     */
    public function testInvalidValue($valueTrue, $valueFalse): void
    {
        $options = [
            'value_true' => $valueTrue,
            'value_false' => $valueFalse,
        ];

        $form = $this->factory->create(BooleanType::class, null, $options);
        $form->submit('foo');

        $this->assertFalse($form->isSynchronized());
        $this->assertNull($form->getData());
    }

    /**
     * @dataProvider providerWidget
     */
    public function testWidget(string $widget, bool $expanded): void
    {
        $options = [
            'widget' => $widget,
        ];

        $form = $this->factory->create(BooleanType::class, null, $options);
        $view = $form->createView();

        $this->assertSame($expanded, $view->vars['expanded']);
        $this->assertFalse($view->vars['multiple']);
    }

    public function testHumanize(): void
    {
        $options = [
            'value_true' => 'an_underscored__label',
            'value_false' => 'aCamel Cased  Label',
        ];

        $form = $this->factory->create(BooleanType::class, null, $options);
        $view = $form->createView();

        $this->assertCount(2, $view->vars['choices']);
        $this->assertSame('An underscored label', $view->vars['choices'][0]->label);
        $this->assertSame('A camel cased label', $view->vars['choices'][1]->label);
    }

    public function providerValueTrueFalse(): array
    {
        return [
            'true/false' => ['true', 'false'],
            'yes/no' => ['yes', 'no'],
            'on/off' => ['on', 'off'],
            '1/0' => ['1', '0'],
            '1/2' => [1, 2],
            '1.3/2.7' => [1.3, 2.7],
        ];
    }

    public function providerWidget(): array
    {
        return [
            'choice' => ['choice', false],
            'radio' => ['radio', true],
        ];
    }
}
