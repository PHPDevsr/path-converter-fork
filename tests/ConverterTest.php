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

use PHPDevsr\PathConverter\Converter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Converter test case.
 *
 * @internal
 */
final class ConverterTest extends TestCase
{
    /**
     * Test Converter, provided by dataProvider.
     */
    #[DataProvider('provideConvertCases')]
    public function testConvert(string $relative, string $from, string $to, string $expected): void
    {
        $converter = new Converter($from, $to, '/');
        $result = $converter->convert($relative);

        self::assertSame($expected, $result);
    }

    public static function provideConvertCases(): iterable
    {
        yield [
           '../images/img.jpg',
           '/home/forkcms/frontend/core/layout/css',
           '/home/forkcms/frontend/cache/minified_css',
           '../../core/layout/images/img.jpg',
        ];

        yield [
            '../../images/icon.gif',
            '/css/imports/',
            '/css/',
            '../images/icon.gif',
        ];

        yield [
            '/home/username/file.txt',
            '/css/imports',
            '/css',
            '/home/username/file.txt',
        ];

        yield [
            'image.jpg',
            'tests/css/sample/convert_relative_path/source',
            'tests/css/sample/convert_relative_path/source',
            'image.jpg',
        ];

        yield [
            '../images/img.jpg',
            'C:/My Documents/forkcms/frontend/core/layout/css',
            'C:/My Documents/forkcms/frontend/cache/minified_css',
            '../../core/layout/images/img.jpg',
        ];

        yield [
            '../images/img.jpg',
            '/Users/mathias/Documents/— Projecten/PROJECT_NAAM/Web/src/Backend/Core/Layout/Css/',
            '/Users/mathias/Documents/— Projecten/PROJECT_NAAM/Web/src/Backend/Cache/MinifiedCss/',
            '../../Core/Layout/images/img.jpg',
        ];

        yield [
            'image.jpg',
            '/var/www/mysite.com/assets/some_random_folder_name/',
            '/var/www/mysite.com/assets/some_other_random_folder_name/',
            '../some_random_folder_name/image.jpg',
        ];

        yield [
            'image.jpg',
            '/var/www/',
            '/',
            'var/www/image.jpg',
        ];

        yield [
            'image.jpg',
            '/',
            '/var/www/',
            '../../image.jpg',
        ];

        yield [
            'rotissanser-webfont.eot',
            'typo3temp/assets/compressed/../../../typo3conf/ext/user_merkl/Resources/Public/Fonts/webfontkit-rotissanser/stylesheet.css',
            'typo3temp/assets/compressed/merged-abce7d875ee92a78bd5e1871ef774fbe.css',
            '../../../typo3conf/ext/user_merkl/Resources/Public/Fonts/webfontkit-rotissanser/rotissanser-webfont.eot',
        ];

        yield [
            './../images/header-section/HeroImage.jpg',
            '/wordpress/wp-content/themes/racine/styles/',
            '/wordpress/wp-content/cache/min/',
            '../../themes/racine/images/header-section/HeroImage.jpg',
        ];

        yield [
            '../images/./header-section/HeroImage2.jpg',
            '/wordpress/wp-content/themes/racine/styles/',
            '/wordpress/wp-content/cache/min/',
            '../../themes/racine/images/header-section/HeroImage2.jpg',
        ];
    }
}
