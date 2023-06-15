<?php

namespace App\UI\Components\User;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('user_profile_menu', template: '_ui/components/user/profile_menu.html.twig')]
class UserProfileMenu
{
    public string $routePrefix = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefault('routePrefix', 'front');
        $resolver->setAllowedTypes('routePrefix', ['string']);

        return $resolver->resolve($data);
    }
}
