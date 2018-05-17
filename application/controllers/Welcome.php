<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection; 

class Welcome extends CI_Controller {

	public function index()
	{
		$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
		$channel = $connection->channel();
		$channel->queue_declare('hello', false, false, false, false);

		$msg = new AMQPMessage('Yur message goes here....');
		$channel->basic_publish($msg, '', 'hello');
		
		$channel->close();
		$connection->close();

		$this->load->view('welcome_message');
	}
}
