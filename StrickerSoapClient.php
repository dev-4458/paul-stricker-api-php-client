<?php
/**
 * WebService Client v1.2
 *
 * @service StrickerSoapClient
 */
class StrickerSoapClient{
	/**
	 * The WSDL URI
	 *
	 * @var string
	 */
	public static $_WsdlUri='http://ws.stricker-europe.com/StrickerService.svc?wsdl';
	

	public static $clientWCFAZURE;

	public static function InitializeSoap()
	{
		if(self::$clientWCFAZURE == null){
			self::$clientWCFAZURE = new SoapClient(self::$_WsdlUri, array('cache_wsdl' => 0, "connection_timeout"=>1200));
		}
	}

	/**
	 * AuthenticateClient
	 *
	 * @var string
	 */
	public static function AuthenticateClient($accessKey)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->AuthenticateClient(array('accessKey' => $accessKey));
		return $response->AuthenticateClientResult;
	}
	
	public static function ValidateSession($token)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->ValidateSession(array('token' => $token));
		return $response->ValidateSessionResult;
	}
	
	public static function Products($token, $lang)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->Products(Array(
			"token" => $token,
			"lang" => $lang
		));
		return $response->ProductsResult;
	}
	
	public static function Optionals($token, $lang)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->Optionals(Array(
			"token" => $token,
			"lang" => $lang
		));
		return $response->OptionalsResult;
	}
	
	public static function OptionalsComplete($token, $lang)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->OptionalsComplete(Array(
			"token" => $token,
			"lang" => $lang
		));
		return $response->OptionalsCompleteResult;
	}
	
	public static function CustomizationOptions($token, $lang)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->CustomizationOptions(Array(
			"token" => $token,
			"lang" => $lang
		));
		return $response->CustomizationOptionsResult;
	}
	
	public static function Stocks($token, $lang)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->Stocks(Array(
			"token" => $token,
			"lang" => $lang
		));
		return $response->StocksResult;
	}
	
	public static function CustomizationTables($token, $lang)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->CustomizationTables(Array(
			"token" => $token,
			"lang" => $lang
		));
		return $response->CustomizationTablesResult;
	}
	
	/**
	 * CreateOrder
	 *
	 * NOTE VERY IMPORTANT -> You must save OrderLineStamp field from this request response, in your system in order to process the art work later (using the method CreateServiceOrder).
	 * 
	 * @param  mixed $token
	 * 
	 * Get token as response send request with public key 
	 * 
	 * @param  mixed $order
	 * 
     * $orderLine1 = Array( "LineType" => "Simple", "Sku" => "81000.03", "Quantity" => "1" );
	 * $orderLine2 = Array( 
	 * 	  "LineType" => "PRINT",
	 * 	  "Sku" => "81000.05", 
	 * 	  "Quantity" => "1",
	 * 	  "WaitArtWork" => true
	 *  );
	 * $order = Array($orderLine1, $orderLine2);
	 * 
	 * @param  mixed $destination
	 * 
	 * $destination = Array(
	 * 	  "AddressLine1" => "Street name",
	 * 	  "AddressLine2" => "Door number",
	 * 	  "Postalcode" => "1000",
	 * 	  "ExtentionPostalcode" => "",
	 * 	  "City" => "City",
	 * 	  "Country" => "PT",
	 * 	  "PhoneNumber" => "93243232",
	 * );
	 * 
	 * @param  mixed $courier
	 * 
	 * 	Example: "CTT"
	 * 
	 * @param  mixed $observation
	 * 
	 *  Example: "Testing" or ""
	 * 
	 * @param  mixed $internalReference
	 * 
	 *  Your id of the order in your system.
	 * 
	 * @param  mixed $relatedOrderStamp
	 * 
	 *  Related Order Stamp or null.
	 * 
	 * @param  mixed $shippingDate
	 * 
	 * 	Date to Ship this order.
	 * 
	 * @param  mixed $noShipping
	 * 
	 *  Indicate wether this order has shipping (true) or not (false).
	 * 
	 * @param  mixed $test
	 * 
	 * This variable determine if the request is to be inserted in prod or dev envoyrement
	 * 
	 *
	 * @return void
	 */
	public static function CreateOrder($token, $order, $destination, $courier, $observation, $internalReference, $relatedOrderStamp = null, $shippingDate = null, $noShipping =false , $test = false)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->OrderV1(Array(
			"token" => $token,
			"order" => $order,
			"destination" => $destination,
			"courier" => $courier,
			"observation" => $observation,
			"internalReference" => $internalReference,
			"relatedOrderStamp" => null,
			"shippingDate" => null,
			"noShipping" => false,
			"test" => $test
		));
		return $response;
	}

	/**
	 * CreateServiceOrder
	 *
	 * @param  mixed $token
	 * 
	 * Get token as response send request with public key 
	 * 
	 * @param  mixed $orderStamp
	 * 
	 * Get orderStamp from {Response from CreateOrder}->OrderV1Result->OrderDetails->OrderStamp
	 * 
	 * @param  mixed $serviceOrdersArray
	 *
	 *  $fileExampleByes = file_get_contents("PATH_TO_FILE");
	 *
	 * 		$arrayServiceFiles = array(
	 * 			array(
	 * 					"FileName" => "test",
	 * 					"FileExtension" => "txt",
	 * 					"FileBytes" => $fileExampleByes 
	 * 				)
	 * 		);
	 *
	 * 		$serviceOrdersArray = array(
	 * 			array(
	 * 				"OrderLineStamp" => $OrderLineStamp,
	 * 				"Appproved" => true,
	 * 				"LogoArea" => 2.25,
	 * 				"LogoHeight" => 1.5,
	 * 				"LogoWidth" => 1.5,
	 * 				"ServCode" => "81000.16.27.LSR1-01-01",
	 * 				"Files" => $arrayServiceFiles
	 * 			)
	 * 		);
	 *
	 * @param  mixed $test
	 * 
	 * This variable determine if the request is to be inserted in prod or dev envoyrement
	 *
	 * @return void
	 */
	public static function CreateServiceOrder($token, $orderStamp, $serviceOrdersArray, $test){
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->ServiceOrderV1(Array(
			"token" => $token,
			"orderStamp" => $orderStamp,
			"order" => $serviceOrdersArray,
			"test" => $test
		));
		return $response;
	}
	
	public static $arrayStatus = array(
		"Empty" => "",
		"WAITING_ART_WORK" => "WAITING_ART_WORK",
		"WAITING_ART_WORK_AND_STOCK" => "WAITING_ART_WORK_AND_STOCK",
		"NEW" => "NEW",
		"PROCESSING" => "PROCESSING",
		"WAITING_STOCK" => "WAITING_STOCK",
		"PROCESSED" => "PROCESSED",
		"PENDING_MOCKUP_APPROVAL" => "PENDING_MOCKUP_APPROVAL",
		"INVOICED" => "INVOICED",
		"SENT" => "SENT",
		"CANCELED" => "CANCELED");

	/**
	 * OrderList
	 * 
	 * @param  mixed $token
	 * 
	 * Get token as response send request with public key 
	 * 
	 * @param  mixed $statusOption
	 * 
	 * "Empty" => "",
	 * "WAITING_ART_WORK" => "WAITING_ART_WORK",
	 * "WAITING_ART_WORK_AND_STOCK" => "WAITING_ART_WORK_AND_STOCK",
	 * "NEW" => "NEW",
	 * "PROCESSING" => "PROCESSING",
	 * "WAITING_STOCK" => "WAITING_STOCK",
	 * "PROCESSED" => "PROCESSED",
	 * "PENDING_MOCKUP_APPROVAL" => "PENDING_MOCKUP_APPROVAL",
	 * "INVOICED" => "INVOICED",
	 * "SENT" => "SENT",
	 * "CANCELED" => "CANCELED"
	 * 
	 * @param  mixed $numberOfRecords
	 * 
	 * Number of records to get from webservice Soap Server
	 * 
	 * @param  mixed $test
	 * 
	 * This variable determine if the request is to be inserted in prod or dev envoyrement
	 *
	 * @return void
	 */
	public static function OrderList($token, $statusOption = "Empty", $numberOfRecords = 10, $test = false)
	{	

		$optionStatusofArray = self::$arrayStatus[$statusOption];

		self::InitializeSoap();
		$response = self::$clientWCFAZURE->OrdersV1(Array(
			"token" => $token,
			"status" => $optionStatusofArray,
			"number" => $numberOfRecords,
			"test" => $test
		));
		return $response->OrdersV1Result;
	}

	public static function Colors($token, $langage){
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->Colors(Array(
			"token" => $token,
			"lang" => $langage
		));
		return $response->ColorsResult;
	}
	
	public static function ProductsTree($token, $lang)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->ProductsTree(Array(
			"token" => $token,
			"lang" => $lang
		));
		return $response->ProductsTreeResult;
	}
	
	public static function CloseSession($token)
	{
		self::InitializeSoap();
		$response = self::$clientWCFAZURE->CloseSession(Array( "token" => $token ));
	}
	
}
