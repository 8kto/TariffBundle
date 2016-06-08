<?php

namespace TariffBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use TariffBundle\Entity\Feature;
use TariffBundle\Entity\User;

/**
 * Description of FeatureConcreteType
 *
 * @author Okto <web@axisful.info>
 */
class FeatureConcreteType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('feature', EntityType::class, array(
                    'class'    => Feature::class,
                    'label' => false,
                    'required' => true,
//                    'choices_as_values' => true,
//                    'choices' => $user->getCategories(),
                    'attr' => array('data-live-search' => true)
//                    'multiple' => true,
//                    'expanded' => true,
                ))
                ->add('value', null, [
                    'label' => 'Значение'
                ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'TariffBundle\Entity\FeatureConcrete',
        ));
    }

}
