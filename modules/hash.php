<?php
	//Модуль хеширования паролей
	function getHash($password){
		$salt = "";
		while(strlen($salt) < 50){
			$char = chr(rand(97, 125));
			if($char == 62 || $char == 60)
				continue;
			$salt .= $char;
		}
		return array('hash' => hash('sha512', $salt . $password), 'salt' => $salt);
	}

	function compareHash($password, $hash, $salt){
		if($hash == hash('sha512', $salt . $password))
			return true;
		else
			return false;
	}
?>