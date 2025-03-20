<?php

namespace App\Http\Auth\Form;

use App\Domain\User\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CreatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'constraints' => [
                    new Length([
                        'min' => 8,
                        'minMessage' => 'form.constraint.password_min_length',
                    ]),
                ],
                'invalid_message' => 'form.constraint.invalid_password',
                'first_options' => [
                    'label' => 'password',
                    'toggle' => true,
                    'hidden_label' => null,
                    'visible_label' => null,
                ],
                'second_options' => [
                    'label' => 'password_repeat',
                ],
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'save',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
