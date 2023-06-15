<?php

namespace App\UI\Components\Form;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\PostMount;
use Symfony\UX\TwigComponent\Attribute\PreMount;

#[AsTwigComponent('form_wizard', template: '_ui/components/form/wizard.html.twig')]
class FormWizardComponent
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

     public array $steps = [];

    public string $activeClass = '';
    public string $disableClass = '';

    #[PreMount]
    public function preMount(array $data): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(['steps' => []]);
        $resolver->setDefaults(['activeClass' => '']);
        $resolver->setDefaults(['disableClass' => '']);
        $resolver->setRequired('steps');
        $resolver->setAllowedTypes('activeClass', 'string');
        $resolver->setAllowedTypes('disableClass', 'string');
        $resolver->setAllowedTypes('steps', ['array']);

        return $resolver->resolve($data);
    }

    #[PostMount]
    public function postMount(): void
    {
        $request = $this->requestStack->getCurrentRequest();

        if (!is_null($request)) {
            foreach ($this->steps as &$step) {
                if (isset($step['disableCondition']) && $step['disableCondition']) {
                    $step['class'] = $this->disableClass;
                } elseif ($request->attributes->get('_route') === $step['route']) {
                    $step['class'] = $this->activeClass;
                    $step['path'] = $this->urlGenerator->generate($step['route'], (array) $request->attributes->get('_route_params'));
                } else {
                    $step['path'] = $this->urlGenerator->generate($step['route'], (array) $request->attributes->get('_route_params'));
                }
            }
        }
    }
}
