# International Bank Account Number form type for Symfony

Simply gives you a nice widget for IBAN numbers, please note that it's based on
the default bootstrap form theme (any of the normal or horizontal one).

# Installation

Install the package:

```sh
composer require makinacorpus/iban-bundle
```

Register the associated form theme in your ``app/config.yml`` file:

```yaml
twig:
    debug:            "%kernel.debug%"
    strict_variables: false
    form_themes:
        # ...
        - "IbanBundle:Form:fields.html.twig"
```

# Usage

The widget has no options. Just add it to your form:

```php
    $this->createFormBuilder()
        ->add('iban', IbanType::class, [
            'label'       => "IBAN",
            'required'    => true,
            'constraints' => [
                new Assert\Iban(),
            ],
        ])
```

Please use the ``Symfony\Component\Validator\Constraints\Iban`` class for
validation, it does respect the *ISO 7064* standard.
