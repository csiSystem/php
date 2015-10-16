<?php
/**
*Permet de parser une url 
* @param $url Url à parser
*@return tableau contenant les paramètres
*/
class Router
{
	static function parse($url,$request){
		//decomplosition de l'url
		$url = trim($url,'/');
		$params = explode('/', $url);
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : index;
		$request->params = array_slice($params,2);
		return true;

	}
}

?>