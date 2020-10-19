<?php

    class Usuario{
        private $id;
        private $email;
        private $senha;
        private $nome;

        private $pdo;

        public function __construct($i = null){
            try{
                $this->pdo = new PDO("mysql:dbname=usuarios;host=localhost:8889", "admin", "admin");
            }catch(PDOException $e){
                echo "ERRO: ".$e->getMessage();
            }

            if(!empty($i)){
                $sql = "SELECT * FROM usuarios WHERE id = ?";
                $sql = $this->pdo->prepare($sql);
                $sql->execute(array($i));

                if($sql->rowCount() > 0){
                    $dado = $sql->fetch();
                    $this->id = $dado['id'];
                    $this->email = $dado['email'];
                    $this->senha = $dado['senha'];
                    $this->nome = $dado['nome'];
                }
            }    
        }


        public function getId(){
            return $this->id;
        }

        public function setEmail($v){
            $this->email = $v;
        }
        public function getEmail(){
            return $this->email;
        }

        public function setSenha($v){
            $this->senha = md5($v);
        }       

        public function setNome($v){
            $this->nome = $v;
        }
        public function getNome(){
            return $this->nome;
        }

        public function salva(){
            if(!empty($this->id)){
                $sql = "UPDATE usuarios SET email = ?, senha = ?, nome = ? WHERE id = ?";
                $sql = $this->pdo->prepare($sql);
                $sql->execute(array($this->email, $this->senha, $this->nome, $this->id));
            }else{
                $sql = "INSERT INTO usuarios SET email = ?, senha = ?, nome = ?";
                $sql = $this->pdo->prepare($sql);
                $sql->execute(array($this->email, $this->senha, $this->nome));
            }
        }

        public function delete(){
            $sql = "DELETE FROM usuarios WHERE id = ?";
            $sql = $this->pdo->prepare($sql);
            $sql->execute(array($this->id));
        }
    }

?>