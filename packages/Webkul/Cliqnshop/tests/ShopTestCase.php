<?php

namespace Webkul\Cliqnshop\Tests;

use Tests\TestCase;
use Webkul\Core\Tests\Concerns\CoreAssertions;
use Webkul\Cliqnshop\Tests\Concerns\ShopTestBench;

class ShopTestCase extends TestCase
{
    use CoreAssertions, ShopTestBench;
}
