<?php

/*
 * This file is part of Opener.
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rainbow;

class Opener
{
    const OS_UNKNOWN = -1;
    const OS_DARWIN  = 1;
    const OS_LINUX   = 2;
    const OS_WINDOWS = 3;

    /**
     * @var int
     */
    private $systemType;

    public function open($url, $callback = null)
    {
        if (is_array($url)) {
            $url = implode(' ', $url);
        }
        $cmd = $this->buildCommandForUrl($url);

        $output = $this->doExec($cmd);

        if (null !== $callback && is_callable($callback)) {
            call_user_func($callback, $output);
        }
    }

    protected function buildCommandForUrl($url)
    {
        $os = $this->detectSystemType();

        return $this->buildSystemCommandForUrl($os, $url);
    }

    protected function buildSystemCommandForUrl($os, $url)
    {
        $safeUrl = escapeshellarg($url);

        if ($os === self::OS_WINDOWS) {
            return $this->buildWindowsCommandForUrl($safeUrl);
        }

        if ($os === self::OS_DARWIN) {
            return $this->buildOpenCommandForUrl('open', $safeUrl);
        }

        if ($os === self::OS_LINUX) {
            return $this->buildOpenCommandForUrl('xdg-open', $safeUrl);
        }

        return null;
    }

    protected function buildWindowsCommandForUrl($safeUrl)
    {
        return sprintf('cmd /c start "" %s', $safeUrl);
    }

    protected function buildOpenCommandForUrl($cmd, $safeUrl)
    {
        return sprintf('%s %s', $cmd, $safeUrl);
    }

    /**
     * This method is for internal testing purposes.  This will be a stub in the unit
     * tests so the actual commands aren't really executed.
     *
     * @param  string $cmd Command to execute
     * @return string Output of the executed command.
     */
    protected function doExec($cmd)
    {
        return exec($cmd);
    }

    protected function detectSystemType()
    {
        if (null === $this->systemType) {
            $this->systemType = $this->doDetectSystemType();
        }

        return $this->systemType;
    }

    /**
     * Detects what the current system OS is by inspecting the `PHP_OS` constant.
     *
     * @return int Integer mapped to one of the Opener::OS_* class constants
     */
    private function doDetectSystemType()
    {
        $os = PHP_OS;

        if (stristr($os, 'DAR')) {
            return self::OS_DARWIN;
        }

        if (stristr($os, 'WIN')) {
            return self::OS_WINDOWS;
        }

        if (stristr($os, 'LINUX')) {
            return self::OS_LINUX;
        }

        return self::OS_UNKNOWN;
    }
}
