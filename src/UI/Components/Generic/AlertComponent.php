<?php

namespace App\UI\Components\Generic;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('alert', template: '_ui/components/generic/alert.html.twig')]
class AlertComponent
{
    public string $message;
    public string $type = 'success';
    public string $color = 'green';

    public function mount(string $type = 'success'): void
    {
        $this->color = match ($type) {
            'danger' => 'red',
            'warning' => 'orange',
            default => 'green'
        };
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['type' => 'success']);
        $resolver->setAllowedValues('type', ['success', 'danger', 'warning']);
        $resolver->setRequired('message');
        $resolver->setAllowedTypes('message', 'string');

        return $resolver->resolve($data);
    }
}
