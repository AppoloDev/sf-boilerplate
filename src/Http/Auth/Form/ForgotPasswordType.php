<?php

namespace App\Http\Auth\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ForgotPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Réinitialiser le mot de passe',
            ]);
    }
}
