<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
/*
if(isset($_COOKIE['loggedadmin'])) {
         $_SESSION['loggedadmin']=$_COOKIE['loggedadmin'];
          setcookie('loggedadmin', $_SESSION['loggedadmin'], time() + (86400 * 30), "/");
}
if(isset($_COOKIE['loggeduser'])) {
        $_SESSION['loggeduser']=$_COOKIE['loggeduser'];
         setcookie('loggeduser', $_SESSION['loggeduser'], time() + (86400 * 30), "/");
}
*/
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require '../../api/v2.php';
 $link=mysqli_connect('localhost','viclghik_user','okay2pay','viclghik_ok');
 if(isset($_GET['verify'])){
     $id=$_GET['verify'];
     mysqli_query($link,"UPDATE users set emailv='1' where id='$id'");
     $query=mysqli_query($link,"SELECT * from users  where id='$id'");
  while ($res=mysqli_fetch_array($query)) {
    $email=$res['phone'];
   
  }
   
     header("Location: ../../dashboard/");
     
 }
 if (isset($_POST['action'])) {
    $type=$_POST['action'];
/*
if(isset($_COOKIE['loggeduser'])) {
    $_SESSION['loggeduser']=$_COOKIE['loggeduser'];
} */
if ($type=="logchk") {
if (!isset($_SESSION['loggeduser'])) {
    echo "criminal";
}else{
    setcookie('loggeduser', $_SESSION['loggeduser'], time() + (86400 * 30), "/");
}
}
if ($type=="adminlogchk") {
if (!isset($_SESSION['loggedadmin'])) {
    echo "criminal";
}
}
if ($type=="red") {
if (isset($_SESSION['loggeduser'])) {
    echo "user";
}
if (isset($_SESSION['loggedadmin'])) {
    echo "admin";
}
}
if ($type=='authsignup') {
    $ref=$_POST['ref'];
     $prom=$_POST['prom'];
   $email=$_POST['email'];
   $name=$_POST['name'];
   $epin=$_POST['epin'];
   $em=$_POST['remail'];
   if ($prom !=="") {
       $ref=$prom;
   }
   $password=$_POST['password'];
    $query=mysqli_query($link,"SELECT * FROM login where email ='$email'");
    $query89=mysqli_query($link,"SELECT * FROM users where email ='$em'");
    
 
    $count2=mysqli_num_rows($query);
    $count20=mysqli_num_rows($query89);
  
      if ($count2 =='0') 
      {
        if ($count20 =="0") 
        {
          $date=date("Y-m-d");
          $api_key = generateRandomString();
          mysqli_query($link,"INSERT INTO login values('','$email','$password','user')");
          mysqli_query($link,"INSERT INTO users values('','$name','$epin','$email','$em',' ','','$date','1','null','0','$api_key')");
       
          $_SESSION['loggeduser']=$email;
          if ($ref !== '') 
          {
            $m=$ref;
             $querym=mysqli_query($link,"SELECT * FROM users where id ='$ref'");
             while ($resm=mysqli_fetch_array($querym)) 
             {
                   $m=$resm['phone'];
                   $fname=$resm['first_name'];
                   $last=$resm['last_name'];
            }
             
             mysqli_query($link,"INSERT INTO referrals values('','$m','$em','pending','$date')");
    
          }
          
          
          $querym=mysqli_query($link,"SELECT * FROM users where email ='$em'");
             while ($resm=mysqli_fetch_array($querym)) {
                   $m=$resm['phone'];
                   $fname=$resm['first_name'];
                   $last=$resm['last_name'];
             }
          $bvn=0;
    $bvnfn=$fname;
    $bvnln=$last;
    $phone=$m;
    
     $query=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
        while ($res=mysqli_fetch_array($query)) {
          
            $firstname= $res['first_name'];
            $lastname= $res['last_name'];
            $email=$res['email'];
        }
        $query1=mysqli_query($link,"SELECT * FROM fees where rank='paystack_api_secret'");
        while ($res1=mysqli_fetch_array($query1)) {
            $paystack_secret=$res1['fee'];
        }
                $url1 = "https://api.paystack.co/customer";
        
                $POST = array(
                'customer' => $phone,
                'phone' => $phone, 
                'first_name' => $bvnfn, 
                'last_name' => $bvnln, 
                'email' => $email
                );
                
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url1,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>  http_build_query($POST),
              CURLOPT_HTTPHEADER => array(
                 'content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$paystack_secret,
               
              ),
            ));
            
            
            
            $response = curl_exec($curl);
            
         
            curl_close($curl);
            $response=json_decode($response,true);
   
        $stat=$response["data"];
  
        
    
        
            $bnu=$response["data"]["customer_code"];
            mysqli_query($link,"UPDATE users set bvn='$bnu' where phone='$phone'");
        
        
            $url2 = "https://api.paystack.co/customer/".$bvn;
        
                $POST = array(
                'customer' => $bvn,
                 'phone' => $phone, 
                'first_name' => $bvnfn, 
                'last_name' => $bvnln, 
                'email' => $email
                );
                
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url2,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS =>  http_build_query($POST),
              CURLOPT_HTTPHEADER => array(
                 'content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$paystack_secret,
               
              ),
            ));
            
            
            
            $responses = curl_exec($curl);
          
         
            curl_close($curl);
           // $response=json_decode($response,true);
    
    $querym=mysqli_query($link,"SELECT * FROM users where email ='$em'");
             while ($resm=mysqli_fetch_array($querym)) {
                   $bvn=$resm['bvn'];
                   
             }
        
       // if(!empty($bvn)){
            
            $url3 = "https://api.paystack.co/dedicated_account";
        
                $POST = array(
                'customer' => $bvn,
                 'phone' => $phone, 
                'first_name' => $bvnfn, 
                'last_name' => $bvnln, 
                'email' => $email,
                'preferred_bank' =>'wema-bank'
                );
                
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url3,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>  http_build_query($POST),
              CURLOPT_HTTPHEADER => array(
                 'content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$paystack_secret,
               
              ),
            ));
            
            
            
            $response = curl_exec($curl);
            
         
            curl_close($curl);
            $response_2=json_decode($response,true);
             
        
            $bnum = $response_2["data"]["account_number"];
            
            $ban="Wema Bank";
                
            $query_11 = "SELECT * from vaccounts where number = $bnum";
            $result = $link->query($query_11);
            
            if ($result->num_rows > 0){
           
            } else {
              //mysqli_query($link,"INSERT INTO vaccounts (phone, bank, number) values ('$phone','$ban','122222')") ;
                mysqli_query($link,"INSERT INTO vaccounts (phone, bank, number) values ('$phone','$ban','$bnum')") ;
            }
             mysqli_query($link,"UPDATE vaccounts  set number='$bnum' where phone='$phone'");
            
       // }
        }
else{
    echo "Email Already Registered";
}
     
      }
      else{
        echo 'Phone Number Already Registered';
      }
  
}
if ($type=='auth1') {
     $email=$_POST['email'];
      $password=$_POST['pass'];
    $query1=mysqli_query($link,"SELECT * from users where email='$email' ");
   
    $query2=mysqli_query($link,"SELECT * from login  where email='$email' and password='$password' ");
  
    $res1=mysqli_num_rows($query1);
   
    $res2=mysqli_num_rows($query2);
    
  if ($res2==1) {
if ($email=='admin') {
         $_SESSION['loggedadmin']=$email;
          setcookie('loggedadmin', $_SESSION['loggedadmin'], time() + (86400 * 30), "/");
   
    }
    else{
       
 
   
        $_SESSION['loggeduser']=$email;
         setcookie('loggeduser', $_SESSION['loggeduser'], time() + (86400 * 30), "/");
  
    
       
    }
       
   
  
 
   
  }
else{
    echo "Invalid Email or Password";
}
}
if ($type=="va") {
$phone=$_SESSION['loggeduser'];
$query=mysqli_query($link,"SELECT * FROM users where phone='$phone' and pin ='null' ");
$row=mysqli_num_rows($query);
if ($row == 1) {
    echo  "sss";
}
else{
    echo $row;
}
}
if ($type=="vbvn") {
    $bvn=$_POST['bvn'];
    $bvnfn=$_POST['bvnfn'];
    $bvnln=$_POST['bvnln'];
    $phone=$_SESSION['loggeduser'];
    
     $query=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
        while ($res=mysqli_fetch_array($query)) {
          
            $firstname= $res['first_name'];
            $lastname= $res['last_name'];
            $email=$res['email'];
        }
        $query1=mysqli_query($link,"SELECT * FROM fees where rank='paystack_api_secret'");
        while ($res1=mysqli_fetch_array($query1)) {
            $paystack_secret=$res1['fee'];
        }
                $url1 = "https://api.paystack.co/customer";
        
                $POST = array(
                'customer' => $phone,
                'phone' => $phone, 
                'first_name' => $bvnfn, 
                'last_name' => $bvnln, 
                'email' => $email
                );
                
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url1,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>  http_build_query($POST),
              CURLOPT_HTTPHEADER => array(
                 'content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$paystack_secret,
               
              ),
            ));
            
            
            
            $response = curl_exec($curl);
            
         
            curl_close($curl);
            $response=json_decode($response,true);
   
        $stat=$response["data"];
  
        sleep(.5);
        
        $querym=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
             while ($resm=mysqli_fetch_array($querym)) {
                    $bvn=$resm['bvn'];
                    $phone=$resm['phone'];
                   
             }
            
    
        
            $bnu=$response["data"]["customer_code"];
            mysqli_query($link,"UPDATE users set bvn='$bnu' where phone='$phone'");
        
        
            $url2 = "https://api.paystack.co/customer/".$bvn;
        
                $POST = array(
                'customer' => $bvn,
                 'phone' => $phone, 
                'first_name' => $bvnfn, 
                'last_name' => $bvnln, 
                'email' => $email
                );
                
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url2,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS =>  http_build_query($POST),
              CURLOPT_HTTPHEADER => array(
                 'content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$paystack_secret,
               
              ),
            ));
            
            
            
            $responses = curl_exec($curl);
          
         
            curl_close($curl);
           // $response=json_decode($response,true);
        sleep(.5);
      
        
           $querym=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
             while ($resm=mysqli_fetch_array($querym)) {
                   $bvn=$resm['bvn'];
                   
             }
     
       // if(!empty($bvn)){
            
            $url3 = "https://api.paystack.co/dedicated_account";
        
                $POST = array(
                'customer' => $bvn,
                 'phone' => $phone, 
                'first_name' => $bvnfn, 
                'last_name' => $bvnln, 
                'email' => $email,
                'preferred_bank' =>'wema-bank'
                );
                
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => $url3,
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>  http_build_query($POST),
              CURLOPT_HTTPHEADER => array(
                 'content-type: application/x-www-form-urlencoded',
                'Authorization: Bearer '.$paystack_secret,
               
              ),
            ));
            
            
            
            $response = curl_exec($curl);
            
         
            curl_close($curl);
            $response_2=json_decode($response,true);
             
            $bnum = $response_2["data"]["account_number"];
            
            $ban="Wema Bank";
                
            $query_11 = "SELECT * from vaccounts where number = $bnum";
            $result = $link->query($query_11);
            
            if ($result->num_rows > 0){
           
            } else {
              
                mysqli_query($link,"INSERT INTO vaccounts (phone, bank, number) values ('$phone','$ban','$bnum')") ;
            }
             mysqli_query($link,"UPDATE vaccounts  set number='$bnum' where phone='$phone'");
    
            echo 'done';
       // }
}
if ($type=="home") {
    $t1=0;
    $t2=0;
    
$phone=$_SESSION['loggeduser'];
$query19=mysqli_query($link,"SELECT * FROM referrals where main='$phone'");
$row19=mysqli_num_rows($query19);
$query=mysqli_query($link,"SELECT * FROM vaccounts where phone='$phone'");
$queryk=mysqli_query($link,"SELECT * FROM vaccounts where phone='$phone'");
$row=mysqli_num_rows($query);
$query1=mysqli_query($link,"SELECT * FROM transactions where phone='$phone' order by id desc");
$row1=mysqli_num_rows($query1);
$query2=mysqli_query($link,"SELECT SUM(amount) AS Totalc FROM balance where type='credit' and phone='$phone'");
while($r=mysqli_fetch_array($query2)){
$t1=$r['Totalc'];
}
$query3=mysqli_query($link,"SELECT SUM(amount) AS Totald FROM balance where type='debit' and phone='$phone'");
while($r1=mysqli_fetch_array($query3)){
$t2=$r1['Totald'];
}
$query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$fn=$r2['first_name'];
$ln=$r2['last_name'];
$mail=$r2['email'];
$mbn=$r2['phone'];
$rank=$r2['rank'];
}
while($r2k=mysqli_fetch_array($queryk)){
$oi=$r2k['number'];
    $POST = array(
        'destination_account' => $oi, 
        
        
          
        );
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.ufitpay.com/v1/search_vendor_bank_statement",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS =>  http_build_query($POST),
  CURLOPT_HTTPHEADER => array(
   'content-type: application/x-www-form-urlencoded',
    'Api-Key: sxj47aNm84boWZKkpKAkyK5YroYT18' ,
    'Api-Token: Ic77oZViyCwin1x16w7DqSMBVWOe18'
   
  ),
));
$response = curl_exec($curl);
curl_close($curl);
$balanceJ=json_decode($response,true);
if ($balanceJ["data"]) {
  $u=0;
$tt =count($balanceJ["data"]
) ;
$date="2021-11-11";
for ($i=0; $i < $tt ; $i++) { 
$dat=  explode(" ",$balanceJ["data"][$i]["datetime"]) ;
if ($dat[0] >= $date) {
  $u= $u + $balanceJ["data"][$i]["amount"];
}
    
}
$ul=$u * 0.99;
$t1 =$t1 + $ul;
}
}
$_SESSION['balance']=$t1-$t2;
$query0=mysqli_query($link,"SELECT * FROM fees where name='Merchant' ");
       while ($res0=mysqli_fetch_array($query0)) {
$fee=$res0['fee'];
       }
    ?>
          <?php
    
    $num=$_SESSION['loggeduser'];
  
    $query44=mysqli_query($link,"SELECT * from users where phone='$num'");
