#
# Table structure for table 'tx_mooxsocial_domain_model_facebook'
#
CREATE TABLE tx_mooxsocial_domain_model_facebook (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	created int(11) unsigned DEFAULT '0' NOT NULL,
	updated int(11) unsigned DEFAULT '0' NOT NULL,
	model varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,
	status_type varchar(255) DEFAULT '' NOT NULL,
	page varchar(255) DEFAULT '' NOT NULL,
	action varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	summary text NOT NULL,
	text text NOT NULL,
	author varchar(255) DEFAULT '' NOT NULL,
	author_id varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	caption text NOT NULL,
	url text NOT NULL,
	link_name varchar(255) DEFAULT '' NOT NULL,
	link_url text NOT NULL,
	image_url text NOT NULL,
	image_embedcode text NOT NULL,
	video_url text NOT NULL,
	video_embedcode text NOT NULL,	
	shared_url text NOT NULL,
	shared_title varchar(255) DEFAULT '' NOT NULL,
	shared_description text NOT NULL,
	shared_caption text NOT NULL,
	likes int(11) DEFAULT '0' NOT NULL,
	shares int(11) DEFAULT '0' NOT NULL,
	comments int(11) DEFAULT '0' NOT NULL,
	api_uid varchar(255) DEFAULT '' NOT NULL,
	api_hash text NOT NULL,	

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_mooxsocial_domain_model_twitter'
#
CREATE TABLE tx_mooxsocial_domain_model_twitter (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	created int(11) unsigned DEFAULT '0' NOT NULL,
	updated int(11) unsigned DEFAULT '0' NOT NULL,
	model varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,
	status_type varchar(255) DEFAULT '' NOT NULL,
	page varchar(255) DEFAULT '' NOT NULL,
	action varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	summary text NOT NULL,
	text text NOT NULL,
	author varchar(255) DEFAULT '' NOT NULL,
	author_id varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	caption text NOT NULL,
	url text NOT NULL,
	link_name varchar(255) DEFAULT '' NOT NULL,
	link_url text NOT NULL,
	image_url text NOT NULL,
	image_embedcode text NOT NULL,
	video_url text NOT NULL,
	video_embedcode text NOT NULL,	
	shared_url text NOT NULL,
	shared_title varchar(255) DEFAULT '' NOT NULL,
	shared_description text NOT NULL,
	shared_caption text NOT NULL,
	likes int(11) DEFAULT '0' NOT NULL,
	shares int(11) DEFAULT '0' NOT NULL,
	comments int(11) DEFAULT '0' NOT NULL,
	api_uid varchar(255) DEFAULT '' NOT NULL,
	api_hash text NOT NULL,	

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_mooxsocial_domain_model_youtube'
#
CREATE TABLE tx_mooxsocial_domain_model_youtube (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	created int(11) unsigned DEFAULT '0' NOT NULL,
	updated int(11) unsigned DEFAULT '0' NOT NULL,
	model varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,
	status_type varchar(255) DEFAULT '' NOT NULL,
	page varchar(255) DEFAULT '' NOT NULL,
	action varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	summary text NOT NULL,
	text text NOT NULL,
	author varchar(255) DEFAULT '' NOT NULL,
	author_id varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	caption text NOT NULL,
	url text NOT NULL,
	link_name varchar(255) DEFAULT '' NOT NULL,
	link_url text NOT NULL,
	image_url text NOT NULL,
	image_embedcode text NOT NULL,
	video_url text NOT NULL,
	video_embedcode text NOT NULL,	
	shared_url text NOT NULL,
	shared_title varchar(255) DEFAULT '' NOT NULL,
	shared_description text NOT NULL,
	shared_caption text NOT NULL,
	likes int(11) DEFAULT '0' NOT NULL,
	shares int(11) DEFAULT '0' NOT NULL,
	comments int(11) DEFAULT '0' NOT NULL,
	api_uid varchar(255) DEFAULT '' NOT NULL,
	api_hash text NOT NULL,	

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_mooxsocial_domain_model_flickr'
#
CREATE TABLE tx_mooxsocial_domain_model_flickr (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	created int(11) unsigned DEFAULT '0' NOT NULL,
	updated int(11) unsigned DEFAULT '0' NOT NULL,
	model varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,
	status_type varchar(255) DEFAULT '' NOT NULL,
	page varchar(255) DEFAULT '' NOT NULL,
	action varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	summary text NOT NULL,
	text text NOT NULL,
	author varchar(255) DEFAULT '' NOT NULL,
	author_id varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	caption text NOT NULL,
	url text NOT NULL,
	link_name varchar(255) DEFAULT '' NOT NULL,
	link_url text NOT NULL,
	image_url text NOT NULL,
	image_embedcode text NOT NULL,
	video_url text NOT NULL,
	video_embedcode text NOT NULL,	
	shared_url text NOT NULL,
	shared_title varchar(255) DEFAULT '' NOT NULL,
	shared_description text NOT NULL,
	shared_caption text NOT NULL,
	likes int(11) DEFAULT '0' NOT NULL,
	shares int(11) DEFAULT '0' NOT NULL,
	comments int(11) DEFAULT '0' NOT NULL,
	api_uid varchar(255) DEFAULT '' NOT NULL,
	api_hash text NOT NULL,	

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);

#
# Table structure for table 'tx_mooxsocial_domain_model_slideshare'
#
CREATE TABLE tx_mooxsocial_domain_model_slideshare (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	
	created int(11) unsigned DEFAULT '0' NOT NULL,
	updated int(11) unsigned DEFAULT '0' NOT NULL,
	model varchar(255) DEFAULT '' NOT NULL,
	type varchar(255) DEFAULT '' NOT NULL,
	status_type varchar(255) DEFAULT '' NOT NULL,
	page varchar(255) DEFAULT '' NOT NULL,
	action varchar(255) DEFAULT '' NOT NULL,
	title varchar(255) DEFAULT '' NOT NULL,
	summary text NOT NULL,
	text text NOT NULL,
	author varchar(255) DEFAULT '' NOT NULL,
	author_id varchar(255) DEFAULT '' NOT NULL,
	description text NOT NULL,
	caption text NOT NULL,
	url text NOT NULL,
	link_name varchar(255) DEFAULT '' NOT NULL,
	link_url text NOT NULL,
	image_url text NOT NULL,
	image_embedcode text NOT NULL,
	video_url text NOT NULL,
	video_embedcode text NOT NULL,	
	shared_url text NOT NULL,
	shared_title varchar(255) DEFAULT '' NOT NULL,
	shared_description text NOT NULL,
	shared_caption text NOT NULL,
	likes int(11) DEFAULT '0' NOT NULL,
	shares int(11) DEFAULT '0' NOT NULL,
	comments int(11) DEFAULT '0' NOT NULL,
	api_uid varchar(255) DEFAULT '' NOT NULL,
	api_hash text NOT NULL,	

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY language (l10n_parent,sys_language_uid)
);