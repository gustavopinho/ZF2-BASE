# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  # Specify the base box
  config.vm.box = 'ARTACK/debian-jessie'

  # Setup port forwarding
  config.vm.network "forwarded_port", guest: 80, host: 8085

  # VM name
  config.vm.hostname = "zfbase.local"

  # Setup synced folder
  config.vm.synced_folder "./" , "/vagrant/", :mount_options => ["dmode=777","fmode=666"]

  # Shell provisioning
  config.vm.provision "shell" do |s|
    s.path = "provision/setup.sh"
  end

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "512"]
  end

end
