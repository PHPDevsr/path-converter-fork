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

namespace PHPDevsr\PathConverter\Tests;

use PHPDevsr\PathConverter\NoConverter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Converter test case.
 *
 * @internal
 */
final class NoConverterTest extends TestCase
{
    /**
     * Test Converter, provided by dataProvider.
     */
    #[DataProvider('provideConvertCases')]
    public function testConvert(string $relative, string $expected): void
    {
        $converter = new NoConverter();
        $result = $converter->convert($relative);

        self::assertSame($expected, $result);
    }

    public static function provideConvertCases(): iterable
    {
        yield [
           '../images/img.jpg',
           '../images/img.jpg',
        ];

        yield [
            '../../images/icon.gif',
            '../../images/icon.gif',
        ];

        yield [
            '/home/username/file.txt',
            '/home/username/file.txt',
        ];

        yield [
            'image.jpg',
            'image.jpg',
        ];

        yield [
            '../images/img.jpg',
            '../images/img.jpg',
        ];

        yield [
            '../images/img.jpg',
            '../images/img.jpg',
        ];

        yield [
            'image.jpg',
            'image.jpg',
        ];
    }
}
