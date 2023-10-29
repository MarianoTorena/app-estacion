<?php 	
		class Usuario extends DBAbstract
	{

		// Valida el usuario por su token_action
		public function validateUser($parameters){
			// Busca usuario con token_action
			$sql ="SELECT * FROM `appestacion__usuarios` WHERE `token_action`='$parameters';";

			$response_query = $this->query($sql);

			$response = array("errno" => 404, "error" => "El token no corresponde a un usuario");
			// Error 404 si no se encuentra
			if(!empty($response_query)){
				$response = $response_query;
			}else{
				return $response;
			}

			$email = $response[0]['email'];
			$active_date = date("Y-m-d H:i:s");
			// Activa el usuario en la db
			$ssql = "UPDATE `appestacion__usuarios` SET `activo` = '1', `token_action` = '', `active_date` = '$active_date' WHERE `appestacion__usuarios`.`email` = '$email';";

			$this->query($ssql);

			return array("errno" => 200, "error" => "Se activo correctamente el usuario");			
		}

		public function blockUser($parameters){
			$sql ="SELECT * FROM `appestacion__usuarios` WHERE `token`='$parameters';";

			$response_query = $this->query($sql);

			$response = array("errno" => 404, "error" => "El token no corresponde a un usuario");
			
			// Error 404 si no se encuentra
			if(!empty($response_query)){
				$response = $response_query;
			}else{
				return $response;
			}

			// bloquea el user
			$email = $response[0]['email'];
			$blocked_date = date("Y-m-d H:i:s");
			$token_action = md5(uniqid());
			// Activa el usuario en la db
			$ssql = "UPDATE `appestacion__usuarios` SET `activo` = '0', `bloqueado` = '1', `token_action` = '$token_action', `blocked_date` = '$blocked_date' WHERE `appestacion__usuarios`.`email` = '$email';";

			$this->query($ssql);

			return array("errno" => 200, "error" => "Se bloqueo correctamente el usuario", "token_action" => $token_action, "email" => $email);
		}

		public function getByToken($tokenAction){
			$sql ="SELECT * FROM `appestacion__usuarios` WHERE `token_action`='$tokenAction';";
			$response_query = $this->query($sql);
			
			// si se encuentra user
			if(!empty($response_query)){
				$response = array('errno' => 200, 'error' => 'usuario encontrado', 'email' => $response_query[0]['email']);
				return $response;
			}else{
				return false;
			}
		}

		public function recovery($parameters){
			$sql ="SELECT * FROM `appestacion__usuarios` WHERE `email`='$parameters';";

			$response_query = $this->query($sql);

			$response = array("errno" => 404, "error" => "El email no se encuentra registrado");

			// Error 404 si no se encuentra
			if(!empty($response_query)){
				$response = $response_query;
			}else{
				return $response;
			}

			$token_action = md5(uniqid());
			$recover_date = date("Y-m-d H:i:s");
			$ssql = "UPDATE `appestacion__usuarios` SET `recuperado` = '1', `recover_date` = '$recover_date', `token_action` = '$token_action' WHERE `appestacion__usuarios`.`email` = '$parameters';";

			$this->query($ssql);

			return array("errno" => 200, "error" => "Se Inicio el proceso de restablecimiento", "token_action" => $token_action, "email" => $parameters);
		}

		public function resetPass($email,$pass){
			$password = md5($pass);
			$sql = "UPDATE `appestacion__usuarios` SET `activo` = '1', `password` = '$password', `recuperado` = '0', `bloqueado` = '0', `token_action` = '' WHERE `appestacion__usuarios`.`email` = '$email';";

			$this->query($sql);

			$sql ="SELECT `token` FROM `appestacion__usuarios` WHERE `email`='$email';";
			$response = $this->query($sql);
			// var_dump($response);
			return array("errno" => 200, "error" => "Se reestablecio correctamente", "token" => $response[0]['token'], "email" => $email);
		}
	}
 ?>