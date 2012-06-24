<?php

class Vstream { 

	public $workdir;

	public function fext($file) {
		return (pathinfo($file, PATHINFO_EXTENSION));
	}

	private function get_file($file, $large = FALSE) {
		global $HTTP_SERVER_VARS;

		set_time_limit(0);

		if ($large) {
			passthru('cat '.escapeshellarg($file), $err); 
		} else { 

			$seek_start=0;
			$seek_end=-1;
			$fs = filesize($file);

			if(isset($_SERVER['HTTP_RANGE']) || isset($HTTP_SERVER_VARS['HTTP_RANGE'])) { 
 
				$seek_range = isset($HTTP_SERVER_VARS['HTTP_RANGE']) ? substr($HTTP_SERVER_VARS['HTTP_RANGE'] , strlen('bytes=')) : substr($_SERVER['HTTP_RANGE'] , strlen('bytes='));
				$range=explode('-',$seek_range); 

				if($range[0] > 0) {$seek_start = intval($range[0]); }

				$seek_end = ($range[1] > 0) ? intval($range[1]) : -1;


		   		header('HTTP/1.0 206 Partial Content'); 
		    		header('Status: 206 Partial Content'); 
		    		header('Accept-Ranges: bytes'); 
		    		header("Content-Range: bytes $seek_start-$seek_end/".$fs); 

			}

			if($seek_end < $seek_start) {$seek_end=$fs - 1;}
			$cl = $seek_end - $seek_start + 1;

			header('Content-Length: '.$cl);
			ob_flush();

   			$fo = fopen($file, 'rb');

    			fseek($fo, $seek_start);

       		while(!feof($fo)){
               		set_time_limit(0);
        			print(fread($fo, 1024*1024*50));
        			flush();
        			ob_flush();
    			}

    			fclose($fo);
		}
		
		exit;
	}


	public function stream($file,$name = false) {
		
		if (!$name) $name = $file;
		
		if (!preg_match('/^(avi|divx|mpeg|mp4|mkv)$/i', $this->fext($file))) {die('404 Invalid format');}
//echo $this->workdir.$file;exit;
		if (!is_file($this->workdir.$file)) {die('404 File not found');}

		header('Content-Type: video/divx');
		header('Content-Disposition: inline; filename="'.$name.'"');

		$this->get_file($this->workdir.$file);
	}

}