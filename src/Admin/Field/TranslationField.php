<?php


namespace App\Admin\Field;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use phpDocumentor\Reflection\Types\Self_;

class TranslationField implements FieldInterface
{
    use FieldTrait;


    public static function new(string $propertyName, ?string $label = null, $fieldConfig = []):self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setFormType(TranslationsType::class)
            ->setFormTypeOptions(
                [
                    'default_locale' => '%locale%',
                    'fields' => $fieldConfig
                ]
            );
    }
}