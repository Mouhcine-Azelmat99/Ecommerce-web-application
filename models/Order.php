<?php

class Order{
     static public function getAll(){
        $stmt = DB::connect()->prepare('SELECT * FROM orders ORDER BY done_at DESC');
        $stmt->execute();
        return $stmt->fetchAll();
        $stmt->close();
        $stmt =null;
    }
    static public function createOrder($data){
        $stmt = DB::connect()->prepare('INSERT INTO orders (fullname,product,qte,price,total)
            VALUES (:fullname,:product,:qte,:price,:total)');
            $stmt->bindParam(':fullname',$data['fullname']);
            $stmt->bindParam(':product',$data['product']);
            $stmt->bindParam(':qte',$data['qte']);
            $stmt->bindParam(':price',$data['price']);
            $stmt->bindParam(':total',$data['total']);
            if($stmt->execute()){
                return 'ok';
            }else{
                return 'error';
            }
            $stmt->close();
            $stmt = null;
    }
    static public function deleteOrder($data){
        $id = $data['id'];
        try{
            $stmt = DB::connect()->prepare('DELETE FROM orders WHERE id = :id');
            $stmt->execute(array(":id" => $id));
            $order = $stmt->fetch(PDO::FETCH_OBJ);
            if($stmt->execute()){
                return 'ok';
            }else{
                return 'error';
            }
            $stmt->close();
            $stmt =null;
        }catch(PDOException $ex){
            echo "erreur " .$ex->getMessage();
        }
    }
}