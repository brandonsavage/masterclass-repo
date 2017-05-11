## first install vagrant hostmanager:
# `$ vagrant plugin install vagrant-hostmanager`

$script = <<SCRIPT
  echo I am provisioning...
  date > vagrant_provisioned_at
  echo I am setting up nginx vhost configuration ...
  cp -rp /vagrant/masterclass.nginx.conf /etc/nginx/conf.d/
  service nginx restart
  echo web server is ready, access at http://dev.masterclass.com
  echo mysql setup database dev
  mysql -uroot -pvagrant -e 'CREATE DATABASE IF NOT EXISTS `dev` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci'
  echo create initial mysql schema
  mysql -uroot -pvagrant dev < /vagrant/schema.sql
  echo Ready for mastery.
SCRIPT

Vagrant.configure(2) do |config|
  config.vm.box = "rasmus/php7dev"

  config.vm.network "private_network", ip: "10.0.99.12"
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.aliases = 'dev.masterclass.com'

  config.vm.synced_folder ".", "/vagrant", owner: "vagrant", group: "www-data", mount_options: ['dmode=775']

  config.vm.provision "shell", inline: $script
end
