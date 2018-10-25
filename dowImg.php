<?php
/**
	 * [download_remote_pic description]
	 * @Author   tgd
	 * @DateTime 2018-10-18
	 * @param    [type]     $url [description]
	 * @return   [type]          [description]
	 */
	function download_remote_pic($params){
	    $header = [
	        "User-Agent: Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:45.0) Gecko/20100101 Firefox/45.0",      
	        "Accept-Language: zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",      
	        "Accept-Encoding: gzip, deflate",
	    ];  
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, $params["url_img"]);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  
	    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_ENCODING, "gzip");  
	    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
	    $data = curl_exec($curl);
	    $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	    curl_close($curl);  

	    // echo $code;
	    if ($code == 200) {//把URL格式的图片转成base64_encode格式的！      
	       $imgBase64Code = "data:image/jpeg;base64," . base64_encode($data);  
	    }  
	    $img_content = $imgBase64Code;//图片内容  
	    if (preg_match("/^(data:\s*image\/(\w+);base64,)/", $img_content, $result)) {   
	        $type = $result[2];//得到图片类型png?jpg?gif?   
	        $new_file = "./uploads".$params["card_id"].".{$type}";   
	        if (file_put_contents($new_file, base64_decode(str_replace($result[1], "", $img_content)))) {  
	            return $new_file; 
	        }
	    } 

	    return false;
	} 
?>
