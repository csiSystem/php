<?php
/**
*Permet de parser une url 
* @param $url Url à parser
* @return tableau contenant les paramètres
*/
class Router
{
	static $routes = array();
	static $prefixes = array();

	/*
	* Ajoute de prefix au routing
	**/
	static function prefix($url,$momPrefix){
		self::$prefixes[$url] = $momPrefix;
	}


	/*
	* Permet de parser une url
	* @param $url Url à parser
	* @return tableau contenant les paramètres
	*/
	static function parse($url,$request){
		//decomplosition de l'url
		$url = trim($url,'/');
		if (empty($url)) {
			$url = Router::$routes[0]['url'];
		}else{
			$match = false;
			foreach (Router::$routes as $v) {
				if (!$match && preg_match($v['redirreg'],$url,$match)) {
					//debug($match);
					$url  = $v['origin'];
					foreach ($match as $k => $v) {
						$url = str_replace(':'.$k.':', $v, $url);
					}
					$match = true;
				}
			}
		}	

		$params = explode('/', $url);
		if(in_array($params[0], array_keys(self::$prefixes))){
			$request->prefix = self::$prefixes[$params[0]];
			array_shift($params);
			//debug($params);die();
		}
		//debug($params);die();
		$request->controller = $params[0];
		$request->action = isset($params[1]) ? $params[1] : 'index';
		foreach (self::$prefixes as $key => $value) {
			if (strpos($request->action,$value.'_')=== 0){
				$request->action = str_replace($value.'_','', $request->action);
			}
		}
		$request->params = array_slice($params,2);
		return true;

	}

	/*
	* connect prend un url et la redirige
	**/

	//maregle = Router::connect('membre/:pseudo-:id','membre/view/id:([0-9]+)/pseudo:([a-z0-9\-]+)');
	static function connect($redir,$url){
		$r= array();

		$r['params'] = array();
		$r['url'] = $url;
		//$r['redir'] = $redir; 
		/*retirer les '/' et les remplacer par des '\' dnas l'url d'origine.
		et a la fin et au debut on met de \
		*/

		$r['originreg'] = preg_replace('/([a-z0-9]+):([^\/]+)/', '${1}:(?P<${1}>${2})',$url);
		$r['originreg'] = str_replace('/*','(?P<args>/?.*)', $r['originreg']);
		$r['originreg'] = '/^'.str_replace('/', '\/', $r['originreg']).'$/';

		$r['origin'] = preg_replace('/([a-z0-9]+):([^\/]+)/',':${1}:',$url);
		$r['origin'] = str_replace('/*', ':args:', $r['origin']);

		$params = explode('/', $url);
		foreach ($params as $key => $value) {
			if (strpos($value,':')) {
				$p = explode(':',$value);
				$r['params'][$p[0]] = $p[1];
			}
		}
		$r['redirreg'] = $redir;

		$r['redirreg'] = str_replace('/*','(?P<args>/?.*)', $r['redirreg']);
		foreach ($r['params'] as $key => $value) {
			//je remplace pa l'expression reguliere correspondante
			$r['redirreg'] = str_replace(":$key","(?P<$key>$value)",$r['redirreg']);
		}
		$r['redirreg'] = '/^'.str_replace('/','\/',$r['redirreg']).'$/';

		$r['redir'] = preg_match('/:([a-z0-9]+)/',':${1}:', $redir);
		$r['redir'] = str_replace('/*', ':args:', $r['redir']);

		//debug($r);die();
		self::$routes[]  = $r;
		
	}
		

	static function url($url = ''){
		trim($url,'/');
		foreach (self::$routes as $v) {
			if(preg_match($v['originreg'],$url,$match)){
				$url = $v['redir'];
				foreach ($match as $key => $w) {
					$url = str_replace(":$key:",$w, $url);
				}
			}
		}
		foreach (self::$prefixes as $key => $value) {
			if (strpos($url, $value) === 0) {
				$url = str_replace($value, $key, $url);
			}
		}
		return BASE_URL.'/'.$url;

	}

}
	
	

?>