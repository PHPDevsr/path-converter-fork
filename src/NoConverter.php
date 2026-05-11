<?php

declare(strict_types=1);

/**
 * This file is part of PHPDevsr\PathConverter.
 *
 * (c) 2026 Denny Septian Panggabean <xamidimura@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace PHPDevsr\PathConverter;

/**
 * Don't convert paths.
 *
 * Please report bugs on https://github.com/matthiasmullie/path-converter/issues
 *
 * @author Matthias Mullie <pathconverter@mullie.eu>
 * @copyright Copyright (c) 2015, Matthias Mullie. All rights reserved
 * @license MIT License
 */
class NoConverter implements ConverterInterface
{
    public function convert(string $path): string
    {
        return $path;
    }
}
