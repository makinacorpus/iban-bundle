<?php

namespace MakinaCorpus\IbanBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Simple IBAN input with only one fat input field.
 */
class SimpleIbanType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // CCCD (Country Code, Check Digits)
            ->add('value', TextType::class, [
                'required' => true,
                'attr' => [
                    'maxlength' => 50, // reserve space for whitespace and -
                    'placeholder' => 'FR76 1234 5678 9012 3456 7890 1234',
                    'size' => 50,
                    'style' => 'width: auto;',
                ],
            ])
            ->addModelTransformer(new SimpleIbanTransformer())
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'error_bubbling' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'iban_simple';
    }
}
