<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('getPageUrl',[ApppRuntime::class,'pageUrl'],['needs_context' => true])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('widget', [ApppRuntime::class, 'widget'])
        ];
    }
}