<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
     return [
         new TwigFilter('widget', [AppRuntime::class, 'widget'])
     ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getPageUrl', [AppRuntime::class, 'pageUrl'], ['needs_context'=> true]),
        ];
    }
}