role :app, ENV['PRODUCTION_HOST']
role :web, ENV['PRODUCTION_HOST']

set :branch, ENV["CI_BRANCH"]
set :user, ENV["PRODUCTION_USER"]
set :deploy_to, ENV['PRODUCTION_DEPLOY_TO'] || ENV['DEPLOY_TO']

set :slackistrano, {
  klass: Slackistrano::CustomMessaging,
  webhook: ENV['PRODUCTION_NOTIFICATION_WEBHOOK']
}

set :ssh_options, {
  user: fetch(:user),
  keys: [
    File.join(ENV['HOME'], '.ssh', 'id_rsa'),
    File.join(ENV['HOME'], '.ssh', ENV['PRODUCTION_PEM'])
  ],
  forward_agent: true,
  auth_methods: %w(publickey password),
  proxy: fetch(:ssh_proxy, nil)
}
