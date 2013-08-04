<?php

namespace Rainbow\Tests\Stub;

use Rainbow\Opener as RealOpener;

class OpenerStub extends RealOpener
{
    protected function doExec($cmd)
    {
        return sprintf('called command: %s', $cmd);
    }
}
