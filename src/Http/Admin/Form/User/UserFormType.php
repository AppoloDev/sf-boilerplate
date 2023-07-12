<?php

namespace App\Http\Admin\Form\User;

use App\Domain\User\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
                'label' => 'Prénom',
                'required' => true,
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'required' => true,
                'attr' => [
                    'style' => 'text-transform: uppercase;',
                ],
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                ],
                // TODO: DataTransformer TO Uppercase --> Toolbox
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ],
                'help' => 'L\'email sera <strong>utilisé</strong> comme identifiant pour se connecter',
                'help_html' => true
            ])
            ->add('roles', ChoiceType::class, [
                'label' => 'Rôles',
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'required' => true,
                'multiple' => false,
                'constraints' => [
                    new NotNull(),
                ],
                // TODO : Mettre un CustomRadioType
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
            ->get('roles')->addModelTransformer(new CallbackTransformer(
                function ($transofmrItem) {
                    if (in_array('ROLE_ADMIN', $transofmrItem)) {
                        return 'ROLE_ADMIN';
                    }

                    if (in_array('ROLE_MANAGER', $transofmrItem)) {
                        return 'ROLE_MANAGER';
                    }

                    return 'ROLE_USER';
                },
                function ($reverseItem) {
                    return [$reverseItem];
                }
                // TODO: A refactor et mettre dans la toolbox
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
