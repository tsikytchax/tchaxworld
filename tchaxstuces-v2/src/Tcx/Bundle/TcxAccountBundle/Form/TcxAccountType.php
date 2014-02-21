<?php

namespace Tcx\Bundle\TcxAccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TcxAccountType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('username', 'text', array(
        		'required' => true
        	))
            ->add('birthday', 'birthday', array(
				'required' => true
            ))
            ->add('email', 'email', array(
        		'required' => true,
        	))
            ->add('password', 'password', array(
        		'required' => true,
            	'max_length' => 16
        	))
            ->add('tcxAccountAvatarFile', 'file') 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Tcx\Bundle\TcxAccountBundle\Entity\TcxAccount'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tcx_bundle_tcxaccountbundle_tcxaccount';
    }
}
