<?php

namespace MakinaCorpus\IbanBundle\Form\Type;

use Symfony\Component\Form\DataTransformerInterface;

class IbanTransformer implements DataTransformerInterface
{
    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if (!is_string($value)) {
            return null;
        }

        $length = strlen($value);

        if ($length < 4) {
            return ['cccd' => $value];
        }

        $ret = [];
        $ret['cccd'] = substr($value, 0, 4);

        foreach (['a', 'b', 'c', 'd', 'e', 'f'] as $i => $key) {

            // String starts at (array offset starts with 0)
            $start = $i * 4 + 4;
            $size = $length - $start;

            if ($size < 4) {
                $ret[$key] = substr($value, $start, $size);

                break; // Do not continue spitting values.

            } else {
                $ret[$key] = substr($value, $start, 4);
            }
        }

        return $ret;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($submitted)
    {
        $value = '';

        foreach (['cccd', 'a', 'b', 'c', 'd', 'e', 'f'] as $key) {
            $value .= trim($submitted[$key]);
        }

        return $value;
    }
}
