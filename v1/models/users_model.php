<?php

class Users extends Conectar{

    public function get_all(){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT * FROM users";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_users(){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT nameUser FROM users";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_users_ids(){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT telegramID FROM users";
        $sql=$conectar->prepare($sql);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_users_by_name($nameUser){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT * FROM users WHERE nameUser=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$nameUser);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_users_by_id($internalId){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT * FROM users WHERE internalID=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$internalId);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_user_creation_date($public_Id){
        $conectar=parent::connect();
        parent::set_name();
        $sql="SELECT nameUser,dateCreation,telegramID,internalID FROM users WHERE telegramID=?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$public_Id);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_animes_of_usr($telegramID){
        $conectar=parent::connect();
        parent::set_name();

        $sql="SELECT animes.name, user_animes.lastCapNoti, animes.ani_id
        FROM user_animes 
        LEFT JOIN animes ON user_animes.ani_id = animes.ani_id 
        RIGHT JOIN users ON user_animes.user_id = users.internalID
        WHERE users.telegramID = ?";
        $sql=$conectar->prepare($sql);
        $sql->bindValue(1,$telegramID);
        $sql->execute();

        return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_user_database($telegramID, $nameUser, $LastNameUsr, $UsrName) {
        // Connect to the database
        $conectar = parent::connect();
        parent::set_name();
        
        // Use parameterized queries to prevent SQL injection attacks (In this case I'm using "?")
        $sql = "SELECT * FROM users WHERE telegramID = ? AND nameUser = ? AND LastNameUsr = ? AND UsrName = ?";
        $stmt = $conectar->prepare($sql);
        $stmt->execute([$telegramID, $nameUser, $LastNameUsr, $UsrName]);
    
        // Check for any existing data that matches the input parameters
        if ($stmt->rowCount() > 0) {
            echo "Ya existe";
        } else {
            // Insert the new data into the database using parameterized queries
            $sql = "INSERT INTO users (telegramID, nameUser, LastNameUsr, UsrName) VALUES (?, ?, ?, ?)";
            $stmt = $conectar->prepare($sql);
            $stmt->execute([$telegramID, $nameUser, $LastNameUsr, $UsrName]);
        }
    
        // Fetching the result set is unnecessary and will throw an error because is a POST method, so remove the line under this comment:
        // return $resultado=$sql->fetchAll(PDO::FETCH_ASSOC);
    }
   
    public function add_anime_to_usr($nameAnime,$telegramID ){
        $conectar = parent::connect();
        parent::set_name();
        
        $sql = "INSERT INTO user_animes (ani_id, user_id, lastCapNoti) 
        SELECT animes.ani_id, users.internalID , animes.Last_Episode
        FROM animes, users 
        WHERE animes.name = ? AND users.telegramID = ?";

        $stmt = $conectar->prepare($sql);

        try {
            $stmt->execute([$nameAnime,$telegramID]);
            echo "Done";
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
        
    }

    public function remove_anime_to_usr($nameAnime,$telegramID){
        $conectar = parent::connect();
        parent::set_name();
        
        $sql = "DELETE user_animes 
        FROM user_animes 
        INNER JOIN animes ON user_animes.ani_id = animes.ani_id 
        INNER JOIN users ON user_animes.user_id = users.internalID 
        WHERE animes.name = ? AND users.telegramID = ?";

        $stmt = $conectar->prepare($sql);

        try {
            $stmt->execute([$nameAnime,$telegramID]);
            echo "Done";
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
    }

    public function alter_anime_to_usr($lastEpisode, $ani_id,$telegramID,  ){
        $conectar = parent::connect();
        parent::set_name();
        
        $sql = "UPDATE user_animes 
        JOIN users ON user_animes.user_id = users.internalID
        SET user_animes.lastCapNoti = ?
        WHERE user_animes.ani_id = ? AND users.telegramID = ?
        ";

        $stmt = $conectar->prepare($sql);

        try {
            $stmt->execute([$lastEpisode,$ani_id,$telegramID]);
            echo "Done";
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
        }
        
    }

    
}

?>