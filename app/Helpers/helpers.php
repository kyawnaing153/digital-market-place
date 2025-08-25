<?php

function send_mail($request)
{
    try {        
        $check = Mail::html($request->template, function ($message) use($request) {
			$message->to($request->receiver_email)
			  ->subject($request->subject);
		  });
        return true;
    } catch (Exception $ex) {
        return false;
    }
}


//Generate Unique key
function generate_key($string)
{
    $string = trim(strtoupper($string));
    $text = str_replace(' ', '_', $string);
    return $text;
}

//admin common Date format
function set_date_format($created_at)
{
    $date = Date('M d Y', strtotime($created_at));
    $new_date = str_replace('00:00', '', $date);
    return $new_date;
}
//user common Date format
function set_date_with_time($created_at)
{
    $date = Date('d M Y g:i A', strtotime($created_at));
    $new_date = str_replace('00:00', '', $date);
    return $new_date;
}

//user common Date format
function set_date_format2($created_at)
{
    $date = Date('M d Y', strtotime($created_at));
    $new_date = str_replace('00:00', '', $date);
    return $new_date;
}
//user common Date format
function set_date_format3($created_at)
{
    $date = Date('M  Y', strtotime($created_at));
    $new_date = str_replace('00:00', '', $date);
    return $new_date;
}

//Generate Unique Key 
function unique_key($str = 15)
{
    $randomString = Illuminate\Support\Str::random($str);
    return  hash('sha256', time() . str_shuffle($randomString));
}

function randomstring($str = 5){
    return Illuminate\Support\Str::random($str);
}
//Get User Ip Address from Request 
function request_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

//change time into Ago , Recently
function time_elapsed_string2($datetime, $full = false)
{
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'Recently';
}


// JSON RESPONSE
function json_response($array, $status)
{
    return response()->json($array, $status, [], JSON_NUMERIC_CHECK);
}

//Get Setting table
function getSetting(){
    return (object) App\Models\Setting::whereNull('long_value')->pluck('short_value','key')->toArray();
}
//Get Setting table
function getSettingShortValue($key){
     $data = App\Models\Setting::where('key',$key)->first();
     return !empty($data) ? $data->short_value : '';
}

//Get Setting table
function getSettingLongText(){
    return (object) App\Models\Setting::whereNull('short_value')->pluck('long_value','key')->toArray();
}

//Get Language table
function getlanguage(){
    return App\Models\Languages::where('is_active',1)->get();
}

//Get featured Product category table
function getFeaturedCategory(){
   return App\Models\Frontend\ProductCategory::where(['is_featured'=>1,'is_active'=>1])->with('subCategories')->get();
}

//common function for getting images from Storage URL
function getImage($path)
{
    if ($path != "")
            return \Storage::url($path);
        return $path;
}

//common function for converting any string encode into base64
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

//common function for converting any string decode into base64
function base64url_decode($data) {
return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

//function for used to getting user agents from mobile and desktop
function isMobileDev($HTTP_USER_AGENT){
    if(!empty($HTTP_USER_AGENT)){
       if(preg_match('/(Mobile|Android|Tablet|GoBrowser|[0-9]x[0-9]*|uZardWeb\/|Mini|Doris\/|Skyfire\/|iPhone|Fennec\/|Maemo|Iris\/|CLDC\-|Mobi\/)/uis',$HTTP_USER_AGENT)){
          return true;
       };
    };
    return false;
}

//function for used to getting user agents from request
function get_user_agent($user_agent){
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$user_agent) && !preg_match('/Opera/i',$user_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$user_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$user_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$user_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$user_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$user_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    return $bname;
}


function sendUserEmailMandrill($request){
    try {        
    $tos[] = array(
        'email' => $request->receiver_email,
        'name' => '',
        'type' => 'to'
        );
        $message = array(
        'html' => $request->template,	
        'subject' => $request->subject,
        'from_email' => $request->from_email_address,
        'from_name' => $request->from_name,
        'to' =>$tos,
        ); 	   
        $POSTFIELDS = array(
        'key' => config('services.Mandrill_Key'),
        'message' => $message
        );
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://mandrillapp.com/api/1.0/messages/send.json');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($POSTFIELDS));
    
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
        curl_close($ch);
        return true;
    } catch (Exception $ex) {
        return false;
    }
}

function hexToRgb($hexColor)
{
    // Remove the hash if present
    $hexColor = ltrim($hexColor, '#');

    // Split the string into R, G, and B components
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));

    // Return RGB as an array or string
    return "{$r}, {$g}, {$b}";
}
