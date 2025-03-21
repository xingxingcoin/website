<?php

declare(strict_types=1);

namespace Xing\Deployer;

use function Deployer\import;
use function Deployer\runLocally;
use function Deployer\set;
use function Deployer\task;

require_once  'recipe/common.php';

import(__DIR__ . '/hosts.yaml');

set('shared_files', [
    '.env',
    'public/.htaccess',
    'public/robots.txt'
]);
set('shared_dirs', [
    'public/uploads',
    'var/uploads',
    'var/log'
]);
set('writable_dirs', [
    'var',
    'public/uploads'
]);
set('do_not_deploy', [
    '.ddev',
    '.deploy',
    'docs',
    'tests',
    '.gitignore',
    '.env.dev',
    'LICENSE',
    'phpunit.xml',
    'psalm.xml',
    'infection.json5',
    'README.md'
]);

task('local:composer:install', static function (): void {
    runLocally('composer install');
});
task('local:npm:install', static function (): void {
    runLocally('npm install');
});
task('local:npm:build', static function (): void {
    runLocally('npm run build');
});

task('deploy', [
    'local:composer:install',
    'local:npm:install',
    'local:npm:build',
    'deploy:lock',
    'deploy:unlock'
]);
