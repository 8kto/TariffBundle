<?php

namespace TariffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\CardScheme;
use Symfony\Component\Validator\Constraints\NotBlank;

class OrderType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('tariff', TextType::class, [
                    'label' => 'Тариф',
                    'attr'  => ['disabled' => true]
                ])
                ->add('purchase_data', CollectionType::class, array(
                    'entry_type' => PurchaseDataType::class,
                    'label'      => false,
                    'mapped'     => false
                ))
                ->add('p_code_cart', TextType::class, [
                    'label'       => 'Код карточки',
                    'mapped'      => false,
                    'constraints' => array(
                        new NotBlank(),
//                        new CardScheme([ 'schemes' => "VISA"])
                    ),
                ])
                ->add('p_code_ccv', null, [
                    'label'       => 'Код CCV',
                    'mapped'      => false,
                    'constraints' => array(
                        new NotBlank(),
                        new Length(array('min' => 3)),
                    ),
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TariffBundle\Entity\Order'
        ));
    }

}
