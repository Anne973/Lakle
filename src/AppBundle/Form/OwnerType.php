<?php
/**
 * Created by PhpStorm.
 * User: Anne
 * Date: 26/01/2018
 * Time: 21:26
 */

namespace AppBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OwnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('phone', TelType::class)
            ->add('email', EmailType::class)
            ->add('attachments', CollectionType::class, array(
               'entry_type' => FileType::class,
               'entry_options' => array(
                   'attr' => array ('class' => 'attachment-box')
               ),
                'allow_add' => true,
                'prototype' => true,
                'allow_delete' => true,
            ))
            ->add('message', TextareaType::class, array('required' => false))

        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(

        ));
    }
}