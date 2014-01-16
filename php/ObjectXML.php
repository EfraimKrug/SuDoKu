<html>
<body>
<?php
include 'ObjectFile.php';

interface XMLInterface
{
	public function SetFileName($v);
	public function SetFileHandle($v);
	public function SetType($v);
	public function SetName($v);
	public function SetWebsite($v);
	public function SetAddress($v);
	public function SetCity($v);
	public function SetState($v);
	public function SetTitle($v);
	public function SetUrl($v);
	public function SetDescription($v);
	public function GetFileName();
	public function GetFileHandle();
	public function GetType();
	public function GetName();
	public function GetWebsite();
	public function GetAddress();
	public function GetCity();
	public function GetState();
	public function GetTitle();
	public function GetUrl();
	public function GetDescription();
	
	// only real funtions here:
	public function startFile();
	public function endFile();
	public function writeFile();

}

//XMLObject Class
class XMLObject implements XMLInterface
{
		var $FileName = "";
		var $FileHandle = 0;
		var $type = "";
		var $name = "";
		var $website = "";
		var $address = "";
		var $city = "";
		var $state = "";
		#Job
		var $title = "";
		var $url = "";
		var $description = "";
		
		var $mode = ""; //start or append
		var $writer = 0;
		var $xml = 0;

	 function XMLObject($fname)
	{
		$this->FileName = $fname;
		
	}
	
function closeFile(){
	fclose($this->FileHandle);
	}
	
function openFile($mode = "r"){
		$fO = new FileObject($this->FileName);
		if(@$fO->testExistance($this->FileName)){
				$this->mode = "append";
				$fO->openFile("a");
				$this->FileHandle = $fO;
		} else {
			$this->mode = "start";
			$fO->openFile("w");
			$this->FileHandle = $fO;
		}
	}

function startFile(){
	if($this->mode == "start"){
		$this->startNewFile();
		}
	else {
		$this->startOldFile();
		}
	}
	
function endFile(){
	if($this->mode == "start"){
		$this->endNewFile();
		}
	else {
		$this->endOldFile();
		}
	}

function writeFile(){
	if($this->mode == "start"){
		$this->writeNewFile();
		}
	else {
		$this->writeOldFile();
		}
	}

function SetFileName($v){$this->FileName = $v; }
function SetFileHandle($v){$this->FileHandle = $v; }
function SetType($v){$this->Type = $v; }
function SetName($v){$this->Name = htmlspecialchars($v); }
function SetWebsite($v){$this->Website = htmlspecialchars($v); }
function SetAddress($v){$this->Address = htmlspecialchars($v); }
function SetCity($v){$this->City = htmlspecialchars($v); }
function SetState($v){$this->State = htmlspecialchars($v); }		
function SetTitle($v){$this->Title = htmlspecialchars($v); }
function SetUrl($v){$this->Url = htmlspecialchars($v); }
function SetDescription($v){$this->Description = htmlspecialchars($v); }

function GetFileName(){return $this->FileName; }
function GetFileHandle(){return $this->FileHandle; }
function GetType(){return $this->Type; }
function GetName(){return $this->Name; }
function GetWebsite(){return $this->Website; }
function GetAddress(){return $this->Address; }
function GetCity(){return $this->City; }
function GetState(){return $this->State; }		
function GetTitle(){return $this->Title; }
function GetUrl(){return $this->Url; }
function GetDescription(){return $this->Description; }

//get xml object ready to write institutions
function startNewFile(){	
	$this->writer = new XMLWriter();
	$this->writer->openMemory();
	$this->writer->setIndent(true);
	$this->writer->setIndentString(" ");
	$this->writer->startDocument("1.0", "UTF-8");
	$this->writer->startElement("joblist");
	}

function endNewFile(){
	$fO = new FileObject($this->FileName,"w");
	$fO->openFile("w");
	$fO->writeLine($this->writer->outputMemory());
	$fO->closeFile();
	}

function writeNewFile(){
	$this->writer->startElement("institution");
	$this->writer->writeElement("type", $this->GetType());
	$this->writer->writeElement("name", $this->GetName());
	$this->writer->writeElement("website", $this->GetWebsite());
	$this->writer->writeElement("address", $this->GetAddress());
	$this->writer->writeElement("city", $this->GetCity());
	$this->writer->writeElement("state", $this->GetState());
	$this->writer->startElement("job");
	$this->writer->writeElement("title", $this->GetTitle());
	$this->writer->writeElement("url", $this->GetUrl());
	$this->writer->writeElement("description", $this->GetDescription());
	$this->writer->endElement();
	$this->writer->endElement();
	$this->writer->endDocument();
	}
	
function startOldFile(){
	$this->xml = simplexml_load_file($this->FileName, null, LIBXML_NOCDATA);
	}
	
function endOldFile(){
	$dom = new DOMDocument("1.0");
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = true;
	$dom->loadXML($this->xml->asXML());
	$dom->save($this->FileName);
	}	
	
function writeOldFile(){
	$institution = $this->xml->addChild("institution");
	$institution->addChild("type", $this->GetType());
	$institution->addChild("name", $this->GetName());
	$institution->addChild("website", $this->GetWebsite());
	$institution->addChild("address", $this->GetAddress());
	$institution->addChild("city", $this->GetCity());
	$institution->addChild("state", $this->GetState());
	$job = $institution->addChild("job");
	$job->addChild("title", $this->GetTitle());
	$job->addChild("url", $this->GetUrl());
	$job->addChild("description", $this->GetDescription());
	}		
	
function dumpObject(){
	echo "<br>Type: " . $this->GetType();
	echo "<br>Name: " . $this->GetName();
	echo "<br>Website: " . $this->GetWebsite();
	echo "<br>Address: " . $this->GetAddress();
	echo "<br>City: " . $this->GetCity();
	echo "<br>State: " . $this->GetState();
	echo "<br>Title: " . $this->GetTitle();
	echo "<br>URL: " . $this->GetUrl();
	echo "<br>Description: " . $this->GetDescription();
	}
}

