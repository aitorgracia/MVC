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

    $resultado = $this->ejecutarConsulta(
        "CREATE TABLE contactos( 
        Nombre   VARCHAR (20) NOT NULL,
        Apellido VARCHAR (20),
        Direccion  VARCHAR (40)NOT NULL,
        Telefono  VARCHAR (13) NOT NULL,
        Correo  VARCHAR (40)
        );");
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
            header('Location: ?method=home');;
            return;
        }
    } 
    header('Location: ?method=login');
    
    }

    public function home()
    {
        include('views/home.php');
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

}