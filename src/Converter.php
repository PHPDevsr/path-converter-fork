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
 * Convert paths relative from 1 file to another.
 *
 * E.g.
 *     ../../images/icon.jpg relative to /css/imports/icons.css
 * becomes
 *     ../images/icon.jpg relative to /css/minified.css
 *
 * Please report bugs on https://github.com/matthiasmullie/path-converter/issues
 *
 * @author Matthias Mullie <pathconverter@mullie.eu>
 * @copyright Copyright (c) 2015, Matthias Mullie. All rights reserved
 * @license MIT License
 */
class Converter implements ConverterInterface
{
    protected string $from;
    protected string $to;

    /**
     * @param string $from The original base path (directory, not file!)
     * @param string $to   The new base path (directory, not file!)
     * @param string $root Root directory (defaults to `getcwd`)
     */
    public function __construct(string $from, string $to, string $root = '')
    {
        $shared = $this->shared($from, $to);

        if ('' === $shared) {
            // when both paths have nothing in common, one of them is probably
            // absolute while the other is relative
            $root = $root ?: (string) getcwd();
            $from = str_starts_with($from, $root) ? $from : preg_replace('/\/+/', '/', $root.'/'.$from);
            $to = str_starts_with($to, $root) ? $to : preg_replace('/\/+/', '/', $root.'/'.$to);

            // or traveling the tree via `..`
            // attempt to resolve path, or assume it's fine if it doesn't exist
            $from = @realpath($from) ?: $from;
            $to = @realpath($to) ?: $to;
        }

        $from = $this->dirname($from);
        $to = $this->dirname($to);

        $from = $this->normalize($from);
        $to = $this->normalize($to);

        $this->from = $from;
        $this->to = $to;
    }

    /**
     * Convert paths relative from 1 file to another.
     *
     * E.g.
     *     ../images/img.gif relative to /home/forkcms/frontend/core/layout/css
     * should become:
     *     ../../core/layout/images/img.gif relative to
     *     /home/forkcms/frontend/cache/minified_css
     *
     * @param string $path The relative path that needs to be converted
     *
     * @return string The new relative path
     */
    public function convert(string $path): string
    {
        // quit early if conversion makes no sense
        if ($this->from === $this->to) {
            return $path;
        }

        $path = $this->normalize($path);

        // if we're not dealing with a relative path, just return absolute
        if (str_starts_with($path, '/')) {
            return $path;
        }

        // normalize paths
        $path = $this->normalize($this->from.'/'.$path);

        // strip shared ancestor paths
        $shared = $this->shared($path, $this->to);
        $lenShared = mb_strlen($shared);
        $path = mb_substr($path, $lenShared);
        $to = mb_substr($this->to, $lenShared);

        // add .. for every directory that needs to be traversed to new path
        $to = str_repeat('../', \count(array_filter(explode('/', $to))));

        return $to.ltrim($path, '/');
    }

    /**
     * Normalize path.
     */
    protected function normalize(string $path): string
    {
        // deal with different operating systems' directory structure
        $path = rtrim(str_replace(\DIRECTORY_SEPARATOR, '/', $path), '/');

        // remove leading current directory.
        if (str_starts_with($path, './')) {
            $path = substr($path, 2);
        }

        // remove references to current directory in the path.
        $path = str_replace('/./', '/', $path);

        /*
         * Example:
         *     /home/forkcms/frontend/cache/compiled_templates/../../core/layout/css/../images/img.gif
         * to
         *     /home/forkcms/frontend/core/layout/images/img.gif
         */
        do {
            $path = preg_replace('/[^\/]+(?<!\.\.)\/\.\.\//', '', (string) $path, -1, $count);
        } while ($count);

        return $path;
    }

    /**
     * Figure out the shared path of 2 locations.
     *
     * Example:
     *     /home/forkcms/frontend/core/layout/images/img.gif
     * and
     *     /home/forkcms/frontend/cache/minified_css
     * share
     *     /home/forkcms/frontend
     */
    protected function shared(string $path1 = '', string $path2 = ''): string
    {
        // $path could theoretically be empty (e.g. no path is given), in which
        // case it shouldn't expand to array(''), which would compare to one's
        // root /
        $path1 = $path1 !== '' && $path1 !== '0' ? explode('/', $path1) : [];
        $path2 = $path2 !== '' && $path2 !== '0' ? explode('/', $path2) : [];

        $shared = [];

        // compare paths & strip identical ancestors
        foreach ($path1 as $i => $chunk) {
            if (isset($path2[$i]) && $path1[$i] === $path2[$i]) {
                $shared[] = $chunk;
            } else {
                break;
            }
        }

        return implode('/', $shared);
    }

    /**
     * Attempt to get the directory name from a path.
     */
    protected function dirname(string $path): string
    {
        if (@is_file($path)) {
            return \dirname($path);
        }

        if (@is_dir($path)) {
            return rtrim($path, '/');
        }

        // no known file/dir, start making assumptions

        // ends in / = dir
        if (mb_substr($path, -1) === '/') {
            return rtrim($path, '/');
        }

        // has a dot in the name, likely a file
        if (preg_match('/.*\..*$/', basename($path)) !== 0) {
            return \dirname($path);
        }

        // you're on your own here!
        return $path;
    }
}
