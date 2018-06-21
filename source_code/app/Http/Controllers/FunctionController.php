<?php  
    namespace App\Http\Controllers;
    use App\Http\Controllers\Controller;
    use App\Category;
    use App\Commonpage;
    use App\Maternitycheckup;
   use App\Checklist;
   use App\Babyregistry;


    class FunctionController extends Controller {
        public static function appendToPaginate($unsets = array()){
            $params = $_GET;

            $appends = array();
            if ($unsets) {
                foreach($unsets as $item){
                    unset($params[$item]);
                }
            }

            if ($params) {
                foreach($params as $key=>$val){
                    if($val!=''){
                        $appends[$key] = $val;
                    }

                }
            }

            return $appends;
        }

        public static function displaySearchCounter($current_page = '', $item_per_page = '' , $total_page = ''){
            if($current_page > 1){
                $start = ($current_page -1 ) * $item_per_page + 1;
                if($item_per_page * $current_page > $total_page){
                    $end = $total_page;
                }else{
                    $end = $item_per_page * $current_page;
                }
            }else{
                if($item_per_page * $current_page > $total_page){
                    $end = $total_page;
                }else{
                    $end = $item_per_page * $current_page;
                }
                if($total_page){
                    $start = 1;
                }else{
                    $start = 0;
                }

            }
            return $start.' - '. $end;
        }

        public static function add_param_url($param = array()) {
            $url = \Request::fullUrl();
            if(isset($_GET[$param[0]]) && $_GET[$param[0]]==$param[1]){
                return $url;
            }else{
                if($_GET){
                    if(isset($_GET[$param[0]])){
                        $str = $param[0].'='.$_GET[$param[0]];
                        $convert = $param[0].'='.$param[1];
                        $url = str_replace($str,$convert, $url);
                    } else{
                        $url.= '&'.$param[0].'='.$param[1];
                    }
                }else{
                    
                    $url.= '/?'.$param[0].'='.$param[1];
                }
            }
            return $url;
        }

        public static function random($chars = 8) {
            $letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            return substr(str_shuffle($letters), 0, $chars);
        }

        public static function getImageLink($name, $type, $size) {
            if ($name) {
                return URL('/').'/uploads/'.$type.'/'.$size.'/'.$name;
            } else {
                return null;
            }
        }

        public static function checkData($check) {
            if (isset($check) && $check) {
                return $check;
            } else {
                return null;    
            }
        }


    public static  function limit_content_length($content, $length) {
        $excerpt = preg_replace(" (\[.*?\])", '', $content);
        //$excerpt = strip_shortcodes($excerpt);
        $excerpt = strip_tags($excerpt);
        $excerpt = substr($excerpt, 0, $length);
        if (strlen($content) > $length) {
            $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
            $excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
            $excerpt = $excerpt . '...';
        }
        return $excerpt;
    }

        public static function getWeekDay ($id, $lang ='vi') {
            if($lang == 'vi'){
                $cat_name = Category::select('cat_name_vi')->where('id',$id)->get()->toArray();
                if ($cat_name) {
                    return $cat_name[0]['cat_name_vi'];
                } else {
                    return '--';
                }
            } else {
                $cat_name = Category::select('cat_name_en')->where('id',$id)->get()->toArray();
                if ($cat_name) {
                    return $cat_name[0]['cat_name_en'];    
                } else {
                    return '--';                    
                }
            }
        }
        
    }
?>