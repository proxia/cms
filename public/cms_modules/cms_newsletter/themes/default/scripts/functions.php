<?php
function insert_lektori($input){
	$insert = array();
	$insert = unserialize($input['value']);
	if (is_Array($insert)){
		foreach ($insert as $user_id){
				$user_detail = new CMS_User($user_id);
				$output[$user_id]['id'] = $user_id;
				$output[$user_id]['name'] = $user_detail->getFirstname()."&nbsp;".$user_detail->getFamilyname();
			}
		}
	return $output;
}
