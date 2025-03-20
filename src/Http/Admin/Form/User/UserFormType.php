<?php

namespace App\Http\Admin\Form\User;

use App\Domain\User\Entity\User;
use AppoloDev\SFToolboxBundle\Form\DataTransformer\ArrayToStringTransformer;
use AppoloDev\SFToolboxBundle\Form\DataTransformer\UppercaseTransformer;
use AppoloDev\SFToolboxBundle\Form\FormType\CardRadioType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'firstname',
                'required' => true,
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'lastname',
                'required' => true,
                'attr' => [
                    'style' => 'text-transform: uppercase;',
                ],
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'email',
                'required' => true,
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
                'help' => 'email_will_be_used_as_your_login',
                'help_html' => true,
            ])
            ->add('roles', CardRadioType::class, [
                'label' => 'roles',
                'choices' => [
                    'administrator' => 'ROLE_ADMIN',
                    'user' => 'ROLE_USER',
                ],
                'required' => true,
                'multiple' => false,
                'constraints' => [
                    new NotNull(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'save',
            ])
        ;

        $builder->get('lastname')->addModelTransformer(new UppercaseTransformer());
        $builder->get('roles')->addModelTransformer(
            new ArrayToStringTransformer(['ROLE_ADMIN', 'ROLE_USER'])
        )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
