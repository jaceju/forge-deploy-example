<?php
/*
 * This file has been generated automatically.
 * Please change the configuration for correct use deploy.
 */

require 'recipe/laravel.php';

// Set configurations
set('repository', 'git@github.com:jaceju/forge-deploy-example.git');
set('shared_files', ['.env']);
set('shared_dirs', [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);
set('writable_dirs', ['bootstrap/cache', 'storage']);
set('writable_use_sudo', false); // Using sudo in writable commands?
set('clear_use_sudo', false);    // Using sudo in clean commands?

// Configure servers
server('production', getenv('DEPLOY_HOST'))
    ->user(getenv('DEPLOY_USER'))
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', getenv('DEPLOY_PATH'));

/**
 * Restart php-fpm on success deploy.
 */
task('php7.0-fpm:restart', function () {
    // Attention: The user must have rights for restart service
    // Attention: the command "sudo /bin/systemctl restart php-fpm.service" used only on CentOS system
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo /bin/systemctl restart php7.0-fpm.service');
})->desc('Restart PHP-FPM service');

after('success', 'php7.0-fpm:restart');