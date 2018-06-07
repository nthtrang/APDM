<?php

$conf['dir'] = "../../PNsZip";
if ((isset($_GET['step']))&&(!empty($_GET['step']))) $step=$_GET['step']; else $step=0;
if ((isset($_GET['dirname']))&&(!empty($_GET['dirname']))) $dirname=$_GET['dirname']; else $dirname=".";
$dirname = str_replace("../","",$dirname);
class zipfile
{
    var $datasec      = array();
    var $ctrl_dir     = array();
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    var $old_offset   = 0;
    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {
        	$timearray['year']    = 1980;
        	$timearray['mon']     = 1;
        	$timearray['mday']    = 1;
        	$timearray['hours']   = 0;
        	$timearray['minutes'] = 0;
        	$timearray['seconds'] = 0;
        } // end if

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    } // end of the 'unix2DosTime()' method

    function addFile($data, $name, $time = 0)
    {
        $name     = str_replace('\\', '/', $name);

        $dtime    = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";            // ver needed to extract
        $fr   .= "\x00\x00";            // gen purpose bit flag
        $fr   .= "\x08\x00";            // compression method
        $fr   .= $hexdtime;             // last mod time and date

        // "local file header" segment
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);             // crc32
        $fr      .= pack('V', $c_len);           // compressed filesize
        $fr      .= pack('V', $unc_len);         // uncompressed filesize
        $fr      .= pack('v', strlen($name));    // length of filename
        $fr      .= pack('v', 0);                // extra field length
        $fr      .= $name;

        // "file data" segment
        $fr .= $zdata;

        // "data descriptor" segment (optional but necessary if archive is not
        // served as file)
        $fr .= pack('V', $crc);                 // crc32
        $fr .= pack('V', $c_len);               // compressed filesize
        $fr .= pack('V', $unc_len);             // uncompressed filesize

        // add this entry to array
        $this -> datasec[] = $fr;

        // now add to central directory record
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";                // version made by
        $cdrec .= "\x14\x00";                // version needed to extract
        $cdrec .= "\x00\x00";                // gen purpose bit flag
        $cdrec .= "\x08\x00";                // compression method
        $cdrec .= $hexdtime;                 // last mod time & date
        $cdrec .= pack('V', $crc);           // crc32
        $cdrec .= pack('V', $c_len);         // compressed filesize
        $cdrec .= pack('V', $unc_len);       // uncompressed filesize
        $cdrec .= pack('v', strlen($name) ); // length of filename
        $cdrec .= pack('v', 0 );             // extra field length
        $cdrec .= pack('v', 0 );             // file comment length
        $cdrec .= pack('v', 0 );             // disk number start
        $cdrec .= pack('v', 0 );             // internal file attributes
        $cdrec .= pack('V', 32 );            // external file attributes - 'archive' bit set

        $cdrec .= pack('V', $this -> old_offset ); // relative offset of local header
        $this -> old_offset += strlen($fr);

        $cdrec .= $name;

        // optional extra field, file comment goes here
        // save to central directory
        $this -> ctrl_dir[] = $cdrec;
    } // end of the 'addFile()' method

    function file()
    {
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);

        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries "on this disk"
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries overall
            pack('V', strlen($ctrldir)) .           // size of central dir
            pack('V', strlen($data)) .              // offset to start of central dir
            "\x00\x00";                             // .zip file comment length
    } // end of the 'file()' method
    
    function addFiles($files /*Only Pass Array*/)
    {
        foreach($files as $file) {
			if (is_file($file)) //directory check
			{
				$data = implode("",file($file));
	            $this->addFile($data,$file);
            } else {
//				$data = implode("",file("ndkziper.txt"));
//	            $this->addFile($data,$file."/ndkziper.txt");
			}	
		}
    }
    
    function output($file)
    {
        $fp=fopen($file,"w");
        fwrite($fp,$this->file());
        fclose($fp);
    }

} // end class
//===================================
function getdir($path=".") {
global $dirarray,$conf,$dirsize;	
if ($dir = opendir($path)) {
  while (false !== ($entry = @readdir($dir))) {
	 if (($entry!=".")&&($entry!="..")) {
	  	$lastdot = strrpos($entry,".");
		$ext = chop(strtolower(substr($entry,$lastdot+1)));
		$fname = substr($entry,0,$lastdot);
		if ($path!=".") $newpath = $path."/".$entry;
		else $newpath = $entry;
		$newpath = str_replace("//","/",$newpath);

		if (($entry!="NDKziper.php")&&($entry!="ndkziper.txt")&&($entry!=$conf['dir'])) {
			$dirarray[] = $newpath;
			if ($fsize=@filesize($newpath)) $dirsize+=$fsize;
			if (is_dir($newpath)) getdir($newpath);
		} 
  	 }
  }
}
}// end func
//===================================
function getcurrentdir($path=".") {
global $conf;	
$dirarr = array();
if ($dir = opendir($path)) {
  while (false !== ($entry = @readdir($dir))) {
	 if (($entry!=".")&&($entry!="..")) {
	  	$lastdot = strrpos($entry,".");
		$ext = chop(strtolower(substr($entry,$lastdot+1)));
		$fname = substr($entry,0,$lastdot);
		if ($path!=".") $newpath = $path."/".$entry;
		else $newpath = $entry;
		$newpath = str_replace("//","/",$newpath);

		if (($entry!="NDKziper.php")&&($entry!="ndkziper.txt")&&($entry!=$conf['dir'])) {
			$dirarr[] = $newpath;
		} 
  	 }
  }
}
return $dirarr;
}// end func
//=========================
function size_format($bytes="") {
  $retval = "";
  if ($bytes >= 1048576) {
	$retval = round($bytes / 1048576 * 100 ) / 100 . " MB";
  } else if ($bytes  >= 1024) {
	    $retval = round($bytes / 1024 * 100 ) / 100 . " KB";
    } else {
        $retval = $bytes . " bytes";
      }
  return $retval;
}

