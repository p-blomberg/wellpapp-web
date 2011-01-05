<?php
class wellpappConnection {
	private $do_debug;
	private $host;
	private $port;

	private function connect() {
		$this->sock=socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($this->sock===false) {
			throw new exception("Failed to create socket");
		}

		$result=socket_connect($this->sock, $this->host, $this->port);
		if($result===false) {
			throw new exception("Failed to connect to ".$this->host." on port ".$this->port.": ".socket_last_error());
		}
	}

	public function __construct($db_alias, $debug) {
		global $repo_root;
		$this->do_debug = $debug;
		
		$settings_basefile = $repo_root.'/db_settings/'.$db_alias;
		$settings_file = $settings_basefile . '.php';
		$settings_localfile = $settings_basefile . '.local.php';
		
		require $settings_file;
		if ( file_exists($settings_localfile) ){
			require $settings_localfile;
		}

		$this->host=$host;
		$this->port=$port;

		$this->connect();
	}

	public function query($command) {
		$command.="\n";
		$flags=null;
		$result=socket_send($this->sock, $command, strlen($command), $flags);
		if($result===false) {
			die("Failed to send data to socket: ".socket_last_error());
		}

		$lines=array();
		do {
			$line = socket_read($this->sock, 1024, PHP_NORMAL_READ);
			if($line===false) {
			 die("err: ".socket_last_error());
			}
			if($line[0]=='E') {
				die("Server returned error: ".$line);
			}
			if(trim($line)=='OK') {
				break;
			}
			if($line[0]=='R') {
				$lines[]=substr($line,1);
			}
		} while ($line != "");

		return $lines;
	}
}
?>
