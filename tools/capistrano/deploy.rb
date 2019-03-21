# config valid only for current version of Capistrano
set :application, ENV['APPLICATION']
set :repo_url, ENV['REPO']
set :deploy_to, ENV['DEPLOY_TO']
set :php_bin_path, "$HOME/.phpbrew/php/php-#{ENV['PHP_VERSION']}/bin"
set :exec_phpbrew, "source ~/.phpbrew/bashrc && phpbrew use #{ENV['PHP_VERSION']}"
set :exec_nvm,     "source ~/.nvm/nvm.sh && nvm use #{ENV['NODE_VERSION']}"

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call

# config/deploy.rb

# config valid only for current version of Capistrano
lock '3.6.0'

# Default branch is :master
# ask :branch, proc { `git rev-parse --abbrev-ref HEAD`.chomp }.call

# Default deploy_to directory is /var/www/my_app
# set :deploy_to, '/var/www/my_app'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
set :pty, true

# Default value for :linked_files is []
set :linked_files, %w{.env}

# Default value for linked_dirs is []
# set :linked_dirs, %w{bin log tmp/pids tmp/cache tmp/sockets vendor/bundle public/system}

# Default value for default_env is {}
set :default_env, {
  path: "#{fetch(:php_bin_path)}:/opt/ruby/bin:$PATH"
}

set :linked_dirs, %w{vendor storage node_modules}

set :composer_working_dir, -> { "#{fetch(:release_path)}" }
set :composer_install_flags, ''

set :laravel_working_dir, "./"
set :laravel_dotenv_file, '' # do not copy local .env to the server
set :laravel_version, 5.7
set :laravel_upload_dotenv_file_on_deploy, false
set :laravel_artisan_flags, "--env=production"

set :laravel_set_linked_dirs, false
set :laravel_set_acl_paths, true
set :laravel_server_user, "www-data"

# nvm settings
set :nvm_type, :user # or :system, depends on your nvm setup
set :nvm_node, "v#{ENV['NODE_VERSION']}"
set :nvm_map_bins, %w{node yarn}
set :nvm_node_path, -> {
  if fetch(:nvm_type, :user) == :system
    '/usr/local/nvm/'
  else
    "$HOME/.nvm/"
  end
}

# yarn setting
set :yarn_flags, '' # default
set :yarn_roles, :all                                      # default
set :yarn_env_variables, {}                                # default

namespace :deploy do

  after "deploy:updated", :laravel_tasks do
    invoke "laravel:migrate", :'--force'
  end

  after 'deploy:symlink:release', :update_php_fpm do
    on roles(:app), in: :groups, limit: 3, wait: 10 do
      execute :phpbrew, :fpm, :start
    end
  end

  after :updated, :node_tasks do
    invoke "node:build_production"
  end
end
