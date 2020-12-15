<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getPageUrl', [AppRuntime::class, 'pageUrl'], array('need_context'=>true))
        ];
    }
}