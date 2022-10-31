<?php

include_once __DIR__ . '/../libs/asCoreLib.php';

// Klassendefinition
class HorizonView extends AsCoreLib {

	// Global properties
	 
	// Der Konstruktor des Moduls
	// Überschreibt den Standard Kontruktor von IPS
	public function __construct($InstanceID) {

		// Diese Zeile nicht löschen
        parent::__construct($InstanceID);
 
        // Selbsterstellter Code
    }
 
    // Überschreibt die interne IPS_Create($id) Funktion
    public function Create() {
            
		// Diese Zeile nicht löschen.
		parent::Create();

		// Properties
		$this->RegisterPropertyString("Sender","HorizonView");
		$this->RegisterPropertyInteger("RefreshInterval",0);
		$this->RegisterPropertyString("hostname","");
				
		// Variables
		
		// Attributes
		
		// Default Actions
		

		// Timer
		$this->RegisterTimer("RefreshInformation", 0 , 'HPEILO_RefreshInformation($_IPS[\'TARGET\']);');

    }

	public function Destroy() {

		// Never delete this line
		parent::Destroy();
	}
 
    // Überschreibt die intere IPS_ApplyChanges($id) Funktion
    public function ApplyChanges() {

		
		$newInterval = $this->ReadPropertyInteger("RefreshInterval") * 1000;
		$this->SetTimerInterval("RefreshInformation", $newInterval);

       	// Diese Zeile nicht löschen
       	parent::ApplyChanges();
    }

	public function GetConfigurationForm() {

        	
		// Initialize the form
		$form = Array(
            	"elements" => Array(),
				"actions" => Array()
        	);

		// Add the Elements
		$form['elements'][] = Array("type" => "CheckBox", "name" => "DebugOutput", "caption" => "Write Debug messages to INFO log");
		$form['elements'][] = Array("type" => "NumberSpinner", "name" => "RefreshInterval", "caption" => "Refresh Interval");
		$form['elements'][] = Array("type" => "ValidationTextBox", "name" => "hostname", "caption" => "Hostname or IP address");
		$form['elements'][] = Array("type" => "ValidationTextBox", "name" => "ApiUsername", "caption" => "Username");
		$form['elements'][] = Array("type" => "PasswordTextBox", "name" => "ApiPassword", "caption" => "Password");
		
		// Add the buttons for the test center
		$form['actions'][] = Array("type" => "Button", "label" => "Refresh Overall Status", "onClick" => 'HPEILO_RefreshInformation($id);');
		
		// Return the completed form
		return json_encode($form);

	}

	public function RefreshInformation() {

		$this->LogMessage("Data refresh was triggered","DEBUG");
	}
	
	public function RequestAction($Ident, $Value) {
	
	}

}
?>
