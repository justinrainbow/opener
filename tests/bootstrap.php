<?php

/*
 * This file is part of Opener.
 *
 * (c) Justin Rainbow <justin.rainbow@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

error_reporting(E_ALL | E_STRICT);

// Ensure that composer has installed all dependencies
if (!file_exists(dirname(__DIR__) . '/composer.lock')) {
    echo <<<EOH
Dependencies must be installed using composer:

php composer.phar install --dev


See http://getcomposer.org for help with installing composer
EOH;
    # This StackOverflow answer has great info on common exit codes:
    # http://stackoverflow.com/questions/1101957/are-there-any-standard-exit-status-codes-in-linux
    exit(64);
}

require_once 'PHPUnit/TextUI/TestRunner.php';

// Include the composer autoloader
$autoloader = require dirname(__DIR__) . '/vendor/autoload.php';

$autoloader->add('Rainbow\Tests', 'tests/');
