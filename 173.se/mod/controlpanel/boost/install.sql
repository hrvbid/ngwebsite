-- @author Matthew McNaney <mcnaney at gmail dot com>
-- @version $Id: install.sql 5919 2008-06-04 15:44:22Z matt $

CREATE TABLE controlpanel_tab (
  id varchar(255) NOT NULL,
  title varchar(255) NOT NULL,
  link varchar(255) NOT NULL,
  tab_order smallint NOT NULL default 0,
  itemname varchar(255) NOT NULL
);

CREATE TABLE controlpanel_link (
 id INT NOT NULL PRIMARY KEY,
 tab varchar(255) NOT NULL,
 active SMALLINT NOT NULL,
 label varchar(50) NULL,	
 itemname varchar(50) NOT NULL,
 restricted SMALLINT NOT NULL default 0,
 url TEXT,
 description TEXT,
 image varchar(255),
 link_order SMALLINT NOT NULL
 );
