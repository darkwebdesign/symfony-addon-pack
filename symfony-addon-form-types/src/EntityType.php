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

namespace DarkWebDesign\SymfonyAddonFormTypes;

use DarkWebDesign\SymfonyAddonTransformers\EntityToIdentifierTransformer;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Exception\RuntimeException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

if (!interface_exists(ManagerRegistry::class)) {
    throw new \LogicException('You cannot use "DarkWebDesign\SymfonyAddonFormTypes\EntityType" as the "doctrine/persistence" package is not installed. Try running "composer require doctrine/persistence:^1.0".');
}

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
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (!class_exists(EntityToIdentifierTransformer::class)) {
            throw new \LogicException(sprintf('You cannot use "%s" as the "darkwebdesign/symfony-addon-transformers" package is not installed. Try running "composer require darkwebdesign/symfony-addon-transformers".', __CLASS__));
        }

        $builder->addViewTransformer(new EntityToIdentifierTransformer($options['entity_manager'], $options['class']));
    }

    /**
     * Configures the options for this type.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        if (!interface_exists(ObjectManager::class)) {
            throw new \LogicException(sprintf('You cannot use "%s" as the "doctrine/persistence" package is not installed. Try running "composer require doctrine/persistence:^1.0".', __CLASS__));
        }

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

        $resolver->setDefaults([
            'entity_manager' => null,
        ]);

        $resolver->setRequired([
            'class',
        ]);

        $resolver->setNormalizer('entity_manager', $entityManagerNormalizer);
        $resolver->setNormalizer('compound', $compoundNormalizer);

        $resolver->setAllowedTypes('entity_manager', [
            'null',
            'string',
            ObjectManager::class,
        ]);
    }
}
