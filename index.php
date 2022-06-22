<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header ("Access-Control-Allow-Origin: *");
header ("Access-Control-Allow-Headers: *");


include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();
var_dump($conn);
$product =(file_get_contents('php://input'));
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        $product = json_decode((file_get_contents('php://input')));
        $sql = "INSERT INTO `produit`(`nomCategorieProduit`, `nom`, `prix`, `qteStock`, `photo`, `description`) VALUES (:categorie, :nom, :prix, :qteStock, :photo, :description)";
        // $sql = "INSERT INTO utilisateur (nom, prenom, adresse, email, motDePasse, creer_le) VALUES (:nom, :prenom, :adresse, :email, :motDePasse, :creer_le)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $product->nom);
        $stmt->bindParam(':prix', $product->prix);
        $stmt->bindParam(':qteStock', $product->qteStock);
        $stmt->bindParam(':photo', $product->photo);
        $stmt->bindParam(':description', $product->description);
        $stmt->bindParam(':categorie', $product->categorie);
    
        if($stmt->execute()) 
        {
            $response = ['status' => 1, 'message' => 'Record created successfully'];
        }else {
            $response = ['status' => 0, 'message' => 'Failed to create record'];
        }
        echo json_encode($response);

        break;
    
    default:
        # code...
        break;
}