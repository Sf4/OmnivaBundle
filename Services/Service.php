<?php

namespace Sf4\OmnivaBundle\Services;

use MyCLabs\Enum\Enum;

/**
 * Class Service
 * @method static Service TERMINAL()
 * @method static Service COURIER()
 * @method static Service COURIER_LT_LV()
 * @method static Service POST_OFFICE()
 * @package Sf4\OmnivaBundle\Services
 */
class Service extends Enum
{
    private const SMS = 'ST';
    private const EMAIL = 'SF';
    private const COD = 'BP';
    private const TERMINAL = 'PP';
    private const POST_OFFICE = 'CD';
    private const COURIER = 'QP';
    private const COURIER_LT_LV = 'QH';
}
