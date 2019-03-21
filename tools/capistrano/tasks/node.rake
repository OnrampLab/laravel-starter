namespace :node do
  desc "build production"
  task :build_production do
    on roles fetch(:yarn_roles) do
      within fetch(:yarn_target_path, release_path) do
        with fetch(:yarn_env_variables, {}) do
          execute :yarn, :production
        end
      end
    end
  end
end
