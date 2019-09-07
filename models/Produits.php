<?php
class Produits{
    // Connexion
    private $connexion;
    private $table = "produits";

    // object properties
    public $id;
    public $nom;
    public $description;
    public $prix;
    public $categories_id;
    public $categories_nom;
    public $created_at;

    /**
     * Constructeur avec $db pour la connexion à la base de données
     *
     * @param $db
     */
    public function __construct($db){
        $this->connexion = $db;
    }

    /**
     * Lecture des produits
     *
     * @return void
     */
    public function lire(){
        $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.categories_id, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id ORDER BY p.created_at DESC";
    
        $query = $this->connexion->prepare($sql);

        $query->execute();
    
        return $query;
    }

    /**
     * Créer un produit
     *
     * @return void
     */
    function creer(){
    
        $sql = "INSERT INTO " . $this->table . " SET nom=:nom, prix=:prix, description=:description, categories_id=:categories_id, created_at=:created_at";
    
        $query = $this->conn->prepare($sql);
    
        $this->name=htmlspecialchars(strip_tags($this->nom));
        $this->prix=htmlspecialchars(strip_tags($this->prix));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->categories_id=htmlspecialchars(strip_tags($this->categories_id));
        $this->created_at=htmlspecialchars(strip_tags($this->created_at));
    
        $query->bindParam(":nom", $this->nom);
        $query->bindParam(":prix", $this->prix);
        $query->bindParam(":description", $this->description);
        $query->bindParam(":categories_id", $this->categories_id);
        $query->bindParam(":created_at", $this->created_at);
    
        if($query->execute()){
            return true;
        }
        return false;
    }

    /**
     * Lire un produit
     *
     * @return void
     */
    function lireUn(){
    
        // query to read single record
        $sql = "SELECT c.nom as categories_nom, p.id, p.nom, p.description, p.prix, p.categories_id, p.created_at FROM " . $this->table . " p LEFT JOIN categories c ON p.categories_id = c.id WHERE p.id = ? LIMIT 0,1";
    
        $query = $this->connexion->prepare( $sql );
    
        // bind id of product to be updated
        $query->bindParam(1, $this->id);
    
        // execute query
        $query->execute();
    
        // get retrieved row
        $row = $query->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->nom = $row['nom'];
        $this->prix = $row['prix'];
        $this->description = $row['description'];
        $this->categories_id = $row['categories_id'];
        $this->categories_nom = $row['categories_nom'];
    }
}