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
        $firstChain = substr($phoneNumber, 0,1);
        $secondChain = substr($phoneNumber, 1,2);
        $thridChain = substr($phoneNumber, 3,2);
        $fourthChain = substr($phoneNumber, 5,2);
        $fithChain = substr($phoneNumber, 7,2);

        $phoneFormat = $firstChain.' '.$secondChain.' '.$thridChain.' '.$fourthChain.' '.$fithChain;

        return $phoneFormat;
    }
}