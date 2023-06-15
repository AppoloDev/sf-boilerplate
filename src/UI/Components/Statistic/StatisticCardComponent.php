<?php

namespace App\UI\Components\Statistic;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('statistic_card', template: '_ui/components/statistic/card.html.twig')]
class StatisticCardComponent
{
    public int $number = 0;
    public string $title = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['title' => '']);
        $resolver->setDefaults(['number' => 0]);
        $resolver->setAllowedTypes('title', 'string');
        $resolver->setAllowedTypes('number', ['int']);

        return $resolver->resolve($data);
    }
}
