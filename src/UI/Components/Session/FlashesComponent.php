<?php

namespace App\UI\Components\Session;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('flashes', template: '_ui/components/session/flashes.html.twig')]
class FlashesComponent
{
    public array $flashes;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['flashes' => []]);
        $resolver->setRequired('flashes');
        $resolver->setAllowedTypes('flashes', 'array');

        return $resolver->resolve($data);
    }
}
