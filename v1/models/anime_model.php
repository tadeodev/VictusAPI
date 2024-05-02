<?php
function fuzzySearch($query, $names) {
    // Set maximum allowed edit distance
    $maxDistance = strlen($query);
    // Array to store matching names
    $matches = [];

    // Convert query to lowercase
    $queryLower = strtolower($query);

    // Iterate through all names
    foreach ($names as $name) {
        // Convert name to lowercase
        $nameLower = strtolower($name);
        
        // Calculate Levenshtein distance between query and name
        $distance = levenshtein($queryLower, $nameLower);

        // If distance is within threshold, add name to matches
        if ($distance <= $maxDistance) {
            $matches[] = $name;
        }
    }
    return $matches;
}
class Animes extends Conectar{

    public function get_all(){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT * FROM animes";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_name(){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT Name FROM animes";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_anime_by_name($name){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT * FROM animes WHERE Name=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$name);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_anime_by_id($ani_id){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT * FROM animes WHERE ani_id=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$ani_id);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function get_anime_addition_date($ani_id){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT Name,Episodes,Last_Episode FROM animes WHERE ani_id=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$ani_id);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_anime_database($Name, $Season, $Episodes, $Last_Episode) {
        // Connect to the database
        $conectar = parent::connect();
        parent::set_name();
        
        // Use parameterized queries to prevent SQL injection attacks (In this case I'm using "?")
        $sql = "SELECT * FROM animes WHERE Name = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$Name]);
    
        // Check for any existing data that matches the input parameters
        if ($stmt->rowCount() > 0) {
            echo "Ya existe";
        } else {
            // Insert the new data into the database using parameterized queries
            $sql = "INSERT INTO animes (Name, Season, Episodes, Last_Episode) VALUES (?, ?, ?, ?)";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$Name, $Season, $Episodes, $Last_Episode]);
        }

    }

    public function update_anime_lastepisode($Name, $Last_Episode) {
        // Connect to the database
        $conectar = parent::connect();
        parent::set_name();
        
        // Use parameterized queries to prevent SQL injection attacks (In this case I'm using "?")
        $sql = "SELECT Last_Episode FROM animes WHERE Name = ? AND Last_Episode = ? AND Episodes = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$Name, $Last_Episode, $Last_Episode]);
    
        // Check for any existing data that matches the input parameters
        if ($stmt->rowCount() > 0) {
            echo "Ya existe";
        } else {
            // Insert the new data into the database using parameterized queries
            $sql = "UPDATE animes SET Last_Episode = ? WHERE Name = ?";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$Last_Episode, $Name]);
        }
    
    }
    
    public function find($Name) {
        // Connect to the database
        $conectar = parent::connect();
        parent::set_name();
        
        // Use parameterized queries to prevent SQL injection attacks (In this case I'm using "?")
        // Include fuzzy search in the SQL query
        $sql = "SELECT Name FROM animes WHERE Name LIKE ?";
        
        // Fuzzy search query
        $fuzzyQuery = "%$Name%";
        
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$fuzzyQuery]);
        
        // Fetch matching names
        $matches = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        // If matches found, return them
        if (!empty($matches)) {
            return $matches;
        } else {
            // If no matches found, perform fuzzy search
            $allNamesStmt = $conectar->prepare("SELECT Name FROM animes");
            $allNamesStmt->execute();
            $allNames = $allNamesStmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Perform fuzzy search using Levenshtein distance
            $suggestions = fuzzySearch($Name, $allNames);
            
            // Return suggestions
            if (!empty($suggestions)) {
                return $suggestions;
            } else {
                return "No matches";
            }
        }
    }
    
    
}
