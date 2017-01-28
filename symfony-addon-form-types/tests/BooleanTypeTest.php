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

namespace DarkWebDesign\SymfonyAddon\FormType\Tests;

use DarkWebDesign\SymfonyAddon\FormType\BooleanType;
use Symfony\Component\Form\Test\TypeTestCase;

class BooleanTypeTest extends TypeTestCase
{
    /** @var \DarkWebDesign\SymfonyAddon\FormType\BooleanType */
    private $type;

    protected function setUp()
    {
        parent::setUp();

        $this->type = new BooleanType();
    }

    /**
     * @param string $valueTrue
     * @param string $valueFalse
     *
     * @dataProvider providerValueTrueFalse
     */
    public function test($valueTrue, $valueFalse)
    {
        $options = array(
            'value_true' => $valueTrue,
            'value_false' => $valueFalse,
        );

        $form = $this->factory->create($this->type, null, $options);
        $form->submit($valueTrue);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->getData());

        $form = $this->factory->create($this->type, null, $options);
        $form->submit($valueFalse);

        $this->assertTrue($form->isSynchronized());
        $this->assertFalse($form->getData());
    }

    /**
     * @param string $valueTrue
     * @param string $valueFalse
     *
     * @dataProvider providerValueTrueFalse
     */
    public function testInvalidValue($valueTrue, $valueFalse)
    {
        $options = array(
            'value_true' => $valueTrue,
            'value_false' => $valueFalse,
        );

        $form = $this->factory->create($this->type, null, $options);
        $form->submit('foo');

        $this->assertFalse($form->isSynchronized());
        $this->assertNull($form->getData());
    }

    /**
     * @param string $widget
     * @param bool $expanded
     *
     * @dataProvider providerWidget
     */
    public function testWidget($widget, $expanded)
    {
        $options = array(
            'widget' => $widget,
        );

        $form = $this->factory->create($this->type, null, $options);
        $view = $form->createView();

        $this->assertSame($expanded, $view->vars['expanded']);
        $this->assertFalse($view->vars['multiple']);
    }

    public function testHumanize()
    {
        $options = array(
            'value_true' => 'an_underscored__label',
            'value_false' => 'aCamel Cased  Label',
        );

        $form = $this->factory->create($this->type, null, $options);
        $view = $form->createView();

        $this->assertCount(2, $view->vars['choices']);
        $this->assertSame('An underscored label', $view->vars['choices'][0]->label);
        $this->assertSame('A camel cased label', $view->vars['choices'][1]->label);
    }

    /**
     * @return array[]
     */
    public function providerValueTrueFalse()
    {
        return array(
            'true/false' => array('true', 'false'),
            'yes/no' => array('yes', 'no'),
            'on/off' => array('on', 'off'),
            '1/0' => array('1', '0'),
        );
    }

    /**
     * @return array[]
     */
    public function providerWidget()
    {
        return array(
            'choice' => array('choice', false),
            'radio' => array('radio', true),
        );
    }
}
