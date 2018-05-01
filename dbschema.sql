
-- students table--

CREATE table `students` (

 id INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
 project_id INT (11) NULL,
 course_id INT (11) NULL,
 name VARCHAR (255) NOT NULL,
 email  VARCHAR (255) NOT NULL,
 password  VARCHAR (100) NOT NULL,
 student_number VARCHAR (30) NOT NULL,
 registration_number VARCHAR (30) NOT NULL,
 created_at TIMESTAMP,
 updated_at TIMESTAMP,
 PRIMARY KEY(id),

 FOREIGN KEY (project_id) REFERENCES projects(id)
 ON DELETE CASCADE ON UPDATE CASCADE,

 FOREIGN KEY(course_id) REFERENCES courses(id)
 ON DELETE CASCADE ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* lecturers table */

CREATE table `lecturers` (

 id INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
 course_id INT (11) NULL,
 name VARCHAR (255) NOT NULL,
 email  VARCHAR (255) NOT NULL,
 password  VARCHAR (100) NOT NULL,
 created_at TIMESTAMP CURRENT_TIME,
 updated_at TIMESTAMP NULL,
 PRIMARY KEY(id),

 FOREIGN KEY(course_id) REFERENCES coures(id)
 ON DELETE CASCADE ON UPDATE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/* projects */

CREATE TABLE  IF NOT EXISTS `projects` (
    id INT (11) UNSIGNED NOT NULL AUTO_INCREMENT,
    category_id INT (11) NULL,
    title  VARCHAR (500) NOT NULL,
    body TEXT NULL,
    document_url VARCHAR (500) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY(id)

    FOREIGN KEY (category_id) REFERENCES category(id)
    ON DELETE CASCADE ON UPDATE CASCADE

)ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `projects` ADD `category_id` INT(11)  NULL AFTER `title`
AND CONSTRAINT FOREIGN KEY(category_id) REFERENCES category(id) ON DELETE CASCADE ON UPDATE CASCADE;