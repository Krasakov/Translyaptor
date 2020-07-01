<?php

namespace App\Form;

use App\Entity\TextItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control css-textarea',
                    'rows' => 30,
                    'minlength' => 3,
                    'placeholder' => "Enter text...",
                ],
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TextItem::class,
        ]);
    }
}