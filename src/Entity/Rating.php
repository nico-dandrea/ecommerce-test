<?php

namespace App\Entity;

class Rating
{
    private $rate;
    private $count;

    public function __construct($rate, $count)
    {
        $this->rate = $rate;
        $this->count = $count;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getCount()
    {
        return $this->count;
    }
}