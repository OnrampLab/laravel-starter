role :app, ENV['DEV_HOST']
role :web, ENV['DEV_HOST']

set :branch, ENV["CI_BRANCH"]
set :user, ENV["DEV_USER"]
set :deploy_to, ENV['DEV_DEPLOY_TO'] || ENV['DEPLOY_TO']

set :slackistrano, {
  klass: Slackistrano::CustomMessaging,
  webhook: ENV['DEV_NOTIFICATION_WEBHOOK']
}

set :ssh_options, {
  user: fetch(:user),
  keys: [
    File.join(ENV['HOME'], '.ssh', 'id_rsa'),
    File.join(ENV['HOME'], '.ssh', ENV['DEV_PEM'])
  ],
  auth_methods: %w(publickey)
}



### ============================================================


