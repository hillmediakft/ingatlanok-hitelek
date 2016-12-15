<?php
use System\Libs\LogIntoDb;
 
$config['events'] = array(

	'insert_user' => function($type, $message){

		$log = new LogIntoDb();
		$log->index($type, $message);

	},
	'update_user' => function($type, $message){

		$log = new LogIntoDb();
		$log->index($type, $message);

	},
	'delete_user' => function($type, $message){

		$log = new LogIntoDb();
		$log->index($type, $message);

	},
 	'insert_property' => function($type, $message){

		$log = new LogIntoDb();
		$log->index($type, $message);

	},
	'update_property' => function($type, $message){

		$log = new LogIntoDb();
		$log->index($type, $message);

	},
	'delete_property' => function($type, $message){

		$log = new LogIntoDb();
		$log->index($type, $message);

	} 


);
?>