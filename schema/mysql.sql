CREATE TABLE `host` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`os` varchar(64) NOT NULL,
`created` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `exec_log` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`pid` int NOT NULL,
`log` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE `config` (
`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`type` varchar(64) NOT NULL,
`hostname` varchar(64) NOT NULL,
`servicename` varchar(64) NOT NULL,
`monitorobject` varchar(64) NOT NULL,
`msggroup` varchar(64) NOT NULL,
`alertgroup` varchar(64) NOT NULL,
`alertkey` varchar(64),
`ciid` varchar(64) NOT NULL,
`threshold_critical` int(10),
`threshold_warning` int(10),
`createdby` varchar(64) NOT NULL,
`created` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_unicode_ci;

insert into config values (1,'filesystem','localhost','VirBox_filesystems','/etc','ENG-OSS','System','fs etc','vagrant-prod',98,20,'max muster',now());
insert into config values (2,'filesystem','localhost','VirBox_filesystems','/var','ENG-OSS','System','fs var','vagrant-prod',98,20,'max muster',now());