if ($step==1) {
	$zdir = $_POST['zdir'];
	$folder_file = $_POST['folderfile'];
	$fp = fopen($folder_file.'/log_file.txt', 'r+');
	touch($folder_file.'/log_file.txt');
    //fwrite($fp, "\n");
	$j=1;
	$str = '';
	for ($i=0; $i <count($zdir); $i++) {		
	 $str .= $j.". ".$zdir[$i]."  \r\n ";
	 $j++;
	}
    fwrite($fp, $str);	
    fclose($fp);
	$zdir[] = 'log_file.txt';
	if (count($zdir)>0) {
		$dirarray=array();
		$dirsize=0;
		$zdirsize=0;
		for ($i=0;$i<count($zdir);$i++) {
			$ffile = $zdir[$i];
			if (is_dir($ffile)) {
				getdir($ffile);
			} else {
				if ($fsize=@filesize($ffile)) $zdirsize+=$fsize;
			}
		}
		$zdirsize+=$dirsize;
		for ($i=0;$i<count($dirarray);$i++) {
			$zdir[] = $dirarray[$i];
		}
		if (!@is_dir($conf['dir'])) {
			$res = @mkdir($conf['dir'],0777);
			if (!$res) $txtout = "Cannot create dir !<br>";
		} else @chmod($conf['dir'],0777);
	
		$zipname = $_POST['filename'];
		$zipname=str_replace("/","",$zipname);
		if (empty($zipname)) $zipname="PNsZip_".time();
		$zipname.=".zip";
		
		$ziper = new zipfile();
		$ziper->addFiles($zdir);
		$ziper->output("{$conf['dir']}/{$zipname}");
		
		if ($fsize=@filesize("{$conf['dir']}/{$zipname}")) $zipsize=$fsize;
		else $zipsize=0;
		
		$zdirsize = size_format($zdirsize);
		$zipsize = size_format($zipsize);
		$archive_file_name = $conf['dir'].'/'.$zipname;			
		header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$archive_file_name");
		exit;
	} 
}
if ($step==2) {
	$zdir = 100;
        
	$folder_file = 'folderfile';
	$fp = fopen($folder_file.'/log_file.txt', 'r+');
	touch($folder_file.'/log_file.txt');
    //fwrite($fp, "\n");
	$j=1;
	$str = '';
	for ($i=0; $i <count($zdir); $i++) {		
	 $str .= $j.". ".$zdir[$i]."  \r\n ";
	 $j++;
	}
    
    fwrite($fp, $str);	
    fclose($fp);
	$zdir[] = 'log_file.txt';
	if (count($zdir)>0) {
		$dirarray=array();
		$dirsize=0;
		$zdirsize=0;
		for ($i=0;$i<count($zdir);$i++) {
			$ffile = $zdir[$i];
			if (is_dir($ffile)) {
				getdir($ffile);
			} else {
				if ($fsize=@filesize($ffile)) $zdirsize+=$fsize;
			}
		}
		$zdirsize+=$dirsize;
		for ($i=0;$i<count($dirarray);$i++) {
			$zdir[] = $dirarray[$i];
		}
		if (!@is_dir($conf['dir'])) {
			$res = @mkdir($conf['dir'],0777);
			if (!$res) $txtout = "Cannot create dir !<br>";
		} else @chmod($conf['dir'],0777);
	
		$zipname = $_POST['filename'];
		$zipname=str_replace("/","",$zipname);
		if (empty($zipname)) $zipname="PNsZip_".time();
		$zipname.=".zip";
		
		$ziper = new zipfile();
		$ziper->addFiles($zdir);
		$ziper->output("{$conf['dir']}/{$zipname}");
		
		if ($fsize=@filesize("{$conf['dir']}/{$zipname}")) $zipsize=$fsize;
		else $zipsize=0;
		
		$zdirsize = size_format($zdirsize);
		$zipsize = size_format($zipsize);
		$archive_file_name = $conf['dir'].'/'.$zipname;			
		header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$archive_file_name");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("$archive_file_name");
		exit;
	} 
}
?>
