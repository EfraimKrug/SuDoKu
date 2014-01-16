<?php
include 'ObjectSTRING.php';
//study in php standard functions:
//FileWorkBegin
interface FileInterface
{
	public function openFile();
	public function readLine();
	public function setFileName();
	public function getFileName();
}

//FileObject Class
class FileObject implements FileInterface
{
		var $FileName = "";
		var $FileHandle;

	 function FileObject($fname = "ObjectFILE.php", $mode = "r")
	{
		$this->FileName = $fname;		
	}

//start the file over...
function rewindFile(){
	rewind($this->FileHandle);
}

//testExistance
//does not effect anything on object at all!
function testExistance($fname){
	#echo "<BR>In testExistance: " . $fname;
	$FileHandle = fopen($fname, "r");
	return $FileHandle;
	}
	
//openFile
function openFile($mode = "r"){
	if($mode == "w"){
		$this->FileHandle = fopen($this->FileName, "w") or exit("WHAT? You have GOT to be kidding!");
		}
	elseif ($mode == "a"){
		$this->FileHandle = fopen($this->FileName, "a") or exit("WHAT? You have GOT to be kidding!");
		}	
	else {
		$this->FileHandle = fopen($this->FileName, "r") or exit("WHAT? You have GOT to be kidding!");
		}
	return $this->FileHandle;
	}

//closeFile
function closeFile(){
	fclose($this->FileHandle);
	$this->FileHandle = 0;
	}
	
//readLine
function readLine(){
	if(!feof($this->FileHandle)){
		return fgets($this->FileHandle);
		}
	else {
		return False;
		}
	}

//writeLine
function writeLine($line = ""){
	#echo "<br>in writeLine";
	#echo "<br>$this->FileName";
	#echo "<br>$line";
	#echo "<br>$this->FileHandle";
	return fwrite($this->FileHandle, $line);
	}
	
//setFileName
function setFileName($file = "PHPObject.php"){
	$this->FileName = $file;
	}
//getFileName
function getFileName(){
	return $this->FileName;
	}

//printFunction
function printFunction($functionName){
	$sO = new StringObject;
	$this->rewindFile();
	
	$fName = "\/\/" . $functionName;
	$printSwitch = 0;
	echo "<table>";
	while ($line = $this->readLine()){
		$sO->setString($line);
		if($sO->match("/\/\//")){
			$printSwitch = 0;
			}
		if($sO->match("/^" . $fName . "/")){
			$printSwitch = 1;
			}
		if($printSwitch > 0){
			echo "<TR><td>&nbsp;&nbsp;&nbsp;&nbsp;</td><TD><font color=green>" . $line . "</font></TD></TR>";
			}
		}
	echo "</table>";
	}
		

//FileObject End Class
}



//fileObjectTest
function test2(){
	echo "<br>================================================";
	echo "<br>== F I L E   -   O B J E C T    -     T E S T ==";
	echo "<br>================================================";
	$fO = new FileObject;
	if(@$fO->testExistance("MYFILE.txt")){
		echo "MYFILE.txt EXISTS!!";
		}
	else {
		echo "<br>Maybe it doesn't exist so much...";
		}
	}

function fileObjectTest(){
	echo "<br>================================================";
	echo "<br>== F I L E   -   O B J E C T    -     T E S T ==";
	echo "<br>================================================";
	echo "<pre>";
	printFunction("FileObject");
	$fO = new FileObject;
	$sO = new StringObject;
	$targetList = array("<br>" => "{BR}");
	printFunction("openFile");
	printFunction("readLine");
	printFunction("closeFile");
	while($line = $fO->readLine()){
		$sO->setString($line);
		$line = $sO->replaceTargetList($targetList);
		echo "<br>" . $line;
		}
	$fO->closeFile();
	echo "</pre>";
	}
######################################################
## Directory Object
######################################################
interface DirectoryInterface
{
	public function openDirectory();
	#public function readFile();
	public function setRootDirectory($dir);
	public function getRootDirectory();
	public function setCurrentDirectory($dir);
	public function getCurrentDirectory();
	public function setTargetDirectory($dir);
	public function getTargetDirectory();

	public function setRootDirectoryName($dirName);
	public function getRootDirectoryName();
	public function setCurrentDirectoryName($dirName);
	public function getCurrentDirectoryName();
	public function setTargetDirectoryName($dirName);
	public function getTargetDirectoryName();

