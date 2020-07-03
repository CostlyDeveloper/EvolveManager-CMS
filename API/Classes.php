<?php

class Response
{
	public $SessionID;
	public $Response;
	public $Message;

	function __construct($_Response, $_Message, $_SessionID)
	{
		$this->SessionID = $_SessionID ? $_SessionID : null;
		$this->Response = $_Response ? $_Response : null;
		$this->Message = $_Message ? $_Message : null;
	}
}

class ResponseMessage
{

	public $Code;
	public $Title;
	public $Message;

	function __construct($_Code, $_Title, $_Message)
	{
		$this->Code = $_Code ? $_Code : null;
		$this->Title = $_Title ? $_Title : null;
		$this->Message = $_Message ? $_Message : null;
	}
}

class Request
{

	public $Request;
	public $Code;
	public $Title;
	public $Message;

	function __construct($_Request, $_Code = null, $_Title = null, $_Message = null)
	{
		$_Request ? '' : $_Code = '001';



		$this->Request = $_Request ? $_Request : null;
		$this->Code = $_Code ? $_Code : null;
		$this->Title = $_Title ? $_Title : null;
		$this->Message = $_Message ? $_Message : null;
	}
}
