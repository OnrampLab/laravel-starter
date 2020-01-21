# default deploy_config_path is 'config/deploy.rb'
set :deploy_config_path, 'tools/capistrano/deploy.rb'
set :stage_config_path, 'tools/capistrano/stages'

require 'capistrano/env-config'

# Load DSL and set up stages
require 'capistrano/setup'

# Include default deployment tasks
require 'capistrano/deploy'
require 'capistrano/composer'
require 'capistrano/laravel'
require 'capistrano/nvm'
require 'capistrano/yarn'
require 'capistrano/locally'
require 'slackistrano/capistrano'
require_relative 'tools/capistrano/notification'
require 'net/ssh/proxy/jump'

# Include tasks from other gems included in your Gemfile
#
# For documentation on these, see for example:
#
#   https://github.com/capistrano/rvm
#   https://github.com/capistrano/rbenv
#   https://github.com/capistrano/chruby
#   https://github.com/capistrano/bundler
#   https://github.com/capistrano/rails
#   https://github.com/capistrano/passenger
#
# Load custom tasks from `lib/capistrano/tasks` if you have any defined
Dir.glob('tools/capistrano/tasks/*.rake').each { |r| import r }




# please check https://github.com/SimplyBridal/kid-guard-funnel/commit/c3befb7ae502e2fb0add356e5c7f8b54cea82a86
