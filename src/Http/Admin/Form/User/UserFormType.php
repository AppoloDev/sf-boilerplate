<?php

namespace App\Http\Admin\Form\User;

use App\Domain\User\Entity\User;
use AppoloDev\SFToolboxBundle\Form\DataTransformer\ArrayToStringTransformer;
use AppoloDev\SFToolboxBundle\Form\DataTransformer\UppercaseTransformer;
use AppoloDev\SFToolboxBundle\Form\FormType\CardRadioType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
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
            ->add('roles', CardRadioType::class, [
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
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
        ;

        $builder->get('lastname')->addModelTransformer(new UppercaseTransformer());
        $builder->get('roles')->addModelTransformer(
                new ArrayToStringTransformer(['ROLE_ADMIN', 'ROLE_MANAGER', 'ROLE_USER'])
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
