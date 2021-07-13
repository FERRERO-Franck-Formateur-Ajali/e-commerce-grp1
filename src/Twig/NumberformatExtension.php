<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class NumberformatExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('total', [$this, 'total']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('total', [$this, 'total']),
            new TwigFunction('promo', [$this, 'promo']),
            new TwigFunction('totalPromo', [$this, 'totalPromo']),
        ];
    }

    public function total($total)
    {
        return number_format($total, '2', ',', '').' €';
    }

    public function promo($prix, $promo)
    {
        return number_format(round(($prix * (1 -($promo / 100))), 2), '2', ',', '').' €/Kg';
    }

    public function totalPromo($prix, $promo, $quantite)
    {
        return number_format(round(($prix * (1 -($promo / 100))), 2) * $quantite, '2', ',', '').' €';
    }
}
