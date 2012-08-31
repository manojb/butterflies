<?php 
ini_set('display_errors',1);
class RestUtils
{
	public static function processRequest()
	{
		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		$return_obj		= new RestRequest();
		$data			= array();

		switch ($request_method)
		{
			case 'get':
				$data = $_GET;
				break;
			case 'post':
				$data = $_POST;
				break;
			case 'put':
				parse_str(file_get_contents('php://input'), $put_vars);
				$data = $put_vars;
				break;
		}
		
		//Set action method
		$action_method = isset($data['action']) ? $data['action'] : '';

		// store the method
		$return_obj->setMethod($action_method);

		// set the raw data, so we can access it if needed (there may be
		// other pieces to your requests)
		$return_obj->setRequestVars($data);

		if(isset($data['data']))
		{
			// translate the JSON to an Object for use however you want
			$return_obj->setData(json_decode($data['data']));
		}
		return $return_obj;
	}

	public static function sendResponse($status = 200, $response = '', $content_type = 'text/html')
	{
		$body['status_code'] = $status;
		$body['status_msg'] = RestUtils::getStatusCodeMessage($status);
		$body['response'] = $response;
		echo json_encode($body);
		exit;
	}

	public static function getStatusCodeMessage($status)
	{
		$codes = Array(
		    100 => 'Continue',
		    101 => 'Switching Protocols',
		    200 => 'OK',
		    201 => 'Created',
		    202 => 'Accepted',
		    203 => 'Non-Authoritative Information',
		    204 => 'No Content',
		    205 => 'Reset Content',
		    206 => 'Partial Content',
		    300 => 'Multiple Choices',
		    301 => 'Moved Permanently',
		    302 => 'Found',
		    303 => 'See Other',
		    304 => 'Not Modified',
		    305 => 'Use Proxy',
		    306 => '(Unused)',
		    307 => 'Temporary Redirect',
		    400 => 'Bad Request',
		    401 => 'Unauthorized',
		    402 => 'Payment Required',
		    403 => 'Forbidden',
		    404 => 'Not Found',
		    405 => 'Method Not Allowed',
		    406 => 'Not Acceptable',
		    407 => 'Proxy Authentication Required',
		    408 => 'Request Timeout',
		    409 => 'Conflict',
		    410 => 'Gone',
		    411 => 'Length Required',
		    412 => 'Precondition Failed',
		    413 => 'Request Entity Too Large',
		    414 => 'Request-URI Too Long',
		    415 => 'Unsupported Media Type',
		    416 => 'Requested Range Not Satisfiable',
		    417 => 'Expectation Failed',
		    500 => 'Internal Server Error',
		    501 => 'Not Implemented',
		    502 => 'Bad Gateway',
		    503 => 'Service Unavailable',
		    504 => 'Gateway Timeout',
		    505 => 'HTTP Version Not Supported'
		);
		return (isset($codes[$status])) ? $codes[$status] : '';
	}
}

class RestRequest
{
	private $request_vars;
	private $data;
	private $http_accept;
	private $method;

	public function __construct()
	{
		$this->request_vars		= array();
		$this->data				= '';
		$this->http_accept		= (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'json')) ? 'json' : 'xml';
		$this->method			= 'get';
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function setMethod($method)
	{
		$this->method = $method;
	}

	public function setRequestVars($request_vars)
	{
		$this->request_vars = $request_vars;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getMethod()
	{
		return $this->method;
	}

	public function getHttpAccept()
	{
		return $this->http_accept;
	}

	public function getRequestVars()
	{
		return $this->request_vars;
	}
}