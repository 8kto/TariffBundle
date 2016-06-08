<?php

namespace TariffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PurchaseDataType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('Код карточки', TextType::class, [
                    'label' => 'Название'
                ])
                ->add('Код CCV', null, [
                    'label' => 'Название'
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
//            'data_class' => 'TariffBundle\Entity\Order'
            'mapped' => false
        ));
    }

}
