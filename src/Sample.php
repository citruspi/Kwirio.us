<?php
    include('Kwirio.php');
    
    $Kwirious = new Kwirio();
    
    $Kwirious->setHash('b45cffe084dd3d20d928bee85e7b0f21');       

    if($Kwirious->validate())
        echo $Kwirious->crack(); //prints out "string"
    else
        echo "Please set a valid hash.";
        
    $Kwirious->setHash('BlahBlahBlah');    
        
    if($Kwirious->validate())
        echo $Kwirious->crack();
    else
        echo "Please set a valid hash."; //Not a valid hash  

?>

