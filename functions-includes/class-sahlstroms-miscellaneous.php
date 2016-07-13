<?php

class Sahlstroms_Miscellaneous {

	public function __construct() {
		add_action('init', array($this, 'register_menu'));
		add_action( 'wp_ajax_email_action', array($this, 'email_action') );
		add_action( 'wp_ajax_nopriv_email_action', array($this, 'email_action') );
		add_filter( 'user_contactmethods', array($this, 'modify_contact_methods'));
		add_action( 'show_user_profile', array($this, 'custom_user_field') );
		add_action( 'edit_user_profile', array($this, 'custom_user_field') );
		add_action( 'personal_options_update', array($this, 'my_save_custom_user_profile_fields') );
		add_action( 'edit_user_profile_update', array($this, 'my_save_custom_user_profile_fields') );
	}
	
	public function email_action() {

        $name = strip_tags(trim($_POST["name"]));
	$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phonenumber = trim($_POST["phonenumber"]);
        $address = trim($_POST["address"]);
        $citystate = trim($_POST["citystate"]);
        $message = trim($_POST["message"]);

        if ( empty($name) ) {
            http_response_code(400);
            echo "Please enter at least your first name.";
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo "Please enter a valid email address.";
            exit;
        }

        if ( empty($message) ) {
            http_response_code(400);
            echo "Please enter a message.";
            exit;
        }

	$users = get_users();
        $emailArray = [];
        $phoneArray = [];
        foreach($users as $user) {

        	if(get_the_author_meta('get_messages', $user->ID) === 'yes') {
        		array_push($emailArray, $user->data->user_email); 

        		$phoneNumber = get_the_author_meta('phone_number', $user->ID);
        		if($phoneNumber) {
        			$phoneNumber = preg_replace("/\D/", "", $phoneNumber) . '@vtext.com';
        			array_push($phoneArray, $phoneNumber); 
        		}
        	}
        }
        $recipients = implode(',', $emailArray);
        $textRecipients = implode(',', $phoneArray);

        $email_headers = "From: $name <$email>";
        $email_headers .= "Reply-To: $email\r\n";
        $email_headers .= "MIME-Version: 1.0\r\n";
        $email_headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        
        $text_headers = "Content-Type: text/plain";

        $subject = "Sahlstroms HVAC Message Submitted";
        $email_content = "Name: $name\n";
        $email_content .= "Phone: $phonenumber\n";
        $email_content .= "Email: $email\n";
        $email_content .= "Address: $address\n";
        $email_content .= "City, State: $citystate\n";
        $email_content .= "\n";
        $email_content .= "Message:\n$message\n";
        
        $text_content = "$name\n";
        $text_content .= "$phonenumber\n";
        $text_content .= "$email\n";
        $text_content .= "$address";

        if (mail($recipients, $subject, $email_content, $email_headers)) {
            http_response_code(200);
            echo "Thanks! Your message has been sent.";
        } else {
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

        mail($textRecipients, '', $text_content, $text_headers);

       	if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])){
			wp_redirect(home_url() . '/contact?formSubmitted');
		}

        die();   
	}

	public function register_menu() {
		register_nav_menu('primary-menu', __('Primary Menu'));
	}

	public function my_acf_json_save_point($path) {
	    $path = get_stylesheet_directory() . '/acf-fields';
	    return $path; 
	}

	public function my_acf_json_load_point($paths) {
	    unset($paths[0]);
	    $paths[] = get_stylesheet_directory() . '/acf-fields';
	    return $paths;
	}

	public function modify_contact_methods($profile_fields) {
		$profile_fields['phone_number'] = 'Phone Number';
		return $profile_fields;
	}

	public function custom_user_field( $user ) {
		$getMessages = get_the_author_meta( 'get_messages', $user->ID);
		?>
		    <h3><?php _e('Notifications'); ?></h3>
		    <p>If checked, this user will recieve messages when they're submitted on the site.</p>
		    <table class="form-table">
		        <tr>
		            <th>
		                <label for="company">Recieve Messages?</label>
		            </th>
		            <td>
		                <label><input type="checkbox" name="get_messages" <?php if ($getMessages == 'yes' ): ?> checked="checked"<?php endif; ?> value="yes" />Yes, receive messages.</label>
		            </td>
		        </tr>
		    </table>
		<?php 
	}

	public function my_save_custom_user_profile_fields( $user_id ) {
	    if ( !current_user_can( 'edit_user', $user_id ) )
	        return FALSE;

	    update_usermeta( $user_id, 'get_messages', $_POST['get_messages'] );
	}
}
