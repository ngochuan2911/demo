<?php
namespace Functions\Helpers;

use App\User;
use DB;
use Illuminate\Support\Str;
use App\Category, App\Models\Survey, App\Models\SurveyAnswer;

class Functions{

	public static function createEditor() {
    ?>
        <script type="text/javascript">
            $(document).ready(function(){
                tinymce.init({
                    selector: ".text-editor",
                    theme: "modern",
                    content_css : "/custom_editor.css",
                    entity_encoding : "raw",
                    height:200,
                    plugins: [
                      'advlist autolink link image imagetools lists charmap print preview hr anchor pagebreak spellchecker',
                      'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                      'save table contextmenu directionality emoticons template paste textcolor responsivefilemanager'
                    ],
                    image_advtab: true,
                    relative_urls: false,
                    remove_script_host: false,
                    external_filemanager_path:"<?php echo asset('Backend/js/filemanager') ?>/",
                    filemanager_title:"Thư viện ảnh",
                    external_plugins: { "filemanager" : "<?php echo asset('Backend/js/filemanager/plugin.min.js') ?>"},
                    //subfolder:"",
                   toolbar: "fullscreen | undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | image responsivefilemanager media| print preview code",
                });
            });
        </script>
    <?php
    }


     public static function selectTruong ($data, $select = 0) {
        foreach($data as $value){
            $id = $value['id'];
            $truong = $value['tentruong'];
            if($id == $select){
                echo "<option value='$id' selected='selected'>$truong</option>";
            }else{
                echo "<option value='$id'>$truong</option>";
            }
        }
    }
    public static function selectNganh ($data, $select = 0) {
        foreach($data as $value){
            $id = $value['id'];
            $nganh = $value['tennganh'];
            if($id == $select){
                echo "<option value='$id' selected='selected'>$nganh</option>";
            }else{
                echo "<option value='$id'>$nganh</option>";
            }
        }
    }
    
    public static function selectChecklist ($data, $select = 0) {
        foreach($data as $value){
            $id = $value['id'];
            $truong = $value['tentruong'];
            if($id == $select){
                echo "<option value='$id' selected='selected'>$truong</option>";
            }else{
                echo "<option value='$id'>$truong</option>";
            }
        }
    }
    

    public static function subContent ($content, $length = 200, $read_more = "") {
    	//$str = preg_replace("/<img[^>]+\>/i", "", $content);
        $str = strip_tags($content);
    	if(strlen($str) > $length)
		{
			$str = substr($str, 0, $length);
			$last_space = strrpos($str, ' ');
			$str = substr($str, 0, $last_space);
			$str = trim($str);
			$str = $str.$read_more;
		}
    	return $str;
    }

    public static function getAllTaxonomy() { //lấy ra hết tất cả các chuyên mục
            $cats = Category::where('slug' , 'san-pham')->first(); //lấy thông tin của chuyên mục sản phẩm
            if (count($cats) == 0) { //nếu tồn tại sẽ tìm tiếp trong thằng cấp 2 thuộc danh mục san pham
                return false; // 
            }

            $cats = $cats->toArray();
            $cat_lv_2 = Category::where('parent', $cats['id'])->select('id', 'slug', 'cat_name_vi', 'cat_name_en')->get();

            if (count($cat_lv_2) == 0) {
                return false;
            }

            $cat_lv_2 = $cat_lv_2->toArray();

            foreach ($cat_lv_2 as $key => $item) {
                $cat_lv_3  = array();

                $query = Category::where('parent', $item['id'])->select('id', 'slug', 'cat_name_vi', 'cat_name_en')->get();

                if (count($query) > 0) {
                    $cat_lv_3 = $query->toArray();

                    $cat_lv_2[$key]['cat_lv_3'] = $cat_lv_3;
                } else {
                    $cat_lv_2[$key]['cat_lv_3'] = null;
                }
            }

            return $cat_lv_2;
        }

    public static function getAllTaxo() { //lấy ra hết tất cả các chuyên mục
            $cats = Category::where('slug' , 'san-pham')->first(); //lấy thông tin của chuyên mục sản phẩm
            if (count($cats) == 0) { //nếu tồn tại sẽ tìm tiếp trong thằng cấp 2 thuộc danh mục san pham
                return false; // 
            }

            $cats = $cats->toArray();
            $cat_lv_2 = Category::where('parent', $cats['id'])->select('id', 'slug', 'cat_name_vi', 'cat_name_en')->skip(0)->take(5)->get();

            if (count($cat_lv_2) == 0) {
                return false;
            }

            $cat_lv_2 = $cat_lv_2->toArray();

            foreach ($cat_lv_2 as $key => $item) {
                $cat_lv_3  = array();

                $query = Category::where('parent', $item['id'])->select('id', 'slug', 'cat_name_vi', 'cat_name_en')->get();

                if (count($query) > 0) {
                    $cat_lv_3 = $query->toArray();

                    $cat_lv_2[$key]['cat_lv_3'] = $cat_lv_3;
                } else {
                    $cat_lv_2[$key]['cat_lv_3'] = null;
                }
            }

            return $cat_lv_2;
        }

    public static function countSurveyAnswerByOption($qid, $option) {
        return SurveyAnswer::where('qid', $qid)->where('option', $option)->count();
    }

    public static function countSurveyAnswerByOther($qid, $option) {
        return SurveyAnswer::where('qid', $qid)->where('other', '!=', '')->count();
    }

    public static function getUserID($token) {
        $user = User::where('remember_token', $token)->first();

        if (count($user) == 0) {
            return null;
        } else {
            return $user->id;
        }
    }
}
?>