<?php

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
