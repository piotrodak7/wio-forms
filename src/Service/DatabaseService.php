<?php
namespace WioForms\Service;

class DatabaseService
{
    public $WioForms;
    public $settings;
    public $formStruct;

    private $Connections;

    function __construct( $WioFormsObiect ){
        $this->WioForms = $WioFormsObiect;

        $this->Connections = [];
    }



    /*
    this function get FormSettings and bind in to out obiect
    its used by all public method
    its used directly in showForm()
    in showEntry() and getEntryAsArray() we get $formDataStructID from database
    in preSubmit(), submit() and update() we get $formDataStuctID from POST
    */
    public function getFormDataStruct( $formDataStructId ){

        $databaseQuery =
        [
            'table' => 'WioForms_formStruct',
            'where' => 'formStructId == "'.$formDataStructId.'"',
        ];

        $queryResult = $this->Connections['Main']->SelectOne( $databaseQuery );

        if ( $queryResult == 'false' )
        {
            $this->ErrorLog->ErrorLog('Cannot get DataStruct from Database.');
            return false;
        }

        $this->WioForms->formStruct = json_decode( $queryResult['dataStruct'], true );
        if ( json_last_error()!= JSON_ERROR_NONE )
        {
            $this->ErrorLog->ErrorLog('Problem with JSON validation of formStruct file.');
            return false;
        }
        return true;
    }


    public function setConnections(){
        foreach ($this->WioForms->settings['DatabaseConnections'] as $DBconn_Name => $DBconn_Data)
        {
            $className = '\WioForms\DatabaseConnection\\'.$DBconn_Name;
            if ( class_exists($className) ) {
                $this->Connections[ $DBconn_Name ] = new $className( $DBconn_Data );
            }
            else {
                $this->ErrorLog->ErrorLog('There is no '.$className.' class');
                return false;
            }
        }
        return true;
    }


    /*
    used for saveEntry() and updateEntry()
    produces FormEntry format from $postData
    */
    private function getEntryFromPost( $postData ){}


    /*
    Used by submit()
    It uses main channel of DB communication and puts FormEntry there
    */
    private function saveEntry( $formEntryFormat ){}

    /*
    Used by submit()
    It uses main channel of DB communication and puts FormEntry there
    */
    private function updateEntry( $formEntryFormat ){}


    /*
    this function collects all DatabaseStore Input and Update queries
    it saves them to database by DatabaseStore connections
    */
    private function advancedEntrySave( $postData ){}


    /*
    makes similar thing to DatabaseStore_save()
    changes Input queries for Update queries
    */
    private function advancedEntryUpdate( $postData ){}

}

/*
CREATE TABLE `WioForms_formStruct` (
    `formStructId` VARCHAR(128) NOT NULL ,
    `name` VARCHAR(128) NOT NULL ,
    `used` TINYINT(4) NOT NULL ,
    `dataStruct` TEXT NOT NULL ,
    PRIMARY KEY (`formId`)
) ENGINE = InnoDB;

CREATE TABLE `WioForms_entries` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `formStructId` VARCHAR(128) NOT NULL ,
    `dateAdded`
    `previousVersion`
    `isCurrentVersion`
    `entryDatat` TEXT NOT NULL ,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

*/

?>