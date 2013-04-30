CREATE TABLE ngmenu (
  msite     int(9)      NOT NULL,
  mname     varchar(32) NOT NULL,
  mlang     char(5)     NOT NULL,
  mtitle    varchar(64) NOT NULL,
  mpinpoint varchar(32) NOT NULL,
  mpinpage  varchar(64) NOT NULL,
  mvertical char(1)     NOT NULL,
  mpinall   char(1)     NOT NULL,
  mpublic   char(1)     NOT NULL,
  mowner	int(9)		NOT NULL,
  msrc      mediumtext  NOT NULL,
  mdst      mediumtext  NOT NULL,
  PRIMARY KEY (msite,mname,mlang)
);