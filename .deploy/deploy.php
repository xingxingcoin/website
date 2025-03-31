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
set('writable_mode', 'sticky');

task('local:composer:install', static function (): void {
    runLocally('composer install');
});
task('local:npm:install', static function (): void {
    runLocally('npm install');
});
task('local:npm:build', static function (): void {
    runLocally('npm run build');
});
task('deploy:update_code', static function (): void {
   $doNotDeploy = get('do_not_deploy');
   foreach ($doNotDeploy as $item) {
       runLocally('run -RF ' . $item);
   }

   upload('.', '{{release_path}}');
});

task('deploy:prepare', [
    'local:composer:install',
    'local:npm:install',
    'local:npm:build',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
]);

task('deploy', [
    'deploy:prepare',
    'deploy:publish',
    'deploy:cleanup',
]);

after('deploy:failed', 'deploy:unlock');
