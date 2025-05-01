const { src, dest, series, parallel, watch, task } = require('gulp');
const replace = require('gulp-replace');

const newPluginVersion = '3.0.1'; // Latest version number
const latestWpTest = '6.8'; // Latest WP version number tested
const minWpVersion = '5.0'; // Min WP version number supported
const minPhpVersion = '7.0'; // Min PHP version number required
const authorName = 'Rodgath';
const authorUrl = `https://github.com/${authorName}`
const pluginUrl = `https://github.com/${authorName}/dilaz-panel`

const headerCommentBlock = `/*
 * Plugin Name:       Dilaz Panel
 * Plugin URI:        ${pluginUrl}
 * Description:       Simple options panel for WordPress themes and plugins.
 * Requires at least: ${minWpVersion}
 * Requires PHP:      ${minPhpVersion}
 * Author:            ${authorName}
 * Author URI:        ${authorUrl}
 * Text Domain:       dilaz-panel
 * Domain Path:       /languages
 * Version:           ${newPluginVersion}
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
||
|| --------------------------------------------------------------------------------------------
|| Admin Options Panel
|| --------------------------------------------------------------------------------------------
||
|| @package     Dilaz Panel
|| @subpackage  Panel
|| @version     ${newPluginVersion}
|| @since       Dilaz Panel 1.0.0
|| @author      ${authorName}, ${authorUrl}
|| @copyright   Copyright (C) 2017 - ${new Date().getFullYear()}, ${authorName}
|| @link        ${pluginUrl}
|| @License     GPL-2.0+
|| @License URI http://www.gnu.org/licenses/gpl-2.0.txt
||
*/`;

task('update-plugin-header', function () {
  return src('./dilaz-panel.php')
        .pipe(replace(/\/\*[\s\S]*?\*\//, headerCommentBlock)) // Non-greedy match for comment block
        .pipe(dest('./'));
});

task('update-readme', function () {
  return src('./readme.txt')
        .pipe(replace(/(Requires at least:)\s*[\d.]+/g, `$1 ${minWpVersion}`))
        .pipe(replace(/(Tested up to:)\s*[\d.]+/g, `$1 ${latestWpTest}`))
        .pipe(replace(/(Stable tag:)\s*[\d.]+/g, `$1 ${newPluginVersion}`))
        .pipe(replace(/(Requires PHP:)\s*[\d.]+/g, `$1 ${minPhpVersion}`))
        .pipe(dest('./'));
});

task('default', series('update-plugin-header', 'update-readme'));