while($r2=mysqli_fetch_array($query44)){
$bvn_2=$r2['bvn'];
$firstname= $r2['first_name'];
        $lastname= $r2['last_name'];
        $email=$r2['email'];
        
       
            $display = 'none';
            $name = 'Create a Bank account in one click in seconds!';
            $btn_text = 'Create';
             $bvn_value = Null;
       
        
        
       
}
          
        
    ?>
         <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"><?php echo $name; ?></h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>we will never share your details with any third party. You can read our privacy policy <a href="">here</a>
                                                                            </div>
                                                                            
                                                                            
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                            
                                                                            
                                                                                       
                                                                            <div class="container-fluid p-0 mb-3">
                                                                                <div class="row ">
                                                                                    <div class="col-6">
                                                                                         <label class="mb-2">First Name</label>
                                                                            <input type="text"  placeholder="First Name" id="bvnfn" class="form-control" value="<?php echo $firstname; ?>" readonly>
                                                                                    </div>
                                                                                     <div class="col-6">
                                                                                          <label class="mb-2">Last Name</label>
                                                                            <input type="text" placeholder="Last Name" id="bvnln" class="form-control"  value="<?php echo $lastname; ?>" readonly>
                                                                                     </div>
                                                                                     
                                                                                     <div class="col-6">
                                                                                          <label class="mb-2">Number</label>
                                                                            <input type="text"  id="bvnnu" class="form-control"  value="<?php echo  $_SESSION['loggeduser']; ?>" readonly>
                                                                                     </div>
                                                                                     <div class="form-group mb-3" style="display:<?php echo $display; ?>;">
                                                                                        <label class="mb-2">BVN</label>
                                                                                        <input type="text" readonly id="bvn" maxlength="11" class="form-control" placeholder="Enter Bvn" id="bvn" value="<?php echo $bvn_value; ?>" >
                                                                                        </div>
                                                                                     
                                                                                </div>
                                                                            </div>
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary" type="button" id="bvnbtn"  onclick="vbvn()"><?php echo $btn_text; ?> </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
   <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Upgrade To Merchant Account</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>When you upgrade to Merchant account you get 20 percent discount on every transaction e.g MTN 1GB N225 would become  MTN 1GB N210 
                                                                            </div>
                                                                            <center>
                                                                                
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">Amount</label>
                                                                            <input type="text"  maxlength="11" class="form-control"  readonly=""  value="N <?php echo number_format($fee,0) ?>">
                                                                            </div>
                                                                            
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary" type="button" id="uaccbtn" onclick="uacc()" style="width: 80%">Upgrade Account</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
                                                            <div class="modal fade bs-example-modal-center4"   tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h6 class="modal-title">ATM Top up</h6>
                                                                            
                                                                        
                                                                           
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert" style="display:none;">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span> Top up your account ins seconds <br>       <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Please chat up on whatsapp for faster processing (07061843610) <br> <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Minimum deposit is N 500<br> <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Kindly note N50 service charge will be debited from each deposit you make
                                                                            </div>
                                                                            <div class="alert mb-3 alert-info" role="alert" style="display:none;">
                                                                            Bank Name: UBA <br>
                                                                            Account Number : 1023248428<br>
                                                                            Account Name : Osvnel Ventures
                                                                            </div>
                                                                            <center>
                                                                                
                                                                            </center>
                                                                            
                                                                           
                                                                           
                                                                                <input type="hidden" name="" id="realsscws">
                                                                                <div class="form-group mb-3">
                                                                                <label class="mb-2">Senders Name </label>
                                                                                <input type="text"  class="form-control"  value="<?php  echo $fn." ".$ln?>" readonly="" >
                                                                                
                                                                               
                                                                               
                                                                                </div>
                                                                                
                                                                                <div class="form-group mb-3">
                                                                                <label class="mb-2">Amount</label> 
                                                                                <input type="text"   class="form-control"   value="<?php  echo $mbn; ?>" id="mobile_number" readonly="">
                                                                              
                                                                                </div>
                                                                                
                                                                                <div class="form-group mb-3">
                                                                                <label class="mb-2">Email</label>
                                                                                <input type="text"    class="form-control" value="<?php  echo $mail?>"    id="email" readonly>
                                                                               
                                                                                </div>
                                                                                
                                                                               <div class="form-group mb-3">
                                                                                <label class="mb-2">Amount</label>
                                                                                <input type="text" onChange="myFunction()"  class="form-control"   placeholder="Input amount you sent to the account" id="amount" required="">
                                                                                <p style="color:crimson;" id="topay"></p>
                                                                                </div>
                                                                                
                                                                               
                                                                                <center>
                                                                                    <button class="btn btn-primary" type="button"  onclick="payWithPaystack()" style="width: 40%">Deposit Now</button>
                                                                                </center>
                                                                          
                                                                          
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
                                                            <div class="modal fade bs-example-modal-center1000 kj" id="nbvs"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Verify Account</h5>
                                                                          
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>An Email Containing your verification has ben Sent To Your Email, click on the link. Please Make Sure You Check Your Inbox/Spam 
                                                                            </div>
                                                                            <center>
                                                                                
                                                                            </center>
                                                                            <input type="hidden" name="" id="realc">
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">Code</label>
                                                                            <input type="text"  maxlength="4" class="form-control"   placeholder="Input Code" id="vcode">
                                                                            <small id="rtext" onclick="ve(); this.innerHTML='resent';  this.disabled=true; setTimeout(function(){ this.disabled=false; },10000) ;">Resend</small>
                                                                            </div>
                                                                            <center>
                                                                                <button class="btn btn-primary" disabled="" type="button" id="verbtn" onclick="vacc(document.getElementById('vcode').value)" style="width: 40%">Verify Account</button> <button class="btn  btn-primary" type="button"  style="width: 40%" onclick="logout()">Logout</button>
                                                                            </center>
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="modal fade bs-example-modal-center100" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Add Security Pin</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>This Pin Will Be required For Transactions
                                                                            </div>
                                                                            <center>
                                                                                
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">Pin</label>
                                                                            <input type="number"   class="form-control"   value="" id="pin">
                                                                            </div>
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Retype Pin</label>
                                                                            <input type="number"   class="form-control"     value="" id="pin1">
                                                                            </div>
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary" type="button" id="usecbtn" onclick="usec()" style="width: 80%">Update Pin</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                      <span class="iconify" data-icon="fluent:building-bank-48-filled" ></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php 
                                            if ($row > 0) {
                                                while ($e=mysqli_fetch_array($query)) {
                                                    $bank=$e['bank'];
                                                    $number=$e['number'];
                                                }
                                                ?>
                                                
                                                
                                                
                                                
                                                  <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><b>Bank Account 1% Charge </b></p>
                                                <h6 class="mb-1"><?php echo $number ?><span class="ms-1 " style="position:relative; top: -2px;"><span class="iconify" data-icon="akar-icons:copy" data-width="12"></span></span></h6>
                                                 <p class="mb-1"><?php echo $bank ?></p>
                                                                                          </div>
                                                <?php
                                            }
                                           else{
                                                ?>
                                                <?php
    
    $num=$_SESSION['loggeduser'];
  
    $query44=mysqli_query($link,"SELECT * from users where phone='$num'");
while($r2=mysqli_fetch_array($query44)){
$bvn_2=$r2['bvn'];
$firstname= $r2['first_name'];
        $lastname= $r2['last_name'];
        $email=$r2['email'];
        
        if(empty($bvn_2)){
            $display = 'none';
            $name = 'Create an Account in seconds and Verified it!';
            $btn_text = 'Submit';
             $bvn_value = 0;
             $verify_tsxt = 'Tap to create account';
              $action = 'Add Vbn!';
        }else{
            $display =  'block';
            $name = 'Verify Bvn To Get Account Details';
            $btn_text = 'Verify Bvn';
            $bvn_value = $bvn_2;
            $verify_tsxt = 'Verify Now!';
            $action = 'Verify Vbn!';
        }
       
}
          
        
    ?>
    
                                                  <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><b>Bank Account</b></p>
                                                <h6 class="mb-1"> <?php echo $action; ?>  </h6>
                                                 <p class="mb-1" style="font-size:.8em; text-decoration: underline; cursor: pointer;" onclick="
                                                     document.getElementById('vam').click();
                                                 "><?php echo $verify_tsxt; ?></p>
                                                                                          </div>
                                                <?php
                                            }
                                             ?>
                                          
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                       <span class="iconify" data-icon="ic:twotone-account-balance-wallet" ></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">   <b>Balance</b></p>
                                                <h5 class="mb-4">N <?php  echo number_format(($t1 -$t2),0); ?></h5>
                                                                                          </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-3 col-sm-6">
                              <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                        <i class="ri-group-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                             
                                                    
                                                
                                                <p class="mb-1"><b>Fund Wallet</b></p>
                                                <h6 class="mb-1" style="font-size:.9em">ATM payment</h6>
                                                <button class="btn btn-primary p-0" style="height: 20px; width: 70% ; font-size: .7em;" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center4">Top up</button>
                                                                                          
                                            
                                                                                          </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                       <span class="iconify" data-icon="icon-park-outline:transaction-order" ></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><b>Rank</b></p>
                                                <?php 
                                                    if ($rank == "1") {
                                                     
                                                       ?>
                                                    <h6 class="mb-1">Smart User</h6>
                                                    <p class="mb-1" style="font-size:.7em; text-decoration: underline; cursor: pointer;" onclick="
                                                     document.getElementById('vam1').click();
                                                 ">Tap to upgrade account</p>
                                                       <?php
                                                    }
                                                    if ($rank == "2") {
                                                       
                                                       ?>
                                                    <h5 class="mb-4">Merchant</h5>
                                                   
                                                       <?php
                                                    }
                                                  ?>
                                                                                          </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <?php
                        $link=mysqli_connect('localhost','viclghik_user','okay2pay','viclghik_ok');
                        $query111=mysqli_query($link,"SELECT * FROM fees where rank='paystack_api_key'");
    while ($res1=mysqli_fetch_array($query111)) {
        $paystack_key=$res1['fee'];
    }
$query123=mysqli_query($link,"SELECT * FROM fees where name='Card'");
    while ($res1=mysqli_fetch_array($query123)) {
        $card_fee=$res1['fee'];
    }
    ?>
                        
                        <!-- end row -->
                         <div class="row">
                            <input type="hidden" id="paystack_key" value="<?php echo $paystack_key; ?>"> 
                            <input type="hidden" id="card_fee" value="<?php echo $card_fee; ?>"> 
                         </div>
                
                        <!-- end row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Category/Network</th>
                                                        <th scope="col">type</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Status</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query1)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                      
                                                        <td><?php  echo $de['rdate'] ?></td>
                                                        <td><?php  echo $de['name'] ?></td>
                                                        <td><?php  echo $de['cat'] ?></td>
                                                          <td><?php  echo $de['type'] ?></td>
                                                        
                                                        <td>
                                                           N  <?php  echo number_format($de['amount'],0)  ?>
                                                        </td>
                                                          <td>
                                                            <?php  echo $de['status'];  ?>
                                                        </td>
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
    <?php
}
if ($type=="bills") {
?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Bills</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="row" style="margin-top:10vh">
                            <div class="col-lg-4">
                                <div class="card card-body text-center">
                                    <center><img src="../img/cable.png" class="mb-4" height="100px" width="100px"></center>
                                    <h4 class="card-title ">Cable Subscriptions</h4>
                                    
                                    <a onclick="cable()"  class="btn btn-primary mt-3 waves-effect waves-light">Proceed</a>
                                </div>
                            </div>
                            <div class="col-lg-4 ">
                                <div class="card card-body text-center">
                                    <center><img src="../img/ele.png" class="mb-4" height="100px" width="100px"></center>
                                    <h4 class="card-title ">Electricity Bill Payment</h4>
                                    
                                    <a onclick="ele()"  class="btn btn-primary mt-3 waves-effect waves-light">Proceed</a>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="card card-body text-center">
                                    <center><img src="../img/waec.png" class="mb-4" height="100px" width="100px"></center>
                                    
                                    <h4 class="card-title">Buy Waec pin</h4>
                                    
                                    <a onclick="waec()"  class="btn btn-primary mt-3 waves-effect waves-light">Proceed</a>
                                </div>
                            </div>
                        </div>
<?php
    }
    if ($type=="cable") {
          $phone=$_SESSION['loggeduser'];
    $query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$v=$r2['rank'];
$pin=$r2['pin'];
}
        $query40=mysqli_query($link,"SELECT * from fees where name='Cable' and rank='$v'");
while($r20=mysqli_fetch_array($query40)){
$fee=$r20['fee'];
}
?>
  <input type="hidden" name="" id="dpin" value="<?php echo $pin ?>">
        <button type="button" style="display: none" id="vam1" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center9">Modal Demo</button>
<div class="modal fade bs-example-modal-center9" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick="if (document.getElementById('vvpin').value == document.getElementById('dpin').value) {
                                                                                     var ju=document.getElementById('c1cp').options[document.getElementById('c1cp').selectedIndex].text;
                                            var ju1=document.getElementById('id_cablename').options[document.getElementById('id_cablename').selectedIndex].text;
                                            var ju2=document.getElementById('c1cp').options[document.getElementById('c1cp').selectedIndex].text;
                                            var myArr = ju.split('N');
                                            console.log(myArr[1]);
                                            paycable(document.getElementById('c1sc').value,document.getElementById('c1cp').value,document.getElementById('id_cablename').value,myArr[1],ju1,ju2);
                                                                                  } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
                                                                                }">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
        <button type="button" style="display: none" id="vam2" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center90">Modal Demo</button>
<div class="modal fade bs-example-modal-center90" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction1</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin2">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick="
                                                                               
                                                                                
                                                                                if (document.getElementById('vvpin2').value == document.getElementById('dpin').value) {
                                                                              
                                                                                var ju=document.getElementById('c2cp').options[document.getElementById('c2cp').selectedIndex].text;
                                                                                
                                                                                var ju1=document.getElementById('id_cablename').options[document.getElementById('id_cablename').selectedIndex].text;
                                                                                var ju2=document.getElementById('c2cp').options[document.getElementById('c2cp').selectedIndex].text;
                                                                                
                                                                                var myArr = ju.split('N');
                                                                                console.log(myArr[1]);
                                                                                paycable(document.getElementById('c2sc').value,document.getElementById('c2cp').value,document.getElementById('id_cablename').value,myArr[1],ju1,ju2);
                                                                                  } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
                                                                                }
                                                                                "
                                                                                >Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
        <button type="button" style="display: none" id="vam3" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center900">Modal Demo</button>
