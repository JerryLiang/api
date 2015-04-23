<?php

class DataStore {
	
	var $_root = '/datastore/';
	var $_prefix = '/datastore/';
	var $_memcache = null;
	var $_servers = array();
	
	public function __construct($prefix='',$server='') {
		if (!empty($prefix)) {
			$this->_prefix = $this->_root.$prefix;
	  }
		
		if (!empty($server)) {
			$servers = explode(',',$server);	
		} elseif (defined('DATASTORE_STORE_PATH')) {
			$servers = explode(',',DATASTORE_STORE_PATH);
		} else {
			_logger(_LL_ERROR, "please check DATASTORE_STORE_PATH settings.\n");
		}
		
		foreach ($servers as $server) {
			$params = @parse_url($server);	
			$host = $params['host'];
			$port = strval($params['port']);
			$this->_servers[] = array( "host" => $host, "port" => $port);
		}
		if (!$this->connect()) {
			_logger(_LL_ERROR, "please check DATASTORE_STORE_PATH settings.\n");
		}
	}
	
	private function connect() {
		$sn = count($this->_servers);
		if ($sn==0) {
			return false; 
		} else if ($sn==1) {
			try {
					$tt = new TokyoTyrant();				
				  $this->_memcache = $tt->connect($this->_servers[0]["host"], $this->_servers[0]["port"]);	
				  return true;
			} catch (TokyoTyrantException $e) {
			    return false;
			}
			 
		} else if ($sn>1) {
			$servers = $this->_servers;
			for ($i=0; $i<$sn; $i++) {
					$ret = rand(0,count($servers)-1);
					try {
						  $tt = new TokyoTyrant();						
						  $this->_memcache = $tt->connect($servers[$ret]["host"], $servers[$ret]["port"]);	
						  return true;
					} catch (TokyoTyrantException $e) {
					    if ( ($e->getCode() === TokyoTyrant::TTE_NOHOST) || 
					    		 ($e->getCode() === TokyoTyrant::TTE_REFUSED) ) 
					    {
					    		unset($servers[$ret]);
					    		$servers = array_merge($servers);
					    		continue;
					    }
					    return false;	
					}
			 }
			 return false;
		}
	}
	
	public function add($key, $value) {
		$new_key = $this->_prefix.$key;
		try {
		    return $this->_memcache->putKeep ( $new_key, serialize ( $value ) );
		} catch (TokyoTyrantException $e) {
		    if ($e->getCode() === TokyoTyrant::TTE_KEEP) {
		        return false;
		    } else {
						_logger(_LL_ERROR, "DataStore::add\n".$e->getMessage()."\n" );
						return false;
		    }
		}		
		
	}
	
	public function replace($key, $value) {
		$new_key = $this->_prefix.$key;	
		try {
		    $this->_memcache->get($new_key);
				return $this->_memcache->put( $new_key, serialize ( $value ) );
		} catch (TokyoTyrantException $e) {
		    if ($e->getCode() === TokyoTyrant::TTE_NOREC) {
		        return false;
		    }
		}		
	}
	
	public function set($key, $value=null) {
        if (!is_object($this->_memcache)) return null;
		if (is_array($key)) {
			$new_key = array();
			foreach ($key as $k => $v) {
					$new_key[$this->_prefix.$k] = serialize ( $v );
			}
			try {
			    $this->_memcache->put ( $new_key );
			} catch (TokyoTyrantException $e) {
			    return false;
			}
			return true;
		} else {
			$new_key = $this->_prefix.$key;
			try {
			    $this->_memcache->put ( $new_key, serialize ( $value ) );
			} catch (TokyoTyrantException $e) {
			    return false;
			}
			return true;
		}		
	}
	
	public function get($key) {
        if (!is_object($this->_memcache)) return null;
		if (is_array($key)) {
			$new_key = array();
			foreach ($key as $k) {
					$new_key[] = $this->_prefix.$k;
			}			
			$result = $this->_memcache->get ( $new_key );
			if (is_array ( $result )) {
				foreach ( $result as $k => $v ) {
					$result [$k] = $v === false ? false : unserialize ( $v );
				}
			}
		} else {
			$new_key = $this->_prefix.$key;	
			$result = $this->_memcache->get ( $new_key );
			if ($result) {
				$result = unserialize ( $result );
			}
		}
		return $result;
	}	

	public function delete($key) {
		if (is_array($key)) {
			$new_key = array();
			foreach ($key as $k) {
					$new_key[] = $this->_prefix.$k;
			}			
			return $this->_memcache->out ( $new_key );
		} else {
			$new_key = $this->_prefix.$key;	
			return $this->_memcache->out ( $new_key );
		}				
	}

}

?>