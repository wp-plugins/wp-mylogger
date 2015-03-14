=== WP MyLogger ===
Contributors: paniko
Tags: logger, appenders, debug, developer
Requires at least: 3.5.1
Tested up to: 3.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin use Apache log4php™ libary for create custom loggers on your file system or mail account. Is possible specify the type (rolling, daily), name logger ect.
This plugin is very useful in development to debug issues or to create log files when you create an importer. 

== Description ==
To use the custom appenders, add this code in your init plugin for example:
Choose among appenders (LoggerAppenderDailyFile,LoggerAppenderRollingFile,LoggerAppenderFile,LoggerAppenderMail,LoggerAppenderMailEvent), for each type you must 
specify the relative parameters, how to official documentation of log4php.

* For rolling file appenders:

`<?php
	private $logger; //add in your class pugin to get an instance logger
	$parameters = array(
		My_Logger::ROLLING_MAX_FILE_SIZE	=> '1MB',
		My_Logger::ROLLING_APPENDER			=> true,
		My_Logger::ROLLING_MAX_BACKUP_INDEX	=> 5
	);

	$mylogger = My_Logger::get_instance("<your_logger_name>", My_Logger::ROLLING, $parameters);
	$this->logger = $mylogger->getLogger();

	//for debug you add:

	$this->logger->debug($parameters);
	$this->logger->debug("test");
?>`

* For *mail* appender:
`<?php
		private $logger; //add in your class pugin to get an instance logger
		$parameters = array(
				My_Logger::MAIL_FROM		=> '<your_from@email>',
				My_Logger::MAIL_TO			=> '<your_to@email>',
				My_Logger::MAIL_SUBJECT		=> '<your subject>',
				My_Logger::THRESHOLD		=> My_Logger::LEVEL_DEBUG//6: Sets the root logger level to DEBUG. This means that logging requests with the level lower than DEBUG will not be logged by the root logger.
		);
		
		$mylogger = My_Logger::get_instance("<your name logger>", My_Logger::MAIL, $parameters);
?>`

** SET Logger threshold **
A level describes the severity of a logging message. There are six levels, show here in descending order of severity.
You can set level of logger, add the parameter:

* FATAL	Highest	Very severe error events that will presumably lead the application to abort.
* ERROR	...	Error events that might still allow the application to continue running.
* WARN	...	Potentially harmful situations which still allow the application to continue running.
* INFO	...	Informational messages that highlight the progress of the application at coarse-grained level.
* DEBUG	...	Fine-grained informational events that are most useful to debug an application.
* TRACE	Lowest	Finest-grained informational events.

If do you want put a logger in frontend, add this code in template script:
`<?php
		$parameters = array(
			My_Logger::ROLLING_MAX_FILE_SIZE	=> '1MB',
			My_Logger::ROLLING_APPENDER			=> true,
			My_Logger::ROLLING_MAX_BACKUP_INDEX	=> 5,
			My_Logger::THRESHOLD	=> My_Logger::LEVEL_DEBUG
		);

		$mylogger = new My_Logger("<your_logger_name>", My_Logger::ROLLING, $parameters);

		$logger = $mylogger->getLogger();
		$logger->debug("test my logger");
?>`		
		
		


For more info read the API documents of log4php:[Apache Log4php Docs](http://logging.apache.org/log4php/docs/appenders.html "API Documents") 

*Configuration*
You can set configuration path file to export your logger, in the plugin's settings.

== Installation ==

1. Upload `wp-mylogger.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. /assets/banner-772x250.png

== Changelog ==

= 1.0 =
* First version with integration a custom appender log4php.
