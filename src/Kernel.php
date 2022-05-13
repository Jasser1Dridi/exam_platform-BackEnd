<?php

namespace App;
ini_set('memory_limit', '1024M');
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;


class Kernel extends BaseKernel
{
    use MicroKernelTrait;


}
