<?php 

class SEMember extends DataExtension {
    
    private static $db = array(
        "Phone" => "Varchar(60)",
        "Photo" => "Varchar(250)",
    );
    
    public function updateCMSFields(FieldList $fields) {
        
        $fields->removeByName("Phone");
        $fields->removeByName("Photo");
       
        $fields->insertAfter("Email", new TextField("Phone"));
        $fields->insertAfter("Phone", new LiteralField('','<p>Photo:</p>'),"Photo");
        
        //$fields->addFieldToTab('Root.Content.Main', new LiteralField('','<p>Photo:</p>'),"Content");
        
        return $fields;
    }
}