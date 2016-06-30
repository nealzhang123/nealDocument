<?php 

use OSS\OssClient;
use OSS\Core\OssException;
class Image_From_Sql_To_Oss {
	public function __construct(){

	}

	public function uploadFile($ossClient, $bucket, $filePath, $object) {
		try{
			$ossClient->uploadFile($bucket, $object, $filePath);
		} catch(OssException $e){
			//printf(__FUNCTION__ . ": FAILED\n");
			//printf($e->getMessage() . "\n");
			return false;
		}
		//print(__FUNCTION__ . ": OK" . "\n");
		return true;
	}


	public function deleteObject($ossClient, $bucket, $object ){
		try{
	        $ossClient->deleteObject($bucket, $object);
	    } catch(OssException $e) {
	       // printf(__FUNCTION__ . ": FAILED\n");
	       // printf($e->getMessage() . "\n");
	        return false;
	    }
	    	//print(__FUNCTION__ . ": OK" . "\n");
	    return true;
	}


	public function uploadimagetooss($file_path){
		//error_log($file_path);
		$ossClient 	= new OssClient(OSS_ACCESS_ID, OSS_ACCESS_KEY, OSS_ENDPOINT);
		$file 		= $this->stacktech_get_file_name( $file_path );
		$basename = substr($file['name'] ,strrpos($file['name'] ,'/')+1 );
		// $basename	= basename( $file['name']);
		//error_log($basename);
		$dirname	= dirname( $file['name']);
		$upload_dir = wp_upload_dir();
		$dir_path	= $upload_dir['baseurl'];
		while($dir_path){
			$a = basename($dir_path);
			$root_path = $a.'/'.$root_path;
			$b = dirname($dir_path);
			if ($a == 'wp-content' ){
				break;
			}
			$dir_path = $b;
		}
		//error_log($file['path']);
		$object 	= $root_path.$dirname.'/'.$basename;
		//error_log($object);
		return $this->uploadFile($ossClient, OSS_BUCKET_NAME, $file['path'], $object);
	}

	public function deleteimagefromoss( $file_path){
		//error_log($file_path);
		$ossClient 	= new OssClient(OSS_ACCESS_ID, OSS_ACCESS_KEY, OSS_ENDPOINT);
		$file 		= $this->stacktech_get_file_name( $file_path );
		$basename = substr($file['name'] ,strrpos($file['name'] ,'/')+1 );
		// $basename	= basename( $file['name']);
		//error_log($basename);
		$dirname	= dirname( $file['name']);
		$upload_dir = wp_upload_dir();
		$dir_path	= $upload_dir['baseurl'];
		while($dir_path){
			$a = basename($dir_path);
			$root_path = $a.'/'.$root_path;
			$b = dirname($dir_path);
			if ($a == 'wp-content' ){
				break;
			}
			$dir_path = $b;
		}
		$object 	= $root_path.$dirname.'/'.$basename;
		//error_log($object);
		return $this->deleteObject($ossClient, OSS_BUCKET_NAME, $object);
	}


	public function stacktech_get_file_name( $file_location ) {

		// Grab the uploads folder
		$uploads_location 	= wp_upload_dir();
		$upload_dir 		= $uploads_location['basedir'] . '/';
		$upload_url 		= $uploads_location['baseurl'] . '/';

		// If URL, then convert to path
		$initial = substr( $file_location, 0, 7 );
		if ( 'http://' == $initial || 'https://' == $initial ) {
			$file_path = str_replace( $upload_url, $upload_dir, $file_location ); // Convert URL to path
		} else {
			$file_path = $file_location;
		}

		$file_name = str_replace( $upload_dir, '', $file_path ); 

		// return an array with both file name and file path
		return array(
			'name' => $file_name,
			'path' => $file_path,
		);
	}
}

