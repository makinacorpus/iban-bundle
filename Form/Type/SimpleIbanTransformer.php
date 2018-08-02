<?php

namespace MakinaCorpus\IbanBundle\Form\Type;

use Symfony\Component\Form\DataTransformerInterface;

class SimpleIbanTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return \is_string($value) ? ['value' => $value] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($submitted)
    {
        return \is_array($submitted) ? ($submitted['value'] ?? null) : null;
    }
}