<div class="modal fade bs-example-modal-center900" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick="if (document.getElementById('vvpin').value == document.getElementById('dpin').value) {
                                                                                     var ju=document.getElementById('c3cp').options[document.getElementById('c3cp').selectedIndex].text;
                                            var ju1=document.getElementById('id_cablename').options[document.getElementById('id_cablename').selectedIndex].text;
                                            var ju2=document.getElementById('c3cp').options[document.getElementById('c3cp').selectedIndex].text;
                                            var myArr = ju.split('N');
                                            console.log(myArr[1]);
                                            paycable(document.getElementById('c3sc').value,document.getElementById('c3cp').value,document.getElementById('id_cablename').value,myArr[1],ju1,ju2);
                                                                                  } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
                                                                                }">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item ">Bills</li><li class="breadcrumb-item active">Cable</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6">
                                <div class="container-fluid p-4 " style="background: white; border-radius: 20px;">
                                        <div style="float:right; cursor:pointer;" class="mb-2" onclick="
                                    document.getElementById('c1').style.display='none';
                                    document.getElementById('c2').style.display='none';
                                    document.getElementById('c3').style.display='none';
                                    document.getElementById('ds').style.display='block';
                                    document.getElementById('id_cablename').disabled=false;
                                    "><span class="iconify me-1" data-icon="bi:arrow-left-circle-fill"></span>Back</div>
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Cable Name</label>
                                        <select name="cablename" class="select form-control"  id="id_cablename">
                                          <option value="" >Choose Cable</option>
                                          <option value="1">GOTV</option>
                                          <option value="2">DSTV</option>
                                          <option value="3">STARTIMES</option>
                                        </select>
                                    </div>
                                    <center><button class="btn btn-primary" style="width:100%"
                                        onclick="                                       if (document.getElementById('id_cablename').value !=='') {
                                            document.getElementById('id_cablename').disabled=true;
                                            document.getElementById('c'+document.getElementById('id_cablename').value).style.display='block';
                                            this.style.display='none';
                                        }
                                            
                                        " 
                                        id="ds"
                                        >Proceed</button></center>
                                        <div id="c1" style="display:none">
                                            <div class="form-group mb-3" >
                                            <label class="mb-2">Smart Card number / IUC number</label>
                                            <input type="text" class="form-control" style="width:70%; display: inline-block;" name="" id="c1sc" maxlength="15" >
                                            <button class="btn btn-primary" onclick="cablec(document.getElementById('c1sc').value,document.getElementById('id_cablename').options[getElementById('id_cablename').selectedIndex].text,document.getElementById('id_cablename').value,this)">Verify</button>
                                            <small id="f1"></small>
                                        </div>
                                        <div class="form-group mb-3" >
                                            <label class="mb-2">Cable Plan</label>
                                            <select name="cableplan" class="select form-control" required="" id="c1cp">
                                            <option value="34">GOtv Smallie - Monthly  = N800</option>
                                            <option value="16">GOtv Jinja  = N1640</option>
                                            <option value="35">GOtv Smallie - Quarterly  = N2100</option>
                                            <option value="17">GOtv Jolli  = N2460</option>
                                            <option value="2">GOtv Max  = N3600</option>
                                            <option value="36">GOtv Smallie - Yearly  = N6200</option>
                                            </select>
                                        </div>
                                        <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>we charge a N <?php echo $fee ?> service fee
                                                                            </div>
                                            <center><button class="btn btn-primary"  disabled=""  style="width:100%"
                                        onclick="
                                        if (document.getElementById('c1sc').value !=='' && document.getElementById('c1cp').value !=='' ) {
 
                                           document.getElementById('vam1').click();
                                        }
                                            
                                        " 
                                        id="c1btn"
                                        >Proceed</button></center>
                                        </div>
                                        <div id="c2" style="display:none">
                                            <div class="form-group mb-3" >
                                          
                                            <div class="form-group mb-3" >
                                            <label class="mb-2">Smart Card number / IUC number1</label>
                                            <input type="text" class="form-control" style="width:70%; display: inline-block;" name="" id="c2sc" maxlength="15" >
                                            <button class="btn btn-primary" onclick="cablec(document.getElementById('c2sc').value,document.getElementById('id_cablename').options[getElementById('id_cablename').selectedIndex].text,document.getElementById('id_cablename').value,this)">Verify</button>
                                            <small id="f2"></small>
                                        </div>
                                        </div>
                                        <div class="form-group mb-3" >
                                            <label class="mb-2">Cable Plan</label>
                                            <select name="cableplan" class="select form-control" required="" id="c2cp">
                                            <option value="20">DStv Padi  = N1850</option>
                                            <option value="33">ExtraView Access  = N2500</option>
                                            <option value="32">DStv HDPVR Access Service  = N2500</option>
                                            <option value="6">DStv Yanga  = N2565</option>
                                            <option value="28">DStv Padi + ExtraView  = N4350</option>
                                            <option value="19">DStv Confam  = N4615</option>
                                            <option value="27">DStv Yanga + ExtraView  = N5065</option>
                                            <option value="23">DStv Asia  = N6200</option>
                                            <option value="26">DStv Confam + ExtraView  = N7115</option>
                                            <option value="7">DStv Compact  = N7900</option>
                                            <option value="29">DStv Compact + Extra View  = N10400</option>
                                            <option value="8">DStv Compact Plus  = N12400</option>
                                            <option value="31">DStv Compact Plus - Extra View  = N14900</option>
                                            <option value="9">DStv Premium  = N18400</option>
                                            <option value="25">DStv Premium Asia  = N20500</option>
                                            <option value="30">DStv Premium + Extra View  = N20900</option>
                                            <option value="24">DStv Premium French  = N25550</option>
                                            </select>
                                        </div>
                                        <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>we charge a N <?php echo $fee ?>  service fee
                                                                            </div>
                                            <center><button class="btn btn-primary" disabled="" id="c2btn" style="width:100%"
                                        onclick="
                                            if (document.getElementById('c2sc').value !=='' && document.getElementById('c2cp').value !=='' ) {
                                                   document.getElementById('vam2').click();
                                          
                                        }
                                            
                                        " 
                                        >Proceed</button></center>
                                        </div>
                                        <div id="c3" style="display:none">
                                            <div class="form-group mb-3" >
                                            
                                            <div class="form-group mb-3" >
                                            <label class="mb-2">Smart Card number / IUC number</label>
                                            <input type="text" class="form-control" style="width:70%; display: inline-block;" name="" id="c3sc" maxlength="15" >
                                            <button class="btn btn-primary" onclick="cablec(document.getElementById('c3sc').value,document.getElementById('id_cablename').options[getElementById('id_cablename').selectedIndex].text,document.getElementById('id_cablename').value,this)">Verify</button>
                                            <small id="f3"></small>
                                        </div>
                                        </div>
                                        <div class="form-group mb-3" >
                                            <label class="mb-2">Cable Plan</label>
                                            <select name="cableplan" class="select form-control" required="" id="c3cp">
                                                <option value="42">nova - 90 naira - 1 Day  = N90</option>
                                                <option value="43">Basic - 160 naira - 1 Day  = N160</option>
                                                <option value="44">Smart - 200 naira - 1 Day  = N200</option>
                                                <option value="37">nova - 300 naira - 1 Week  = N300</option>
                                                <option value="45">Classic - 320 naira - 1 Day  = N320</option>
                                                <option value="46">Super - 400 naira - 1 Day  = N400</option>
                                                <option value="38">Basic - 600 naira - 1 Week  = N600</option>
                                                <option value="39">Smart - 700 naira - 1 Week  = N700</option>
                                                <option value="14">nova - 900 naira - 1 Month  = N900</option>
                                                <option value="40">Classic - 1200 naira - 1 Week  = N1200</option>
                                                <option value="41">Super - 1,500 naira - 1 Week  = N1500</option>
                                                <option value="12">Basic - 1,700 naira - 1 Month  = N1700</option>
                                                <option value="13">Smart - 2,200 naira - 1 Month  = N2200</option>
                                                <option value="11">Classic - 2,500 naira - 1 Mont  = N2500</option>
                                                <option value="15">Super - 4,200 naira - 1 Month  = N4200</option>
                                                </select>
                                        </div>
                                        <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>we charge a N <?php echo $fee ?>  service fee
                                                                            </div>
                                            <center><button class="btn btn-primary" id="c3btn" disabled style="width:100%"
                                        onclick="
                                            if (document.getElementById('c3sc').value !=='' && document.getElementById('c3cp').value !=='' ) {
  document.getElementById('vam2').click();
                                           
                                        }
                                            
                                        " 
                                        >Proceed</button></center>
                                        </div>
                                        
                                        
                                </div>
                                <center class="mt-3" style="cursor: pointer;" onclick="window.location=window.location"> <span class="iconify me-2" data-icon="bi:arrow-left"></span>Back to Bills</center>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
<?php
    }
    if ($type=="paycable") {
  $phone=$_SESSION['loggeduser'];
    $query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$v=$r2['rank'];
}
        $query40=mysqli_query($link,"SELECT * from fees where name='Cable' and rank='$v'");
while($r20=mysqli_fetch_array($query40)){
$fee=$r20['fee'];
}
        $phone=$_SESSION['loggeduser'];
        $sm=$_POST['sm'];
        $cp=$_POST['cp'];
        $cn=$_POST['cn'];
        $pp=$_POST['price'] + $fee;
        $name=$_POST['name'];
        $name1=$_POST['name1'];
$bal=$_SESSION['balance'];
if ($bal >= $pp) {
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.superjara.com/api/cablesub/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "cablename": '.$cn.' ,
"cableplan" : '.$cp.', 
"smart_card_number": '.$sm.'
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Token 2f91e3c18e88e8d1b05a980fe7c72914ab0f5fcd',
    'Content-Type: application/json'
  ),
));
$response = curl_exec($curl);
curl_close($curl);
$balanceJ=json_decode($response,true);
if ($balanceJ["error"][0]) {
    echo "An Error occured please contact admin<br><br>";
    echo $response;
}
else if ($balanceJ["Status"]=="successful"){
    echo "";
$date=date("Y-m-d");
mysqli_query($link,"INSERT INTO transactions values('','$name1','$name','$pp','Cable','success','$phone','$date')");
    mysqli_query($link,"INSERT INTO balance values('','debit','$pp','$date','$phone')");
    $_SESSION['balance']=$_SESSION['balance'] -$pp;
}
    else{
        echo $response;
    }
    
}
else{
    echo "You do not have sufficient balance ( Bal: N".$bal." | fee: N".$pp.")";
}
    }
    if ($type=="ele") {
        
         $phone=$_SESSION['loggeduser'];
    $query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$v=$r2['rank'];
$pin=$r2['pin'];
}
        $query40=mysqli_query($link,"SELECT * from fees where name='Electricity' and rank='$v'");
while($r20=mysqli_fetch_array($query40)){
$fee=$r20['fee'];
}
        ?>
  <input type="hidden" name="" id="dpin" value="<?php echo $pin ?>">
        <button type="button" style="display: none" id="vam1" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center9">Modal Demo</button>
<div class="modal fade bs-example-modal-center9" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick="if (document.getElementById('vvpin').value == document.getElementById('dpin').value) {
                                                                                  var ju2=document.getElementById('dist').options[document.getElementById('dist').selectedIndex].text;
 payele(document.getElementById('dist').value,document.getElementById('mn').value,document.getElementById('mt').value,document.getElementById('ma').value,document.getElementById('cp').value,ju2)
                                                                                  } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
                                                                                }">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item ">Bills</li><li class="breadcrumb-item active">Electricity</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6"> 
<div class="container-fluid p-4 mb-5 " style="background: white; border-radius: 20px;">
    <div class="form-group mb-3">
        <label class="mb-3"> Distributor</label>
        <select name="disco_name" class="select form-control" required="" id="dist">
        
              <option value="1">Ikeja-Electric</option>
              <option value="2">Eko-Electric</option>
              <option value="3">Abuja-Electric</option>
              <option value="4">Kano-Electric</option>
              <option value="5">Enugu-Electric</option>
              <option value="6">Port Harcourt-Electric</option>
              <option value="7">Ibadan-Electric</option>
              <option value="8">Kaduna-Electric</option>
              <option value="9">Jos-Electric</option>
            </select>
    </div>
    <div class="form-group mb-3">
        <label class="mb-3"> Metre Number</label><br>
     <input type="text" class="form-control" style="width:50%; display: inline-block;" name="" id="mn" maxlength="15" >
                                            <button class="btn btn-primary" onclick="elec(document.getElementById('mn').value,document.getElementById('dist').options[getElementById('dist').selectedIndex].text,this,document.getElementById('mt').value)">Verify</button><br>
                                            <small id="f11"></small>
    </div>
    <div class="form-group mb-3">
        <label class="mb-3"> Metre Type</label>
    <select name="MeterType" class="select form-control" required="" id="mt">
  
  <option value="Prepaid">Prepaid</option>
  <option value="Postpaid">Postpaid</option>
</select>
    </div>
    <div class="form-group mb-3">
        <label class="mb-3"> Amount </label>
        <input type="number" class="form-control" name="" id="ma">
    </div>
    <div class="form-group mb-3">
        <label class="mb-3"> Customer Phone</label>
        <input type="text" class="form-control" name="" id="cp">
    </div>
    <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>we charge a N <?php echo $fee  ?> service fee
                                                                            </div>
<center><button class="btn btn-primary mb-5" type="button" id="elh" disabled="" onclick="  
if (document.getElementById('mn').value !=='' && document.getElementById('ma').value !=='' && document.getElementById('cp').value !=='' ) {
document.getElementById('vam1').click();
}
">Purchase</button></center>
</div>
   <center class="mt-2 mb-4" style="cursor: pointer;" onclick="window.location=window.location"> <span class="iconify me-2" data-icon="bi:arrow-left"></span>Back to Bills</center>
                            </div>
                            <div class="col-sm-4"></div>
                        </div>
        <?php
    }
        if ($type=="payele") {
                     $phone=$_SESSION['loggeduser'];
    $query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$v=$r2['rank'];
}
        $query40=mysqli_query($link,"SELECT * from fees where name='Electricity' and rank='$v'");
while($r20=mysqli_fetch_array($query40)){
$fee=$r20['fee'];
}
        $phone=$_SESSION['loggeduser'];
        $dist=$_POST['dist'];
        $cp=$_POST['cp'];
        $mn=$_POST['mn'];
        $mt=$_POST['mt'];
        $dist1=$_POST['dist1'];
        $ma=$_POST['ma'] + $fee;
$bal=$_SESSION['balance'];
if ($bal >= $ma) {
$user="directorvictor@icloud.com";
$password="mummy2012";
$pp=rand(88,78654678);
$POST = array('billersCode' => $mn, 
    'serviceID' => strtolower($dist1),
    'variation_code' => strtolower($mt),
     'request_id' => $pp,
     'amount' => $ma,
     'phone' => $cp,
          
        );
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://vtpass.com/api/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS =>  http_build_query($POST),
  CURLOPT_HTTPHEADER => array(
   'content-type: application/x-www-form-urlencoded'
   
  ),
  
));
 curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $user. ":" .$password); 
$response = curl_exec($curl);
curl_close($curl);
$balanceJ=json_decode($response,true);
if ($balanceJ["content"]["transactions"]["status"]=="failed") {
    echo "error";
}
else if ($balanceJ["response_description"]=="TRANSACTION SUCCESSFUL"){
    echo "good";
$date=date("Y-m-d");
mysqli_query($link,"INSERT INTO transactions values('','$dist1','Meter Number | $mn','$ma','Eletricity','success   | $balanceJ[purchased_code] ','$phone','$date')");
    mysqli_query($link,"INSERT INTO balance values('','debit','$ma','$date','$phone')");
    $_SESSION['balance']=$_SESSION['balance'] - $ma;
}
    else{
        echo $response;
    }
}
else{
    echo "You do not have sufficient balance ( Bal: N".$bal." | fee: N".$ma.")";
}
    }
    if ($type=="airtime") {
$phone=$_SESSION['loggeduser'];
    $query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$v=$r2['rank'];
$pin=$r2['pin'];
}
        $query40=mysqli_query($link,"SELECT * from fees where name='Airtime' and rank='$v'");
while($r20=mysqli_fetch_array($query40)){
$fee=$r20['fee'];
}
        $lo= 1-($fee/100);
        ?>
        <input type="hidden" name="" id="dpin" value="<?php echo $pin ?>">
        <button type="button" style="display: none" id="vam" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center9">Modal Demo</button>
<div class="modal fade bs-example-modal-center9" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick="if (document.getElementById('vvpin').value == document.getElementById('dpin').value) { payairtime(document.getElementById('id_network').value,document.getElementById('phone').value,document.getElementById('amt').value);   } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
                                                                                }">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
                <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Airtime</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-6"> 
<div class="container-fluid p-4 mb-5 " style="background: white; border-radius: 20px;">
    <div class="form-group mb-3">
        <label class="mb-2">Network</label>
        <select name="network" class="select form-control" required="" id="id_network">
  <option value="mtn">MTN</option>
  <option value="glo">GLO</option>
  <option value="9mobile">9MOBILE</option>
  <option value="airtel">AIRTEL</option>
  
</select>
    </div>
    <div class="form-group mb-3">
        <label class="mb-2">Mobile Number</label>
        <input type="text" name="" maxlength="11" class="form-control" id="phone">
    </div>
    <div class="form-group mb-3">
        <label class="mb-2">Amount</label>
        <input type="number" name=""  class="form-control" id="amt" oninput="document.getElementById('amt3').value=this.value * <?php echo $lo ?> ;">
    </div>
    <div class="form-group mb-3">
        <label class="mb-2">To be Debited</label>
        <input type="number" name=""  class="form-control" id="amt3" readonly>
    </div>
    <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>you get <?php echo $fee ?>% discount on all airtime purchase
                                                                            </div>
    <center><button class="btn btn-primary" id="payair" onclick="
if (document.getElementById('phone').value !==''  && document.getElementById('amt').value !=='') {
document.getElementById('vam').click();
    
}
    "> Buy Airtime</button></center>
</div>
</div>
<div class="col-sm-2"></div>
</div>
        <?php
    }
    if ($type=="payairtime") {
        $phone=$_SESSION['loggeduser'];
    $query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$v=$r2['rank'];
}
        $query40=mysqli_query($link,"SELECT * from fees where name='Airtime' and rank='$v'");
while($r20=mysqli_fetch_array($query40)){
$fee=$r20['fee'];
}
        $phone=$_SESSION['loggeduser'];
        $net=$_POST['net'];
        $cp=$_POST['phone'];
        $amt=$_POST['amt'];
        $amt1=$_POST['amt'] * (1-($fee/100) );
    $date=date("Y-m-d  h:i:s");
$bal=$_SESSION['balance'];
if ($bal >= $amt1) {
$user="directorvictor@icloud.com";
$password="mummy2012";
$POST = array('request_id' => $net.$cp.$date, 
    'serviceID' => $net,
    'amount' =>  $amt,
    'phone' => $cp
          
        );
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://vtpass.com/api/pay",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS =>  http_build_query($POST),
  CURLOPT_HTTPHEADER => array(
   'content-type: application/x-www-form-urlencoded'
   
  ),
  
));
 curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $user. ":" .$password); 
