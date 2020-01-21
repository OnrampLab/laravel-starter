role :app, %w{localhost}
role :web, %w{localhost}

set :branch, ENV["CI_BRANCH"]
set :user, nil
set :deploy_to, ENV['DEPLOY_TO']

set :slackistrano, false















### ============================================================

### init
after 'deploy:starting', :localhost_init_task do
  on release_roles :all do
    #
  end
end