function testXML(){
	$xml = new XMLObject("XMLoutTEST.xml");
	$xml->SetType("University");
	$xml->SetName("BU");
	$xml->SetWebsite("http://www.bu.edu");
	$xml->SetAddress("32 Bay State Road");
	$xml->SetCity("Boston");
	$xml->SetState("MA");
	$xml->SetTitle("ORAL & MAXILLOFACIAL SURGERY ASST, SDM Oral & Maxil. Surg., Salary Grade 25");
	$xml->SetUrl("https://bu.silkroad.com/epostings/submit.cfm?fuseaction=app.jobinfo&jobid=295337&company_id=15509&version=1&source=ONLINE&jobOwner=1016047&aid=1");
	$xml->SetDescription("The surgery assistant position consists of assisting all Oral Surgeons including residents with surgery in a clinic and operating room setting for oral surgical type procedures i.e. implants, extractions, sinus lift etc..They must maintain all operatories to ensure smooth patient flow follow and practice all OSHA standards regarding infection control and blood borne pathogens, perform sterilization and operatory disinfection responsibilities. Assistants must be certified to take radiographs and be knowledgeable about university and privacy policies. They must also provide a comfortable environment for patients. Must have certification in Radiology DAANCE in order to be considered.");
	$xml->dumpObject();
	$xml->openFile();
	$xml->startFile();
	$xml->writeFile();
	$xml->endFile();
	echo "<BR>ENDED";
	$xml->openFile();
	$xml->startFile();
	echo "<BR>STARTED";
	$xml->writeFile();
	$xml->endFile();
}

function testXML2(){
	$xml = new XMLObject("XMLout.xml");
	$xml->openFile();
	}
	
##testXML2();
##testXML();
?>