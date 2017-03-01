<?php
use System\Libs\LogIntoDb;
use System\Libs\Emailer;
 
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

	},
	'change_price' => function($user_id_array, $price_change_data){

		foreach ($user_id_array as $value) {
			# code...
		}

		$to_email = '';
		$to_name = '';
		$subject = '';
		$from_email = '';
		$from_name = '';
		$template_data = '';

        // paraméterek: ($from_email, $from_name, $to_email, $to_name, $subject, $form_data, $template)
        $emailer = new Emailer($from_email, $from_name, $to_email, $to_name, $subject, $template_data, 'arvaltozas');
        if ($emailer->send()) {
			return false;
        } else {
			return true;
        }		
	} 


);
?>