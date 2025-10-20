<?php
namespace backend\components;
use Yii;
use yii\base\Model;
use backend\models\Configure;
use backend\models\Contact;
use backend\models\Template;
use Mailgun\Mailgun;

class MyExt extends Model {
	/*
	* @param $price giá tiền
	*/
	public static function formatPrice($price)
	{
		$cont = Contact::getContact();
		if (empty($price))
			return $cont->replace_price;
		else
			return (number_format($price, 0, '', '.') . '' . $cont->currency_format);
	}

	public static function getBlock($str, $length)
	{

		if (strlen($str) <= $length)
			return $str;

		$str = substr($str, 0, $length);

		$rightpos = strrpos($str, ' ');
		return substr($str, 0, $rightpos) . '...';
	}

	public static function removeSign($str, $space = true) {

		$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
		$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
		$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
		$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
		$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
		$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
		$str = preg_replace("/(đ)/", 'd', $str);

		$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
		$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
		$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
		$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
		$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
		$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);
		$str = preg_replace("/(Đ)/", 'D', $str);

		$str = preg_replace("/(')/", '', $str);
		$str = preg_replace("/(&)/", '', $str);
		$str = preg_replace('/[^A-Za-z0-9\-]/', '-', $str);

//		$str = str_replace("/", '', $str);
//		$str = str_replace("(", '', $str);
//		$str = str_replace(")", '', $str);

		if($space == true)
			$str = str_replace(" ", "-", $str);
		// $str = preg_replace('/[^A-Za-z0-9-.\-]/', '', $str);

