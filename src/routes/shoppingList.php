<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

// get shopping list
$app->get('/api/shoppingList', function(Request $request, Response $response ){

    $sql = "SELECT * FROM Shopping_List";

    try{
        // get db object
        $db = new db();
        // connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $shoppingList = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($shoppingList);
        
    } catch(PDOException $e){

        echo '{"error": {"text": '.$e->getMessage().'}';

    }

});

// get single entry from list
$app->get('/api/shoppingListEntry/{id}', function(Request $request, Response $response ){

        $id = $request->getAttribute('id');

    
        $sql = "SELECT * FROM Shopping_List WHERE CustomerID = $id";
    
        try{
            // get db object
            $db = new db();
            // connect
            $db = $db->connect();
    
            $stmt = $db->query($sql);
            $shoppingListEntry = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            echo json_encode($shoppingListEntry);
            
        } catch(PDOException $e){
    
            echo '{"error": {"text": '.$e->getMessage().'}';
    
        }
    
    });

    // add shopping item
$app->post('/api/shoppingListEntry/add', function(Request $request, Response $response ){
    
            $custId = $request->getParam('CustomerID');
            $prodName = $request->getParam('ProductName');
            $prodQty = $request->getParam('ProductQuantity');
            $prodPrice = $request->getParam('ProductPrice');

    
        
            $sql = "INSERT INTO Shopping_List (CustomerID, ProductName, ProductQuantity, ProductPrice) VALUES (:CustomerID,:ProductName,:ProductQuantity,:ProductPrice)";
        
            try{
                // get db object
                $db = new db();
                // connect
                $db = $db->connect();
        
               $stmt = $db->prepare($sql);

               $stmt->bindParam(':CustomerID', $custId);
               $stmt->bindParam(':ProductName', $prodName);
               $stmt->bindParam(':ProductQuantity', $prodQty);
               $stmt->bindParam(':ProductPrice', $prodPrice);

               $stmt->execute();

               echo '{"notice": {"text": "item added!"}';
                
            } catch(PDOException $e){
        
                echo '{"error": {"text": '.$e->getMessage().'}';
        
            }
        
        });

        // update list
        $app->put('/api/shoppingListEntry/update/{id}', function(Request $request, Response $response ){

                    $custId = $request->getAttribute('id');
                    //$custId = $request->getParam('CustomerID');
                    $prodName = $request->getParam('ProductName');
                    $prodQty = $request->getParam('ProductQuantity');
                    $prodPrice = $request->getParam('ProductPrice');
        
            
                
                    $sql = 
                    "UPDATE Shopping_List SET 
                    ProductName = :ProductName,
                    ProductQuantity = :ProductQuantity,
                    ProductPrice = :ProductPrice
                    WHERE CustomerID = $custId";

                
                    try{
                        // get db object
                        $db = new db();
                        // connect
                        $db = $db->connect();
                
                       $stmt = $db->prepare($sql);
        
                       //$stmt->bindParam(':CustomerID', $custId);
                       $stmt->bindParam(':ProductName', $prodName);
                       $stmt->bindParam(':ProductQuantity', $prodQty);
                       $stmt->bindParam(':ProductPrice', $prodPrice);
        
                       $stmt->execute();
        
                       echo '{"notice": {"text": "item updated!"}';
                        
                    } catch(PDOException $e){
                
                        echo '{"error": {"text": '.$e->getMessage().'}';
                
                    }
                
                });

                // delete single entry from list
$app->delete('/api/shoppingListEntry/delete/{id}', function(Request $request, Response $response ){
    
            $id = $request->getAttribute('id');
    
        
            $sql = "DELETE FROM Shopping_List WHERE CustomerID = $id";
        
            try{
                // get db object
                $db = new db();
                // connect
                $db = $db->connect();
        
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $db = null;

                echo '{"notice": {"text": "Entry Deleted"}';
                
            } catch(PDOException $e){
        
                echo '{"error": {"text": '.$e->getMessage().'}';
        
            }
        
        });