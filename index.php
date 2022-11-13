<?php
	/*
		WEB SERVICE => 

		tiene las opciones de leer, crear y eliminar 
	*/

	//Realiza la conexión 
	include 'conexion.php';
	
	$pdo = new Conexion();


  	////////////////////////////////////////MÉTODO GET////////////////////////////////////////////////////////////////////////////
	//Listar registros y consultar registro
	  if($_SERVER['REQUEST_METHOD'] == 'GET'){

		//
		if(isset($_GET['id']))
		{
			//
			$sql = $pdo->prepare("SELECT * FROM contactos WHERE id=:id");
			//
			$sql->bindValue(':id', $_GET['id']);
			$sql->execute();
			//FETCH_ASSOC =>
			$sql->setFetchMode(PDO::FETCH_ASSOC);

			//Respuesta => 200 OK La solicitud ha tenido éxito. 
			header("HTTP/1.1 200 Hay datos");

			//JSON regrese la información 
			echo json_encode($sql->fetchAll());
			exit;				
			
			} else {
			
			$sql = $pdo->prepare("SELECT * FROM contactos");
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			header("HTTP/1.1 200 Hay datos");
			echo json_encode($sql->fetchAll());
			exit;		
		}
	}
	
	////////////////////////////////////////MÉTODO POST////////////////////////////////////////////////////////////////////////////
	//Insertar registro
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$datos = json_decode(file_get_contents('php://input'));	
		if(contactos::insert($datos->nombre, $datos->apellido, $datos->edad, $datos->identifcacion, $datos->telefono, $datos->ciudad, $datos->email)) {
			http_response_code(200);
		}//end if
		else {
			//el codigo 400 significa que la solicitud no es valida
			http_response_code(400);
		}//end else
	
		//
	}
	
	////////////////////////////////////////MÉTODO PUT////////////////////////////////////////////////////////////////////////////
	//Actualizar registro
	if($_SERVER['REQUEST_METHOD'] == 'PUT')
	{		
		$sql = "UPDATE contactos SET nombre=:nombre, apellido=:apellido, edad=:edad, identificacion=:identificacion, telefono=:telefono, ciudad=:ciudad, email=:email WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':nombre', $_GET['nombre']);
		$stmt->bindValue(':apellido', $_GET['apellido']);
		$stmt->bindValue(':edad', $_GET['edad']);
		$stmt->bindValue(':identificacion', $_GET['identificacion']);
		$stmt->bindValue(':telefono', $_GET['telefono']);
		$stmt->bindValue(':ciudad', $_GET['ciudad']);
		$stmt->bindValue(':email', $_GET['email']);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	

	////////////////////////////////////////MÉTODO DELETE////////////////////////////////////////////////////////////////////////////
	//Eliminar registro
	if($_SERVER['REQUEST_METHOD'] == 'DELETE')
	{
		$sql = "DELETE FROM contactos WHERE id=:id";
		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(':id', $_GET['id']);
		$stmt->execute();
		header("HTTP/1.1 200 Ok");
		exit;
	}
	
	//Si no corresponde a ninguna opción anterior
	header("HTTP/1.1 400 Bad Request");
?>