<?php

namespace TariffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TariffType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name', null, [
                    'label' => 'Название'
                ])
                ->add('description', TextareaType::class, [
                    'attr'  => array('class' => 'tinymce'),
                    'label' => 'Описание'
                ])
                ->add('active', null, [
                    'label' => 'Активный'
                ])
                ->add('price', null, [
                    'label' => 'Цена, $'
                ])
                ->add('features', CollectionType::class, array(
                    'entry_type'   => FeatureConcreteType::class,
                    'allow_add'    => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                    'label'        => false
                ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TariffBundle\Entity\Tariff'
        ));
    }

}
