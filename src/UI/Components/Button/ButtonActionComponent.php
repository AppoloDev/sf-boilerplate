<?php

namespace App\UI\Components\Button;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('button_action', template: '_ui/components/button/action.html.twig')]
class ButtonActionComponent
{
    public ?bool $permission = null;
    public ?string $path = null;
    public string $class = '';
    public ?string $icon = null;
    public ?string $iconClass = null;
    public ?string $labelBefore = null;
    public ?string $labelAfter = null;
    public ?string $tooltip = null;
    public ?string $target = null;
    public array $swal = [];

    public function mount(?bool $permission): void
    {
        $this->permission = is_null($permission) ? true : $permission;
    }

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['permission' => null]);
        $resolver->setDefaults(['path' => null]);
        $resolver->setDefaults(['class' => '']);
        $resolver->setDefaults(['icon' => null]);
        $resolver->setDefaults(['iconClass' => null]);
        $resolver->setDefaults(['target' => null]);
        $resolver->setDefaults(['labelBefore' => null]);
        $resolver->setDefaults(['labelAfter' => null]);
        $resolver->setDefaults(['tooltip' => null]);
        $resolver->setDefaults(['swal' => []]);
        $resolver->setRequired('icon');
        $resolver->setAllowedTypes('permission', ['bool', 'null']);
        $resolver->setAllowedTypes('path', ['string', 'null']);
        $resolver->setAllowedTypes('class', 'string');
        $resolver->setAllowedTypes('icon', ['string', 'null']);
        $resolver->setAllowedTypes('iconClass', ['string', 'null']);
        $resolver->setAllowedTypes('target', ['string', 'null']);
        $resolver->setAllowedTypes('labelBefore', ['string', 'null']);
        $resolver->setAllowedTypes('labelAfter', ['string', 'null']);
        $resolver->setAllowedTypes('tooltip', ['string', 'null']);
        $resolver->setAllowedTypes('swal', 'array');

        return $resolver->resolve($data);
    }
}
