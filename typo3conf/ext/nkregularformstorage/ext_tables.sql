#
# Table structure for table 'tx_nkregularformstorage_domain_model_formresult'
#
CREATE TABLE tx_nkregularformstorage_domain_model_formresult (

    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    name varchar(255) DEFAULT '' NOT NULL,
    email varchar(255) DEFAULT '' NOT NULL,
    trxid varchar(255) DEFAULT '' NOT NULL,
    trxamount varchar(10) DEFAULT '' NOT NULL,
    invoiceid varchar(255) DEFAULT '' NOT NULL,
    ptype tinyint(4) unsigned DEFAULT '0' NOT NULL,
    pstatus tinyint(4) unsigned DEFAULT '0' NOT NULL,
    cardno varchar(50) DEFAULT '' NOT NULL,
    description text,
    form text NOT NULL,
    formserialized text NOT NULL,
    customtstamp int(11) unsigned DEFAULT '0' NOT NULL,
    feuseruid int(11) DEFAULT '0' NOT NULL,

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

    sys_language_uid int(11) DEFAULT '0' NOT NULL,
    l10n_parent int(11) DEFAULT '0' NOT NULL,
    l10n_diffsource mediumblob,

    PRIMARY KEY (uid),
    KEY parent (pid),
    KEY t3ver_oid (t3ver_oid,t3ver_wsid),
    KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (

	authorize_customer_profile varchar(50) DEFAULT '' NOT NULL,
);

CREATE TABLE tx_nkregularformstorage_domain_model_paymentprofile
(
    uid int(11) NOT NULL auto_increment,
    pid int(11) NOT NULL DEFAULT '0',

    tstamp int(11) NOT NULL DEFAULT '0',
    crdate int(11) NOT NULL DEFAULT '0',
    cruser_id int(11) NOT NULL DEFAULT '0',
    deleted tinyint(4) NOT NULL DEFAULT '0',
    hidden tinyint(4) NOT NULL DEFAULT '0',

    feuser int(11) NOT NULL DEFAULT '0',
    cusprofile int(11) NOT NULL DEFAULT '0',
    payprofile int(11) NOT NULL DEFAULT '0',
    card varchar(250) NOT NULL DEFAULT '',
    email varchar(250) NOT NULL DEFAULT '',

    PRIMARY KEY (uid),
    KEY parent (pid)
);

--
-- Table structure for table `tx_vs_payments_trxlog`
--

CREATE TABLE tx_vs_payments_trxlog (

    uid int(11) NOT NULL auto_increment,
    pid int(11) NOT NULL DEFAULT '0',

    tstamp int(11) NOT NULL DEFAULT '0',
    crdate int(11) NOT NULL DEFAULT '0',
    cruser_id int(11) NOT NULL DEFAULT '0',
    deleted tinyint(4) NOT NULL DEFAULT '0',
    hidden tinyint(4) NOT NULL DEFAULT '0',

    success tinyint(3) NOT NULL DEFAULT '0',
    trxtype varchar(20) NOT NULL DEFAULT '',
    status varchar(15) NOT NULL DEFAULT '',
    refid varchar(50) DEFAULT '',
    authcode varchar(15) NOT NULL DEFAULT '',
    profileid varchar(20) NOT NULL DEFAULT '',
    message text,
    rawresult text,
    amount varchar(10) NOT NULL DEFAULT '0.00',
    cardno varchar(30) NOT NULL DEFAULT '',
    expires varchar(5) NOT NULL DEFAULT '',
    csc varchar(4) NOT NULL DEFAULT '',
    description text,
    invoiceno varchar(20) NOT NULL DEFAULT '',
    cardholder varchar(50) NOT NULL DEFAULT '',
    address varchar(50) NOT NULL DEFAULT '',
    city varchar(50) NOT NULL DEFAULT '',
    state char(2) NOT NULL DEFAULT '',
    zip varchar(10) NOT NULL DEFAULT '',

    PRIMARY KEY (uid),
    KEY parent (pid)
);
