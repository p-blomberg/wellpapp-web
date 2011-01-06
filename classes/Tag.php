<?php
class Tag {
	private $guid;
	private $name;
	private $type;
	private $post_count;
	private $weak_post_count;

	public function __construct($data) {
		$this->guid=$data['G'];
		$this->name=$data['N'];
		$this->type=$data['T'];
		$this->post_count=$data['P'];
		$this->weak_post_count=$data['W'];
	}

	public function __get($key) {
		switch($key) {
			case 'really_private_data':
				die("Tag::$key is private");
			default:
				if(isset($this->$key)) {
					return $this->$key;
				}
		}
	}

	public function posts() {
		return Post::selection("TG",$this->guid);
	}

	public static function selection($method=null, $data=null) {
		global $wpc;

		$bad_chars=array("\n","\r"," ");
		$data=str_replace($bad_chars,'',$data);

		$tags=array();
		switch($method) {
			case 'name':
				$command="STEP".$data;
				break;
			case 'guid':
				$command="STEG".$data;
				break;
			case null:
				$command="STEP";
				break;
			default:
				throw new exception("Bad selection method");
		}
		$result=$wpc->query($command);
		foreach($result as $r) {
			$parts=explode(' ',$r);
			foreach($parts as $part) {
				$res[substr($part, 0, 1)] = trim(substr($part, 1));
			}
			$tag=new Tag($res);
			$tags[]=$tag;
		}
		return $tags;
	}

}
?>
