# -*- mode: ruby -*-
# vi: set ft=ruby :

$install_ldap = <<SCRIPT
export DEBIAN_FRONTEND=noninteractive
apt-get -yq update
apt-get -yq --no-install-suggests --no-install-recommends --force-yes install slapd ldap-utils apparmor-utils conntrack php5-cli
sudo aa-complain /usr/sbin/slapd
SCRIPT

$setup_vagrant_user_environment = <<SCRIPT
if ! grep "cd /vagrant" /home/vagrant/.profile > /dev/null; then
  echo "cd /vagrant" >> /home/vagrant/.profile
fi
SCRIPT

Vagrant.configure(2) do |config|
  config.vm.box = 'bento/ubuntu-14.04'

  # LDAP port
  config.vm.network 'forwarded_port', guest: 3890, host: 3890
  # PHP embedded webserver port, running in .ci/php_scripts
  config.vm.network 'forwarded_port', guest: 3891, host: 3891

  config.vm.provision 'shell', privileged: true, inline: '/vagrant/.ci/config_iptables.sh', :run => 'always'
  config.vm.provision 'shell', inline: $install_ldap
  config.vm.provision 'shell', privileged: false, inline: '/vagrant/.ci/OpenLDAP_run.sh', :run => 'always'
  config.vm.provision 'shell', privileged: false, inline: '/vagrant/.ci/load_fixtures.sh', :run => 'always'
  config.vm.provision 'shell', inline: $setup_vagrant_user_environment
end