$response = curl_exec($curl);
curl_close($curl);
$balanceJ=json_decode($response,true);
if ($balanceJ["code"] !=="000") {
    echo $balanceJ["response_description"];
}
else if ($balanceJ["code"] =="000") {
mysqli_query($link,"INSERT INTO transactions values('','Airtime','$net','$amt','$cp','success','$phone','$date')");
    mysqli_query($link,"INSERT INTO balance values('','debit','$amt1','$date','$phone')");
    $_SESSION['balance']=$_SESSION['balance'] - $amt1;
}
else{
    echo $response;
}
    
    
}
else{
    echo "You do not have sufficient balance ( Bal: N".$bal." | fee: N".$amt1.")";
}
    }
        if ($type=="data") {
                 $phone=$_SESSION['loggeduser'];
    $query4=mysqli_query($link,"SELECT * from users where phone='$phone'");
while($r2=mysqli_fetch_array($query4)){
$v=$r2['rank'];
$pin =$r2['pin'];
}
        $query40=mysqli_query($link,"SELECT * from dataplans where network='mtn' and rank='$v'");
        $query400=mysqli_query($link,"SELECT * from dataplans where network='glo' and rank='$v'");
        $query4000=mysqli_query($link,"SELECT * from dataplans where network='9mobile' and rank='$v'");
        $query40000=mysqli_query($link,"SELECT * from dataplans where network='Airtel' and rank='$v'");
?>
        <input type="hidden" name="" id="dpin" value="<?php echo $pin ?>">
        <button type="button" style="display: none" id="vam1" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center99">Modal Demo</button>
<div class="modal fade bs-example-modal-center99" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick="if (document.getElementById('vvpin').value == document.getElementById('dpin').value) {  var ju=document.getElementById('c1cp').options[document.getElementById('c1cp').selectedIndex].getAttribute('amt');
                                            var ju1=document.getElementById('id_cablename').options[document.getElementById('id_cablename').selectedIndex].text;
                                            var ju2=document.getElementById('c1cp').options[document.getElementById('c1cp').selectedIndex].text;
                                            
                                            console.log(ju);
                                            if(document.getElementById('cb1').checked){
                                            paydata(document.getElementById('c1sc').value,document.getElementById('c1cp').value,document.getElementById('id_cablename').value,ju,ju1,ju2,'ch'); 
                                            
                                            }
                                            else{paydata(document.getElementById('c1sc').value,document.getElementById('c1cp').value,document.getElementById('id_cablename').value,ju,ju1,ju2); }
                                            } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
                                                                                     
   
                                                                                } ">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
                                                             <button type="button" style="display: none" id="vam2" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center90">Modal Demo</button>
<div class="modal fade bs-example-modal-center90" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin2">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick=" if (document.getElementById('vvpin2').value == document.getElementById('dpin').value) { 
                                                                                         var ju=document.getElementById('c2cp').options[document.getElementById('c2cp').selectedIndex].getAttribute('amt');
                                            var ju1=document.getElementById('id_cablename').options[document.getElementById('id_cablename').selectedIndex].text;
                                            var ju2=document.getElementById('c2cp').options[document.getElementById('c2cp').selectedIndex].text;
                                              if(document.getElementById('cb2').checked){
                                              
                                              paydata(document.getElementById('c2sc').value,document.getElementById('c2cp').value,document.getElementById('id_cablename').value,ju,ju1,ju2,'ch');
                                              }
                                              else{
                                               paydata(document.getElementById('c2sc').value,document.getElementById('c2cp').value,document.getElementById('id_cablename').value,ju,ju1,ju2);
                                              }
                                            
                                                   
                                                                                   } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
                                                                                }  ">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
                                                             <button type="button" style="display: none" id="vam3" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center9">Modal Demo</button>
<div class="modal fade bs-example-modal-center9" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin3">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button  data-bs-dismiss="modal" class="btn btn-primary" type="button" id="bvnbtn" onclick=" if (document.getElementById('vvpin3').value == document.getElementById('dpin').value) { 
                                            var ju=document.getElementById('c3cp').options[document.getElementById('c3cp').selectedIndex].getAttribute('amt');
                                            var ju1=document.getElementById('id_cablename').options[document.getElementById('id_cablename').selectedIndex].text;
                                            var ju2=document.getElementById('c3cp').options[document.getElementById('c3cp').selectedIndex].text;
                                          if(document.getElementById('cb3').checked){
                                          
                                           paydata(document.getElementById('c3sc').value,document.getElementById('c3cp').value,document.getElementById('id_cablename').value,ju,ju1,ju2,'ch');
                                          }
                                          else{
                                          
                                            paydata(document.getElementById('c3sc').value,document.getElementById('c3cp').value,document.getElementById('id_cablename').value,ju,ju1,ju2);}
                                                                                 } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
                                                                                    
   
                                                                                }">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Data Subscription</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-1"></div>
                            <div class="col-sm-6 mb-3">
                                <div class="container-fluid p-4 " style="background: white; border-radius: 20px;">
                                    <div style="float:right; cursor:pointer;" class="mb-2" onclick="
                                    document.getElementById('c1').style.display='none';
                                    document.getElementById('c2').style.display='none';
                                    document.getElementById('c3').style.display='none';
                                    document.getElementById('ds').style.display='block';
                                    document.getElementById('id_cablename').disabled=false;
                                    "><span class="iconify me-1" data-icon="bi:arrow-left-circle-fill"></span>Back</div>
                                    <div class="form-group mb-3">
                                        <label class="mb-2">Data</label>
                                        <select name="network" class="select form-control" required="" id="id_cablename">
 
                                          <option value="1">MTN</option>
                                          <option value="2">GLO</option>
                                          <option value="3">9MOBILE</option>
                                          
                                          <option value="4">AIRTEL</option>
                                          
                                          
                                        </select>
                                    </div>
                                    <center><button class="btn btn-primary" id="ds" style="width:100%"
                                        onclick="                                       if (document.getElementById('id_cablename').value !=='') {
                                            document.getElementById('id_cablename').disabled=true;
                                            document.getElementById('c'+document.getElementById('id_cablename').value).style.display='block';
                                            this.style.display='none';
                                        }
                                            
                                        " 
                                        >Proceed</button></center>
                                        <div id="c1" style="display:none">
                                            <div class="form-group mb-3" >
                                            <label class="mb-2">Mobile number</label>
                                            <input type="text" class="form-control" name="" id="c1sc" maxlength="11">
                                        </div>
                                        <div class="form-group mb-3" >
                                            <label class="mb-2">Data Plan</label>
              <select name="plan" class="select form-control" required="" id="c1cp">
<?php
while ($res=mysqli_fetch_array($query40)) {
    if ($res["amt"] !=="") {
    
    
 ?>
<option plantype="<?php echo strtoupper($res['type'])  ?>" value="<?php echo $res['value']; ?>" amt="<?php echo $res['amt']; ?>"  style="display: block;"><?php echo explode("=",$res['name'])[0] ; ?>  <?php  echo $res['type'] ?>  |  N<?php echo $res['amt'] ?></option>
<?php
}
}
 ?>
</select>
                                        </div>
                                         <div class="form-group mb-3">
                                            <div class="row">
                                                <div class="col-1">
                                                    <input type="checkbox" id="cb1">
                                                </div>
                                                <div class="col-11">Bypass number validator </div>
                                            </div>
                                        </div>
                                            <center><button class="btn btn-primary" style="width:100%"
                                        onclick="
                                        if (document.getElementById('c1sc').value !=='' && document.getElementById('c1cp').value !=='' ) {
                                            
                                            document.getElementById('vam1').click();
                                        }
                                            
                                        " 
                                        id="c1btn"
                                        >Proceed</button></center>
                                        </div>
                                        <div id="c2" style="display:none">
                                            <div class="form-group mb-3" >
                                            <label class="mb-2">Mobile number</label>
                                            <input type="text" class="form-control" name="" id="c2sc" maxlength="11">
                                        </div>
                                        <div class="form-group mb-3" >
                                            <label class="mb-2">Data Plan</label>
                                        <select name="plan" class="select form-control" required="" id="c2cp">
                                    
                                <?php
 
while ($res2=mysqli_fetch_array($query400)) {
     if ($res2["amt"] !=="") {
 ?>
<option plantype="<?php echo strtoupper($res2['type'])  ?>" value="<?php echo $res2['value']; ?>" amt="<?php echo $res2['amt']; ?>"  style="display: block;"><?php echo explode("=",$res2['name'])[0] ; ?>  <?php  echo $res2['type'] ?>   |  N<?php echo $res2['amt'] ?></option>
<?php
}
}
 ?>
                                    </select>
                                        </div>
                                         <div class="form-group mb-3">
                                            <div class="row">
                                                <div class="col-1">
                                                    <input type="checkbox" id="cb2">
                                                </div>
                                                <div class="col-11">Bypass number validator </div>
                                            </div>
                                        </div>
                                       
                                            <center><button class="btn btn-primary" id="c2btn" style="width:100%"
                                        onclick="
                                            if (document.getElementById('c2sc').value !=='' && document.getElementById('c2cp').value !=='' ) {
                                       document.getElementById('vam2').click();
                                        }
                                            
                                        " 
                                        >Proceed</button></center>
                                        </div>
                                        <div id="c3" style="display:none">
                                            <div class="form-group mb-3" >
                                            <label class="mb-2">Mobile number</label>
                                            <input type="text" class="form-control" name="" id="c3sc" maxlength="11">
                                        </div>
                                        <div class="form-group mb-3" >
                                            <label class="mb-2">Data Plan</label>
                                                <select name="plan" class="select form-control" required="" id="c3cp">
        
<?php
 
while ($res200=mysqli_fetch_array($query4000)) {
     if ($res200["amt"] !=="") {
 ?>
<option plantype="<?php echo strtoupper($res200['type'])  ?>" value="<?php echo $res200['value']; ?>" amt="<?php echo $res200['amt']; ?>"  style="display: block;"><?php echo explode("=",$res200['name'])[0] ; ?> <?php  echo $res200['type'] ?>  |  N<?php echo $res200['amt'] ?></option>
<?php
}
}
 ?>
        </select>
                                        </div>
                                        
                                         <div class="form-group mb-3">
                                            <div class="row">
                                                <div class="col-1">
                                                    <input type="checkbox" id="cb3">
                                                </div>
                                                <div class="col-11">Bypass number validator </div>
                                            </div>
                                        </div>
                                        
                                            <center><button class="btn btn-primary" id="c3btn" style="width:100%"
                                        onclick="
                                            if (document.getElementById('c3sc').value !=='' && document.getElementById('c3cp').value !=='' ) {
                                                document.getElementById('vam3').click();
                                        }
                                            
                                        " 
                                        >Proceed</button></center>
                                        </div>
                                        
                                        
                                </div>
                            </div>
                            <div class="col-sm-4 card p-3  " style="border-radius:20px">
                                <h6 class="mb-2">DATA BALANCE CODES</h6>
                                <div class="mb-2">MTN : *131*4# or 
*460*260#</div>
            <div class="mb-2">9MOBILE : *228#</div> 
            <div class="mb-2">GLO : *127*0#</div> 
             <div class="mb-2">AIRTEL : *140#</div> 
                            </div>
                        </div>
