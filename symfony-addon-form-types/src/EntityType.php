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

use DarkWebDesign\SymfonyAddon\Transformer\EntityToIdentifierTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Entity form field type.
 *
 * @author Raymond Schouten
 *
 * @since 2.3
 */
class EntityType extends AbstractType
{
    /** @var \Doctrine\Common\Persistence\ManagerRegistry */
    private $registry;

    /**
     * @param \Doctrine\Common\Persistence\ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        $this->registry = $registry;
    }

    /**
     * Builds the form.
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addViewTransformer(new EntityToIdentifierTransformer($options['entity_manager'], $options['class']));
    }

    /**
     * Sets the default options for this type.
     *
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $registry = $this->registry;

        $entityManagerNormalizer = function (Options $options, $entityManager) use ($registry) {
            if (null !== $entityManager) {
                if ($entityManager instanceof ObjectManager) {
                    return $entityManager;
                }

                return $registry->getManager($entityManager);
            }

            $entityManager = $registry->getManagerForClass($options['class']);

            if (null === $entityManager) {
                throw new RuntimeException(sprintf(
                    'Class "%s" seems not to be a managed Doctrine entity. Did you forget to map it?',
                    $options['class']
                ));
            }

            return $entityManager;
        };

        $compoundNormalizer = function () {
            return false;
        };

        $resolver->setDefaults(array(
            'entity_manager' => null,
        ));

        $resolver->setRequired(array(
            'class',
        ));

        $resolver->setNormalizers(array(
            'entity_manager' => $entityManagerNormalizer,
            'compound' => $compoundNormalizer,
        ));

        $resolver->setAllowedTypes(array(
            'entity_manager' => array('null', 'string', 'Doctrine\Common\Persistence\ObjectManager'),
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string
     */
    public function getName()
    {
        return 'entity';
    }
}
