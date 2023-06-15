<?php

namespace App\UI\Components\Form;

use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('form_submit', template: '_ui/components/form/submit.html.twig')]
class FormSubmitComponent
{
    public ?FormView $form = null;
    public string $submitField = '';
    public ?string $deletePath = null;
    public array $swal = [];

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefault('submitField', 'submit');
        $resolver->setDefault('deletePath', null);
        $resolver->setDefaults(['swal' => []]);
        $resolver->setRequired('form');
        $resolver->setAllowedTypes('submitField', 'string');
        $resolver->setAllowedTypes('deletePath', ['string', 'null']);
        $resolver->setAllowedTypes('swal', 'array');

        return $resolver->resolve($data);
    }
}
