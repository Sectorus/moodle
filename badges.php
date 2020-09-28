<?php
	require_once('config.php');
	defined('MOODLE_INTERNAL') || die;
		
	global $PAGE, $CFG, $COURSE, $DB;
	
	$token = 'e9585538e632d2edc20d846b3cfa4ec0';
	
	$fields = ['id', 'courseid', 'expiredate', 'name'];
	$userid = 8;
	
	$payload = array(
		'wsfunction' => 'core_badges_get_user_badges',
		'wstoken' => $token
	);
	
	$url = 'http://' . get_config('local_badge_sync', 'target_moodle') . '/webservice/rest/server.php?moodlewsrestformat=json&userid=' . $userid;
	$ch = curl_init($url);
	$postString = http_build_query($payload, '', '&');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	curl_close($ch);
		
	$json = json_decode($response, true);
	$result = array();
	
	$user_db = $DB->get_record('user', array('id' => $userid));

	for ($i = 0; $i < count($json['badges']); $i++) {
		$badge = array();
		$image_url = $json['badges'][$i]['badgeurl'];
		$image_url = str_replace("/webservice", "", $image_url);
		$badge['userid'] = $userid;
		$badge['username'] = $user_db->username;
		$badge['image_url'] = $image_url;
		foreach($json['badges'][$i] as $key => $value){
			if(in_array($key, $fields, true))
			{
				$badge[$key] = $value;
			}			
		}
		
		$course_id = $json['badges'][$i]['courseid'];
		$course_name = null;
		if(!is_null($course_id)){
			$course_name = $DB->get_record('course', array('id' => $course_id));
		}
		$badge['course'] = $course_name->fullname;
		array_push($result, $badge);
	}
	
	$payload = array(
		//'json' => json_encode($result)
	);
	
	$t = trim(json_encode($result), '[]');
	$url = 'https://qline.uni-graz.at/QSYSTEM_KFU/inmoodlews.callMoodleHook?pTest=' . urlencode($t);
	$ch = curl_init($url);
	$postString = http_build_query($payload, '', '&');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postString);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	
	echo $url . "<br><br>";
	echo "Finished! " . $httpcode;
	//echo "<br><br>" . moodle_url::make_webservice_pluginfile_url($event->contextid, 'badges', 'badgeimage', 6, '/','f1')->out(true);
?>

