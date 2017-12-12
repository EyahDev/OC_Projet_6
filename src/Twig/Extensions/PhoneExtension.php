<?php

namespace App\Twig\Extensions;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PhoneExtension extends AbstractExtension
{
    public function getFilters() {
        return array(
            new TwigFilter('phone', array($this,'phoneFilter')),
        );
    }

    public function phoneFilter($phoneNumber) {
        $firstChain = substr($phoneNumber, 0,2);
        $secondChain = substr($phoneNumber, 2,2);
        $thridChain = substr($phoneNumber, 4,2);
        $fourthChain = substr($phoneNumber, 6,2);
        $fithChain = substr($phoneNumber, 8,2);

        $phoneFormat = $firstChain.' '.$secondChain.' '.$thridChain.' '.$fourthChain.' '.$fithChain;

        return $phoneFormat;
    }
}