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
     * Search an item by key
     * $hui_item_key: A array of the item's info
     * return the ID of the first matched item or FALSE
     */
    public function search_item($hui_item_key){
        //...
    }

    /**
     * Get infos about an item
     * return an array of the item's info or FALSE
     */
    public function get_item_info($hui_item_id){
        //...
    }

    /**
     * List important info of all items
     * return an array of all items' important info or FALSE
     */
    public function list_item(){
        //...
    }

    /**
     * Read data from target file, convert it to array
     * return an array or FALSE
     */
    private function data_to_array(){
        $file = fopen($this -> hui_target_file_name, "r");
        $data = array();
        $item_num = 0;
        $match_sta = 0;
        while(!feof($file)){
            $content = fgets($file)
            if(preg_match_all("/\-------([0-9]|[A-z]){32}-([0-9]|[A-z]){7}-Start-------\d*/is", $content)) && $match_sta === 0){
                $data[$item_num] = array();
                $match_sta = 1;
            }else if($match_sta === 1){
                $data[$item_num]["item_id"] = substr($content, 9);
                $match_sta = 2;
            }else if($match_sta === 2){
                $data[$item_num]["hook_id"] = substr($content, 9);
                $match_sta = 3;
            }else if($match_sta === 3){
                $data[$item_num]["action_id"] = substr($content, 11);
                $match_sta = 4;
            }else if($match_sta === 4){
                $data[$item_num]["title"] = substr($content, 7);
                $match_sta = 5;
            }else if($match_sta === 5){
                $data[$item_num]["content"] = substr($content, 9);
                $match_sta = 6;
            }else if($match_sta === 6){
                $content_hash = substr($content, 14);
                if(md5($data[$item_num]["content"]) !== $content_hash){
                    return false;
                }
                $match_sta = 7;
            }else if($match_sta === 7){
                $disabled_content = substr($content, 9);
                $disabled = false;
                if($disabled_content === "True"){
                    $disabled = true;
                }else if($disabled_content !== "True" && $disabled_content !== "False"){
                    return false;
                }
                $data[$item_num]["disable"] = $disabled;
                $match_sta = 8;
            }else if(preg_match_all("/\-------([0-9]|[A-z]){32}-([0-9]|[A-z]){7}-End-------\d*/is", $content)) && $match_sta === 8){
                $item_num++;
                $match_sta = 0;
            }
        }
        fclose($file);
        return $data;
    }
}
?>