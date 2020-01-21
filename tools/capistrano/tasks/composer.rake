namespace :composer do
  desc "update composer"
  task :update_composer do
    on roles(:app) do
      within release_path do
        execute :composer, :update, :'--lock'
      end
    end
  end
end
