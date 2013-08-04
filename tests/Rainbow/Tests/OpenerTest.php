<?php

/*
 * This file is part of Opener.
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rainbow\Tests;

use Rainbow\Opener;

class OpenerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Opener
     */
    protected $opener;

    /**
     * @dataProvider dataCommandCreation
     */
    public function testCreatingCommandOnDarwinOS($os, $url, $cmd)
    {
        $this->setSystemType($this->opener, $os);

        $this->assertEquals($cmd, $this->callBuildCommandForUrl($this->opener, $url));
    }

    public function dataCommandCreation()
    {
        return array(
            array(Opener::OS_DARWIN,  'http://google.com', 'open \'http://google.com\''),
            array(Opener::OS_LINUX,   'http://google.com', 'xdg-open \'http://google.com\''),
            array(Opener::OS_WINDOWS, 'http://google.com', 'cmd /c start "" \'http://google.com\''),
        );
    }

    public function testOpeningUrl()
    {
        $this->assertNull($this->opener->open('http://google.com'));
    }

    public function testCallbackAfterOpenCommand()
    {
        $that = $this;

        $mock = $this->getMock('stdClass', array('called'));
        $mock
            ->expects($this->once())
            ->method('called');

        $this->opener->open('http://example.com', function ($res) use ($that, $mock) {
            $mock->called();

            $that->assertStringStartsWith('called command: ', $res);
        });
    }

    protected function setSystemType(Opener $opener, $type)
    {
        $ref = new \ReflectionProperty('Rainbow\\Opener', 'systemType');
        $ref->setAccessible(true);

        $ref->setValue($opener, $type);
    }

    protected function callBuildCommandForUrl(Opener $opener, $url)
    {
        $ref = new \ReflectionMethod($opener, 'buildCommandForUrl');
        $ref->setAccessible(true);

        return $ref->invoke($opener, $url);
    }

    protected function setUp()
    {
        $this->opener = new Stub\OpenerStub();
    }

    protected function tearDown()
    {
        unset($this->opener);
    }
}
