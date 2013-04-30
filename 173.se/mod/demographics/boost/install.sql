-- @author Matthew McNaney <mcnaney at gmail dot com>
-- @version $Id: install.sql 5919 2008-06-04 15:44:22Z matt $

CREATE TABLE demographics (
  user_id int NOT NULL default 0
);

CREATE UNIQUE INDEX user_id on demographics(user_id);
