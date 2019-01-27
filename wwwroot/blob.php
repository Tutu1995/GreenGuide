<?php
echo "1 ";
require_once 'WindowsAzure/WindowsAzure.php';
echo "5 ";
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\PublicAccessType;
use WindowsAzure\Common\ServiceException;

echo "2 ";
$connectionString="DefaultEndpointsProtocol=https://greenguideblob.blob.core.windows.net/;AccountName=greenguideblob;AccountKey=HyAqZXPfKMucW6NLODq276uK8w29Q1pMXol/fvastdoJ3nsKklMLHNxDQTBoe9aueXxlCvLgJWD9Zz37ahBfpw==";
echo "6 ";
// Create blob REST proxy.
$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);

echo "3 ";

// OPTIONAL: Set public access policy and metadata.
// Create container options object.
$createContainerOptions = new CreateContainerOptions(); 

// Set public access policy. Possible values are 
// PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
// CONTAINER_AND_BLOBS:     
// Specifies full public read access for container and blob data.
// proxys can enumerate blobs within the container via anonymous 
// request, but cannot enumerate containers within the storage account.
//
// BLOBS_ONLY:
// Specifies public read access for blobs. Blob data within this 
// container can be read via anonymous request, but container data is not 
// available. proxys cannot enumerate blobs within the container via 
// anonymous request.
// If this value is not specified in the request, container data is 
// private to the account owner.
//$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

// Set container metadata
//$createContainerOptions->addMetaData("key1", "value1");
//$createContainerOptions->addMetaData("key2", "value2");

echo "ok! ";
try {
    // Create container.
    $blobRestProxy->createContainer("mycontainer", $createContainerOptions);
	echo "great! ";
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
?>