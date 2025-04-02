<?php

declare(strict_types=1);

namespace Deployer;

require_once 'recipe/sulu.php';
require_once 'contrib/cachetool.php';

import(__DIR__ . '/hosts.yaml');

set('shared_files', [
    '.env',
    'public/robots.txt'
]);
add('shared_dirs', []);
add('writable_dirs', []);
set('do_not_deploy', [
    '.git',
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

task('local:create:working:dir', static function (): void {
   if (is_dir(__DIR__ . '/build')) {
       runLocally('rm -rf build');
   }
   runLocally('mkdir build');
});
task('local:checkout', static function (): void {
    runLocally('git clone --depth=1 {{repository}} build');
});
task('local:composer:install', static function (): void {
    runLocallyInBuildDir('composer install');
});
task('local:npm:install', static function (): void {
    runLocallyInBuildDir('npm install');
});
task('local:npm:build', static function (): void {
    runLocallyInBuildDir('npm run build');
});
task('deploy:do_not_deploy', static function () {
    $doNotDeploy = get('do_not_deploy');
    foreach ($doNotDeploy as $item) {
        runLocallyInBuildDir('rm -rf ' . $item);
    }
});
task('deploy:update_code', static function (): void {
   upload('build/.', '{{release_path}}');
});
task('deploy:opcache:clear', static function (): void {
   if (get('cachetool_args') !== '') {
       invoke('cachetool:clear:opcache');
   }
});
after('deploy:symlink', 'deploy:opcache:clear');

task('deploy:prepare', [
    'local:create:working:dir',
    'local:checkout',
    'local:composer:install',
    'local:npm:install',
    'local:npm:build',
    'deploy:setup',
    'deploy:lock',
    'deploy:release',
    'deploy:do_not_deploy',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
]);

task('deploy', [
    'deploy:prepare',
    'deploy:publish',
    'deploy:cleanup',
    'deploy:cache:clear',
    'phpcr:migrate'
]);

after('deploy:failed', 'deploy:unlock');

function runLocallyInBuildDir(string $command): string
{
    return runLocally('cd build && ' . $command);
}
