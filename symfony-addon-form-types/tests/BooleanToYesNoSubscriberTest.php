<?php
/**
 * Copyright (c) 2021 DarkWeb Design
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

use DarkWebDesign\SymfonyAddonFormTypes\BooleanToYesNoSubscriber;
use DarkWebDesign\SymfonyAddonFormTypes\BooleanType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @covers \DarkWebDesign\SymfonyAddonFormTypes\BooleanToYesNoSubscriber
 *
 * @uses \DarkWebDesign\SymfonyAddonFormTypes\BooleanType
 * @uses \DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer
 */
class BooleanToYesNoSubscriberTest extends TypeTestCase
{
    /**
     * @dataProvider provider
     */
    public function test(?bool $value): void
    {
        $form = $this->factory->createBuilder()
            ->add('isActive', BooleanType::class)
            ->addEventSubscriber(new BooleanToYesNoSubscriber(['isActive']))
            ->getForm();

        $form->submit([
            'isActive' => $value,
        ]);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame($value, $form->get('isActive')->getData());
    }

    public function testDataNoField(): void
    {
        $form = $this->factory->createBuilder()
            ->add('isActive', BooleanType::class)
            ->addEventSubscriber(new BooleanToYesNoSubscriber(['isActive']))
            ->getForm();

        $form->submit([]);

        $this->assertTrue($form->isSynchronized());
        $this->assertNull($form->get('isActive')->getData());
    }

    public function testDataNotArray(): void
    {
        $form = $this->factory->createBuilder()
            ->add('isActive', BooleanType::class)
            ->addEventSubscriber(new BooleanToYesNoSubscriber(['isActive']))
            ->getForm();

        $form->submit('not-array');

        $this->assertFalse($form->isSynchronized());
        $this->assertNull($form->get('isActive')->getData());
    }

    public function provider(): array
    {
        return [
            'true' => [true],
            'false' => [false],
            'null' => [null],
        ];
    }
}
