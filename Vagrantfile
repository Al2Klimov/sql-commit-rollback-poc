# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  config.vm.box = "parallels/ubuntu-16.04"
  config.vm.network "private_network", type: "dhcp"
  config.vm.synced_folder ".", "/vagrant"

  config.vm.provision "shell", inline: <<-SHELL
    apt-get update
    apt-get install -y puppet puppet-module-puppetlabs-postgresql
    puppet apply /vagrant/puppet/manifests/site.pp
  SHELL
end
