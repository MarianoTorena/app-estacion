<?php 	
		class Tracker extends DBAbstract
	{

		public function addClientTracker(){
			$post = json_decode(file_get_contents('php://input'),true);
			// var_dump($post);
			// guarda la ip
			$ip = $post['info']['ip'];
			$token = md5($ip);
			$lat = $post['info']['lat'];
			$long = $post['info']['long'];
			$pais = $post['info']['country'];

			$strExplode = explode(' (', $_SERVER["HTTP_USER_AGENT"]);

			$sistema = explode(') ', $strExplode[1])[0];
			$navegador = $strExplode[0];

			// Esta registrado la ip, lat y long?
			$sql = "SELECT * FROM `appestacion__iptracker` WHERE `ip` = '$ip';";
			$response_query = $this->query($sql);

			// Si no esta registrado el ip
			if(empty($response_query)){
				// insert en ip tracker
				$sql = "INSERT INTO `appestacion__iptracker` (`token`, `ip`, `latitud`, `longitud`, `pais`) VALUES ('$token', '$ip', '$lat', '$long', '$pais');";
				$response_query = $this->query($sql);

				$idIpTracker = $this->db->insert_id;
			}else{
				// Si esta registrada obtiene el idIpTracker
				$idIpTracker = $response_query[0]['id'];
			}

			// Incrementa los accesos de cada ip en 1
			foreach ($response_query as $key => $data) {
				$access = $data['access']+1;
				$sql = "UPDATE `appestacion__iptracker` SET `access`= '$access' WHERE `ip` = '$ip';";
				$response_query = $this->query($sql);
			}
			
			// Inserta la informacion del seguimiento
			$sql = "INSERT INTO `appestacion__tracker` (`idIpTracker`, `navegador`, `sistema`) VALUES ('$idIpTracker', '$navegador', '$sistema');";
			$response_query = $this->query($sql);
			
			return array("errno" => 200, "error" => "consulta exitosa");
		}
	}
?>