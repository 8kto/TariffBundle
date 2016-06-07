<?php

namespace Okto\CzrTaskBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @todo Профиль юзера
 *
 * @author Okto <web@axisful.info>
 */
class ProfileFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('timezone');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }

}
