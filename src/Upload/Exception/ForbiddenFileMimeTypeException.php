<?php
/**
 * This file is part of Vegas package
 *
 * @author Adrian Malik <adrian.malik.89@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage https://bitbucket.org/amsdard/vegas-phalcon
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\Upload\Exception;

use Vegas\Upload\Exception as VegasException;

class ForbiddenFileMimeTypeException extends VegasException
{
    protected $message = 'Forbidden mime type';
}