		return strtolower($str);
	}

	function getBrief($str)
	{
		$str_tmp = strip_tags($str);
		return preg_replace('/\s+/', ' ', trim($str_tmp));
	}

	function getFillter($request)
	{
		$arr = [];
		$arr['exited_brand'] = 0;
		$arr['exited_price'] = "";
		$arr['exited_order'] = 0;

		if ($request->get('bid'))
			$arr['exited_brand'] = $request->get('bid');

		if ($request->get('pid'))
			$arr['exited_price'] = $request->get('pid');

		if ($request->get('oid'))
			$arr['exited_order'] = $request->get('oid');

		return $arr;
	}

	public static function getDomain()
	{
		$protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] === 'on' || $_SERVER['HTTPS'] === 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ? 'https' : 'http';
		return $protocol.'://'.$_SERVER['SERVER_NAME'];
	}

	public static function sendMail($to, $subject, $content)
	{
		$conf = Configure::getConfigure();

		# Instantiate the client.
		$mgClient = Mailgun::create($conf->mailgun_key);
		$domain = $conf->mailgun_domain;

		return $mgClient->messages()->send($domain, [
			'from'    => $conf->sender_label.' <'.$conf->email_label.'>',
			'to'      => $to,
			'subject' => $subject,
			'html'    => $content
		]);

	}
	public static function returnDay($day){
		switch ($day) {
			case 1: return 'Thứ Hai'; break;
			case 2: return 'Thứ Ba'; break;
			case 3: return 'Thứ Tư'; break;
			case 4: return 'Thứ Năm'; break;
			case 5: return 'Thứ Sáu'; break;
			case 6: return 'Thứ Bảy'; break;
			case 7: return 'Chủ Nhật'; break;
		}
	}
	public static function returnMonth($month){
		switch ($month) {
			case '01': return 'Tháng Một'; break;
			case '02': return 'Tháng Hai'; break;
			case '03': return 'Tháng Ba'; break;
			case '04': return 'Tháng Bốn'; break;
			case '05': return 'Tháng Năm'; break;
			case '06': return 'Tháng Sáu'; break;
			case '07': return 'Tháng Bảy'; break;
			case '08': return 'Tháng Tám'; break;
			case '09': return 'Tháng Chín'; break;
			case '10': return 'Tháng Mười'; break;
			case '11': return 'Tháng Mười Một'; break;
			case '12': return 'Tháng Mười Hai'; break;
		}
	}

	public  static function  chuoisocong($sososanh,$sobatdau,$socong){
		if(($sososanh-$sobatdau)>=$socong):
			$x=$sososanh-$sobatdau;
			$songuyen=($x-($x%$socong))/$socong;
			if(($sobatdau+$socong*$songuyen)==$sososanh) return 1;
			else return 0;
//			return $x;
		else: return 0;
		endif;


	}

	public function checkDomain($domains){
		if(isset($domains)){
			$ch = array();
			$i = 0;
			foreach($domains as $domain):
				$ch[$i] = curl_init();
				$urlAPI ='https://tenten.vn/api/check/?domain='.$domain;
				$opts = array(CURLOPT_URL=>$urlAPI,CURLOPT_RETURNTRANSFER=>1,CURLOPT_CONNECTTIMEOUT=>5);
				curl_setopt_array($ch[$i], $opts);
				$i++;
			endforeach;

			$mh = curl_multi_init();
			foreach($ch as $c)	curl_multi_add_handle($mh,$c);

			$running = null;
			do {
				curl_multi_exec($mh, $running);
				curl_multi_select($mh);
			} while ($running > 0);

			$rs = '';
			//close the handles
			foreach($ch as $c):
				$rs .= curl_multi_getcontent($c);
				curl_multi_remove_handle($mh,$c);
			endforeach;
			curl_multi_close($mh);
			return $rs;
		}
	}
    public static function mobileDetect() {
        $useragent=$_SERVER['HTTP_USER_AGENT'];
        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            return true;
        if(strstr($_SERVER['HTTP_USER_AGENT'], 'iPad')) {
            return true;
        }

        return false;
    }

    public static function mobileDetectnotipad() {
        $useragent=$_SERVER['HTTP_USER_AGENT'];

        if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
            return true;

        return false;
    }
	public static function changeContents($content){
		$cont = Contact::getContact();
		$noidung='';
		$pattern_phone = "/{{{(.*?)}}}/";
		preg_match_all($pattern_phone, $content, $matches_phone);
		$noidung=$content;
		if(!empty($matches_phone[1])){
			foreach ($matches_phone[1] as $string){
				if($string=='hotline')
					$chuoi_thay_the='<div class="text-center d-flex"><a class="btn btn-read-more btn-animate mx-auto" href="tel:'.$cont->hotline.'">Hotline: '.$cont->hotline.'</a></div>';
				else
					$chuoi_thay_the='<div class="text-center d-flex"><a class="btn btn-read-more btn-animate mx-auto" href="tel:'.$string.'">Hotline: '.$string.'</a></div>';
				$noidung=str_replace('{{{'.$string.'}}}',$chuoi_thay_the,$noidung);

			}

		}

		$pattern_phone = "/{{(.*?)}}/";
		preg_match_all($pattern_phone, $noidung, $matches_phone);
		if(!empty($matches_phone[1])){
			foreach ($matches_phone[1] as $string){
				if($string=='hotline')
					$chuoi_thay_the='<div class="text-center d-flex"><a class="btn btn-chat-tvv btn-animate mx-auto" href="https://zalo.me/'.$cont->hotline.'">'.Yii::t('app','chat-now').': '.$cont->hotline.'</a></div>';
				else
					$chuoi_thay_the='<div class="text-center d-flex"><a class="btn btn-chat-tvv btn-animate mx-auto" href="https://zalo.me/'.$string.'">'.Yii::t('app','chat-now').': '.$string.'</a></div>';
				$noidung=str_replace('{{'.$string.'}}',$chuoi_thay_the,$noidung);

			}

		}

		return $noidung;
	}
	public function domainList($string){
		$str='<select id="registertld" class="form_control domains-extend">';
		$tam=explode('-',$string);
		if(!empty($tam))
			foreach ($tam as $id)
				$str.='<option value="'.trim($id).'">'.trim($id).'</option>';
		$str.='</select>';
		return $str;
	}
	public function isMobile() {
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4));
	}
    public static function combinations($arrays, $i = 0) {
        if (!isset($arrays[$i])) {
            return array();
        }
        if ($i == count($arrays) - 1) {
            return $arrays[$i];
        }

        // get combinations from subsequent arrays
        $tmp = MyExt::combinations($arrays, $i + 1);

        $result = array();

        // concat each array from tmp with each element from $arrays[$i]
        foreach ($arrays[$i] as $v) {
            foreach ($tmp as $t) {
                $result[] = is_array($t) ?
                    array_merge(array($v), $t) :
                    array($v, $t);
            }
        }

        return $result;
    }
    public static function percent($sale, $retail){
        $t=$retail - $sale;
        $a=$t/$retail;
        $number= $a*100;
        return number_format((float)$number, 0, '.', '');
    }
    public static function vat($number){
        $return=$number/100*10;
        return $return;
    }
}
?>
