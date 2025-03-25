<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/sulu.php';

import(__DIR__ . '/hosts.yaml');

add('shared_files', [
    '.env',
    'public/.htaccess',
    'public/robots.txt'
]);
add('shared_dirs', []);
add('writable_dirs', []);
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

task('deploy:prepare', [
    'local:composer:install',
    'local:npm:install',
    'local:npm:build',
    'deploy:info',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:env',
    'deploy:shared',
    'deploy:writable',
]);

task('deploy', [
    'deploy:prepare',
    'deploy:cache:clear',
    'deploy:publish',
]);

after('deploy:failed', 'deploy:unlock');
