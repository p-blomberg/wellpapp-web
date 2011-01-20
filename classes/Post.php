<?php
class Post {
	private $md5;
	private $tags;
	private $ext;

	public function __construct($md5, $tags, $ext) {
		$this->md5=$md5;
		$this->tags=array();
		foreach($tags as $t) {
			$this->tags[]=Tag::from_guid($t);
		}
		$this->ext=$ext;
	}

	public function __get($key) {
		switch($key) {
			case 'really_private_data':
				die("Post::$key is private");
			default:
				if(isset($this->$key)) {
					return $this->$key;
				}
		}
	}

	public function add_tag($tag) {
		global $wpc;
		$command="TP".$this->md5." T".$tag->guid;
		$result=$wpc->query($command);
		var_dump($result);
		die("Nej");
	}

	public static function from_md5($md5) {
		$posts=Post::selection('M', $md5);
		return $posts[0];
	}

	public static function selection($method=null, $data=null) {
		global $wpc;

		$bad_chars=array("\n","\r");
		$data=str_replace($bad_chars,'',$data);

		$tags=array();
		switch($method) {
			case 'M':
				$command="SPM".$data." Fext Fcreated Ftagguid Fwidth Fheight Fscore Fsource";
				break;
			case 'TG':
				$command="SPTG".$data." Fext Fcreated Ftagguid Fwidth Fheight Fscore Fsource";
				break;
			default:
				throw new exception("Bad selection method");
		}
		$result=$wpc->query($command);
		foreach($result as $r) {
			$parts=explode(' ',$r);
			$tags=array();
			foreach($parts as $part) {
				switch($part[0]) {
					case 'P':
						$md5=trim(substr($part, 1));
						break;
					case 'G':
						$tags[]=trim(substr($part, 1));
						break;
					case 'F':
						$flagtype=substr($part, 1, strpos($part,'=')-1);
						switch($flagtype) {
							case 'ext':
								$ext=substr(strstr($part,'='),1);
								break;
						}
				}
			}
			$post=new Post($md5, $tags, $ext);
			$posts[]=$post;
		}
		return $posts;
	}

}
?>