<?php
    }
    if ($type=="paydata") {
        $phone=$_SESSION['loggeduser'];
        $dphone=$_POST['dphone'];
        $plan=$_POST['plan'];
        $net=$_POST['net'];
        $pp=$_POST['price'];
        $netn=$_POST['netn'];
        $plann=$_POST['plann'];
        $ch=$_POST['ch'];
        if($ch=="ch"){
            $pn="1";
        }
        else{
            $pn="0";
        }
$bal=$_SESSION['balance'];
if ($bal >= $pp) {
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.superjara.com/api/data/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "network": "'.$net.'",
"mobile_number": "'.$dphone.'",
"plan": "'.$plan.'",
"Ported_number": "'.$pn.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Token 2f91e3c18e88e8d1b05a980fe7c72914ab0f5fcd',
    'Content-Type: application/json'
  ),
));
$response = curl_exec($curl);
curl_close($curl);
$balanceJ=json_decode($response,true);
if ($balanceJ["error"][0]) {
    echo "An Error occured please contact admin";
}
else if ($balanceJ["Status"]=="successful"){
    if($balanceJ[id]){
            echo "good";
$date=date("Y-m-d");
mysqli_query($link,"INSERT INTO transactions values('','$plann','$netn','$pp','Data','success | $balanceJ[id]','$phone','$date')");
    mysqli_query($link,"INSERT INTO balance values('','debit','$pp','$date','$phone')");
    $_SESSION['balance']=$_SESSION['balance'] - $pp;
    }
    else{
        echo "Something went wrong";
    }
    
}
    else{
        echo $response;
    }
    
}
else{
    echo "You do not have sufficient balance ( Bal: N".$bal." | fee: N".$pp.")";
}
    }
      if ($type=='profile') {
      $phone=$_SESSION['loggeduser'];
      $query10=mysqli_query($link,"SELECT * FROM vaccounts where phone='$phone'");
$row=mysqli_num_rows($query10);
         $query=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
        while ($res=mysqli_fetch_array($query)) {
          
        $firstname= $res['first_name'];
        $lastname= $res['last_name'];
        $email=$res['email'];
        
        
        }
         $query1=mysqli_query($link,"SELECT * FROM login where email='$phone'");
        while ($res1=mysqli_fetch_array($query1)) {
      $passs=$res1['password'];
        
        }
      ?>
      <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Profile</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Profile</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
<input type="hidden" name="" value="<?php echo $passs ?>" id="pass5">
<div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                              
                                <div class="nk-block">
                                    <div class="row g-gs">
                                     <div class="col-sm-4">
                                         <form class="card p-5">
                                             <div class="form-group mb-3">
                                                 <label class="mb-3">
                                                     First Name aaaa
                                                 </label>
                                                 <input type="text" name="" class="form-control" value="<?php echo $firstname ?>" id="fn" <?php if($row > 0){ echo"readonly"; } ?>>
                                             </div>
                                             <div class="form-group mb-3">
                                                 <label class="mb-3">
                                                    Last Name
                                                 </label>
                                                 <input type="text" name="" class="form-control" value="<?php echo $lastname ?>" id="ln"  <?php if($row > 0){ echo"readonly"; } ?>>
                                             </div>
                                              <div class="form-group mb-3">
                                                 <label class="mb-3">
                                                     Phone
                                                 </label>
                                                 <input type="text" name="" class="form-control" value="<?php echo $phone ?>" id="ph" readonly>
                                             </div>
                                              <div class="form-group mb-3">
                                                 <label class="mb-3">
                                                    Email
                                                 </label>
                                                 <input type="text" name="" class="form-control" readonly="" value="<?php echo $email ?>" id="kj">
                                             </div>
                                              
                                              <button class="btn btn-primary mt-3" type="button" id="widt" style="width:100px" onclick="updd(document.getElementById('fn').value,document.getElementById('ln').value,document.getElementById('kj').value); this.innerHTML='updating..';">Update</button>
                                         </form>
                                     </div>
                                       <div class="col-sm-4 ">
                                        <div class="card p-5">
                                            <h5>Reset Pin</h5>
                                            <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                  Password
                                                 </label>
                                                 <input type="text" name="" class="form-control" id="ppass"  oninput="pass3()">
                                             </div>
                                              <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                     New Pin
                                                 </label>
                                                 <input type="number" name="" class="form-control"   id="ppin" oninput="pass3()" >
                                             </div>
                                              <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                    Retype Pin
                                                 </label>
                                                 <input type="number" name="" class="form-control" id="ppin1" oninput="pass3()">
                                             </div>
                                             <button class="btn btn-primary mt-3" type="button" id="widthhh" style="width:200px" disabled="" onclick="pass10(); this.innerHTML='Pin Changed'">Change Pin</button>
                                        </div>
                                          
                                     </div>
                                     <div class="col-sm-4 ">
                                        <div class="card p-5">
                                            <h5>Reset Password</h5>
                                            <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                    Old  Password
                                                 </label>
                                                 <input type="password" name="" class="form-control" oninput ="pass()" id="pass" >
                                             </div>
                                              <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                     New Password
                                                 </label>
                                                 <input type="password" name="" class="form-control"  oninput ="pass()" id="pass1" >
                                             </div>
                                              <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                    Retype Password
                                                 </label>
                                                 <input type="password" name="" class="form-control"  oninput ="pass()" id="pass2"  >
                                             </div>
                                             <button class="btn btn-primary mt-3" type="button" id="widthh" style="width:200px" disabled="" onclick="pass1(); this.innerHTML='Password Changed'">Change Password</button>
                                        </div>
                                          
                                     </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
      <?php
  }
  if ($type=='updd') {
     $fname=$_POST['fname'];
    $phone=$_POST['phone'];
    $phone1=$_POST['email'];
    $email=$_SESSION['loggeduser'];
    mysqli_query($link,"UPDATE users set first_name ='$fname',last_name='$phone', email='$phone1' where phone='$email'");
  }
  if ($type=='upddd') {
        $email=$_SESSION['loggeduser'];
     $fname=$_POST['fname'];
   
    mysqli_query($link,"UPDATE login set password ='$fname' where email='$email'");
  }
  if ($type=="history") {
    $phone=$_SESSION['loggeduser'];
$query1=mysqli_query($link,"SELECT * FROM transactions where phone='$phone' order by id desc");
$row1=mysqli_num_rows($query1);
    ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Transactions</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">History</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Category/Network</th>
                                                        <th scope="col">type</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Status</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query1)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                      
                                                        <td><?php  echo $de['rdate'] ?></td>
                                                        <td><?php  echo $de['name'] ?></td>
                                                        <td><?php  echo $de['cat'] ?></td>
                                                          <td><?php  echo $de['type'] ?></td>
                                                        
                                                        <td>
                                                           N  <?php  echo number_format($de['amount'],0)  ?>
                                                        </td>
                                                          <td>
                                                            <?php  echo $de['status'];  ?>
                                                        </td>
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
    <?php
  }
   if ($type=='reff') {
$phone=$_SESSION['loggeduser'];
    
         $query1=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
         $query40=mysqli_query($link,"SELECT * FROM referrals where main='$phone'");
         $row1=mysqli_num_rows($query40);
        while ($res1=mysqli_fetch_array($query1)) {
      $id=$res1['id']."__".$res1['jdate'].$res1['email'];
        
        }
    ?>
<div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Referrals</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>You Can share your link and earn </p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <!-- .toggle-wrap -->
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                     <div class="col-sm-12">
                                        <div class="card p-5">
                                             <h5 class="mb-2">Your Referal Link</h5>
                                             <label>You Get N1 for each friend you refer</label>
                                               <div class="input-group">
     
                                         <input type="text" name=""  id='myInput' readonly=""class="form-control" value="https://ok2pay.ng/register.html?ref=<?php  echo $id ?>">        <div class="input-group-append">
            <button class="btn btn-outline-primary btn-dim" onclick='
 
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */
  document.execCommand("copy");
document.getElementById("bv").innerHTML="Copied!";
  
            '><span class="iconify mr-2" data-icon="bx:bxs-copy"></span> <span id="bv">Copy</span></button> <button class="btn btn-outline-primary btn-dim" onclick="
window.location='https://wa.me/?text=<?php echo urlencode(" Buy Cheap data, Save money & get Quick loan today . Sign up today and get free ₦5.00  to get started https://ok2pay.ng/register.html?ref=".$id); ?>';
            "><span class="iconify mr-2" data-icon="ant-design:share-alt-outlined"></span></button>
        </div>
    </div>
                                        </div>
                                        
                                     </div>
                                    
                                    </div>
                                     <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">id</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">date</th>
                                                        <th scope="col">amount</th>
                                                       
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query40)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                       <td><?php  echo $de['id'] ?></td>
                                                    
                                                        <td><?php  echo $de['name'] ?></td>
                                                          <td><?php  echo $de['date'] ?></td>
                                                          <td>N 0.5</td>
                                                       
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
    <?php
      }
  if ($type=='withdraw') {
      $email=$_SESSION['loggeduser'];
   $bal=$_SESSION['balance'];
   
      $queryy=mysqli_query($link,"SELECT * FROM withdrawal where phone='$email' and status='processing'");
    $numm=mysqli_num_rows($queryy);
   
   ?>
<div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Withdraw</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>You Can Withdraw Your Funds</p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <!-- .toggle-wrap -->
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                      <?php  
                                         
   
                                        
                                            
                                                         if ($numm == 0) {
      ?>
         <div class="col-xl-12 col-xxl-8">
                                            <div class="card card-bordered card-full">
                                                <div class="card-inner border-bottom">
                                                    <div class="card-title-group">
                                                        <div class="card-title">
                                                       
                                                        </div>
                                                        <div class="card-tools">
                                                      
                                                        </div>
                                                    </div>
                                                </div>
                                               <form class="p-5">
                                                <div class="row">
                                                    <div class="col-sm-6 mb-3">
                                                        <div class="form-group">
                                                       <label class="mb-3">Bank</label>
                                                          <select class="form-control" id="bank">
                                                                
                                                        <option value="801">Abbey Mortgage Bank</option>
                                                        <option value="044">Access Bank</option>
                                                        <option value="063">Access Bank (Diamond)</option>
                                                        <option value="035A">ALAT by WEMA</option>
                                                        <option value="50926">Amju Unique MFB</option>
                                                        <option value="401">ASO Savings and Loans</option>
                                                        <option value="51229">Bainescredit MFB</option>
                                                        <option value="50931">Bowen Microfinance Bank</option>
                                                        <option value="565">Carbon</option>
                                                        <option value="50823">CEMCS Microfinance Bank</option>
                                                        <option value="023">Citibank Nigeria</option>
                                                        <option value="559">Coronation Merchant Bank</option>
                                                        <option value="050">Ecobank Nigeria</option>
                                                        <option value="562">Ekondo Microfinance Bank</option>
                                                        <option value="50126">Eyowo</option>
                                                        <option value="070">Fidelity Bank</option>
                                                        <option value="51314">Firmus MFB</option>
                                                        <option value="011">First Bank of Nigeria</option>
                                                        <option value="214">First City Monument Bank</option>
                                                        <option value="501">FSDH Merchant Bank Limited</option>
                                                        <option value="00103">Globus Bank</option>
                                                        <option value="232">GoMoney</option>
                                                        <option value="058">Guaranty Trust Bank</option>
                                                        <option value="51251">Hackman Microfinance Bank</option>
                                                        <option value="50383">Hasal Microfinance Bank</option>
                                                        <option value="030">Heritage Bank</option>
                                                        <option value="51244">Ibile Microfinance Bank</option>
                                                        <option value="50457">Infinity MFB</option>
                                                        <option value="301">Jaiz Bank</option>
                                                        <option value="082">Keystone Bank</option>
                                                        <option value="50211">Kuda Bank</option>
                                                        <option value="90052">Lagos Building Investment Company Plc.</option>
                                                        <option value="50549">Links MFB</option>
                                                        <option value="50563">Mayfair MFB</option>
                                                        <option value="50304">Mint MFB</option>
                                                        <option value="999991">PalmPay</option>
                                                        <option value="526">Parallex Bank</option>
                                                        <option value="311">Parkway - ReadyCash</option>
                                                        <option value="999992">Paycom</option>
                                                        <option value="50746">Petra Mircofinance Bank Plc</option>
                                                        <option value="076">Polaris Bank</option>
                                                        <option value="101">Providus Bank</option>
                                                        <option value="502">Rand Merchant Bank</option>
                                                        <option value="125">Rubies MFB</option>
                                                        <option value="51310">Sparkle Microfinance Bank</option>
                                                        <option value="221">Stanbic IBTC Bank</option>
                                                        <option value="068">Standard Chartered Bank</option>
                                                        <option value="232">Sterling Bank</option>
                                                        <option value="100">Suntrust Bank</option>
                                                        <option value="302">TAJ Bank</option>
                                                        <option value="51211">TCF MFB</option>
                                                        <option value="102">Titan Bank</option>
                                                        <option value="032">Union Bank of Nigeria</option>
                                                        <option value="033">United Bank For Africa</option>
                                                        <option value="215">Unity Bank</option>
                                                        <option value="566">VFD Microfinance Bank Limited</option>
                                                        <option value="035">Wema Bank</option>
                                                        <option value="057">Zenith Bank</option>
                                                                
                                                            </select>
            <span style="font-size:.8em"> <span class="iconify mr-2" data-icon="gg:danger" style="color: crimson;"></span> You can only add a bank Account with your name</span>
                                                               
                                                   </div>
                                                    </div>
                                                    <div class="col-sm-3 mb-3">
                                                        <label class="mb-3">Account Number</label>
                                                        <input type="text" name="" class="form-control" id="number">
                                                    </div>
                                                     <div class="col-sm-3 mb-3 pt-4">
                                                       <button class="btn btn-primary mt-3" type="button" onclick="
                                                       acctv(); this.innerHTML='Verifying'; this.innerHTML='Veriying...'; this.disabled=true;
                                                      " id="widt">Verify</button>
                                                    </div>
                                                     <div class="col-sm-8">
                                                     <div class="form-group mt-3">
                                                    <label class="mb-3">Account name</label>
                                                    <input type="text" name="" disabled class="form-control" id="aname">
                                                </div>
                                                </div>
                                                </div>
                                               
                                               <div style="display:none; width: 70%;" id="with2">
                                                   
                                                <div class="form-group mt-3">
                                                    <label class="mb-2">Amount</label>
                                                    <div class="input-group mb-1">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">NGN </span>
                                                    </div>
                                                    <input type="text" class="form-control" placeholder="0.00" required oninput="bc(this.value)" id="bvc" >
                                                </div>
                                                <small class="mt-3">Balance: NGN <span> <b id="cvg"><?php echo $bal ?></b> </span></small>
                                                </div>
                                                <center>  <button class="btn btn-primary mt-3 btn-lg" style="width: 200px; display: block; text-align:center;" disabled="" id="kjh" onclick="sendw(this,document.getElementById('bvc').value); this.innerHTML='Sending Withdrawal..';" type="button"> <center>Send Withdrawal</center> </button></center>
                                               </div>
                                                   
                                               </form>
                                            </div><!-- .card -->
                                        </div>
      <?php
    }
    else{
?>
<center><h5>Your Withdrawal is still being processed</h5></center>
<?php
    }
                                            
  ?>
                                      
                                     <!-- .col -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
   <?php
  }
  if ($type=='verifyacct') {
     
    $bank=$_POST['bank'];
    $acct=$_POST['acct'];
        $email=$_SESSION['loggeduser'];
        $query=mysqli_query($link,"SELECT * FROM users where phone='$email'");
        while ($res=mysqli_fetch_array($query)) {
           
        $firstname= $res['first_name'];
        $lastname= $res['last_name'];
        }
       
          $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/bank/resolve?account_number=".$acct."&bank_code=".$bank,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_live_7181693d7332734def1004dc5f53e3cbf485771c",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  
  curl_close($curl);
  
  if ($err) {
   
  } else {
    
  }
  $balanceJ=json_decode($response,true);
  $statusw=$balanceJ['status'];
 if (!$statusw) {
   echo 'kk';
 }
 else{
    $hh=$balanceJ['data']['account_name'];
    $tt=(explode(" ",$hh));
    if ($firstname==$tt[0] || $lastname==$tt[2] || $firstname==$tt[1] || $firstname==$tt[2] || strtoupper($firstname)==$tt[0] || strtoupper($firstname)==$tt[2]) {
        echo $hh;
    }
else{
    echo 'kk';
}
 }
  }
  if ($type=='sendw') {
   $email=$_SESSION['loggeduser'];
     $bank=$_POST['bank'];
     $num=$_POST['num'];
    $amt=$_POST['amt'];
  $date=date("Y-m-d");
mysqli_query($link,"INSERT into  withdrawal values('','$email','$amt','$bank','$num','processing') ");
mysqli_query($link,"INSERT INTO balance values('','debit','$amt','$date','$phone')");
  }
  if ($type=='logout') {
        $_SESSION['balance']=0;
        session_destroy();
        setcookie("loggedadmin", "", time()-3600);
        setcookie("loggeduser", "", time()-3600);
        
  }
 if ($type=='loans') {
$phone=$_SESSION['loggeduser'];
    
         $query1=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
         $query40=mysqli_query($link,"SELECT * FROM loans where phone='$phone'");
         $row1=mysqli_num_rows($query40);
        while ($res1=mysqli_fetch_array($query1)) {
      $id=$res1['id']."__".$res1['jdate'].$res1['email'];
      $pin=$res1['pin'];
        
        }
   $query0=mysqli_query($link,"SELECT * FROM fees where name='Loan'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee=1 + ($res0['fee'] / 100);
       }
    ?>
      <input type="hidden" name="" id="dpin" value="<?php echo $pin ?>">
        <button type="button" style="display: none" id="vam1" class="btn btn-primary btn-sm waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center9">Modal Demo</button>
<div class="modal fade bs-example-modal-center9" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Enter Pin To Carry Out Transaction</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             
                                                                            <center>
                                                                                <p id="bvnerr" style="color:crimson"></p>
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">PIN</label>
                                                                            <input type="password"  maxlength="11" class="form-control" placeholder="Enter PIN" id="vvpin">
                                                                            </div>
                                                                          
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary"  data-bs-dismiss="modal" type="button" id="bvnbtn" onclick="if (document.getElementById('vvpin').value == document.getElementById('dpin').value) {
                                                                                     loan(document.getElementById('amt').value,document.getElementById('reason').value,document.getElementById('address').value,document.getElementById('bvn').value,document.getElementById('rp').value);
                                                                                  } else{
                                                                                     Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
                                                                                }">Proceed </button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Loans</h3>
                                            <div class="nk-block-des text-soft">
                                                <p>You Can Apply For loans</p>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <!-- .toggle-wrap -->
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                     <div class="col-sm-5 mb-5">
                                        <div style="background: white;" class="p-5">
                                            <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>To Loan more than N 100,000 please contact support or visit any of our branch </a>
                                                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2"> Amount</label>
                                                <input type="number" max="100000" name="" class="form-control" id="amt"
                                                oninput="
                                                document.getElementById('zh').value=this.value * <?php echo $fee ?>;
                                                " 
                                                >
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2"> Repayment Amount</label>
                                                <input type="number" class="form-control" readonly="" id="zh">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2"> Reason</label>
                                                <input type="text" name="" class="form-control" id="reason">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Residential Address</label>
                                                <input type="text" name="" class="form-control" id="address">
                                            </div>
                                             <div class="form-group mb-3">
                                                <label class="mb-2">Repayment in Days</label>
                                                <input type="number" name="" class="form-control" placeholder="30"  id="rp">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2"> Bvn</label>
                                                <input type="number" name="" class="form-control"  id="bvn">
                                            </div>
                                            <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Approved Loans will be paid to your Ok2pay wallet only <br><br> <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Loan applications costs N200
                                                                            </div>
                                            <center><button class="btn btn-primary" id="loanbtn" type="button" onclick="
                                                if (document.getElementById('amt').value !=='' && document.getElementById('reason').value !=='' && document.getElementById('address').value !=='' && document.getElementById('bvn').value !==''  && document.getElementById('rp').value !=='' ) {
                                          document.getElementById('vam1').click();
                                                }
                                            ">Apply</button></center>
                                        </div>
                                        
                                     </div>
                                    
                                    </div>
                                     <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">id</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">date</th>
                                                        <th scope="col">amount</th>
                                                        <th scope="col">reason</th>
                                                        <th scope="col">address</th>
                                                        <th scope="col">duration</th>
                                                        <th scope="col">due</th>
                                                         <th scope="col">Amount due</th>
                                                      
                                                       
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query40)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                       <td><?php  echo $de['id'] ?></td>
                                                    
                                                        <td><?php  echo $de['status'] ?></td>
                                                          <td><?php  echo $de['adate'] ?></td>
                                                          <td><?php  echo $de['amount'] ?></td>
                                                           <td><?php  echo $de['reason'] ?></td>
                                                           <td><?php  echo $de['address'] ?></td>
                                                           <td><?php  echo $de['repay'] ?></td>
                                                           <td><?php  echo $de['repayd'] ?></td>
                                                           <td><?php  echo $de['repayamt'] ?></td>
                                                       
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
    <?php
      }
