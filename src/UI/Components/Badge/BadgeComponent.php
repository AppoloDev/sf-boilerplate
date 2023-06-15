<?php

namespace App\UI\Components\Badge;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('badge', template: '_ui/components/badge/badge.html.twig')]
class BadgeComponent
{
    public string|int $label;
    public ?string $color = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['color' => 'gray']);
        $resolver->setRequired('label');
        $resolver->setAllowedTypes('label', ['string', 'int']);
        $resolver->setAllowedTypes('color', ['string', 'null']);

        return $resolver->resolve($data);
    }
}
