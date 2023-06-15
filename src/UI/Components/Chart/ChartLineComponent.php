<?php

namespace App\UI\Components\Chart;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('chart_line', template: '_ui/components/chart/line.html.twig')]
class ChartLineComponent
{
    public ?string $remoteUrl = null;
    public int $month = 0;
    public int $year = 0;

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefault('month', intval((new \DateTime())->format('m')));
        $resolver->setDefault('year', intval((new \DateTime())->format('Y')));
        $resolver->setRequired('remoteUrl');
        $resolver->setAllowedTypes('remoteUrl', 'string');
        $resolver->setAllowedTypes('month', ['int']);
        $resolver->setAllowedTypes('year', ['int']);

        return $resolver->resolve($data);
    }
}
