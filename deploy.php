<?php
namespace Deployer;
require 'recipe/common.php';

// Configuration
set('default_stage', 'production');
set('repository', 'https://github.com/rogoit/rolandgolla.git');
set('shared_files', []);
set('shared_dirs', []);
set('writable_dirs', []);

// Servers
serverList('servers.yml');

// Tasks
desc('Deploy your project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

after('deploy', 'success');