if ($type=="loan") {
    $phone=$_SESSION['loggeduser'];
$amt=$_POST['amt'];
$amt2=$_POST['amt'] * 1.03;
$rp=$_POST['rp'];
$reason=$_POST['reason'];
$address=$_POST['address'];
$bvn=$_POST['bvn'];
$date=date("Y-m-d");
$date2=date('Y-m-d', strtotime($date. ' + '.$rp.' days'));
$bal=$_SESSION["balance"];
if ($rp > 15 && $rp < 181) {
   if ($amt <= 100000) {
   if ($bal >= 200) {
   if (mysqli_query($link,"INSERT INTO loans values('','$phone','$amt','pending','$reason','$address','$bvn','$date','$rp','$date2','$amt2')")) {
    mysqli_query($link,"INSERT INTO balance values('','debit','200','$date','$phone')");
echo "success";
}
else{
    echo "database error";
}
}
else{
    echo "Insufficient Balance To Apply  (Bal :N ".$bal." Fee : N200)";
}
}
else{
     echo "Maximum loan amount is N100,000";
}
}
else{
        echo "Duration can only be between 14 and 180 Days";
}
}
if ($type=="uacc") {
    $date=date("Y-m-d");
   $phone=$_SESSION['loggeduser'];
$bal=$_SESSION['balance'];
$query0=mysqli_query($link,"SELECT * FROM fees where name='Merchant' ");
       while ($res0=mysqli_fetch_array($query0)) {
$fee=$res0['fee'];
       }
if ($bal >= $fee) {
    if ( mysqli_query($link,"UPDATE users set rank='2' where phone='$phone'")) {
        mysqli_query($link,"INSERT INTO balance values('','debit','30000','$date','$phone')");
        echo "true";
    }
  else{
    echo "Database Error";
  }
}
else{
    echo "Insufficient Balance";
  }
   }
   if ($type=="savings") {
    $phone=$_SESSION['loggeduser'];
$query=mysqli_query($link,"SELECT * FROM savings where phone ='$phone' order by id desc");
$row1=mysqli_num_rows($query);
   $query1=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
    
        while ($res1=mysqli_fetch_array($query1)) {
    
      $pin=$res1['pin'];
        
        }
$query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Starter'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Master'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
    ?>
    <input type="hidden" name="" id="dpin" value="<?php echo $pin  ?>">
<div class="modal fade bs-example-modal-center11" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">STARTER  SAVINGS PLAN</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Funds are strictly locked till maturity date <a href="">read more</a> <br><br>
                                                                                 <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Interest funds are available instantly
                                                                            </div>
                                                                            <center>
                                                                              
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">Duration (Months)</label>
                                                                          <select class="form-control" id="sdur" onchange="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('samt').value * this.value * <?php echo ($fee1/100) ?>);
                                                                          ">
                                                                              <option value="1"> 1 Month</option>
                                                                              <option value="2"> 2 Months</option>
                                                                              <option value="3"> 3 Months</option>
                                                                              <option value="4"> 4 Months</option>
                                                                              <option value="5"> 5 Months</option>
                                                                              <option value="6"> 6 Months</option>
                                                                          </select>
                                                                            </div>
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Amount to save</label>
                                                                          <input type="number" name="" class="form-control" placeholder="0.00" id="samt" oninput="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('sdur').value * this.value * <?php echo ($fee1/100) ?>);
                                                                          ">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                            <label class="mb-2">Total Interest (at <?php echo $fee1 ?>% monthly)</label>
                                                                          <input type="text" name="" id="sint" class="form-control" readonly="">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                            <label class="mb-2">When To Get Interest</label>
                                                                          <select class="form-control" id="swhen">
                                                                              <option value="1">Now</option>
                                                                              <option value="2">Maturity Date</option>
                                                                          </select>
                                                                            </div>
                                                                              <div class="form-group mb-3">
                                                                            <label class="mb-2">Account Pin</label>
                                                                         <input type="password" name="" id="accpin" class="form-control">
                                                                            </div>
                                                                            
                                                                           
                                                                            <center>
                                                                                <button class="btn btn-primary" type="button"  onclick="
                                                                                if (document.getElementById('samt').value !=='' && document.getElementById('sdur').value !=='' && document.getElementById('sint').value !=='') {
if (document.getElementById('accpin').value == document.getElementById('dpin').value) {
save('starter',document.getElementById('samt').value,document.getElementById('sdur').value,document.getElementById('sint').value,this,document.getElementById('swhen').value);
}
else{
    Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
}
                                                                                }
                                                                                " style="width: 80%">Start Savings Plan</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="modal fade bs-example-modal-center12" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">BUSINESS  SAVINGS PLAN</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Funds are strictly locked till maturity date <a href="">read more</a> <br><br>
                                                                                 <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Interest funds are available instantly
                                                                            </div>
                                                                            <center>
                                                                              
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">Duration (Months)</label>
                                                                          <select class="form-control" id="sdur2" onchange="
                                                                          document.getElementById('sint2').value= Math.round(document.getElementById('samt2').value * this.value * <?php echo ($fee2/100) ?>);
                                                                          ">
                                                                              <option value="1"> 1 Month</option>
                                                                              <option value="2"> 2 Months</option>
                                                                              <option value="3"> 3 Months</option>
                                                                              <option value="4"> 4 Months</option>
                                                                              <option value="5"> 5 Months</option>
                                                                              <option value="6"> 6 Months</option>
                                                                          </select>
                                                                            </div>
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Amount to save</label>
                                                                          <input type="number" name="" class="form-control" placeholder="0.00" id="samt2" oninput="
                                                                          document.getElementById('sint2').value= Math.round(document.getElementById('sdur2').value * this.value * <?php echo ($fee2/100) ?>);
                                                                          ">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                            <label class="mb-2">Total Interest (at <?php echo $fee2 ?>% monthly)</label>
                                                                          <input type="text" name="" id="sint2" class="form-control" readonly="">
                                                                            </div>
                                                                              <div class="form-group mb-3">
                                                                            <label class="mb-2">When To Get Interest</label>
                                                                          <select class="form-control" id="swhen2">
                                                                              <option value="1">Now</option>
                                                                              <option value="2">Maturity Date</option>
                                                                          </select>
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                            <label class="mb-2">Account Pin</label>
                                                                         <input type="password" name="" id="accpin1" class="form-control">
                                                                            </div>
                                                                            <center>
                                                                                <button class="btn btn-primary" type="button"  onclick="
                                                                                if (document.getElementById('samt2').value !=='' && document.getElementById('sdur2').value !=='' && document.getElementById('sint2').value !=='') {
if (document.getElementById('accpin1').value == document.getElementById('dpin').value) {
save('business',document.getElementById('samt2').value,document.getElementById('sdur2').value,document.getElementById('sint2').value,this,document.getElementById('swhen2').value);
}
else{
    Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
}
                                                                                }
                                                                                " style="width: 80%">Start Savings Plan</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
                                                            <div class="modal fade bs-example-modal-center13" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Master  SAVINGS PLAN</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Funds are strictly locked till maturity date <a href="">read more</a> <br><br>
                                                                                 <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Interest funds are available instantly
                                                                            </div>
                                                                            <center>
                                                                              
                                                                            </center>
                                                                           <div class="form-group mb-3">
                                                                            <label class="mb-2">Duration (Months)</label>
                                                                          <select class="form-control" id="sdur3" onchange="
                                                                          document.getElementById('sint3').value= Math.round(document.getElementById('samt3').value * this.value * <?php echo ($fee3/100) ?>);
                                                                          ">
                                                                              <option value="1"> 1 Month</option>
                                                                              <option value="2"> 2 Months</option>
                                                                              <option value="3"> 3 Months</option>
                                                                              <option value="4"> 4 Months</option>
                                                                              <option value="5"> 5 Months</option>
                                                                              <option value="6"> 6 Months</option>
                                                                          </select>
                                                                            </div>
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Amount to save</label>
                                                                          <input type="number" name="" class="form-control" placeholder="0.00" id="samt3" oninput="
                                                                          document.getElementById('sint3').value= Math.round(document.getElementById('sdur3').value * this.value * <?php echo ($fee3/100) ?>);
                                                                          ">
                                                                            </div>
                                                                            <div class="form-group mb-3">
                                                                            <label class="mb-2">Total Interest (at <?php echo $fee3 ?>% monthly)</label>
                                                                          <input type="text" name="" id="sint3" class="form-control" readonly="">
                                                                            </div>
                                                                            
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">When To Get Interest</label>
                                                                          <select class="form-control" id="swhen3">
                                                                              <option value="1">Now</option>
                                                                              <option value="2">Maturity Date</option>
                                                                          </select>
                                                                            </div>
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Account Pin</label>
                                                                         <input type="password" name="" id="accpin2" class="form-control">
                                                                            </div>
                                                                            <center>
                                                                                <button class="btn btn-primary" type="button"  onclick="
                                                                                if (document.getElementById('samt3').value !=='' && document.getElementById('sdur3').value !=='' && document.getElementById('sint3').value !=='') {
if (document.getElementById('accpin2').value == document.getElementById('dpin').value) {
save('master',document.getElementById('samt3').value,document.getElementById('sdur3').value,document.getElementById('sint3').value,this,document.getElementById('swhen3').value);
                                                     
}
else{
    Swal.fire({title:'Error',text:'Wrong Pin',icon:'error',showCancelButton:!0,confirmButtonColor:'#5664d2',cancelButtonColor:'#ff3d60'});
   
}
                           }
                                                                                " style="width: 80%">Start Savings Plan</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Savings</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Savings</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-sm-4">
                                <div class="card p-4">
                                    <p class="mb-3"><b>STARTER PLAN</b></p>
                                    <p><?php echo $fee1 ?>% Interest Monthly</p>
                                    <p>Minimum : N 1,000</p>
                                    <p>Maximum : N 90,000</p>
                                    <center><button class="btn btn-success" style="width: 80%" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center11">Proceed</button></center>
                                </div>
                            </div>
                             <div class="col-sm-4">
                                <div class="card p-4">
                                    <p class="mb-3"><b>BUSINESS PLAN</b></p>
                                    <p><?php echo $fee2 ?>% Interest Monthly</p>
                                    <p>Minimum : N 100,000</p>
                                    <p>Maximum : N 900,000</p>
                                    <center><button class="btn btn-success" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center12" style="width: 80%">Proceed</button></center>
                                </div>
                            </div>
                             <div class="col-sm-4">
                                <div class="card p-4">
                                    <p class="mb-3"><b>MASTER PLAN</b></p>
                                    <p><?php echo $fee3 ?>% Interest Monthly</p>
                                    <p>Minimum : N 1,000,000</p>
                                    <p>Maximum : N 50,000,000</p>
                                    <center><button class="btn btn-success"  data-bs-toggle="modal" data-bs-target=".bs-example-modal-center13" style="width: 80%">Proceed</button></center>
                                </div>
                            </div>
                        </div>
                             <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">id</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">date</th>
                                                        <th scope="col">amount</th>
                                                        <th scope="col">Plan</th>
                                                        <th scope="col">Interest Paid</th>
                                                        <th scope="col">Mature date</th>
                                                     
                                                      
                                                       
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                       <td><?php  echo $de['id'] ?></td>
                                                    
                                                        <td><?php  echo $de['status'] ?></td>
                                                          <td><?php  echo $de['date'] ?></td>
                                                          <td>N <?php  echo $de['amount'] ?></td>
                                                           <td><?php  echo $de['plan'] ?></td>
                                                           <td>N <?php  echo $de['interest'] ?></td>
                                                           <td><?php  echo $de['mature'] ?></td>
                                                        
                                                       
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
    <?php
   }
   if ($type=="save") {
      
$plan=$_POST['plan'];
$amt=$_POST['amt'];
$dur=$_POST['dur'];
$int=$_POST['int'];
$when=$_POST['when'];
$phone=$_SESSION['loggeduser'];
$date=date("Y-m-d");
$date2=date('Y-m-d', strtotime($date. ' + '.$dur.' months'));
$balance=$_SESSION['balance'];
if ($plan=="starter") {
   if ($amt >= 1000 && $amt <= 90000) {
 if ($balance >= $amt) {
   
if (mysqli_query($link,"INSERT INTO savings values('','$plan','$amt','$int','$date2','$phone','In progress','$date','$when')")) {
 mysqli_query($link,"INSERT INTO balance values('','debit','$amt','$date','$phone')");
 if ($when=="1") {
      mysqli_query($link,"INSERT INTO balance values('','credit','$int','$date','$phone')");
 }
    echo "true";
}
else{
    echo "Database error";
}
}
else{
    echo "Insufficient balance";
}
   }
     else{
    echo "Minimum : N 1000 | Maximum : N 90000 ";
   }
}
else if ($plan=="business") {
   if ($amt >= 100000 && $amt <= 900000) {
 if ($balance >= $amt) {
   
if (mysqli_query($link,"INSERT INTO savings values('','$plan','$amt','$int','$date2','$phone','In progress','$date')")) {
 mysqli_query($link,"INSERT INTO balance values('','debit','$amt','$date','$phone')");
  mysqli_query($link,"INSERT INTO balance values('','credit','$int','$date','$phone')");
    echo "true";
}
else{
    echo "Database error";
}
}
else{
    echo "Insufficient balance";
}
   }
   else{
    echo "Minimum : N 100000 | Maximum : N 900000 ";
   }
}
else if ($plan=="master") {
   if ($amt >= 1000000 && $amt <= 50000000) {
 if ($balance >= $amt) {
   
if (mysqli_query($link,"INSERT INTO savings values('','$plan','$amt','$int','$date2','$phone','In progress','$date')")) {
 mysqli_query($link,"INSERT INTO balance values('','debit','$amt','$date','$phone')");
  mysqli_query($link,"INSERT INTO balance values('','credit','$int','$date','$phone')");
    echo "true";
}
else{
    echo "Database error";
}
}
else{
    echo "Insufficient balance";
}
   }
     else{
    echo "Minimum : N 1000000 | Maximum : N 50000000 ";
   }
}
   }
   if ($type=="adminhome") {
$query10=mysqli_query($link,"SELECT * FROM users order by id desc ");
    $row10=mysqli_num_rows($query10);
    $query100=mysqli_query($link,"SELECT * FROM transactions");
    $row100=mysqli_num_rows($query100);
    $query1000=mysqli_query($link,"SELECT * FROM withdrawal");
    $row1000=mysqli_num_rows($query1000);
$query10000=mysqli_query($link,"SELECT * FROM loans order by id desc ");
    $row10000=mysqli_num_rows($query10000);
    $query1=mysqli_query($link,"SELECT * FROM transactions order by id desc limit 20");
    $query12=mysqli_query($link,"SELECT * FROM fees where name='Whatsapp'");
    $query13=mysqli_query($link,"SELECT * FROM fees where name='notifications'");
    $row1=mysqli_num_rows($query1);
 ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                        <div class="row">
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                      <span class="iconify" data-icon="fluent:building-bank-48-filled" ></span>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                           
                                                  <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><b>Users</b></p>
                                                <h6 class="mb-1"><?php  echo $row10; ?><span class="ms-1 " style="position:relative; top: -2px;"></span></h6>
                                                 
                                                                                          </div>
                                            
                                          
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                       <span class="iconify" data-icon="ic:twotone-account-balance-wallet" ></span>
                                                    </div>
                                                </div>
                                            </div>
                                             <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><b>Transactions</b></p>
                                                <h6 class="mb-1"><?php  echo $row100; ?><span class="ms-1 " style="position:relative; top: -2px;"></span></h6>
                                                 
                                                                                          </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-3 col-sm-6">
                              <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                        <i class="ri-group-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><b>Withdrawals</b></p>
                                                <h6 class="mb-1"><?php  echo $row1000; ?><span class="ms-1 " style="position:relative; top: -2px;"></span></h6>
                                                 
                                                                                          </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0  me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                       <span class="iconify" data-icon="icon-park-outline:transaction-order" ></span>
                                                    </div>
                                                </div>
                                            </div>
                                           <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1"><b>Loans</b></p>
                                                <h6 class="mb-1"><?php  echo $row10000; ?><span class="ms-1 " style="position:relative; top: -2px;"></span></h6>
                                                 
                                                                                          </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                                 <div class="col-sm-6">
                                <p><b>Whatsapp Group Link</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii2=mysqli_fetch_array($query12)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6 text-center pt-2">
                                            <p>  <?php  echo $rii2['name'] ?> Group Link </p>
                                        </div>
                                         <div class="col-6">
                                            <input type="text" name="" class="form-control" value="<?php  echo $rii2['fee'] ?>"  oninput="
updfee(this.value,'<?php echo $rii2['id']  ?>');
">
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                               <div class="col-sm-6">
                                <p><b>Notification Message</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii3=mysqli_fetch_array($query13)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6 text-center pt-2">
                                            <p>  <?php  echo $rii3['name'] ?> </p>
                                        </div>
                                         <div class="col-6">
<textarea class="form-control"  oninput="
updfee(this.value,'<?php echo $rii3['id']  ?>');
"><?php  echo $rii3['fee'] ?></textarea>
                                          
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        
                        <!-- end row -->
                
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        <th scope="col">User</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Category/Network</th>
                                                        <th scope="col">type</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Status</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query1)){
                                                            ?>
                                                             <tr>
                                                      
                                                       <td><?php  echo $de['phone'] ?></td>
                                                      
                                                        <td><?php  echo $de['rdate'] ?></td>
                                                        <td><?php  echo $de['name'] ?></td>
                                                        <td><?php  echo $de['cat'] ?></td>
                                                          <td><?php  echo $de['type'] ?></td>
                                                        
                                                        <td>
                                                           N  <?php  echo number_format($de['amount'],0)  ?>
                                                        </td>
                                                          <td>
                                                            <?php  echo $de['status'];  ?>
                                                        </td>
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
 <?php
   }
   if ($type=="adminfees") {
    $query=mysqli_query($link,"SELECT * FROM fees where rank='1'");
    $query1=mysqli_query($link,"SELECT * FROM fees where  rank='2'");
      $query12=mysqli_query($link,"SELECT * FROM fees where  name='Loan'");
           $query13=mysqli_query($link,"SELECT * FROM fees where  name='Merchant'");
              $query14=mysqli_query($link,"SELECT * FROM fees where  name='Savings'");
              
              $query290=mysqli_query($link,"SELECT * FROM fees where  name='Keys'");
     ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Fees</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <p><b>Smart Users</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($ri=mysqli_fetch_array($query)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6">
                                            <p><?php  echo $ri['name'] ?> </p>
                                        </div>
                                         <div class="col-6">
                                            <input type="text" name="" class="form-control" value="<?php  echo $ri['fee']; ?>"
oninput="
updfee(this.value,'<?php echo $ri['id']  ?>');
"
                                            >
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                             <div class="col-sm-6">
                                <p><b>Merchants Users</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii=mysqli_fetch_array($query1)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6">
                                            <p>  <?php  echo $rii['name'] ?> </p>
                                        </div>
                                         <div class="col-6">
                                            <input type="text" name="" class="form-control" value="<?php  echo $rii['fee'] ?>"  oninput="
updfee(this.value,'<?php echo $rii['id']  ?>');
">
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                                    <div class="col-sm-6">
                                <p><b>Loan Fees (%)</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii2=mysqli_fetch_array($query12)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6">
                                            <p>  <?php  echo $rii2['name'] ?> </p>
                                        </div>
                                         <div class="col-6">
                                            <input type="text" name="" class="form-control" value="<?php  echo $rii2['fee'] ?>"  oninput="
updfee(this.value,'<?php echo $rii2['id']  ?>');
">
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                                    <div class="col-sm-6">
                                <p><b>Merchant Account fee (N)</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii3=mysqli_fetch_array($query13)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6">
                                            <p>  <?php  echo $rii3['name'] ?> </p>
                                        </div>
                                         <div class="col-6">
                                            <input type="text" name="" class="form-control" value="<?php  echo $rii3['fee'] ?>"  oninput="
updfee(this.value,'<?php echo $rii3['id']  ?>');
">
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                            
                            
                             <div class="col-sm-6">
                                <p><b>Keys</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii3=mysqli_fetch_array($query290)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6">
                                            <p>  <?php  echo $rii3['rank'] ?> </p>
                                        </div>
                                         <div class="col-6">
                                            <input type="text" name="" class="form-control" value="<?php  echo $rii3['fee'] ?>"  oninput="
updfee(this.value,'<?php echo $rii3['id']  ?>');
">
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                            
                            
                                  <div class="col-sm-6">
                                <p><b>Savings Percentage (%)</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii4=mysqli_fetch_array($query14)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-6">
                                            <p>  <?php  echo $rii4['name'] ?> |   <?php  echo $rii4['rank'] ?> </p>
                                        </div>
                                         <div class="col-6">
                                            <input type="text" name="" class="form-control" value="<?php  echo $rii4['fee'] ?>"  oninput="
updfee(this.value,'<?php echo $rii4['id']  ?>');
">
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                        </div>
     <?php
   }
   if ($type=="adminupdfee") {
     $new=$_POST['new'];
     $id=$_POST['id'];
mysqli_query($link,"UPDATE fees set fee='$new' where id='$id'");
   }
   if ($type=="admindata") {
    $query=mysqli_query($link,"SELECT * FROM dataplans where rank='1'");
    $query1=mysqli_query($link,"SELECT * FROM dataplans where  rank='2'");
     ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Dashboard</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Fees</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-2">
                                <p><b>Smart Users</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($ri=mysqli_fetch_array($query)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-4">
                                            <p><?php echo $ri['network']." | ".explode("=", $ri['name'])[0]?> </p>
                                        </div>
                                         <div class="col-4">
                                            <input type="text" name="" class="form-control" value="<?php  echo $ri['amt']; ?>"
oninput="
upddata(this.value,'<?php echo $ri['id']  ?>',document.getElementById('dt<?php echo $ri['id']  ?>').value);
" id="mb<?php echo $ri['id']  ?>"
                                            >
                                        </div>
                                        <div class="col-4">
                                            <select class="form-control" id="dt<?php echo $ri['id']  ?>"  onchange="
upddata(document.getElementById('mb<?php echo $ri['id']  ?>').value,'<?php echo $ri['id']  ?>',document.getElementById('dt<?php echo $ri['id']  ?>').value);
">
                                                    <option value="<?php  echo $ri['type']  ?>"><?php  echo $ri['type']  ?></option>
                                                <option value="gifting">gifting</option>
                                                <option value="sme">sme</option>
                                            </select>
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                             <div class="col-sm-6">
                                <p><b>Merchants Users</b></p>
                                <div class="p-4 card">
                                    <?php 
                                    while($rii=mysqli_fetch_array($query1)){
                                        ?>
                                        <div class="row mb-3">
                                        <div class="col-4">
                                            <p><?php   echo $rii['network']." | ".explode("=", $rii['name'])[0] ?> </p>
                                        </div>
                                         <div class="col-4">
                                            <select class="form-control" id="dtt<?php echo $rii['id']  ?>"  onchange="
upddata(document.getElementById('mbb<?php echo $rii['id']  ?>').value,'<?php echo $rii['id']  ?>',document.getElementById('dtt<?php echo $rii['id']  ?>').value);
">
                                                    <option value="<?php  echo $rii['type']  ?>"><?php  echo $rii['type']  ?></option>
                                                <option value="gifting">gifting</option>
                                                <option value="sme">sme</option>
                                            </select>
                                        </div>
                                         <div class="col-4">
                                            <input type="text" name="" class="form-control" value="<?php  echo $rii['amt'] ?>"  oninput="
upddata(this.value,'<?php echo $rii['id']  ?>',document.getElementById('dtt<?php echo $rii['id']  ?>').value);
" id="mbb<?php echo $rii['id']  ?>">
                                        </div>
                                    </div>
                                        <?php
                                    }
                                      ?>
                                    
                                </div>
                            </div>
                        </div>
     <?php
   }
   if ($type=="adminupddata") {
     $new=$_POST['new'];
     $id=$_POST['id'];
     $dt=$_POST['dt'];
mysqli_query($link,"UPDATE dataplans set amt='$new' ,type='$dt' where id='$id'");
   }
    if ($type=="adminupddata1") {
     $new=$_POST['new'];
     $id=$_POST['id'];
     $dt=$_POST['dt'];
      $net=$_POST['net'];
      $name=$_POST['name'];
mysqli_query($link,"INSERT INTO  dataplans values('','$name','$new','$dt','2','$net')");
   }
   if ($type=="admintransactions") {
 
$query1=mysqli_query($link,"SELECT * FROM transactions  order by id desc");
$row1=mysqli_num_rows($query1);
    ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Transactions</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Transactions</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                         <th scope="col">User</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Category/Network</th>
                                                        <th scope="col">type</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Status</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query1)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                      <td><?php  echo $de['phone'] ?></td>
                                                        <td><?php  echo $de['rdate'] ?></td>
                                                        <td><?php  echo $de['name'] ?></td>
                                                        <td><?php  echo $de['cat'] ?></td>
                                                          <td><?php  echo $de['type'] ?></td>
                                                        
                                                        <td>
                                                           N  <?php  echo number_format($de['amount'],0)  ?>
                                                        </td>
                                                          <td>
                                                            <?php  echo $de['status'];  ?>
                                                        </td>
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
    <?php
   }
      if ($type=="adminloans") {
 
$query1=mysqli_query($link,"SELECT * FROM  loans  order by id desc");
$row1=mysqli_num_rows($query1);
    ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Transactions</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Loans</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                         <th scope="col">User</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Loan Due</th>
                                                      
                                                        <th scope="col">Address</th>
                                                        <th scope="col">Reason</th>
                                                        <th scope="col">Bvn</th>
                                                        <th scope="col">Amount</th>
                                                        <th scope="col">Status</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query1)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                      <td><?php  echo $de['phone'] ?></td>
                                                        <td><?php  echo $de['adate'] ?></td>
                                                        <td><?php  echo $de['repayd'] ?></td>
                                                      
                                                        <td><?php  echo $de['address'] ?></td>
                                                          <td><?php  echo $de['reason'] ?></td>
                                                            <td><?php  echo $de['bvn'] ?></td>
                                                        
                                                        <td>
                                                           N  <?php  echo number_format($de['amount'],0)  ?>
                                                        </td>
                                                          <td>
                                                            <?php  echo $de['status'];  ?>
                                                        </td>
                                                        <td><button class="btn btn-primary" onclick="cmpwith1('<?php echo $de['id'] ?>','<?php echo $de['phone'] ?>','<?php echo $de['amount'] ?>',)">Approve</button></td>
                                                         <td><button class="btn btn-primary" onclick="cmpwith10('<?php echo $de['id'] ?>','<?php echo $de['phone'] ?>','<?php echo $de['amount'] ?>',)">Decline</button></td>
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
    <?php
   }
      if ($type=="adminwithdrawals") {
 
$query1=mysqli_query($link,"SELECT * FROM  withdrawal  order by id desc");
$row1=mysqli_num_rows($query1);
    ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Transactions</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Loans</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Latest Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                         <th scope="col">ID</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col">Amount</th>
                                                      
                                                        <th scope="col">Bank</th>
                                                        <th scope="col">Number</th>
                                                       
                                                        <th scope="col">Status</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query1)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                      <td><?php  echo $de['id'] ?></td>
                                                        <td><?php  echo $de['phone'] ?></td>
                                                        <td>  N  <?php  echo number_format($de['amount'],0)  ?></td>
                                                      
                                                        <td><?php  echo $de['bank'] ?></td>
                                                          <td><?php  echo $de['number'] ?></td>
                                                        
                                                          <td>
                                                            <?php  echo $de['status'];  ?>
                                                        </td>
                                                        <td><button class="btn btn-primary" onclick="cmpwith('<?php echo $de['id'] ?>','<?php echo $de['phone'] ?>',<?php echo $de['amount'] ?>)">Complete</button></td>
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
<?php
}
if($type == "bankdeposit"){
     $phone=$_SESSION['loggeduser'];
    $query1=mysqli_query($link,"SELECT * FROM  bank_deposits where phone ='$phone'  order by id desc");
?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Wallet Summary</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Loans</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Wallet Summary</h4>
                                        <div class="table-responsive">
                                            
                                            <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                         <th scope="col">ID</th>
                                                      
                                                        <th scope="col">Amount</th>
                                                      
                                                        <th scope="col">Date</th>
                                                       
                                                        <th scope="col">Status</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query1)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                      <td><?php  echo $de['id'] ?></td>
                                                        <td>  N  <?php  echo number_format($de['amount'],0)  ?></td>
                                                      
                                                        <td><?php  echo $de['rdate'] ?></td>
                                                        
                                                          <td>
                                                             <span class="btn btn-success">Success</span>
                                                            
                                                        </td>
                                                       
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
   }
     if ($type=="adminsavings") {
 
$query=mysqli_query($link,"SELECT * FROM savings order by id desc");
$row1=mysqli_num_rows($query);
    ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Transactions</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Savings</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                             <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Transactions</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">id</th>
                                                         <th scope="col">User</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">date</th>
                                                        <th scope="col">amount</th>
                                                        <th scope="col">Plan</th>
                                                        <th scope="col">Interest Paid</th>
                                                        <th scope="col">Mature date</th>
                                                     
                                                      
                                                       
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                       <td><?php  echo $de['id'] ?></td>
                                                       <td><?php  echo $de['phone'] ?></td>
                                                    
                                                        <td><?php  echo $de['status'] ?></td>
                                                          <td><?php  echo $de['date'] ?></td>
                                                          <td>N <?php  echo $de['amount'] ?></td>
                                                           <td><?php  echo $de['plan'] ?></td>
                                                           <td>N <?php  echo $de['interest'] ?></td>
                                                           <td><?php  echo $de['mature'] ?></td>
                                                        
                                                       
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        
                        <script>
                            
                            $(document).ready( function () {
    $('#myTable').DataTable();
} );
                        </script>
    <?php
   }
     if ($type=="adminusers") {
 
$query=mysqli_query($link,"SELECT * FROM users order by id desc");
$row1=mysqli_num_rows($query);
    ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Transactions</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Users</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                             <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Users</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No transaction yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">id</th>
                                                         <th scope="col">First Name</th>
                                                        <th scope="col">Last Name</th>
                                                        <th scope="col">Phone</th>
                                                        <th scope="col">email</th>
                                                        <th scope="col">Join date</th>
                                                        <th scope="col">Rank</th>
                                                        
                                                     <th scope="col">Fund</th>
                                                        
                                                      <th scope="col">Debit</th>
                                                       
                                                      <th scope="col">Delete</th>
                                                      <th scope="col">Reset</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    if(isset($_GET["page"])){
                                                        $page = (int)$_GET["page"];
                                                    }else{
                                                        $page = 1;
                                                    }
                                            $setLimit = 10;
                                            $pageLimit = ($page * $setLimit) - $setLimit;
                                                    while($de=mysqli_fetch_array($query)){
    
            $phone=$de['phone'];
              $t1=0;
                $t2=0;
                $queryk=mysqli_query($link,"SELECT * FROM vaccounts where phone='$phone' LIMIT '$pageLimit' , '$setLimit'");
            $query2=mysqli_query($link,"SELECT SUM(amount) AS Totalc FROM balance where type='credit' and phone='$phone'");
            while($r=mysqli_fetch_array($query2)){
            $t1=$r['Totalc'];
            }
            $query3=mysqli_query($link,"SELECT SUM(amount) AS Totald FROM balance where type='debit' and phone='$phone'");
            while($r1=mysqli_fetch_array($query3)){
            $t2=$r1['Totald'];
            }
    while($r2k=mysqli_fetch_array($queryk)){
        $oi=$r2k['number'];
    }
$ball=$t1 - $t2;
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                       <td><?php  echo $de['id'] ?></td>
                                                       <td><?php  echo $de['first_name'] ?></td>
                                                    
                                                        <td><?php  echo $de['last_name'] ?></td>
                                                          <td><?php  echo $de['phone'] ?></td>
                                                          <td><?php  echo $de['email'] ?></td>
                                                           <td><?php  echo $de['jdate'] ?></td>
                                                           <td><?php  echo $de['rank'] ?></td>
                                                          
                                                        <td><input type="number"  id="funda<?php  echo $de['id'] ?>" name="" class="form-control" style="width:100px; height:30px; display:inline-block;"> <button class="btn btn-primary" onclick="fundu(document.getElementById('funda<?php  echo $de['id'] ?>').value,this,'<?php  echo $de['phone'] ?>')"> Fund</button></td>
<td>Balance N <?php echo $ball ?></td>
                                                         <td><input type="number"  id="debita<?php  echo $de['id'] ?>" name="" class="form-control" style="width:100px; height:30px; display:inline-block;"> <button class="btn btn-danger" onclick="fundu1(document.getElementById('debita<?php  echo $de['id'] ?>').value,this,'<?php  echo $de['phone'] ?>')"> Debit</button></td>
                                                         <td> <button class="btn btn-danger" onclick="delu('<?php  echo $de['id'] ?>',this,'<?php  echo $de['phone'] ?>')"> Delete User</button></td>
                                                            <td> <button class="btn btn-secondary" onclick="ret('<?php  echo $de['phone'] ?>',this)"> Reset Password</button></td>
                                                       
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
    <?php
   }
     if ($type=="adminreferral") {
 
$query=mysqli_query($link,"SELECT * FROM referrals order by id desc");
$row1=mysqli_num_rows($query);
 
$queryp=mysqli_query($link,"SELECT * FROM codes ");
    ?>
 <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Transactions</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">OK2PAY</a></li>
                                            <li class="breadcrumb-item active">Referral</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                       <div class="row">
                           <div class="col-sm-6">
                             <h4>Add Referral Code</h4>
                               <div class="card p-3">
                                    <div class="row">
                                        <div class="col-4">
                                            <input type="text" class="form-control" name="" placeholder="Name" id="cname">
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" name="" placeholder="Preamble" id="cpre">
                                        </div>
                                        <div class="col-4">
                                           <button class="btn btn-primary" onclick="addc(this,document.getElementById('cname').value,document.getElementById('cpre').value)">Add Code</button>
                                        </div>
                                    </div>
                                   
                               </div>
                           </div>
                            <div class="col-sm-6">
                             <h4>Referral Result</h4>
                               <div class="card p-3">
                                   <div class="row">
     <div class="col-3 mt-2">
                                           id
                                        </div>
                                        <div class="col-3 mt-2">
                                        name
                                        </div>
                                        <div class="col-3 mt-2">
                                            code
                                        </div>
                                        <div class="col-3 mt-2" style="font-size:.8em">
                                        Downlines
                                        </div>
    </div>
<?php   
while($e=mysqli_fetch_array($queryp)){
$dcode=$e['code'];
    $p=mysqli_query($link,"SELECT * FROM referrals where main='$dcode' and plan ='Credited' ");
    $ll=mysqli_num_rows($p);
?>
<div class="row">
                                        <div class="col-3 mt-2">
                                            <?php  echo $e['id'];?>
                                        </div>
                                        <div class="col-3 mt-2">
                                          <?php  echo $e['name'];?>
                                        </div>
                                        <div class="col-3 mt-2">
                                            <?php  echo $e['code'];?>
                                        </div>
                                        <div class="col-3 mt-2">
                                         <?php  echo $ll;?>
                                        </div>
                                    </div>
<?php
}
?>
                                    
                                   
                               </div>
                           </div>
                       </div>
                             <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Referrals</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No Referral yet</p></center>
                                                
                                                <?php
                                            }
                                            else{
                                                ?>
                                                 <table class="table table-centered table-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                       
                                                        
                                                        
                                                        <th scope="col">id</th>
                                                         <th scope="col">Referrer</th>
                                                        <th scope="col">referree name</th>
                                                   
                                                        <th scope="col">Join date</th>
                                                  
                                                        
                                                     
                                                      
                                                       
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   
                                                    while($de=mysqli_fetch_array($query)){
                                                            ?>
                                                             <tr>
                                                      
                                                       
                                                       <td><?php  echo $de['id'] ?></td>
                                                       <td><?php  echo $de['main'] ?></td>
                                                    
                                                        <td><?php  echo $de['name'] ?></td>
                                                       
                                                           <td><?php  echo $de['date'] ?></td>
                                                          
                                                          
                                                        
                                                       
                                                      
                                                    </tr>
                                                            <?php
                                                    }
                                                    ?>
                                                   
                                                 
                                                </tbody>
                                            </table>
                                                <?php
                                            }
                                            ?>
                                           
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
    <?php
   }
 if ($type=='adminprofile') {
      $email=$_SESSION['loggedadmin'];
    
         $query1=mysqli_query($link,"SELECT * FROM login where email='$email'");
        while ($res1=mysqli_fetch_array($query1)) {
      $passs=$res1['password'];
        
        }
      ?>
<input type="hidden" name="" value="<?php echo $passs ?>" id="pass5">
<div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title">Profile</h3>
                                            <div class="nk-block-des text-soft">
                                                
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <!-- .toggle-wrap -->
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                
                                     <div class="col-sm-4 ">
                                        <div class="card p-5">
                                            <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                    Old  Password
                                                 </label>
                                                 <input type="password" name="" class="form-control" oninput ="pass()" id="pass" >
                                             </div>
                                              <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                     New Password
                                                 </label>
                                                 <input type="password" name="" class="form-control"  oninput ="pass()" id="pass1" >
                                             </div>
                                              <div class="form-group mb-4">
                                                 <label class="mb-2">
                                                    Retype Password
                                                 </label>
                                                 <input type="password" name="" class="form-control"  oninput ="pass()" id="pass2"  >
                                             </div>
                                             <button class="btn btn-primary mt-3" type="button" id="widthh" style="width:200px" disabled="" onclick="pass1(); this.innerHTML='Password Changed'">Change Password</button>
                                        </div>
                                          
                                     </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
      <?php
  }
   if ($type=='updddd') {
        $email=$_SESSION['loggedadmin'];
     $fname=$_POST['fname'];
   
    mysqli_query($link,"UPDATE login set password ='$fname' where email='$email'");
  }
  if ($type=='admincmpwith') {
   $id=$_POST['id'];
   $email=$_POST['email'];
   $amt=$_POST['amt'];
   $date=date("Y-m-d");
   mysqli_query($link,"UPDATE withdrawal set status ='completed' where id ='$id'");
      mysqli_query($link,"INSERT INTO balance values('','debit','$amt','$date','$email')");
   echo 'done';
   
}
 if ($type=='admincmpwith1') {
   $id=$_POST['id'];
   $email=$_POST['email'];
    $amt=$_POST['amt'];
   mysqli_query($link,"UPDATE loans set status ='approved' where id ='$id'");
   echo 'done';
   $date=date("Y-m-d");
    mysqli_query($link,"INSERT INTO balance values('','credit','$amt','$date','$email')");
}
if ($type=='admincmpwith10') {
   $id=$_POST['id'];
   $email=$_POST['email'];
    $amt=$_POST['amt'];
   mysqli_query($link,"UPDATE loans set status ='declined' where id ='$id'");
   echo 'done';
   $date=date("Y-m-d");
}
if ($type=="cablec") {
  $value=$_POST["val"];
  $cab=$_POST["cab"];
$user="directorvictor@icloud.com";
$password="mummy2012";
$POST = array('billersCode' => $value, 
    'serviceID' => strtolower($cab),
          
        );
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://vtpass.com/api/merchant-verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS =>  http_build_query($POST),
  CURLOPT_HTTPHEADER => array(
   'content-type: application/x-www-form-urlencoded'
   
  ),
  
));
 curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $user. ":" .$password); 
