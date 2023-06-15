<?php

namespace App\UI\Components\Badge;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('badge_yesno', template: '_ui/components/badge/yesno.html.twig')]
class BadgeYesNoComponent
{
    public bool $value;
    public ?string $labelTrue = null;
    public ?string $labelFalse = null;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['labelTrue' => null]);
        $resolver->setDefaults(['labelFalse' => null]);
        $resolver->setRequired('value');
        $resolver->setAllowedTypes('value', ['bool']);
        $resolver->setAllowedTypes('labelTrue', ['string', 'null']);
        $resolver->setAllowedTypes('labelFalse', ['string', 'null']);

        return $resolver->resolve($data);
    }
}
