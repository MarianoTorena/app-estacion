<?php
	class User extends DBAbstract
	{
		public $email;
		public $pass;
		public $status = "offline";
		public $access = false;
		public $activo = true;
		public $token = "";

		private $register = true;

		function __construct($email){
			$this->email = $email;

			// Busco si el usuario esta registrado
			$sql = "SELECT * FROM `appestacion__usuarios` WHERE `email`='$this->email';";

			$user_list = $this->query($sql);

			// var_dump($user_list);

			// Si el usuario esta registrado
			if(count($user_list)>0){
				// deshabilito el registro del usuario
				$this->register = false;
				$this->pass = $user_list[0]['password'];
				$this->token = $user_list[0]['token'];
				// comprueba si esta bloqueada, no activo o recuperando
				if ($user_list[0]['token_action'] == '' || $user_list[0]['token_action'] == NULL) {
					$this->access = true;
				}else{
					$this->activo = $user_list[0]['activo'];
				}
				
			}
			
		}

		/**
		 * Solo si el usuario es nuevo lo registra pidiendo una contraseña
		 * */
		function register($pass){

			if(!$this->register){
				return array("errno" => 300, "error" => "El usuario ya se encuentra registrado");
			}
			
			$token = md5(uniqid());
			$token_action = md5(uniqid());

			$sql = "INSERT INTO `appestacion__usuarios` ( `email`, `password`,`token`,`token_action`) VALUES ( '$this->email' ,'".md5($pass)."','".$token."','".$token_action."');";

			$this->query($sql);

			return array("errno" => 200, "error" => "Se agrego correctamente el usuario", "token_action" => $token_action);
		}

		/**		 
		 * valida la contraseña de un usuario valido
		 * */
		function login($pass){

			if(!$this->register){
				if(md5($pass)==$this->pass){
					if ($this->access) {
						$this->status = "online";
						return array("errno" => 200, "error" => "Se logueo correctamente.", "user" => $this->email, "token" => $this->token);
						// envíar un email notificando al usuario que ha iniciado sesión
					}else if ($this->activo == 0) {
						return array("errno" => 402, "error" => "Su usuario aún no se ha validado, revise su casilla de correo.");
					}else{
						return array("errno" => 405, "error" => "Su usuario está bloqueado, revise su casilla de correo.");
					}			
				}else{
					return array("errno" => 401, "error" => "Credenciales incorrectas.");
					// envíar un email al usuario informando el intento de acceso
				}			
			}

			return array("errno" => 404, "error" => "Usuario no registrado");
		}
	}

 ?>