$response = curl_exec($curl);
curl_close($curl);
$ve=json_decode($response,true);
if ($ve["content"]["error"]) {
 echo "error";
}
else if($ve["content"]["Customer_Name"]){
echo  $ve["content"]["Customer_Name"];
}
else{
echo $response."error";
}
}
if ($type=="elec") {
    $pho=$_SESSION['loggeduser'];
  $value=$_POST["val"];
  $cab=$_POST["cab"];
    $cabb=$_POST["tt"];
$user="directorvictor@icloud.com";
$password="mummy2012";
$POST = array('billersCode' => $value, 
    'serviceID' => strtolower($cab),
    'type' => strtolower($cabb),
          
        );
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://vtpass.com/api/merchant-verify",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
CURLOPT_POSTFIELDS =>  http_build_query($POST),
  CURLOPT_HTTPHEADER => array(
   'content-type: application/x-www-form-urlencoded'
   
  ),
  
));
 curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($curl, CURLOPT_USERPWD, $user. ":" .$password); 
$response = curl_exec($curl);
curl_close($curl);
$ve=json_decode($response,true);
if ($ve["content"]["error"]) {
 echo "error";
}
else if($ve["content"]["Customer_Name"]){
echo  $ve["content"]["Customer_Name"];
}
else{
echo $response;
}
}
if ($type=="ptpay") {
  $ph=$_SESSION['loggeduser'];
  $amt=$_POST['amt'];
  $date=date("Y-m-d");
mysqli_query($link,"INSERT INTO balance values('','credit','$amt','$date','$ph')");
}
if ($type=="fundu") {
 $amt=$_POST['amt'];
  $id=$_POST['id'];
$date=date("Y-m-d");
 
mysqli_query($link,"INSERT INTO balance values('','credit','$amt','$date','$id')");
}
if ($type=="fundu1") {
 $amt=$_POST['amt'];
  $id=$_POST['id'];
$date=date("Y-m-d");
 
mysqli_query($link,"INSERT INTO balance values('','debit','$amt','$date','$id')");
}
if ($type=="delu") {
 $amt=$_POST['amt'];
  $id=$_POST['id'];
$date=date("Y-m-d");
 
mysqli_query($link,"DELETE FROM login where email='$id'");
mysqli_query($link,"DELETE FROM balance where phone='$id'");
mysqli_query($link,"DELETE FROM users where phone='$id'");
mysqli_query($link,"DELETE FROM vaccounts where phone='$id'");
mysqli_query($link,"DELETE FROM savings where phone='$id'");
mysqli_query($link,"DELETE FROM loans where phone='$id'"); 
mysqli_query($link,"DELETE FROM transactions where phone='$id'");
mysqli_query($link,"DELETE FROM withdrawal where phone='$id'");
}
if ($type=="forgot") {
 $phone=$_POST['num'];
 $query=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
 while($toto=mysqli_fetch_array($query)){
$ee=$toto['email'];
 }
$row=mysqli_num_rows($query);
if ($row==1) {
$rs="wvuio".rand(88,39839383)."jhdgh".rand(88,383);
if (mysqli_query($link,"UPDATE login set password ='$rs' where email='$phone'")) {
echo "Password has been reset and sent to phone number and Email, kindly use the password you got as a temporary login , change this after you login";
}
else{
    echo "DataBase Error";
}
 $curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=Vd4FpMaa3owrF4SpJj9M5inylokapsKqVJhg2nwG8S6Wiu6Iy2lBSGvm7XEF&from=OKPAY&to=".$phone."&body=ok2pay%0D%0AYour%20password%20:".$rs."&dnd=1",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
 
    
   
));
$response = curl_exec($curl);
curl_close($curl);
$mail = new PHPMailer();    
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = "ok2pay.ng";
    $mail->IsHTML(true);
    //Username to use for SMTP authentication
  $mail->Username = 'reset@ok2pay.ng';                 // SMTP username
