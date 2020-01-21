role :app, ENV['STAGING_HOST']
role :web, ENV['STAGING_HOST']

set :branch, ENV["CI_BRANCH"]
set :user, ENV["STAGING_USER"]
set :deploy_to, ENV['STAGING_DEPLOY_TO'] || ENV['DEPLOY_TO']

set :slackistrano, {
  klass: Slackistrano::CustomMessaging,
  webhook: ENV['STAGING_NOTIFICATION_WEBHOOK']
}

set :ssh_options, {
  user: fetch(:user),
  keys: [
    File.join(ENV['HOME'], '.ssh', 'id_rsa'),
    File.join(ENV['HOME'], '.ssh', ENV['STAGING_PEM'])
  ],
  forward_agent: true,
  auth_methods: %w(publickey password),
  proxy: fetch(:ssh_proxy, nil)
}

### ============================================================

### service restart
after 'deploy:symlink:release', :update_php_fpm do
  on roles(:app), in: :groups, limit: 3, wait: 10 do
    execute :phpbrew, :fpm, :start
    execute :sudo, :service, :supervisor, :reload
  end
end
