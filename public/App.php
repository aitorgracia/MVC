<?php

class App
{

    public $dsn ="mysql:dbname=agenda;host=db";
    public $user="root";
    public $clave="password";
    public $db;


    public function __construct()
    {
      
  
      session_start();
    
      
          try {
              $this->db = new PDO($this->dsn, $this->user, $this->clave);
              
          } catch (PDOException $e) {
              echo 'Falló la conexión: ' . $e->getMessage();
          }
          
      }

  public function run()
  {
    if (isset($_GET['method'])) {
      $method = $_GET['method'];
    } else {
      $method = 'login';
    }
  
    $this->$method();      
  }

  public function login()
  {
    if (isset($_SESSION['name'])) 
    {
      header('Location: ?method=home');
      return;
    }

    include('views/login.php');
  }

  public function auth()
  {
    if (isset($_POST['name']) && !empty($_POST['name'])) {

        $name = $_POST['name'];
        $password = $_POST['password'];
        $acred = false;

        $resultado = $this->ejecutarConsulta("SELECT password FROM credenciales WHERE usuario = '".$name."'; ");

        foreach ($resultado as  $value) {
            if (password_verify($password, $value[0])) {
                
                $acred = true;
                
            }
        }
        if ($acred) {
            $_SESSION['name'] = $name;
            $this->ejecutarConsulta(
                "CREATE TABLE IF NOT EXISTS contactos( 
                Tipo   VARCHAR (10) NOT NULL,
                Nombre   VARCHAR (20) NOT NULL,
                Apellidos VARCHAR (40),
                Direccion  VARCHAR (40)NOT NULL,
                Telefono  VARCHAR (13) NOT NULL,
                Email  VARCHAR (40)
                );");
            header('Location: ?method=home');
            return;
        }
    } 
    header('Location: ?method=login');
    
    }

    public function cargarXmlEnBd()
    {
        
        $datos = simplexml_load_file("agenda.xml")->xpath("//contacto");     


        foreach ($datos as $fila) {
            
            $atributo = $fila->xpath("./@tipo"); 
            $nombre = $fila->nombre;
            $apellidos = $fila->apellidos;
            $direccion = $fila->direccion;
            $telefono = $fila->telefono;
            $email = $fila->email;

            if ($atributo[0] == 'persona') {
                $sql = $this->db-> prepare("INSERT INTO contactos (tipo,nombre,apellidos,direccion,telefono) VALUES (?,?,?,?,?)");

                $sql->bindParam(1,$atributo[0]);
                $sql->bindParam(2,$nombre);
                $sql->bindParam(3,$apellidos);
                $sql->bindParam(4,$direccion);
                $sql->bindParam(5,$telefono);
            }
            else {
                $sql = $this->db-> prepare("INSERT INTO contactos (tipo,nombre,direccion,telefono,email) VALUES (?,?,?,?,?)");

                $sql->bindParam(1,$atributo[0]);
                $sql->bindParam(2,$nombre);
                $sql->bindParam(3,$direccion);
                $sql->bindParam(4,$telefono);
                $sql->bindParam(5,$email);
            }

            $sql->execute();

        }

        header('Location: ?method=home');

    }

    public function mostrarCon()
    {

            $resultadop = $this->ejecutarConsulta("SELECT * FROM contactos WHERE tipo = 'persona';");
            $resultadoe = $this->ejecutarConsulta("SELECT * FROM contactos WHERE tipo = 'empresa';");
            
        include "views/home.php";
    }

    public function compTlf()
    {
        if (isset($_POST['tlf']) && !empty($_POST['tlf'])) {

            $resultado = $this->ejecutarConsulta("SELECT * FROM contactos WHERE Telefono = '".$_POST['tlf']."';");

            foreach ($resultado as $value) {
                if ($value) {
                    # code...
                }
            }

            
        }
    }

    public function actuCon()
    {
        
        if (isset($_POST['tlf']) && !empty($_POST['tlf'])) {

            
            
        }

    }


    public function close()
    {
        session_destroy();
        
        $resultado = $this->ejecutarConsulta("DROP TABLE contactos; ");

        header('Location: index.php?method=login');
    }

    public function ejecutarConsulta($sql)
    {
        
        return $this->db->query($sql);

    }

    public function home()
    {
        include('views/home.php');
    }

}