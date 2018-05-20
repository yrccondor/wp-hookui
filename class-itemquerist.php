<?php
/**
 * For querying items in functions-custom-0.php and functions-custom-1.php
 */
class hui_item_querist{
    var $hui_target_file_name;

    function __construct($hui_functions_file_name){
        $this -> hui_target_file_name = 'custom/'.$hui_functions_file_name;
    }


    /**
     * Search an item by title
     * return the ID of the first matched item or FALSE
     */
    public function search_item($hui_item_title){
        $item_list = $this -> data_to_array();
        $item_id = "";
        if($item_list === false){
            return false;
        }
        for ($i = 0; $i < sizeof($item_list); $i++){
            if(strpos(strtolower($item_list[$i]["title"]), strtolower($hui_item_title)) !== false){
                $item_id = $item_list[$i]["item_id"];
                break;
            }
        }
        if($item_id === ""){
            return false;
        }else{
            return $item_id;
        }
    }

    /**
     * Get infos about an item
     * return an array of the item's info or FALSE
     */
    public function get_item_info($hui_item_id){
        $item_list = $this -> data_to_array();
        if($item_list === false){
            return false;
        }
        for ($i = 0; $i < sizeof($item_list); $i++){
            if($item_list[$i]["item_id"] === $hui_item_id){
                break;
            }
        }
        return $item_list[$i];
    }

    /**
     * List important info of all items
     * return an array of all items' important info or FALSE
     */
    public function list_items(){
        $item_list = $this -> data_to_array();
        if($item_list === false){
            return false;
        }
        $imp_list = array();
        for ($i = 0; $i < sizeof($item_list); $i++){
            $imp_list[$i] = array();
            $imp_list[$i]["item_id"] =  $item_list[$i]["item_id"];
            $imp_list[$i]["hook_id"] =  $item_list[$i]["hook_id"];
            $imp_list[$i]["action_id"] =  $item_list[$i]["action_id"];
            $imp_list[$i]["title"] =  $item_list[$i]["title"];
            $imp_list[$i]["disable"] =  $item_list[$i]["disable"];
        }
        return $imp_list;
    }

    /**
     * Create or update cache-*.json of items' info
     * return TRUE or FALSE
     */
    public function update_cache(){
        $item_list = $this -> data_to_array();
        if($item_list === false){
            return 'false';
        }
        $data = array();
        $data['time'] = date('Y-m-d H:i:s');
        $data['data'] = $item_list;
        $json_data = json_encode($data);
        if($this -> hui_target_file_name === "custom/functions-custom-0.php"){
            $cache_name = 'cache-0.json';
        }else if($this -> hui_target_file_name === "custom/functions-custom-1.php"){
            $cache_name = 'cache-1.json';
        }else{
            return false;
        }
        return file_put_contents($cache_name, $json_data);
    }

    /**
     * Check whether the cache need to be updated
     * return TRUE or FALSE
     */
    public function check_cache_time(){
        if($this -> hui_target_file_name === "custom/functions-custom-0.php"){
            $cache_name = 'cache-0.json';
        }else if($this -> hui_target_file_name === "custom/functions-custom-1.php"){
            $cache_name = 'cache-1.json';
        }else{
            return false;
        }
        $json_data = file_get_contents($cache_name);
        $data = json_decode($json_data, true);
        $time_delta = strtotime(date("Y-m-d H:i:s")) - strtotime($data['time']);
        if($time_delta >= 180){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Remove cache-*.json of items' info
     * return TRUE or FALSE
     */
    public function remove_cache(){
        if($this -> hui_target_file_name === "custom/functions-custom-0.php"){
            $cache_name = 'cache-0.json';
        }else if($this -> hui_target_file_name === "custom/functions-custom-1.php"){
            $cache_name = 'cache-1.json';
        }else{
            return false;
        }
        return unlink($cache_name);
    }

    /**
     * Read data from target file, convert it to array
     * return an array of all items' info or FALSE
     */
    public function data_to_array(){
        $file = fopen($this -> hui_target_file_name, "r");
        $data = array();
        $item_id = array();
        $item_num = 0;
        $match_sta = 0;
        while(!feof($file)){
            $content = fgets($file);
            if(preg_match_all("/\-------([0-9]|[a-f]){32}-([0-9]|[a-f]){7}-Start-------\d*/is", $content, $item_id) && $match_sta === 0){
                $data[$item_num] = array();
                $match_sta = 1;
            }else if($match_sta === 1){
                $data[$item_num]["item_id"] =  substr($content, 9, -1);
                $match_sta = 2;
            }else if($match_sta === 2){
                $data[$item_num]["hook_id"] = substr($content, 9, -1);
                $match_sta = 3;
            }else if($match_sta === 3){
                $data[$item_num]["action_id"] = substr($content, 11, -1);
                $match_sta = 4;
            }else if($match_sta === 4){
                $data[$item_num]["title"] = substr($content, 7, -1);
                $match_sta = 5;
            }else if($match_sta === 5){
                $data[$item_num]["content"] = substr($content, 9, -1);
                $match_sta = 6;
            }else if($match_sta === 6){
                $content_hash = substr($content, 14, -1);
                if(md5($data[$item_num]["content"]) !== $content_hash){
                    return false;
                }
                $match_sta = 7;
            }else if($match_sta === 7){
                $disabled_content = substr($content, 9, -1);
                $disabled = false;
                if($disabled_content === "True"){
                    $disabled = true;
                }else if($disabled_content !== "True" && $disabled_content !== "False"){
                    return false;
                }
                $data[$item_num]["disable"] = $disabled;
                $match_sta = 8;
            }else if(preg_match_all("/\-------([0-9]|[a-f]){32}-([0-9]|[a-f]){7}-End-------\d*/is", $content)){
                if($match_sta !== 8){
                    return false;
                }else{
                    $item_num++;
                    $match_sta = 0;
                }
            }
        }
        fclose($file);
        if($match_sta === 0){
            return $data;
        }else{
            return false;
        }
    }
}
?>