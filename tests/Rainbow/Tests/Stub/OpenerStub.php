<?php

/*
 * This file is part of Opener.
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rainbow\Tests\Stub;

use Rainbow\Opener as RealOpener;

class OpenerStub extends RealOpener
{
    protected function doExec($cmd)
    {
        return sprintf('called command: %s', $cmd);
    }
}
