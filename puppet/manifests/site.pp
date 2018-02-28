node default {
	package { 'apache2':
	}
	-> service { 'apache2':
		ensure => running,
		enable => true,
	}

	package { [ 'libapache2-mod-php7.0', 'php7.0-pgsql' ]:
		require => Package['apache2'],
		notify  => Service['apache2'],
	}

	class { 'postgresql::globals':
		version => '9.5',
	}
	-> class { 'postgresql::server':
	}
	-> postgresql::server::db { 'commit_poc':
		user     => 'commit_poc',
		password => 'commit_poc',
		require  => Class['postgresql::server'],
	}

	file { '/var/www/html/poc':
		ensure  => link,
		target  => '/vagrant/poc',
		require => Package['apache2'],
	}
}
