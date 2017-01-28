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

namespace DarkWebDesign\SymfonyAddon\FormType;

use DarkWebDesign\SymfonyAddon\Transformer\BooleanToValueTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Boolean form field type.
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class BooleanType extends AbstractType
{
    /**
     * Builds the form.
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(new BooleanToValueTransformer($options['value_true'], $options['value_false']));
    }

    /**
     * Sets the default options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $self = $this;

        $valueNormalizer = function (Options $options, $value) {
            // PHP converts string array keys containing integers to integers array keys.
            // Make sure that our values are of the same type in order to be able to compare the values.
            return is_numeric($value) && $value / 1 === (int) $value ? (int) $value : $value;
        };

        $labelTrueNormalizer = function (Options $options, $value) use ($self) {
            return !is_null($value) ? (string) $value : $self->humanize($options['value_true']);
        };

        $labelFalseNormalizer = function (Options $options, $value) use ($self) {
            return !is_null($value) ? (string) $value : $self->humanize($options['value_false']);
        };

        $choicesNormalizer = function (Options $options) {
            return array(
                $options['value_true'] => $options['label_true'],
                $options['value_false'] => $options['label_false'],
            );
        };

        $expandedNormalizer = function (Options $options) {
            return 'choice' !== $options['widget'];
        };

        $multipleNormalizer = function () {
            return false;
        };

        $resolver->setDefaults(array(
            'label_false' => null,
            'label_true' => null,
            'value_false' => 'no',
            'value_true' => 'yes',
            'widget' => 'choice',
        ));

        $resolver->setNormalizers(array(
            'value_true' => $valueNormalizer,
            'value_false' => $valueNormalizer,
            'label_true' => $labelTrueNormalizer,
            'label_false' => $labelFalseNormalizer,
            'choices' => $choicesNormalizer,
            'expanded' => $expandedNormalizer,
            'multiple' => $multipleNormalizer,
        ));

        $resolver->setAllowedTypes(array(
            'value_true' => array('string'),
            'value_false' => array('string'),
        ));

        $resolver->setAllowedValues(array(
            'widget' => array('choice', 'radio'),
        ));
    }

    /**
     * Returns the name of the parent type.
     *
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * Returns the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'boolean';
    }

    /**
     * Makes a technical name human readable.
     *
     * @param string $text
     *
     * @return string
     */
    public function humanize($text)
    {
        return ucfirst(trim(strtolower(preg_replace(array('/([A-Z])/', '/[_\s]+/'), array('_$1', ' '), $text))));
    }
}
