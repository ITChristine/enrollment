<?php

if (isset( $_POST['cpt_enrollment'] )
	&& wp_verify_nonce( $_POST['cpt_enrollment'], 'cpt_nonce_action' ) ) {
	$count=0;
	// die("This code is working");
	require_once(ABSPATH . "wp-admin" . '/includes/image.php');
	require_once(ABSPATH . "wp-admin" . '/includes/file.php');
	require_once(ABSPATH . "wp-admin" . '/includes/media.php');
			
	
	$enDb = new enrollment_class;
	$remote_db = new enrollment_class(get_option('en_db') != null ? get_option('en_db') : "pntc_cloud_db");
	
	$uploaddir = wp_upload_dir();
	$file = $_FILES['inputProfileImage'];
	$uploadfile = $uploaddir['path'] . '/' . basename( $file['name'] );
	move_uploaded_file( $file['tmp_name'] , $uploadfile );
	$filename = basename( $uploadfile );
	$wp_filetype = wp_check_filetype(basename($filename), null );
	$attachment = array(
		'post_mime_type' => $wp_filetype['type'],
		'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
		'post_content' => '',
		'post_parent'  => $cpt_id,	
		'post_status' => 'inherit',
		'menu_order' => $_i + 1000
	);
		
	$attach_id = wp_insert_attachment( $attachment, $uploadfile );
	// create post object with the form values
	$fields = array(
		'inputLastName'			=>	isset($_POST['inputLastName']) ? $_POST['inputLastName'] : "",
		'inputFirstName'		=>	isset($_POST['inputFirstName']) ? $_POST['inputFirstName'] : "",
		'inputMiddleName'		=>	isset($_POST['inputMiddleName']) ? $_POST['inputMiddleName'] : "",
		'inputAge'				=>	isset($_POST['inputAge']) ? $_POST['inputAge'] : "",
		'inputEmail'			=>  isset($_POST['inputEmail']) ? $_POST['inputEmail'] : "",
		'inputCivilStatus'		=>	isset($_POST['inputCivilStatus']) ? $_POST['inputCivilStatus'] : "",
		'inputReligion'			=>	isset($_POST['inputReligion']) ? $_POST['inputReligion'] : "",
		'inputGender'			=>	isset($_POST['inputGender']) ? $_POST['inputGender'] : "",
		'inputHeight'			=>	isset($_POST['inputHeight']) ? $_POST['inputHeight'] : "",
		'inputBMI'				=>	isset($_POST['inputBMI']) ? $_POST['inputBMI'] : "",
		'inputBirthdate'		=>  isset($_POST['inputBirthdate']) ? $_POST['inputBirthdate'] : "",
		'inputWeight'			=>	isset($_POST['inputWeight']) ? $_POST['inputWeight'] : "",
		'inputBirthplace'		=>	isset($_POST['inputBirthplace']) ? $_POST['inputBirthplace'] : "",
		'inputAddress'			=>	isset($_POST['inputAddress']) ? $_POST['inputAddress'] : "",
		'inputProvince'			=>	isset($_POST['inputProvince']) ? $_POST['inputProvincr'] : "",
		'inputFbAddress'		=>	isset($_POST['inputFbAddress']) ? $_POST['inputFbAddress'] : "",		

	);
	
	$my_cptpost_args = array(
	
		'post_title'    => $fields['inputLastName'] . " " . $fields['inputFirstName'] ,
		
		//'post_content'  => 'test',
		
		'post_status'   => 'publish',
		
		'post_type' => 'enrollment',
	
	);
	
	$cpt_id = wp_insert_post( $my_cptpost_args, $wp_error);
	
	//This is the one that handles the image posting to the post
	update_post_meta($cpt_id,'_thumbnail_id',$attach_id);
	set_post_thumbnail( $cpt_id, $thumbnail_id );
	
	update_post_meta( $cpt_id, 'inputLastName', isset($_POST['inputLastName']) ? $_POST['inputLastName'] : "");
	update_post_meta( $cpt_id, 'inputFirstName', isset($_POST['inputFirstName']) ? $_POST['inputFirstName'] : "");
	update_post_meta( $cpt_id, 'inputMiddleName', isset($_POST['inputMiddleName']) ? $_POST['inputMiddleName'] : "");
	update_post_meta( $cpt_id, 'inputAge', isset($_POST['inputAge']) ? $_POST['inputAge'] : "");
	update_post_meta( $cpt_id, 'inputEmail', isset($_POST['inputEmail']) ? $_POST['inputEmail']: "");
	update_post_meta( $cpt_id, 'inputCivilStatus', isset($_POST['inputCivilStatus'])? $_POST['inputCivilStatus'] : "");
	update_post_meta( $cpt_id, 'inputReligion', isset($_POST['inputReligion']) ? $_POST['inputReligion'] :"");
	update_post_meta( $cpt_id, 'inputGender', isset($_POST['inputGender']) ? $_POST['inpurGender']: "" );
	update_post_meta( $cpt_id, 'inputHeight', isset($_POST['inputHeight']) ? $_POST['inputHeight'] : "");
	update_post_meta( $cpt_id, 'inputBMI', isset($_POST['inputBMI']) ? $_POST ['inputBMI'] : "");
	update_post_meta( $cpt_id, 'inputBirthdate', isset ($_POST['inputBirthdate']) ? $_POST['inputBirthdate'] : "");
	update_post_meta( $cpt_id, 'inputWeight', isset ($_POST['inputWeight']) ? $_POST['inputWeight'] : "");
	update_post_meta( $cpt_id, 'inputBirthplace', isset ($_POST['inputBirthplace']) ? $_POST['inputBirthplace']: "");
	update_post_meta( $cpt_id, 'inputAddress', isset($_POST['inputAddress']) ? $_POST['inputAddress']: "");
	update_post_meta( $cpt_id, 'inputProvince', isset($_POST['inputProvince']) ? $_POST['inputProivince'] : "");
	update_post_meta( $cpt_id, 'inputContactNum', isset($_POST['inputContactNum']) ? $_POST['inputConatctNum'] : "");
	update_post_meta( $cpt_id, 'inputFbAddress', isset($_POST['inputFbAddress']) ? $_POST['inputFbAddress'] : "");
	
	
	$ins_arr = array(
			'en_post_id'			=>	$cpt_id,
			'en_last_name'			=>	isset($_POST['inputLastName']) ? $_POST['inputLastName'] : "",
			'en_first_name'			=>	isset($_POST['inputFirstName']) ? $_POST['inputFirstName'] : "",
			'en_middle'				=>	isset($_POST['inputMiddleName']) ? $_POST['inputMiddleName'] : "",
			'en_age'				=>	isset($_POST['inputAge']) ? $_POST['inputAge'] : "",
			'en_email'				=>  isset($_POST['inputEmail']) ? $_POST['inputEmail'] : "",
			'en_civil_status'		=>	isset($_POST['inputCivilStatus']) ? $_POST['inputCivilStatus'] : "",
			'en_religion'			=>	isset($_POST['inputReligion']) ? $_POST['inputReligion'] : "",
			'en_gender'				=>	isset($_POST['inputGender']) ? $_POST['inputGender'] : "",
			'en_weight'				=>	isset($_POST['inputWeight']) ? $_POST['inputWeight'] : "",			
			'en_height'				=>	isset($_POST['inputHeight']) ? $_POST['inputHeight'] : "",
			'en_bmi'				=>	isset($_POST['inputBMI']) ? $_POST['inputBMI'] : "",
			'en_birthdate'			=>	isset($_POST['inputBirthdate']) ? $_POST['inputBirthdate'] : "",
			'en_birthplace'			=>	isset($_POST['inputBirthPlace']) ? $_POST['inputBirthPlace'] : "",
			'en_address'			=>  isset($_POST['inputAddress']) ? $_POST['inputAddress'] : "",
			'en_province'			=>	isset($_POST['inputProvince']) ? $_POST['inputProvince'] : "",
			'en_contact'			=>	isset($_POST['inputContactNum']) ? $_POST['inputContactNum'] : "",
			'en_fbadd'			    =>	isset($_POST['inputFbAddress']) ? $_POST['inputFbAddress'] : "",
			'en_enrollee_status'	=>	isset($_POST['enrollee-current-status']) ? $_POST['enrollee-current-status'] : ""
	);
	 //echo "<pre>";
     //print_r($enDb->_return_string_type($ins_arr));
	 //echo "</pre>";
	 //die();
	
	$enDb->_insert_row(
		'wp_pntc_enrollment', 
		$ins_arr, $enDb->_return_string_type($ins_arr)
	);
	
	$remote_db->_insert_row(
		'wp_pntc_enrollment', 
		$ins_arr, $enDb->_return_string_type($ins_arr)
	);
	
	}
	require_once('forms/fe-form.php');
?>