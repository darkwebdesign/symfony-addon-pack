<?php

/**
 * Copyright (c) 2017 DarkWeb Design.
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

namespace DarkWebDesign\SymfonyAddonFormTypes;

use DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class BooleanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (!class_exists(BooleanToValueTransformer::class)) {
            throw new \LogicException(sprintf('You cannot use "%s" as the "darkwebdesign/symfony-addon-transformers" package is not installed. Try running "composer require darkwebdesign/symfony-addon-transformers".', self::class));
        }

        $builder->addModelTransformer(new BooleanToValueTransformer($options['value_true'], $options['value_false']));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $labelTrueNormalizer = fn (Options $options, $value) => !is_null($value) ? (string) $value : $this->humanize((string) $options['value_true']);
        $labelFalseNormalizer = fn (Options $options, $value) => !is_null($value) ? (string) $value : $this->humanize((string) $options['value_false']);

        $choicesNormalizer = fn (Options $options) => [
            $options['label_true'] => $options['value_true'],
            $options['label_false'] => $options['value_false'],
        ];

        $expandedNormalizer = fn (Options $options) => 'choice' !== $options['widget'];

        $multipleNormalizer = fn () => false;

        $resolver->setDefaults([
            'label_true' => null,
            'label_false' => null,
            'value_true' => 'yes',
            'value_false' => 'no',
            'widget' => 'choice',
        ]);

        $resolver->setNormalizer('label_true', $labelTrueNormalizer);
        $resolver->setNormalizer('label_false', $labelFalseNormalizer);
        $resolver->setNormalizer('choices', $choicesNormalizer);
        $resolver->setNormalizer('expanded', $expandedNormalizer);
        $resolver->setNormalizer('multiple', $multipleNormalizer);

        $resolver->setAllowedTypes('value_true', ['string', 'integer', 'float']);
        $resolver->setAllowedTypes('value_false', ['string', 'integer', 'float']);
        $resolver->setAllowedTypes('label_true', ['string', 'null']);
        $resolver->setAllowedTypes('label_false', ['string', 'null']);

        $resolver->setAllowedValues('widget', ['choice', 'radio']);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    /**
     * Makes a technical name human-readable.
     */
    public function humanize(string $text): string
    {
        return ucfirst(trim(strtolower((string) preg_replace(['/([A-Z])/', '/[_\s]+/'], ['_$1', ' '], $text))));
    }
}