	public function printDirectoryObject();
	public function listDirectory($dir);
}

//DirectoryObject Class
class DirectoryObject implements DirectoryInterface
{
		var $RootDirectoryName = "";
		var $RootDirectory = "";
		var $CurrentDirectoryName = "";
		var $CurrentDirectory = "";
		var $TargetDirectoryName = "";
		var $TargetDirectory = "";
		
		var $DirectoryHandle;

	 function DirectoryObject($dname = "current")
	{
		$this->RootDirectoryName = $dname;
		$this->CurrentDirectoryName = $dname;
		if($dname == "current"){
			#echo "<br> ** " . $dname;
			chroot("c:/");
			$this->RootDirectoryName = dirname(__FILE__);
			$this->CurrentDirectoryName = dirname(__FILE__);
			}
	}

	function getRootDirectory(){
		return $this->RootDirectory;
		}
	function getCurrentDirectory(){
		return $this->CurrentDirectory;
		}
	function getTargetDirectory(){
		return $this->TargetDirectory;
		}
	function setTargetDirectory($dir){
		$this->TargetDirectory = $dir;
		}
	function setRootDirectory($dir){
		$this->RootDirectory = $dir;
		}
	function setCurrentDirectory($dir){
		$this->CurrentDirectory = $dir;
		}

	function getRootDirectoryName(){
		return $this->RootDirectoryName;
		}
	function getCurrentDirectoryName(){
		return $this->CurrentDirectoryName;
		}
	function setRootDirectoryName($dirName){
		$this->RootDirectoryName = $dirName;
		}
	function setCurrentDirectoryName($dirName){
		$this->CurrentDirectoryName = $dirName;
		}
	function getTargetDirectoryName(){
		return $this->TargetDirectoryName;
		}
	function setTargetDirectoryName($dirName){
		$this->TargetDirectoryName = $dirName;
		}

//start the file over...
function openDirectory(){
	$this->CurrentDirectory = opendir($this->CurrentDirectoryName);
}

function isDirectory(){
	if(@is_dir($this->CurrentDirectory)){
		return true;
		}
	return false;
}

function listDirectory($dirID){
	echo "<br><br>$dirID";
	if($dirID == "current"){
		$dir = $this->CurrentDirectory;
	} else if($dirID == "target"){
		$dir = $this->TargetDirectory;
	} else if ($dirID == "root"){
		$dir = $this->RootDirectory;
	}
	$count = 1;
		 while (($element=readdir($dir))!= false) {
				if(is_dir($element)){
					echo "<br>[$count] DIRECTORY: {" . $element . "}";
					}
				else {
					echo "<br>[$count] " . $this->CurrentDirectoryName . $element;
				}
			$count++;
			}
	}

function printDirectoryObject(){
	echo "<br>Printing Directory Object<br>";
	echo  "<br>Root: " . $this->RootDirectoryName;
	echo  "<br>Current: " . $this->CurrentDirectoryName;
	echo  "<br>Target: " . $this->TargetDirectoryName;
	}

function createDirectory($NewDirectory){
	$dir = $this->getTargetDirectoryName() . "/" . $NewDirectory;
	if(!@mkdir($dir)){
		$this->listDirectory("target");
		die ("<br>Can not make directory: $dir");
		}
	}
			
#function buildSiteStructure($SiteName = "defaultSite"){		
#	if(!$this->isDirectory($this->TargetDirectoryName)){
#		$this->setTargetDirectoryName($this->getCurrentDirectoryName());
#		$this->setTargetDirectory($this->getCurrentDirectory());
#		}
#	echo "<br>TARGET: " . $this->getTargetDirectoryName() . "/" . $SiteName;
#	$this->createDirectory($SiteName);
#	$this->createDirectory($SiteName . "/api");
#	$this->createDirectory($SiteName . "/css");
#	$this->createDirectory($SiteName . "/php");
#	$this->createDirectory($SiteName . "/html");
#	$this->createDirectory($SiteName . "/js");
#	}
}		// end object
	
function directoryObjectTest(){
	$dO = new DirectoryObject("c:/wamp/www/ObjectPHP/WebScrape");
	$dO->printDirectoryObject();
	$dO->openDirectory();
	$dO->printDirectoryObject();
	$dO->listDirectory("current");
	#$dO->buildSiteStructure("defaultSite2");
	#$dO->printDirectoryObject();
	
}
// begin 
//fileObjectTest();
//test2();
directoryObjectTest();
?>