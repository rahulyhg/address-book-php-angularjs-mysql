/*Table structure for table 'employees' */

DROP TABLE IF EXISTS `employees`;

CREATE TABLE `Employees`(
    id integer NOT NULL  AUTO_INCREMENT ,
    firstname varchar(50) DEFAULT "EFN",
    lastname varchar(50) DEFAULT "ELN",
    addr varchar(150) DEFAULT "EADDR",
    accountno varchar(150) DEFAULT "55555555",
    age integer DEFAULT 0 ,
    email varchar(150) DEFAULT "EMADDR"
    ,createdon datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   modifiedon datetime NOT NULL,
   ownerid int(11) NOT NULL,
   modifiedby int(11) NOT NULL,
   active tinyint(1) NOT NULL DEFAULT '1', 
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

/*Data for the table 'employees' */

LOCK TABLES 'employees' WRITE;

insert  into `employees`('id',
'firstname',
'lastname',
'addr',
'accountno',
'age',
'email'
) values ('','','','','','','',);

UNLOCK TABLES;