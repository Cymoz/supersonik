<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('widget', [AppRuntime::class, 'widget'])
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getPageUrl',[AppRuntime::class,'pageUrl'],array('needs_context'=>true)),
        ];
    }
}
