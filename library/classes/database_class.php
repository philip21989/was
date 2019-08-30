<?php
/*DataBase Class*/
header('Content-Type: text/html; charset=utf-8');
class DATABASE_CLASS
{
	
	function __construct()
	{
		try {
			$manager = new MongoDB\Driver\Manager("mongodb+srv://was_user:was_mongodb@cluster0-0v5rt.mongodb.net/test?retryWrites=true&w=majority");
			return $manager;
		} catch (MongoDB\Driver\Exception\Exception $e) {
            return "Exception Occurred :".$e->getMessage();
        }  
	}
	function returnJson($request_data) {
		// $result = json_encode($request_data);
		// if($result){
		// 	return $result;
		// }else{
		// 	$result = json_encode($request_data, JSON_PARTIAL_OUTPUT_ON_ERROR);
		// 	return $result;
		// }
		return $request_data;
	}  
	function encrypted_password_hash($text,$alg_key='',$alg_value='')
	{
		$alg_key=($alg_key!='')?$alg_key:"SALT_KEY";
		
		$alg_value=($alg_value!='')?$alg_value:SALT;

		return password_hash($text, PASSWORD_BCRYPT, [$alg_key => $alg_value]);
	}
	function randomToken($len=12) 
	{
	    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array();
	    $alphaLength = strlen($alphabet) - 1;
	    for ($i = 0; $i < $len; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass);
	}
	function insert_record($collection_name,$data)
	{
		try{
			$insert_cmd = new MongoDB\Driver\BulkWrite;
			$data['_id'] = new MongoDB\BSON\ObjectID;
			$insert_cmd->insert($data);
			$this->db_conn->executeBulkWrite(DATABASE.'.'.$collection_name, $insert_cmd);
			return 'success';
		} catch (MongoDB\Driver\Exception\Exception $e) {
			return "Exception Occurred :".$e->getMessage();
		}  	
	}
	function update_record($collection_name,$filter_array=[],$updated_data,$multi=FALSE)
	{
		try{
			$update_cmd = new MongoDB\Driver\BulkWrite;
			$update_cmd->update($filter_array,$updated_data,['multi' =>$multi, 'upsert' => FALSE]);
			$this->db_conn->executeBulkWrite(DATABASE.'.'.$collection_name, $update_cmd);
			return 'success';
		} catch (MongoDB\Driver\Exception\Exception $e) {
			return "Exception Occurred :".$e->getMessage();
		}  	
	}
	function get_date_timestamp($format='Y-m-d H:i:s')
	{
		$date_obj=new DateTime(null, new DateTimeZone(TimeZone));
		return $date_obj->format($format);
	}
	function encrypt_password($text) 
	{
		$ivlen = openssl_cipher_iv_length(CIPHER_METHOD);
		$iv=openssl_random_pseudo_bytes($ivlen);
		$return_encrypt=openssl_encrypt($text, CIPHER_METHOD, SALT, $options=0, $iv);
		$return_encrypt=$return_encrypt.'~|~|~'.$iv; 
		$return_encrypt=str_replace('/','~||~',$return_encrypt);
		return base64_encode(serialize($return_encrypt));
	} 

	function decrypt_password($text) 
	{
		$text=unserialize(base64_decode($text));
		$text=str_replace('~||~','/',$text);
		$text_ar=explode('~|~|~',$text);
	    return openssl_decrypt($text_ar[0], CIPHER_METHOD, SALT, $options=0, $text_ar[1]);
	}
	function local_upload_file($tmp_name,$image_path)
	{
		return (move_uploaded_file($tmp_name,$image_path))?true:false;
	}
	function convert_date_format($present_format,$date,$needed_format)
	{
		$date_format=DateTime::createFromFormat($present_format, $date);
		return ($date_format)?$date_format->format($needed_format):'';
	}
}
