<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\File;
header("Access-Control-Allow-Origin: *");

class UploadCsv extends Controller
{
    public function ballz(){
//        $z = DB::select('select * from brands where b_id = ?', [2]);
//        //print_r($z);
//        echo $z[0]->name;
        $z = DB::select('select * from shuffle where b_id = ? limit 5', [2]);
        //print_r($z
        foreach($z as $s){
            echo $s->p_name,'<br>';
        }
        
    }
    
    
    public function collect(Request $request){
        
        $uploadtime = date("Y-m-d H:i:s");//Timestamp http request to retrieve only the data we need
        //DB info here 
        $user_name = "root";
        $password = "";
        $database = "styleminions";
        $server = "127.0.0.1"; 

        function readCSV($csvFile){
            //Read and Parse CSVfile
            $file_handle = fopen($csvFile, 'r');
            while (!feof($file_handle) ) {
                $line_of_text[] = fgetcsv($file_handle, 10240);
            }
            fclose($file_handle);
            return $line_of_text;
        }
        
        if($request->file('ex') != null){
            //CSV File is already validated on the front-end but could still be vakidated on the back-end.
            //No need to store the CSV file on the server. We only need the data inside it.
            $file = $request->file('ex');
            $f_name = $file->getClientOriginalName();
            $tmpName = $_FILES['ex']['tmp_name'];
            $arr = readCSV($tmpName);

            //prepare for Mysql with query and preventing sql injection
            $sql_insert = '';
            $z = 0;
            $link = mysqli_connect($server, $user_name, $password, $database);
            foreach($arr as $arr){
                if ($z != 0){
                    for($i=1; $i<8; $i++){//assuming the order of the columns is always consistent

                           $arr[$i] = mysqli_real_escape_string($link,$arr[$i]);                  
                    }
                    $arr[0]= date('Y-m-d',strtotime($arr[0]));//Always format time to make life easy for quering MYSQL
                    $sql_insert .= "INSERT INTO sales (date, category, title, location, p_condition, pre_tax_amount,
                    tax_name,tax_amount, upload_time) VALUES
                    ('{$arr[0]}','{$arr[1]}','{$arr[2]}','{$arr[3]}','{$arr[4]}','{$arr[5]}','{$arr[6]}','{$arr[7]}',
                    '$uploadtime');";
                }
             $z++;
            }


            $run = mysqli_multi_query($link, $sql_insert);
            if($run === true){
                time_nanosleep(2, 100000); //Necessary to get complete inserted data back
               
                //Callback recent data from MYSQL using time of upload
                $sql_read = "SELECT DATE_FORMAT(date,'%b-%Y') as time,category, SUM(pre_tax_amount) as total_sales FROM
                sales WHERE upload_time='$uploadtime' GROUP BY DATE_FORMAT(date,'%Y-%m'),category";

               $link = mysqli_connect($server, $user_name, $password, $database);
                $call = mysqli_query($link, $sql_read);
                //$fetch = mysqli_fetch_array($call);
                $row_cnt = mysqli_num_rows($call);

                while ($fetch = mysqli_fetch_assoc($call)){
                   $output[] = $fetch;
                }

                print_r(json_encode($output));
                
                

            }
      
        
        } else{
            echo "Why you do this? No CSV file :(";
          }
    }
    
    public function dope(Request $request){
        function img_resize($fn, $dn){//fn is imgage location and dn is the file name to save as
            $jpeg_quality = 95;
            //$photo_dest = $_SERVER['DOCUMENT_ROOT']."/storage/app/images/".$dn; //LIVE SERVER
            $photo_dest = "../storage/app/images/".$dn; //LOCAL SERVER

                if($fn !== ""){
                    list($width, $height, $type, $attr) = getimagesize($fn);
                    if($height > 694){
                    $ratio = $height/$width;
                    $target_height = 694;
                    $target_width = $target_height/$ratio;//adjust image width to match target_height in aspect ratio
                    $src = imagecreatefromstring( file_get_contents( $fn ) );
                    $dst = imagecreatetruecolor( $target_width, $target_height );
                    imagecopyresampled( $dst, $src, 0, 0, 0, 0, $target_width, $target_height, $width, $height );
                    $f = imagejpeg( $dst, $photo_dest, $jpeg_quality);
                    imagedestroy($dst);
                        if($f){
                            return true;
                        }else{
                            return false;
                        }
                    } else{
                        file_put_contents($photo_dest, file_get_contents($fn));
                        //echo "it is fine. just saved it";
                      }
                }
        }
        
        $r_name = $request->rname;
        $r_address = $request->address;
        $r_city = $request->city;
        $r_province = $request->province;
        $s_email = $request->email;
        $s_msg = $request->msg;
        $s_msgcustom = $request->msgcustom;
        $time_stamp = date('Y-m-d-H-i-s');
        $file_name = $r_name."_".$time_stamp; //image file will be saved with this name format
        
        $to = "styleminions@gmail.com, seyi.adaghe@gmail.com";
        $subject = "New Sale";
        $txt = "$request->email is about to pay!\r\n";
        $head = "From: Twistedlovebox <contact@twistedlovebox.com>\r\n";
        //$head .= "To: Ida <$to>\r\n";
        $head .= "X-Mailer: PHP 5.6\r\n";
        $head .= "Return-Path: <$request->email>\r\n";
        $head .= "Reply-To: <$request->email>";
        
        if(!($s_msgcustom == "")){//make custom message default message if it exists. Front end ensures no confusion.
            $s_msg = $request->msgcustom;
        }
        
        $db_list = [$r_name,$r_address,$r_city,$r_province,$s_email,$s_msg,$file_name,$time_stamp];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into lovebox (r_name,r_address,r_city,r_province,s_email,s_msg,img,date) 
        values(?,?,?,?,?,?,?,?)',$db_list);
        //$z =  $request->file('imgfile')->storeAs('images',$file_name.'.jpg');
        $z = img_resize($request->file('imgfile')->path(), $file_name.".jpg");
        
        if($yz){
            echo "Insertion successful.";
            
            mail($to,$subject,$txt,$head); 
        }
//        echo $request->file('imgfile')->path();
//        print_r($request->all());
    }
    
    public function sendMail(Request $request){
        //$to = "styleminions@gmail.com";
        $to = "styleminions@gmail.com, sabdulaz@gmail.com";
		//$subject = "Twistedlovebox Inquiry";
		$subject = "MochaX Inquiry";
		//$txt = "Love your temporary password: IDA\r\n Login and use it to update your password on the account page. ";
        $txt = $request->message;
		$head = "From: $request->name <info@styleminions.co>\r\n";
		//$head .= "To: Ida <$to>\r\n";
		$head .= "X-Mailer: PHP ".phpversion()."\r\n";
		$head .= "Return-Path: <$request->email>\r\n";
		$head .= "Reply-To: $request->name <$request->email>\r\n";

		if(mail($to,$subject,$txt,$head)){
			
			echo "Email sent";
            
		} else {
			
			echo "Email failed";
		}
        //print_r($request->all());
        
    }
    
    public function getData(Request $request){
        $q = $request->q;
        $z = DB::select('select p_id, price, subcategory, img_zero as url from shuffle where women = "1" and price > 0 and img_zero != "" limit ?',[$q]);
        //print_r($z
        //echo json_encode($z);
        return response($z, 201);
        
    }
    
    public function mochaContest(Request $request){
        $db_list = [$request->name,$request->phone,$request->timestamp,$request->points,$request->playtime,$request->played_data];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into mocha_contest (name,phone,time,points,playtime,played_data) 
        values(?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }

    public function fzMochaContest(Request $request){
        $db_list = [
            $request->name,$request->phone,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into fz_mocha (name,phone,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }

    public function dmzMochaContest(Request $request){
        $db_list = [
            $request->name,$request->phone,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into dmz_mocha (name,phone,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }
	
	public function getLeader(Request $request){
        $q = [$request->q];
        //echo $_POST['rname'];
        $yz = DB::select('SELECT * FROM  mocha_contest WHERE time > ? AND phone !=  "9999999999" ORDER BY points DESC LIMIT 20',$q);
        echo json_encode($yz);
    }

    public function fzGetLeader(Request $request){
        $q = [$request->q];
        //echo $_POST['rname'];
        $yz = DB::select('SELECT * FROM  fz_mocha WHERE time > ? AND phone !=  "9999999999" ORDER BY points DESC LIMIT 20',$q);
        echo json_encode($yz);
    }

    public function dmzGetLeader(Request $request){
        $q = [$request->q];
        //echo $_POST['rname'];
        $yz = DB::select('SELECT * FROM  dmz_mocha WHERE time > ? AND phone !=  "9999999999" ORDER BY points DESC LIMIT 20',$q);
        echo json_encode($yz);
    }

    public function lzMochaContest(Request $request){
        $db_list = [
            $request->name,$request->phone,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into lz_mocha (name,phone,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }

    public function lzGetLeader(Request $request){
        $q = [$request->q];
        //echo $_POST['rname'];
        $yz = DB::select('SELECT * FROM  lz_mocha WHERE time > ? AND phone !=  "9999999999" ORDER BY points DESC, playtime ASC LIMIT 20',$q);
        echo json_encode($yz);
    }
    
    public function boroMochaContest(Request $request){
        $db_list = [
            $request->name,$request->email,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup,$request->dress_size
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into boro_mocha (name,email,time,points,playtime,played_data,signup,dress_size) 
        values(?,?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }

    public function apiGetLeader(Request $request){
        //Table must have email and phone columns or else query will fail and crash the API
        //Email and Phone column should have default values at all time or else you will get error 500
        $table = $request->table.'_mocha';
        $q = [$request->q];
        //echo $_POST['rname'];
        $yz = DB::select("SELECT * FROM $table  WHERE time > ? AND phone !=  '9999999999' AND email != 'test@gmail.com' 
              ORDER BY points DESC, playtime ASC LIMIT 20",$q);
        echo json_encode($yz);
    }

    public function apiGetAnalytics(Request $request){
        //Table must have email and phone columns or else query will fail and crash the API
        //Email and Phone column should have default values at all time or else you will get error 500
        $table = $request->table.'_mocha';
        $appName = 'mocha_'.$request->table;
        $q = [$appName,$request->q];
        //echo $_POST['rname'];
        $yz = DB::select("SELECT * FROM $table  WHERE phone != '9999999999' AND email != 'test@gmail.com' 
              ORDER BY time ASC",$q);
        $traffic = DB::select("SELECT count(*) as total FROM mocha_traffic WHERE app_name = ?",$q);
        $output = (object)array();
        $output->traffic = $traffic[0];
        $output->game = $yz;
        echo json_encode($output);
    }

    public function nlsMochaContest(Request $request){
        $db_list = [
            $request->name,$request->email,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into nls_mocha (name,email,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }

    public function inlightenMochaContest(Request $request){
        $db_list = [
            $request->name,$request->email,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into inlighten_mocha (name,email,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }

    public function nudnikMochaContest(Request $request){
        $db_list = [
            $request->name,$request->email,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into nudnik_mocha (name,email,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }
    
    public function andelaMochaContest(Request $request){
        $db_list = [
            $request->name,$request->email,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into andela_mocha (name,email,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }
    public function odessuMochaContest(Request $request){
        $db_list = [
            $request->name,$request->email,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->website,$request->prize
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into odessu_mocha (name,email,time,points,playtime,played_data,website,prize) 
        values(?,?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }
    public function carlaMochaContest(Request $request){
        $db_list = [
            $request->name,$request->email,$request->timestamp,$request->points,$request->playtime,$request->played_data,
            $request->signup
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into carla_mocha (name,email,time,points,playtime,played_data,signup) 
        values(?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }

    public function submitTraffic(Request $request){
        $ip_address = $request->ip();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://freegeoip.net/json/'. $ip_address,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                // Set Here Your Requesred Headers
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            //when http call for ip information fails still save the data
            $db_list = [
                $request->appname,$request->time,$ip_address
            ];
            $yz = DB::insert('insert into mocha_traffic (app_name,time,ip_address) 
            values(?,?,?)',$db_list);
            echo 'ip call failed';
        } else {
             //when http call for ip information succeeds
            //print_r(json_decode($response));
            
            $location = get_object_vars(json_decode($response));
            //echo $location['country_name'];
            $db_list = [
                $request->appname,$request->time,$ip_address,$location['country_name'],$location['region_name'],$location['city'],$location['latitude'],$location['longitude']
            ];
            $yz = DB::insert('insert into mocha_traffic (app_name,time,ip_address,country,region_name,city,latitude,longitude) 
            values(?,?,?,?,?,?,?,?)',$db_list);
            echo json_encode($location);
        }

        
    }
    public function getCurrentChampions(Request $request){
        $q = [$request->today,$request->today];//doubled the data because of the query
        //mysql query gets only the unique insta accounts with the fastest time
        // $yz = DB::select('SELECT name, phone, time,category,short_code,profile_url, playtime as realtime FROM celebpuzzle WHERE playtime in 
        // (select min(playtime) from celebpuzzle where time > ? and leaderboard = 1 GROUP BY name) and leaderboard = 1 
        // group by name ORDER BY playtime ASC LIMIT 100',$q);
        $yz = DB::select('SELECT b.name,b.playtime AS realtime,a.time,a.category,a.short_code,a.profile_url FROM celebpuzzle a JOIN 
        (SELECT name, min(playtime) as playtime FROM celebpuzzle WHERE time > ? AND leaderboard = 1 GROUP BY name)
        AS b ON a.name = b.name AND a.playtime = b.playtime WHERE time > ? AND leaderboard = 1 
        GROUP BY name ORDER BY realtime ASC LIMIT 100',$q);
        //i added another GROUP BY at the end of the query because sometimes there are duplicate leaderboard submissions of the same game
        echo json_encode($yz);
    }
    public function getOldChampions(Request $request){
        $q = [$request->yesterday,$request->today];
        //mysql query gets only the unique insta accounts with the fastest time
        $yz = DB::select('SELECT name, phone, time, profile_url, MIN(playtime) as realtime FROM celebpuzzle WHERE time > ? and time < ?
        and leaderboard = 1 GROUP BY name ORDER BY realtime ASC LIMIT 3',$q);
        echo json_encode($yz);
    }
    public function submitCelebPuzzle(Request $request){
        $db_list = [
            $request->name,$request->timestamp,$request->playtime,$request->picurl,$request->leaderboard,$request->deviceid,
            $request->category,$request->shortcode
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into celebpuzzle (name,time,playtime,profile_url,leaderboard,device_id,category,short_code) values
        (?,?,?,?,?,?,?,?)',$db_list);
        echo "submited i think";
    }
    public function blessMyRequest(Request $request){
        $db_list = [
            $request->payload
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into blessmyrequest (result) values (?)',$db_list);
        echo "submited i think";
    }
    public function blessMyRequestClients(Request $request){
        $db_list = [];
        //echo $_POST['rname'];
        $yz = DB::select("SELECT name, image, city, insta_handle, id FROM bmr_client WHERE client_type != '' ORDER BY name ASC",$db_list);
        echo json_encode($yz);
    }
    public function blessMyRequestReport(Request $request){
        $db_list = [$request->date, $request->clubId];
        $date = $request->date;
        $clubId = $request->clubId;
        $result = array();
        if($request->clubId == ''){
            $yz = DB::select("SELECT result FROM blessmyrequest where result like '%:\"$date%'");
        }else{
            $yz = DB::select("SELECT result FROM blessmyrequest where result like '%:\"$date%' and result like '%:\"$clubId\"%'");
        }
        foreach($yz as $item ){
            $result[] = json_decode($item->result);
        }
        echo json_encode($result);
        //print_r($yz);
    }
    public function bmrAddToVip(Request $request){
        $db_list = [
            $request->club,$request->insta,$request->expiry_date,$request->limit
        ];
        //echo $_POST['rname'];
        $yz = DB::insert('insert into bmr_vip (club_id, insta_handle, expiry_date, request_limit) values (?,?,?,?)',$db_list);
        return response(strval($yz),201);
    }
    public function bmrUpdateVipLimit(Request $request){
        $unique_id = $request->unique_id;
        $club_id = $request->club;
        //echo $_POST['rname'];
        $yz = DB::unprepared("
            SELECT @limit := request_limit FROM bmr_vip where unique_id = $unique_id and club_id = $club_id;
            UPDATE bmr_vip SET request_limit = @limit - 1 where unique_id = $unique_id and club_id = $club_id;
        ");
        return response('yes',204);
    }
    public function bmrVerifyVip(Request $request){
        $insta_handle = $request->insta;
        $club_id = $request->club;
        $now = $request->date;
        //echo $_POST['rname'];
        $yz = DB::select("SELECT expiry_date, unique_id, request_limit from bmr_vip where club_id = $club_id and insta_handle = '$insta_handle'
                        and '$now' < expiry_date  and request_limit > 0");
        if(count($yz) > 0){
            return response(json_encode($yz),200);
        }else{
            return response('Not on vip list',204);
        }
        
    }
	
    
    
}