$mail->Password = 'ok2payngg';                           // SMTP password
$mail->Port = 465;  
    //Set who the message is to be sent from
    $mail->setFrom('reset@ok2pay.ng','OK2PAY');
    //Set an alternative reply-to address
    $mail->addReplyTo('reset@ok2pay.ng', 'OK2PAY Support');
    //Set who the message is to be sent to
    $mail->addAddress($ee);
    //Set the subject line
    $mail->Subject = 'Ok2PAY Password Reset';
  $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
    //Read an HTML message body from an external file, convert referenced images to embedded,
     //Read an HTML message body from an external file, convert referenced images to embedded,
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML("New Password :".$rs);
    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';
    //send the message, check for errors
   $mail->Send();
}
else{
    echo "Phone number not found";
}
}
if ($type=="usec") {
    $phone=$_SESSION['loggeduser'];
$pin=$_POST['pin'];
if (mysqli_query($link,"UPDATE users set pin ='$pin' where phone='$phone'")) {
  echo "true";
}
else{
    echo "database Error";
}
}
if ($type=="vacc") {
    $phone=$_SESSION['loggeduser'];
    $date=date("Y-m-d");
    $query1=mysqli_query($link,"SELECT email FROM users where phone='$phone'");
        while ($res1=mysqli_fetch_array($query1)) {
            $name=$res1['email'];
             $query10=mysqli_query($link,"SELECT * FROM referrals where name='$name'");
        $li=mysqli_num_rows($query10);
        while($km=mysqli_fetch_array($query10)){
            $main=$km['main'];
        }
        }
        if ($li == 1) {
          mysqli_query($link,"INSERT INTO balance values('','credit','0.5','$date','$main')");
          mysqli_query($link,"UPDATE referrals set plan='Credited' where name='$name'");
        }
if (mysqli_query($link,"UPDATE users set emailv ='1' where phone='$phone'")) {
  echo "true";
}
else{
    echo "database Error";
}
}
if ($type=="ve") {
    $email=$_SESSION['loggeduser'];
    
         $query1=mysqli_query($link,"SELECT * FROM users where phone='$email'");
        while ($res1=mysqli_fetch_array($query1)) {
      $ver=$res1['emailv'];
      $em=$res1['email'];
      $id=$res1['id'];
      $fn=$res1['first_name'];
      if ($ver=="0") {
$rand=rand(1000,9999);
$mail = new PHPMailer();    
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = "ok2pay.ng";
    $mail->IsHTML(true);
    //Username to use for SMTP authentication
  $mail->Username = 'reset@ok2pay.ng';                 // SMTP username
$mail->Password = 'ok2payngg';                           // SMTP password
$mail->Port = 465;  
    //Set who the message is to be sent from
    $mail->setFrom('reset@ok2pay.ng','OK2PAY');
    //Set an alternative reply-to address
    $mail->addReplyTo('reset@ok2pay.ng', 'OK2PAY Support');
    //Set who the message is to be sent to
    $mail->addAddress($em);
    //Set the subject line
    $mail->Subject = 'Ok2PAY Registration';
  $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
    //Read an HTML message body from an external file, convert referenced images to embedded,
     //Read an HTML message body from an external file, convert referenced images to embedded,
    $searchArr = ["%ada%", "%ada1%","%mad%"];
$replaceArr = [$rand, $fn,$id];
$body = file_get_contents('email.php');
$body = str_replace($searchArr, $replaceArr, $body);
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($body);
    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';
    //send the message, check for errors
   $mail->Send();
        echo $rand;
      }
        
        }
}
if ($type=="dre") {
    $amt=$_POST['amt'];
    $phone=$_SESSION['loggeduser'];
    $date=date("Y-m-d");
 $query1=mysqli_query($link,"SELECT * FROM users where phone='$phone'");
        while ($res1=mysqli_fetch_array($query1)) {
      $fn=$res1['first_name'];
      $ln=$res1['last_name'];
        $name=$fn." | ".$ln;
}
    if ( mysqli_query($link,"INSERT INTO transactions values('','Manual Deposit','$name','$amt','','pending','$phone','$date')")) {
     echo "true";
    }
   else{
    echo "datbase error";
   }
}
if ($type=="updpin") {
    $pin=$_POST['fname'];
    $phone=$_SESSION['loggeduser'];
    if (mysqli_query($link,"UPDATE users set pin ='$pin' where phone='$phone'")) {
       echo "true";
    }
    else{
        echo "DATABASE ERROR";
    }
}
if ($type=="group") {
 $query1=mysqli_query($link,"SELECT * FROM fees where name='Whatsapp'");
        while ($res1=mysqli_fetch_array($query1)) {
      $link=$res1['fee'];
       echo $link; 
}
}
if ($type=="not") {
 $query1=mysqli_query($link,"SELECT * FROM fees where name='notifications'  ");
        while ($res1=mysqli_fetch_array($query1)) {
      $message=$res1['fee'];
      if ($message !=="") {
         echo $message;
      }
}
}
if ($type=="addc") {
  $cname=$_POST['cname'];
  $cpre=$_POST['cpre'];
$rand=rand(1000,9999);
$code=strtoupper($cpre).$rand;
mysqli_query($link,"INSERT INTO codes values('','$code','$cname')");
}
}
?>