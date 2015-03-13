<?php
class MyLog{
	protected $additivity;
	protected $appender;
	protected $targetDirLog;
	protected $type;
	protected $logger;
	protected $name;
	protected $layout;
	protected $parameters;
	protected $theshold;
	protected $pathLogger;

	public function __construct($name, $type, $parameters){
		$this->setName($name);
		$this->setLogger( Logger::getLogger($name) );
		$this->setParameters($parameters);
		$this->setTreshold($parameters[My_Logger::THRESHOLD]);
		$pattern = "%date %logger %-5level %msg%n";
		$this->setLayout($pattern);
		$opt = get_option('wp_my_loggger');
		if(!empty($opt['path_logger'])){
			$this->pathLogger = $opt['path_logger'];
		}else{
			$upload_dir = wp_upload_dir();
			$upload_dir = $upload_dir['basedir'];
			$pathdefault = $upload_dir.'/log';
			mkdir($pathdefault, 0777,true);
			$this->pathLogger = $pathdefault;
		}
		$this->setType($type);
	}
	
	public function getAdditivity() {
		return $this->additivity;
	}
	public function setAdditivity($additivity) {
		$this->additivity = $additivity;
		return $this;
	}
	public function getAppender() {
		return $this->appender;
	}
	public function setAppender($appender) {
		$this->appender = $appender;
		return $this;
	}
	public function getTargetDirLog() {
		return $this->targetDirLog;
	}
	public function setTargetDirLog($targetDirLog) {
		$this->targetDirLog = $targetDirLog;
		return $this;
	}
	public function getType() {
		return $this->type;
	}
	/**
	 * Set type appender
	 * -- LoggerAppenderRollingFile
	 * @param unknown $args
	 * type
	 * filesize
	 * append
	 * maxbackupindex
	 */
		//$upload_dir = wp_upload_dir();
	public function setType($type) {
		$args = $this->getParameters();
		switch ($type){
			case My_Logger::ROLLING:
				$appRollingFile = new LoggerAppenderRollingFile('rolling-'.$this->getName());
				$appRollingFile->setMaxFileSize($args['maxFileSize']); //'1MB'
				$appRollingFile->setAppend($args['append']); //true
				$appRollingFile->setMaxBackupIndex($args['maxBackupIndex']);//5
				$appRollingFile->setFile($this->pathLogger.'/'.$this->getName().'.log');
				$appRollingFile->setLayout($this->getLayout());
				$appRollingFile->setThreshold($this->getTreshold());
				$appRollingFile->activateOptions();
				$this->logger->setAdditivity(false);
				$this->logger->addAppender($appRollingFile);
				break;
			case My_Logger::MAIL:
				$appMail = new LoggerAppenderMail('mail-'.$this->getName());
				$appMail->setFrom($args['from']);
				$appMail->setTo($args['to']);
				$appMail->setSubject($args['subject']);
				$appMail->setThreshold($this->getLayout());
				$appMail->activateOptions();
				$this->logger->setAdditivity(false);
				$this->logger->addAppender($appMail);
				break;
			case My_Logger::DAILY:
				$appDailyFile = new LoggerAppenderDailyFile('daily-'.$this->getName());
				$appDailyFile->setDatePattern($args['datePattern']);
				$appDailyFile->setFile($this->pathLogger.'/mylog-%s.log');
				$appDailyFile->setLayout($this->getLayout());
				$appDailyFile->setThreshold($this->getTreshold());
				$appDailyFile->activateOptions();
				$this->logger->setAdditivity(false);
				$this->logger->addAppender($appDailyFile);
				break;
		}
	}
	public function getLogger() {
		return $this->logger;
	}
	public function setLogger($logger) {
		$this->logger = $logger;
		return $this;
	}
	public function getName() {
		return $this->name;
	}
	public function setName($name) {
		$this->name = $name;
		return $this;
	}
	public function setLayout($pattern){
		// Use a different layout for the next appender
		$this->layout = new LoggerLayoutPattern();
		$this->layout->setConversionPattern($pattern);
		$this->layout->activateOptions();
	}
	public function getLayout() {
		return $this->layout;
	}
	public function getParameters() {
		return $this->parameters;
	}
	public function setParameters($parameters) {
		$this->parameters = $parameters;
		return $this;
	}
	public function getTreshold() {
		return $this->treshold;
	}
	public function setTreshold($treshold) {
		$this->treshold = $treshold;
		return $this;
	}
	
	

}