if defined?(Slackistrano::Messaging)
    module Slackistrano
      class CustomMessaging < Messaging::Base

        # Reference
        # https://docs.microsoft.com/en-us/outlook/actionable-messages/message-card-reference
        def message_card(title, message)
          {
            '@type' => 'MessageCard',
            '@context' => 'http://schema.org/extensions',
            'themeColor' => '32aee8',
            'title' => title,
            'summary' => message,
            'sections' => [{
              'activityText' => message,
              'facts' => [
                {
                  'name' => 'Project',
                  'value' => application
                },
                {
                  'name' => 'Environment',
                  'value' => stage
                },
                {
                  'name' => 'Branch',
                  'value' => branch
                },
                {
                  'name' => 'Deployer',
                  'value' => deployer
                },
              ],
              'markdown' => true
            }]
          }
        end

        # Suppress starting message.
        def payload_for_starting
          nil
        end

        # Suppress updating message.
        def payload_for_updating
          nil
        end

        # Suppress reverting message.
        def payload_for_reverting
          nil
        end

        # Suppress updated message.
        def payload_for_updated
          message_card('Deployment successed', 'Application has been deployed successfully')
        end

        # Suppress reverted message.
        def payload_for_reverted
          nil
        end

        # Slightly tweaked failed message.
        def payload_for_failed
          message_card('Deployment failed', 'Application has failed to be deployed')
        end

        # Override the deployer helper to pull the best name available (git, password file, env vars).
        # See https://github.com/phallstrom/slackistrano/blob/master/lib/slackistrano/messaging/helpers.rb
        def deployer
          name = `git config user.name`.strip
          name = nil if name.empty?
          name ||= ENV['USER'] || ENV['USERNAME'] || 'Deployer'
          name
        end
      end
    end
 end
