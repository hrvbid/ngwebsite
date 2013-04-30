CREATE TABLE ngblock (
  bsite     int(9)      NOT NULL,
  bname     varchar(32) NOT NULL,
  blang     char(5)     NOT NULL,
  btitle    varchar(64) NOT NULL,
  bpinpoint varchar(32) NOT NULL,
  bpinpage  varchar(64) NOT NULL,
  bpinall   char(1)     NOT NULL,
  bpublic   char(1)     NOT NULL,
  bsrc      mediumtext  NOT NULL,
  bdst      mediumtext  NOT NULL,
  PRIMARY KEY (bsite,bname,blang)
);