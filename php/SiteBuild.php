<?php
#error_reporting(E_ALL);
include 'ObjectFile.php';
######################################################
## SiteBuild Object
## ----------------
##	$dO = new SiteBuildObject("param1", "param2");
##	@param1: 
##	$dO = new SiteBuildObject("current", "c:/wamp/www/PHPSite");
##	$dO->setSiteName("defaultSite2");
##	$dO->openDirectory();
##	$dO->buildSiteStructure();
######################################################

//SiteBuildObject Class
class SiteBuildObject extends DirectoryObject
{		
	var $SiteName = "";
	
	function SiteBuildObject($SourceName = "c:/wamp/www/PHPSite/")
	#function SiteBuildObject($SiteName = "current", $SourceName = "c:/wamp/www/PHPSite/")
	{
		$this->setTargetDirectoryName ($this->getRealCurrentDirectoryName());
		$this->setCurrentDirectoryName ($SourceName);
	}

	function setSiteName ($name){
		$this->SiteName = $name;
		$this->setSiteDirectoryName($this->getSiteDirectoryName() . "/$name");
		}
	function setSiteDirectory($dir){
		return $this->setTargetDirectory($dir);
		}
	function setSiteDirectoryName($dirName){
		return $this->setTargetDirectoryName($dirName);
		}
	function getSiteDirectoryName(){
		return $this->getTargetDirectoryName();
		}
	function getSourceDirectory(){
		return $this->getCurrentDirectory();
		}
	function getSourceDirectoryName(){
		return $this->getCurrentDirectoryName();
		}


#####################################################################
#copyFiles($subDir)													#
#@param $subDir = formed as "/php" - list directory level...		#
#@effect: copy files from source directory to target directories	#
######################################################################
function copyFiles($subDir){
		$source = $this->getSourceDirectoryName() . $subDir;
		$target = $this->getTargetDirectoryName() . "/$this->SiteName" . $subDir;
		$dir = opendir($source);
		 while (($element=readdir($dir))!= false) {
				if(is_dir($element)){
					echo "<br>DIRECTORY: {" . $element . "}";
					}
				else {
					echo "<br>Copying... " . $source . "/" . $element . "to " . $target . "/" . $element; 
					copy ($source . "/" . $element, $target . "/" . $element);
				}
			}
	}

#####################################################################
#printSiteBuild()													#
#@effect: display the SiteBuild Object fields						#
######################################################################
	
function printSiteBuild(){
	echo "<br><br>================================";
	echo "<br>++++++++++ SITE BUILD ++++++++++";
	echo "<br>================================";
	echo "<br>Source Directory: " . $this->getSourceDirectoryName();
	echo "<br>Target Directory: " . $this->getTargetDirectoryName();
	$this->printDirectoryObject();
	}

#####################################################################
#buildSiteStructure()												#
#@effect: workhorse - creates directories / copies files			#
#@requires: $this->SiteName  - name of web site (i.e. DoodleWeb)	#
#####################################################################
function buildSiteStructure(){		
	$SiteName = $this->SiteName;
	if(!$this->isDirectory($this->TargetDirectoryName)){
		$this->setTargetDirectoryName($this->getRealCurrentDirectoryName());
		}
	$this->createDirectory($SiteName);
	$this->createDirectory($SiteName . "/api");
	$this->createDirectory($SiteName . "/css");
	$this->createDirectory($SiteName . "/php");
	$this->createDirectory($SiteName . "/html");
	$this->createDirectory($SiteName . "/js");
	$this->copyFiles("/php");
	$this->copyFiles("/html");
	$this->copyFiles("/js");
	$this->copyFiles("/css");
	}
}		// end object
	

#####################################################################
#SiteBuildTest()													#
#@effect: test harness...											#
#####################################################################
function SiteBuildTest(){
	// current: source
	$dO = new SiteBuildObject("current", "c:/wamp/www/PHPSite");
	$dO->setSiteName("defaultSite3");
	$dO->openDirectory();
	$dO->buildSiteStructure();
	
}
// begin 
SiteBuildTest();
?>