<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Hackathon extends Controller
{
  public function beastmode(){
      /**
 * Pause Developer Application Script
 *
 * This script will submit your resume to Pause's server.
 * Fix the bugs, fill in the missing code, and run it to apply for the job.
 * Requires the CURL module to be loaded in your PHP installation.
 *
 * Please Note: While this sample test is written in php, we encourage you
 * to rewrite this code in the language of your choice, we simply require
 * the submission to our server to match, how you do it is completely up
 * to you!
 *
 * (c) 2013 Pause Productions
 */

// This should point to the resume file you want to submit.
// Note this is a path to the file on your local hard drive,
// not the contents of the file. For best results, use PDF,
// RTF, DOC, DOCX, or TXT.
define('APPLICATION_SERVER', 'http://jobs.pause.ca/submit.php');

$resumefile = 'C:\Users\idaho\Documents\Resume Idahosa Adaghe - Dev.docx';

// Your full name
$name = 'Idahosa Adaghe';

// Your phone number
$phone = '5197299749';

// Your email address
$email = 'idahosa1adaghe@hotmail.ca';

// The message we want to send
$subject = 'My developer application';

// Any additional notes you wish to include
// Bonus points if you discover the security issue with this script or
// have ideas for improvements and note them here.
$notes = '1. Array $vars was setup wrong. key pair values use (=>) instead of (=).
          2. Json_decode function was mispelled.
          3. Converted response object to proper array to retrieve API keys.
          4. A POST parameter for CURL should be included cause of sensitive data.
          5. CURLOPT_SAFE_UPLOAD could be used instead of @ just in case any postfield value begins with @.
          We dont want unexpected files to be submitted like @/etc/passwd.
          6. HTTPS url domain is recommended. 
          7. You should hire me cause am a problem solver, fun to work with and I live in OAKVILLE yaaaaayy.
          
';

// Prepare the payload
$vars = array(
    'name'=> $name,
    'phone'=> $phone,
    'email'=> $email,
    'subject'=> $subject,
    'notes'=> $notes,
    'time'=> time(),
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, APPLICATION_SERVER);
curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);


//decode the json encoded response
$responseVars = json_decode($response);
$responseVars = json_decode(json_encode($responseVars), true);


$vars['application-id'] = $responseVars['application-id'];
$key = $responseVars['application-secret-key'];
//var_dump($key);

// You must write the code that generates the signature to sign the application
// request. This is very similar to how other web services handle signatures,
// so you may be familiar with the process. Here's how to do it:

// 1) Sort the $vars array by key
//$vars = ksort($vars);
ksort($vars);

// 2) Convert the sorted $vars array to an http query string (eg: var1=abc&var2=def)
// Note this string should not be prepended with ?, http://, or anything else,
// it should look like the example string above...
      
$http_var = http_build_query($vars, '', '&amp;',PHP_QUERY_RFC3986);
//$http_var = http_build_query($vars);
      
// 3) Concatenate the string from step 2 and $key (string then $key)
$http_var = $http_var.$key;
var_dump($http_var);
      
// 4) Hash the resulting string from step 3 using SHA256. This is your signature.
//$signature = 'This must be replaced by the code you generate in steps 1,2,3,4)';
//$signature = hash_hmac('sha256',$http_var,$key,true);
$signature = hash('sha256',$http_var);
$signature = base64_encode($signature);

//echo $signature;

// 5) Add the signature to the $vars array as 'sig' (done for you, below)
$vars['sig'] = $signature;


//Check that the file exists
if (!file_exists($resumefile)) {
    die('ERROR: Cannot find local file '.$resumefile."\n");
}
      //var_dump($vars);

    // Add the file to upload
    $vars['resume'] = '@'.$resumefile;

    // Include this script (we'd like to see your work please!)
    $vars['script'] = '@'.__FILE__;

    // Post the data to Pause's server
    print "Submitting application...\n";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, APPLICATION_SERVER);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);

    // If we got back "OK" then it was submitted successfully.
    // Otherwise it should tell us what went wrong.
    if ($response=='OK') {
        print "Resume sent successfully, thank you for applying!\n";
    }
    else {
        print "$response\n";
    }
  }  

}
