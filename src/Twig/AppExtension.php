<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
     
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getPageUrl', [AppRuntime::class, 'pageUrl'], ['needs_context'=> true]),
        ];
    }
}