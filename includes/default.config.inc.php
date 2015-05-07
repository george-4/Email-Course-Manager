<?php
/**
 * The base configurations of the application.
 */

// ** MySQL settings ** //
/** The name of the database */
define('DB_NAME', 'dbname');

/** MySQL database username */
define('DB_USER', 'dbuser');

/** MySQL database password */
define('DB_PASSWORD', 'dbpassword');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Absolute path to the application. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Name of the course. */
define('COURSE_NAME', 'Course');

/** Absolute path to lessons. (Don't forget '/' in the end of the path)*/
define('LESSONSPATH', '/home/user/something/lessons/');

/** Base folder name for lessons. Then the number is added like LESSON0, LESSON1 etc */
define('LESSONFOLDER', 'LESSON');

/** Total lesson count */
define('MAX_LESSONS', '5');

// ** Mail settings ** //
/** Set the hostname of the mail server */
define('EMAIL_HOST', 'mail.yourserver.com');

/** Set who the message is to be sent from (email and name) */
define('EMAIL_FROM', 'from@yourserver.com');
define('EMAIL_FROM_NAME', 'Sender Name');

/** Set a reply-to address and name*/
define('EMAIL_REPLY', 'reply@yourserver.com');
define('EMAIL_REPLY_NAME', 'Sender Name');

/** Password of the email account */
define('EMAIL_PASSWORD', 'password');

/** Set the SMTP port number - likely to be 25, 465 or 587 */
define('SMTP_PORT', '25');

/** Enable SMTP debugging
    0 = off (for production use)
    1 = client messages
    2 = client and server messages */
define('SMTP_DEBUG', '0');