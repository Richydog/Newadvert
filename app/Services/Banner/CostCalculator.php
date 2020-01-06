<?php

namespace App\Services\Banner;

use App\UseCases\Banners\BannerService;

class CostCalculator
{
    private $price;

    public function pris( int $cent)
    {
        $this->price = $cent;
    }

    public function calc(int $views): int
    {
        return floor($this->price * ($views / 1000));
    }
}
