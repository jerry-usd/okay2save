<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
 $link=mysqli_connect('localhost','root','','oks');
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
}
else{
    $ee=$_SESSION['loggeduser'];
  $query=mysqli_query($link,"SELECT * FROM users where email='$ee'");
  while($row=mysqli_fetch_array($query)){
$eee=$row['emailv'];

  }

  if($eee==0){
echo "dd";
  }
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
     
   $email=$_POST['email'];
   $name=$_POST['name'];
   
   $em=$_POST['remail'];
   
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
      
          mysqli_query($link,"INSERT INTO login values('','$em','$password','user')");
          mysqli_query($link,"INSERT INTO users values('','$name','','$email','$em',' ','','$date','1','null','0')");
          mysqli_query($link,"INSERT INTO balances values('','$em','nairab','0.00')");
          mysqli_query($link,"INSERT INTO balances values('','$em','naira','0.00')");
          mysqli_query($link,"INSERT INTO balances values('','$em','dollar','0.00')");
          mysqli_query($link,"INSERT INTO balances values('','$em','inv','0.00')");

       
          $_SESSION['loggeduser']=$em;
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
          setcookie('loggedadmin', $_SESSION['loggedadmin'], time() + (86400000 * 30), "/");
   
    }
    else{
       


 
   
        $_SESSION['loggeduser']=$email;
         setcookie('loggeduser', $_SESSION['loggeduser'], time() + (86400000 * 30), "/");


         while($ress=mysqli_fetch_array($query1)){
$vv=$ress['emailv'];

}
if ($vv==0) {
  echo "no";
}


  
    
       
    }
       
   
  
 
   
  }
else{
    echo "Invalid Email or Password";
}
}
if ($type=="home") {

$email=$_SESSION['loggeduser'];
$query=mysqli_query($link,"SELECT * FROM balances where balance='nairab' and email='$email'");
while($res=mysqli_fetch_array($query)){
	$nairab=$res['amount'];
}


$query1=mysqli_query($link,"SELECT * FROM balances where balance='naira' and email='$email'");
while($res1=mysqli_fetch_array($query1)){
	$naira=$res1['amount'];
}




$query2=mysqli_query($link,"SELECT * FROM balances where balance='dollar' and email='$email'");
while($res2=mysqli_fetch_array($query2)){
	$dollar=$res2['amount'];
}




$query3=mysqli_query($link,"SELECT * FROM balances where balance='inv' and email='$email'");
while($res3=mysqli_fetch_array($query3)){
	$inv=$res3['amount'];
}

$query4=mysqli_query($link,"SELECT * FROM loans where phone='$email' and status='approved'");
while($res4=mysqli_fetch_array($query4)){
	$ramt=$res4['repayamt'];
	$rday=$res4['repayd'];
}


$query5=mysqli_query($link,"SELECT * FROM users where email='$email' ");
while($res5=mysqli_fetch_array($query5)){
	$r=$res5['first_name'];
	
}
$query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='dollarate'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }


	?>

 <div class="row mb-5">
      <div class="col-sm-3 col-6 mb-3">
        <div class="rbox" style="background: rgba(53, 165, 227, 0.79);">
          <div class="row p-0">
            <div class="col-sm-4 ps-4"><img src="../images/n222.png" style="max-height:40px"></div>
            <div class="col-sm-8 p-0">
              <h6 class="font2 mb-4 mt-2 ps-2 km">Balance</h6>
              <p style="font-size: 1.5vw;" class=" lm">N <?php  echo  number_format($nairab,2) ; ?></p>
            </div>
          </div>
        </div>

      </div>


       <div class="col-sm-3 col-6 mb-3">
        <div class="rbox" style="background: rgba(255, 231, 232, 1);">
          <div class="row p-0">
            <div class="col-sm-4 ps-4"><img src="../images/n1.png" style="max-height:40px"></div>
            <div class="col-sm-8 p-0">
              <h6 class="font2 mb-4 mt-2 ps-2 km">Naira Savings</h6>
              <p style="font-size: 1.5vw;" class=" lm">N <?php  echo  number_format($naira,2) ; ?></p>
            </div>
          </div>
        </div>
        
      </div>




       <div class="col-sm-3 col-6 mb-3">
        <div class="rbox" style="background: rgba(232, 255, 245, 1);">
          <div class="row p-0">
            <div class="col-sm-4 ps-4"><img src="../images/d1.png" style="max-height:40px"></div>
            <div class="col-sm-8 p-0">
              <h6 class="font2 mb-4 mt-2 ps-2 km">Dollar Savings</h6>
              <p style="font-size: 1.5vw;" class=" lm">$ <?php  echo  number_format(($dollar/$fee2),2) ; ?></p>
            </div>
          </div>
        </div>
        
      </div>



       <div class="col-sm-3 col-6 mb-3">
        <div class="rbox" style="background: rgba(255, 241, 214, 1);">
          <div class="row p-0">
            <div class="col-sm-4 ps-4"><img src="../images/i1.png" style="max-height:40px"></div>
            <div class="col-sm-8 p-0">
              <h6 class="font2 mb-4 mt-2 ps-2 km">Investments</h6>
              <p style="font-size: 1.5vw;" class=" lm">N <?php  echo  number_format($inv,2) ; ?></p>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <div class="row mb-5">
      <div class="col-sm-4 mb-2">
        <div class="rbox2">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb"></div>
            </div>
             <div class="col-3 pt-4"><img src="../images/l1.png" style="max-height:40px"></div>
            <div class="col-7 p-0 pt-4">
              <h6 class="font2 mb-4 mt-2">Loan Amount Due</h6>
              <p style="font-size: 1.5vw;" class="mb-5 lm">N <?php   if (isset($ramt)) {
              echo  number_format($ramt,2) ; 
              } else{  echo "0.00";}  ?></p>
              <p class="">Due Date: <span class="font2" > <?php   if (isset($rday)) {
              echo  $rday ; 
              } else{  echo "--";}  ?></span></p>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4 mb-2">
        <div class="rbox2">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb"></div>
            </div>
             
            <div class="col-10  pt-4">
              <h6 class="font2 mb-4 mt-2">Quick Actions</h6>
               <a href="savings.html" class="signin btn mb-2" style="min-width: 80% ; text-align: left;">Add to your savings </a>
            <a href="investments.html" class="signin btn mb-2" style="min-width: 80% ; text-align: left;"> Add to your investments </a>
             <a href="loans.html" class="signin btn mb-2" style="min-width: 80% ; text-align: left;"> Get a quick loan</a>
            </div>
          </div>
        </div>
      </div>


      <div class="col-sm-4 mb-2">
        <div class="rbox2">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb"></div>
            </div>
             
            <div class="col-5  pt-4">
              <h6 class="font2 mb-2 mt-2 ">Promos</h6>
              <p style=" font-size: 1.7em;" class="mb-3">Refer & <br>Earn</p>
              <p style="font-size: 1.5vw;" class="mb-2 lm">N 2,000</p>
              
            </div>
            <div class="col-5 pt-5 mt-5">
              <img src="../images/gift.png">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-8 mb-3">
        <div class="rbox" style="background:#23CAE1; height:345px;">
          <h5 class="font2 mb-4" class="" style="color:white">Buy Cheap Data</h5>
          <div class="row ps-2">
            <div class="col-sm-4 col-6">
              <img src="../images/mtn.png" class="cx" style="max-height:250px">
            </div>
            <div class="col-sm-8 mt-2 pt-4 col-6">
              <p class="font2 mb-5" style="text-align: center;">1GB = ₦200 (valid for 30 days)

</p>
<center><button class="btn btn-lg" style="background: #2C5D96; color:white;" onclick="window.location='https://ok2pay.ng'">BUY  NOW</button></center>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="rbox" style="background:#F6F6F6; height: auto;">
          <center>
            <img src="../images/down.png"  class="mb-3" style="max-height:250px"><br>
             <img src="../images/play.svg" class="me-4" style="max-height:25px"> <img src="../images/app.svg" style="max-height:25px">
          </center>
          
        </div>
      </div>
    </div>

	<?php
}
if ($type=="savings") {





	?>

<div class="row">
		<h3 class="font2">Savings</h3>

	</div>
<div class="row mt-5">
	
	<div class="col-sm-2"></div>
	<div class="col-sm-4 p-3">
		<div class="rbox2" style="background: rgba(255, 231, 232, 1); height: 150px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 150px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> <img src="../images/n1.png" style="max-height:40px" class="me-3">Naira Savings </h6>
       <div class="row p-0">
            <div class="col-1"></div>
            <div class="col-8 ">
              <button class="button1 btn" id="nsbtn" role="button">View savings</button>
            </div>
          </div>
            </div>
          </div>
        </div>
	</div>
	<div class="col-sm-4 p-3">
		<div class="rbox2" style="background: rgba(232, 255, 245, 1); height: 150px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 150px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> <img src="../images/d1.png" style="max-height:40px" class="me-3">Dollar Savings </h6>
       <div class="row p-0">
            <div class="col-1"></div>
            <div class="col-8 p-0">
              <button class="button1 btn" id="dsbtn">View savings</button>
            </div>
          </div>
            </div>
          </div>
        </div>
	</div>
	<div class="col-sm-2"></div>
</div>

	<?php
}
if ($type=="ns1") {
  $query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Student'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
$min1=$res0['min'];
$max1=$res0['max'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
$min2=$res00['min'];
$max2=$res00['max'];
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
$min3=$res000['min'];
$max3=$res000['max'];

       }
	?>

<div class="row">
		<h3 class="font2">Naira Savings</h3>
		<p>Back to savings</p>

	</div>
<div class="row mt-5">
	<div class="col-sm-4 p-3">
		<div class="rbox2" style="background: rgba(232, 255, 245, 1); height: 250px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="height: 250px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> Student Savings </h6>

       <div class="row p-0">
            <div class="col-2"></div>
            <div class="col-8 p-0">
            	<p><?php echo $fee1 ?>% per month</p>
                 <p>Minimum : N <?php echo number_format($min1,0)  ?></p>
                                    <p>Maximum : N <?php echo number_format($max1,0)  ?></p>
              <button class="button1 btn mb-2" id="ssbtn">View savings</button>
              
            </div>
          </div>
            </div>
          </div>
        </div>
	</div>
		<div class="col-sm-4 p-3">
			<div class="rbox2" style="background: rgba(53, 165, 227, 0.79); height: 250px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="height: 250px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> Business Savings </h6>
       <div class="row p-0">
            <div class="col-2"></div>
            <div class="col-8 p-0">
            	 <p><?php echo $fee2 ?>% per month</p>
                  <p>Minimum : N <?php echo number_format($min2,0)  ?></p>
                                    <p>Maximum : N <?php echo number_format($max2,0)  ?></p>
              <button class="button1 btn" id="bsbtn">View savings</button>
            </div>
          </div>
            </div>
          </div>
        </div>
		</div>
			<div class="col-sm-4 p-3">
				<div class="rbox2" style="background: rgba(255, 241, 214, 1); height: 250px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="height: 250px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> Money Market Savings </h6>
       <div class="row p-0">
            <div class="col-2"></div>
            <div class="col-8 p-0">
            	 <p><?php echo $fee3 ?>% per month</p>
                  <p>Minimum : N <?php echo number_format($min3,0)  ?></p>
                                    <p>Maximum : N <?php echo number_format($max3,0)  ?></p>
              <button class="button1 btn" id="msbtn">View savings</button>
            </div>
          </div>
            </div>
          </div>
        </div>
				
			</div>
</div>

	<?php
}



if ($type=="ss") {
	$email=$_SESSION['loggeduser'];
$query=mysqli_query($link,"SELECT * FROM savings where phone='$email' and status='in progress' and plan='student'");
$row=mysqli_num_rows($query);
?>

<div class="row">
		<h3 class="font2">Student Naira Savings</h3>
		<p>Back to Naira savings</p>

	</div>
<?php   
if ($row < 1) {
	   $email=$_SESSION['loggeduser'];
$queryl=mysqli_query($link,"SELECT * FROM savings where phone ='$email' order by id desc");
$row1=mysqli_num_rows($queryl);
   $query1=mysqli_query($link,"SELECT * FROM login where email='$email'");
    
        while ($res1=mysqli_fetch_array($query1)) {
    
      $pin=$res1['password'];
        
        }
$query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Student'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
	?>

<div class="row">
	<div class="col-sm-4"></div>
	<div class="col-sm-4 p-3">
		<div class="rbox2" style="background: rgba(232, 255, 245, 1); height: 200px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 200px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> Student Savings </h6>
       <div class="row p-0">
            <div class="col-2"></div>
            <div class="col-8 p-0">
            	<p>no active savings</p>
              <button class="button1 btn mb-2" id="ssbtn"  data-bs-toggle="modal" data-bs-target="#exampleModal">Start new savings</button>
              
            </div>
          </div>
            </div>
          </div>
        </div>
	</div>
	<div class="col-sm-4"></div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade bs-example-modal-center11 " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">STUDENT NAIRA  SAVINGS PLAN</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Funds are strictly locked till maturity date <a href="">read more</a> <br><br>
                                                                                 <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Interest funds can be available instantly, Monthly or at maturity date
                                                                            </div>
                                                                            <center>
                                                                              
                                                                            </center>
                                                                            <div class="row">
                                                                            	<div class="col-sm-6">
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
                                                                            	</div>
                                                                            	<div class="col-sm-6">
                                                                            		  <div class="form-group mb-1">
                                                                            <label class="mb-2">Amount to save (N)</label>
                                                                          <input type="number" name="" class="form-control" placeholder="0.00" id="samt" oninput="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('sdur').value * this.value * <?php echo ($fee1/100) ?>);
                                                                          ">
                                                                            </div>
                                                                            
                                                                            	</div>
                                                                            </div>
                                                                          
                                                                           
                                                                           
                                                                            <div class="row">
                                                                            	<div class="col-sm-6">
                                                                            		 <div class="form-group mb-3">
                                                                            <label class="mb-2">When To Get Interest</label>
                                                                          <select class="form-control" id="swhen">
                                                                              <option value="1">Now</option>
                                                                               <option value="3">Monthly</option>
                                                                              <option value="2">Maturity Date</option>
                                                                          </select>
                                                                            </div>
                                                                            	</div>
                                                                            	<div class="col-sm-6">
                                                                            		
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Total Interest N (at <?php echo $fee1 ?>% monthly)</label>
                                                                          <input type="text" name="" id="sint" class="form-control" readonly="">
                                                                            </div>
                                                                            
                                                                            	</div>
                                                                            	<div class="col-sm-6">
                                                                            		 <div class="form-group mb-3">
                                                                            <label class="mb-2">Account Password</label>
                                                                         <input type="password" name="" id="accpin" class="form-control">
                                                                            </div>
                                                                            	</div>
                                                                            </div>
                                                                           
                                                                             
                                                                           
                                                                            <center>
                                                                                <button class="btn button1" type="button"  onclick="
                                                                                if (document.getElementById('samt').value !=='' && document.getElementById('sdur').value !=='' && document.getElementById('sint').value !=='') {
if (document.getElementById('accpin').value =='<?php  echo $pin ?>' ) {
save('student',document.getElementById('samt').value,document.getElementById('sdur').value,document.getElementById('sint').value,this,document.getElementById('swhen').value);
}
else{

	document.getElementById('failtext').innerHTML='Wrong password';
failm.show();

    
   
}
                                                                                }
                                                                                ">Start Savings Plan</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

	<?php
}
if ($row > 0) {
  $query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Student'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
	while($m=mysqli_fetch_array($query)){
$sb=$m['amount'];
$ti=$m['interest'];
$md=$m['mature'];
$oo=strtotime($md) - strtotime(date("Y-m-d"));
$years = floor($oo / (60*60*24));

$ghw=mysqli_query($link,"SELECT * from transactions where phone='$email' and type='sdeposit' and name='student' order by id desc");

		?>
<div class="modal fade bs-example-modal-center11 " id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Add to Savings</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="asamt" oninput="
                                                                          document.getElementById('tii').innerHTML=Math.round(<?php echo $years  ?>* this.value * <?php echo ($fee1/( 100 * 31)) ?>);
                                                                          " >
                                                                          <small >Total Interest : N <span id="tii"></span> </small><br>
                                                                              <small style="color:crimson;">Minimum : N 1,000</small>
                                                                             </div>
                                                                             <center>   <button class="button1"  id="fsbtn" onclick="  if (document.getElementById('asamt').value > 999) { a2s('student',document.getElementById('asamt').value,<?php  echo $m['id']; ?>,document.getElementById('tii').innerHTML);} ">Add to savings</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="row mb-4">
	<div class="col-sm-7">
		<div class="p-5" style="border-radius: 10px; background: rgba(232, 255, 245, 1); ">
			<h6 class="font2">Balance 	<p style="float:right; font-weight:normal; font-size: .9em"><?php echo $fee1 ?>% / mo</p></h6>
			<p class="font1 mb-3">N <?php echo number_format($sb,0)  ?></p>
			<h6 class="font2">Total Deposit</h6>
			<p class="font1 mb-3">N <?php echo number_format($sb,0)  ?></p>
			<h6 class="font2">Total interest earned </h6>
			<p class="font1 mb-3">N <?php echo   number_format($ti,0)   ?></p>
			<h6 class="font2">Maturity date </h6>
			<p class="font1 mb-3"><?php echo $md  ?></p>
			<button class="btn button1 me-2 mt-3 ms-2" disabled="<?php  if($m['intw']=='1'){ echo "true";} else{ echo "false";} ?>">Claim Interest</button> <button class="btn button1 me-2 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal5">Add to savings</button>
		</div>
	
			
	
		
	</div>
</div>
<h5 class="font2">Deposit history</h5>
<div class="row">
	<div class="col-sm-8">
    <div class="table-responsive">
		<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">amount</th>
      <th scope="col">Status</th>
     
    </tr>
  </thead>
  <tbody>
    <?php  
while($nnn=mysqli_fetch_array($ghw))
{


?>

<tr>
      
      <td><?php echo $nnn['rdate']; ?></td>
      <td>N <?php echo number_format($nnn['amount'],0) ; ?></td>
      <td style="color:limegreen;"><?php echo $nnn['status']; ?></td>
    </tr>

<?php
}
    ?>
    
    
  </tbody>
</table>
</div>
	</div>
</div>
<?php
	}
	
}



}













if ($type=="bs") {
  $email=$_SESSION['loggeduser'];
$query=mysqli_query($link,"SELECT * FROM savings where phone='$email' and status='in progress' and plan='business'");
$row=mysqli_num_rows($query);
?>

<div class="row">
    <h3 class="font2">Business Naira Savings</h3>
    <p>Back to Naira savings</p>

  </div>
<?php   
if ($row < 1) {
     $email=$_SESSION['loggeduser'];
$queryl=mysqli_query($link,"SELECT * FROM savings where phone ='$email' order by id desc");
$row1=mysqli_num_rows($queryl);
   $query1=mysqli_query($link,"SELECT * FROM login where email='$email'");
    
        while ($res1=mysqli_fetch_array($query1)) {
    
      $pin=$res1['password'];
        
        }
$query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Student'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
  ?>

<div class="row">
  <div class="col-sm-4"></div>
  <div class="col-sm-4 p-3">
    <div class="rbox2" style="background: rgba(232, 255, 245, 1); height: 200px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 200px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> Business Savings </h6>
       <div class="row p-0">
            <div class="col-2"></div>
            <div class="col-8 p-0">
              <p>no active savings</p>
              <button class="button1 btn mb-2" id="ssbtn"  data-bs-toggle="modal" data-bs-target="#exampleModal">Start new savings</button>
              
            </div>
          </div>
            </div>
          </div>
        </div>
  </div>
  <div class="col-sm-4"></div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade bs-example-modal-center11 " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">BUSINESS NAIRA  SAVINGS PLAN</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Funds are strictly locked till maturity date <a href="">read more</a> <br><br>
                                                                                 <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Interest funds can be available instantly, Monthly or at maturity date
                                                                            </div>
                                                                            <center>
                                                                              
                                                                            </center>
                                                                            <div class="row">
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">Duration (Months)</label>
                                                                          <select class="form-control" id="sdur" onchange="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('samt').value * this.value * <?php echo ($fee2/100) ?>);
                                                                          ">
                                                                              <option value="1"> 1 Month</option>
                                                                              <option value="2"> 2 Months</option>
                                                                              <option value="3"> 3 Months</option>
                                                                              <option value="4"> 4 Months</option>
                                                                              <option value="5"> 5 Months</option>
                                                                              <option value="6"> 6 Months</option>
                                                                          </select>
                                                                            </div>
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                  <div class="form-group mb-1">
                                                                            <label class="mb-2">Amount to save (N)</label>
                                                                          <input type="number" name="" class="form-control" placeholder="0.00" id="samt" oninput="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('sdur').value * this.value * <?php echo ($fee2/100) ?>);
                                                                          ">
                                                                            </div>
                                                                            
                                                                              </div>
                                                                            </div>
                                                                          
                                                                           
                                                                           
                                                                            <div class="row">
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">When To Get Interest</label>
                                                                          <select class="form-control" id="swhen">
                                                                              <option value="1">Now</option>
                                                                               <option value="3">Monthly</option>
                                                                              <option value="2">Maturity Date</option>
                                                                          </select>
                                                                            </div>
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Total Interest N (at <?php echo $fee2 ?>% monthly)</label>
                                                                          <input type="text" name="" id="sint" class="form-control" readonly="">
                                                                            </div>
                                                                            
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">Account Password</label>
                                                                         <input type="password" name="" id="accpin" class="form-control">
                                                                            </div>
                                                                              </div>
                                                                            </div>
                                                                           
                                                                             
                                                                           
                                                                            <center>
                                                                                <button class="btn button1" type="button"  onclick="
                                                                                if (document.getElementById('samt').value !=='' && document.getElementById('sdur').value !=='' && document.getElementById('sint').value !=='') {
if (document.getElementById('accpin').value =='<?php  echo $pin ?>' ) {
save('business',document.getElementById('samt').value,document.getElementById('sdur').value,document.getElementById('sint').value,this,document.getElementById('swhen').value);
}
else{

  document.getElementById('failtext').innerHTML='Wrong password';
failm.show();

    
   
}
                                                                                }
                                                                                ">Start Savings Plan</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

  <?php
}
if ($row > 0) {
  $query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Student'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
  while($m=mysqli_fetch_array($query)){
$sb=$m['amount'];
$ti=$m['interest'];
$md=$m['mature'];
$oo=strtotime($md) - strtotime(date("Y-m-d"));
$years = floor($oo / (60*60*24));

$ghw=mysqli_query($link,"SELECT * from transactions where phone='$email' and type='sdeposit' and name='business' order by id desc");

    ?>
<div class="modal fade bs-example-modal-center11 " id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Add to Savings</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="asamt" oninput="
                                                                          document.getElementById('tii').innerHTML=Math.round(<?php echo $years  ?>* this.value * <?php echo ($fee2/( 100 * 31)) ?>);
                                                                          " >
                                                                          <small >Total Interest : N <span id="tii"></span> </small><br>
                                                                              <small style="color:crimson;">Minimum : N 1,000</small>
                                                                             </div>
                                                                             <center>   <button class="button1"  id="fsbtn" onclick="  if (document.getElementById('asamt').value > 999) { a2s('business',document.getElementById('asamt').value,<?php  echo $m['id']; ?>,document.getElementById('tii').innerHTML);} ">Add to savings</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="row mb-4">
  <div class="col-sm-7">
    <div class="p-5" style="border-radius: 10px; background: rgba(232, 255, 245, 1); ">
      <h6 class="font2">Balance   <p style="float:right; font-weight:normal; font-size: .9em"><?php echo $fee2 ?>% / mo</p></h6>
      <p class="font1 mb-3">N <?php echo number_format($sb,0)  ?></p>
      <h6 class="font2">Total Deposit</h6>
      <p class="font1 mb-3">N <?php echo number_format($sb,0)  ?></p>
      <h6 class="font2">Total interest earned </h6>
      <p class="font1 mb-3">N <?php echo   number_format($ti,0)   ?></p>
      <h6 class="font2">Maturity date </h6>
      <p class="font1 mb-3"><?php echo $md  ?></p>
      <button class="btn button1 me-2 mt-3 ms-2" disabled="<?php  if($m['intw']=='1'){ echo "true";} else{ echo "false";} ?>">Claim Interest</button> <button class="btn button1 me-2 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal5">Add to savings</button>
    </div>
  
      
  
    
  </div>
</div>
<h5 class="font2">Deposit history</h5>
<div class="row">
  <div class="col-sm-8">
    <div class="table-responsive">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">amount</th>
      <th scope="col">Status</th>
     
    </tr>
  </thead>
  <tbody>
    <?php  
while($nnn=mysqli_fetch_array($ghw))
{


?>

<tr>
      
      <td><?php echo $nnn['rdate']; ?></td>
      <td>N <?php echo number_format($nnn['amount'],0) ; ?></td>
      <td style="color:limegreen;"><?php echo $nnn['status']; ?></td>
    </tr>

<?php
}
    ?>
    
    
  </tbody>
</table>
</div>
  </div>
</div>
<?php
  }
  
}



}

















if ($type=="ms") {
  $email=$_SESSION['loggeduser'];
$query=mysqli_query($link,"SELECT * FROM savings where phone='$email' and status='in progress' and plan='money'");
$row=mysqli_num_rows($query);
?>

<div class="row">
    <h3 class="font2">Money Market Savings</h3>
    <p>Back to Naira savings</p>

  </div>
<?php   
if ($row < 1) {
     $email=$_SESSION['loggeduser'];
$queryl=mysqli_query($link,"SELECT * FROM savings where phone ='$email' order by id desc");
$row1=mysqli_num_rows($queryl);
   $query1=mysqli_query($link,"SELECT * FROM login where email='$email'");
    
        while ($res1=mysqli_fetch_array($query1)) {
    
      $pin=$res1['password'];
        
        }
$query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Student'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
  ?>

<div class="row">
  <div class="col-sm-4"></div>
  <div class="col-sm-4 p-3">
    <div class="rbox2" style="background: rgba(232, 255, 245, 1); height: 200px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 200px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> Money market Savings </h6>
       <div class="row p-0">
            <div class="col-2"></div>
            <div class="col-8 p-0">
              <p>no active savings</p>
              <button class="button1 btn mb-2" id="ssbtn"  data-bs-toggle="modal" data-bs-target="#exampleModal">Start new savings</button>
              
            </div>
          </div>
            </div>
          </div>
        </div>
  </div>
  <div class="col-sm-4"></div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade bs-example-modal-center11 " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Money Market  SAVINGS PLAN</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Funds are strictly locked till maturity date <a href="">read more</a> <br><br>
                                                                                 <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Interest funds can be available instantly, Monthly or at maturity date
                                                                            </div>
                                                                            <center>
                                                                              
                                                                            </center>
                                                                            <div class="row">
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">Duration (Months)</label>
                                                                          <select class="form-control" id="sdur" onchange="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('samt').value * this.value * <?php echo ($fee3/100) ?>);
                                                                          ">
                                                                              <option value="1"> 1 Month</option>
                                                                              <option value="2"> 2 Months</option>
                                                                              <option value="3"> 3 Months</option>
                                                                              <option value="4"> 4 Months</option>
                                                                              <option value="5"> 5 Months</option>
                                                                              <option value="6"> 6 Months</option>
                                                                          </select>
                                                                            </div>
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                  <div class="form-group mb-1">
                                                                            <label class="mb-2">Amount to save (N)</label>
                                                                          <input type="number" name="" class="form-control" placeholder="0.00" id="samt" oninput="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('sdur').value * this.value * <?php echo ($fee3/100) ?>);
                                                                          ">
                                                                            </div>
                                                                            
                                                                              </div>
                                                                            </div>
                                                                          
                                                                           
                                                                           
                                                                            <div class="row">
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">When To Get Interest</label>
                                                                          <select class="form-control" id="swhen">
                                                                              <option value="1">Now</option>
                                                                               <option value="3">Monthly</option>
                                                                              <option value="2">Maturity Date</option>
                                                                          </select>
                                                                            </div>
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Total Interest N (at <?php echo $fee3 ?>% monthly)</label>
                                                                          <input type="text" name="" id="sint" class="form-control" readonly="">
                                                                            </div>
                                                                            
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">Account Password</label>
                                                                         <input type="password" name="" id="accpin" class="form-control">
                                                                            </div>
                                                                              </div>
                                                                            </div>
                                                                           
                                                                             
                                                                           
                                                                            <center>
                                                                                <button class="btn button1" type="button"  onclick="
                                                                                if (document.getElementById('samt').value !=='' && document.getElementById('sdur').value !=='' && document.getElementById('sint').value !=='') {
if (document.getElementById('accpin').value =='<?php  echo $pin ?>' ) {
save('money',document.getElementById('samt').value,document.getElementById('sdur').value,document.getElementById('sint').value,this,document.getElementById('swhen').value);
}
else{

  document.getElementById('failtext').innerHTML='Wrong password';
failm.show();

    
   
}
                                                                                }
                                                                                ">Start Savings Plan</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

  <?php
}
if ($row > 0) {
  $query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Student'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Business'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
  while($m=mysqli_fetch_array($query)){
$sb=$m['amount'];
$ti=$m['interest'];
$md=$m['mature'];
$oo=strtotime($md) - strtotime(date("Y-m-d"));
$years = floor($oo / (60*60*24));

$ghw=mysqli_query($link,"SELECT * from transactions where phone='$email' and type='sdeposit' and name='money' order by id desc");

    ?>
<div class="modal fade bs-example-modal-center11 " id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Add to Savings</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="asamt" oninput="
                                                                          document.getElementById('tii').innerHTML=Math.round(<?php echo $years  ?>* this.value * <?php echo ($fee3/( 100 * 31)) ?>);
                                                                          " >
                                                                          <small >Total Interest : N <span id="tii"></span> </small><br>
                                                                              <small style="color:crimson;">Minimum : N 1,000</small>
                                                                             </div>
                                                                             <center>   <button class="button1"  id="fsbtn" onclick="  if (document.getElementById('asamt').value > 999) { a2s('money',document.getElementById('asamt').value,<?php  echo $m['id']; ?>,document.getElementById('tii').innerHTML);} ">Add to savings</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="row mb-4">
  <div class="col-sm-7">
    <div class="p-5" style="border-radius: 10px; background: rgba(232, 255, 245, 1); ">
      <h6 class="font2">Balance   <p style="float:right; font-weight:normal; font-size: .9em"><?php echo $fee3 ?>% / mo</p></h6>
      <p class="font1 mb-3">N <?php echo number_format($sb,0)  ?></p>
      <h6 class="font2">Total Deposit</h6>
      <p class="font1 mb-3">N <?php echo number_format($sb,0)  ?></p>
      <h6 class="font2">Total interest earned </h6>
      <p class="font1 mb-3">N <?php echo   number_format($ti,0)   ?></p>
      <h6 class="font2">Maturity date </h6>
      <p class="font1 mb-3"><?php echo $md  ?></p>
      <button class="btn button1 me-2 mt-3 ms-2" disabled="<?php  if($m['intw']=='1'){ echo "true";} else{ echo "false";} ?>">Claim Interest</button> <button class="btn button1 me-2 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal5">Add to savings</button>
    </div>
  
      
  
    
  </div>
</div>
<h5 class="font2">Deposit history</h5>
<div class="row">
  <div class="col-sm-8">
    <div class="table-responsive">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">amount</th>
      <th scope="col">Status</th>
     
    </tr>
  </thead>
  <tbody>
    <?php  
while($nnn=mysqli_fetch_array($ghw))
{


?>

<tr>
      
      <td><?php echo $nnn['rdate']; ?></td>
      <td>N <?php echo number_format($nnn['amount'],0) ; ?></td>
      <td style="color:limegreen;"><?php echo $nnn['status']; ?></td>
    </tr>

<?php
}
    ?>
    
    
  </tbody>
</table>
</div>
  </div>
</div>
<?php
  }
  
}



}









if ($type=="ds") {
  $email=$_SESSION['loggeduser'];
$query=mysqli_query($link,"SELECT * FROM savings where phone='$email' and status='in progress' and plan='dollar'");
$row=mysqli_num_rows($query);
?>

<div class="row">
    <h3 class="font2">Dollar Savings</h3>
    <p>Back  savings</p>

  </div>
<?php   
if ($row < 1) {
     $email=$_SESSION['loggeduser'];
$queryl=mysqli_query($link,"SELECT * FROM savings where phone ='$email' order by id desc");
$row1=mysqli_num_rows($queryl);
   $query1=mysqli_query($link,"SELECT * FROM login where email='$email'");
    
        while ($res1=mysqli_fetch_array($query1)) {
    
      $pin=$res1['password'];
        
        }
$query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='dollar'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='dollarate'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
  ?>

<div class="row">
  <div class="col-sm-4"></div>
  <div class="col-sm-4 p-3">
    <div class="rbox2" style="background: rgba(232, 255, 245, 1); height: 200px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 200px;"></div>
            </div>
             
            <div class="col-11  pt-4" >
              <h6 class="font2 mb-4 mt-2"> Dollar Savings </h6>
       <div class="row p-0">
            <div class="col-2"></div>
            <div class="col-8 p-0">
              <p><?php echo $fee1 ?>% / mo</p>
              <p>no active savings</p>
              <button class="button1 btn mb-2" id="ssbtn"  data-bs-toggle="modal" data-bs-target="#exampleModal">Start new savings</button>
              
            </div>
          </div>
            </div>
          </div>
        </div>
  </div>
  <div class="col-sm-4"></div>
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade bs-example-modal-center11 " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Dollar SAVINGS PLAN</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Funds are strictly locked till maturity date <a href="">read more</a> <br><br>
                                                                                 <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Interest funds can be available instantly, Monthly or at maturity date
                                                                            </div>
                                                                            <center>
                                                                              
                                                                            </center>
                                                                            <div class="row">
                                                                              <div class="col-sm-6">
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
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                  <div class="form-group mb-1">
                                                                            <label class="mb-2">Amount to save (N)</label>
                                                                          <input type="number" name="" class="form-control" placeholder="0.00" id="samt" oninput="
                                                                          document.getElementById('sint').value= Math.round(document.getElementById('sdur').value * this.value * <?php echo ($fee1/100) ?>);  document.getElementById('ii').innerHTML=Math.round(this.value / <?php  echo $fee2 ?>);
                                                                          "> <small>rate: <?php  echo $fee2 ?>/$ |  you will get <span id="ii" style="font-weight: bolder;"></span>$</small>
                                                                            </div>
                                                                            
                                                                              </div>
                                                                            </div>
                                                                          
                                                                           
                                                                           
                                                                            <div class="row">
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">When To Get Interest</label>
                                                                          <select class="form-control" id="swhen">
                                                                              <option value="1">Now</option>
                                                                               <option value="3">Monthly</option>
                                                                              <option value="2">Maturity Date</option>
                                                                          </select>
                                                                            </div>
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                
                                                                             <div class="form-group mb-3">
                                                                            <label class="mb-2">Total Interest N (at <?php echo $fee1 ?>% monthly)</label>
                                                                          <input type="text" name="" id="sint" class="form-control" readonly="">
                                                                            </div>
                                                                            
                                                                              </div>
                                                                              <div class="col-sm-6">
                                                                                 <div class="form-group mb-3">
                                                                            <label class="mb-2">Account Password</label>
                                                                         <input type="password" name="" id="accpin" class="form-control">
                                                                            </div>
                                                                              </div>
                                                                            </div>
                                                                           
                                                                             
                                                                           
                                                                            <center>
                                                                                <button class="btn button1" type="button"  onclick="
                                                                                if (document.getElementById('samt').value !=='' && document.getElementById('sdur').value !=='' && document.getElementById('sint').value !=='') {
if (document.getElementById('accpin').value =='<?php  echo $pin ?>' ) {
save('dollar',document.getElementById('samt').value,document.getElementById('sdur').value,document.getElementById('sint').value,this,document.getElementById('swhen').value);
}
else{

  document.getElementById('failtext').innerHTML='Wrong password';
failm.show();

    
   
}
                                                                                }
                                                                                ">Start Savings Plan</button>
                                                                            </center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

  <?php
}
if ($row > 0) {
  $query0=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='dollar'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='dollarate'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;
       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='Savings' and rank='Money market'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];
       }
  while($m=mysqli_fetch_array($query)){
$sb=$m['amount'];
$ti=$m['interest'];
$md=$m['mature'];
$oo=strtotime($md) - strtotime(date("Y-m-d"));
$years = floor($oo / (60*60*24));

$ghw=mysqli_query($link,"SELECT * from transactions where phone='$email' and type='sdeposit' and name='dollar' order by id desc");

    ?>
<div class="modal fade bs-example-modal-center11 " id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Add to Savings</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="asamt" oninput="
                                                                          document.getElementById('tii').innerHTML=Math.round(<?php echo $years  ?>* this.value * <?php echo ($fee1/( 100 * 31)) ?>);
                                                                          " >
                                                                          <small >Total Interest : N <span id="tii"></span> </small><br>
                                                                              <small style="color:crimson;">Minimum : N 1,000</small> <br><small> rate is <?php echo $fee2 ?>/$</small>
                                                                             </div>
                                                                             <center>   <button class="button1"  id="fsbtn" onclick="  if (document.getElementById('asamt').value > 999) { a2s('dollar',document.getElementById('asamt').value,<?php  echo $m['id']; ?>,document.getElementById('tii').innerHTML);} ">Add to savings</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>
<div class="row mb-4">
  <div class="col-sm-7">
    <div class="p-5" style="border-radius: 10px; background: rgba(232, 255, 245, 1); ">
      <h6 class="font2">Balance   <p style="float:right; font-weight:normal; font-size: .9em"><?php echo $fee1 ?>% / mo</p></h6>
      <p class="font1 mb-3">$ <?php echo number_format(($sb / $fee2),0)  ?></p>
      <h6 class="font2">Total Deposit</h6>
      <p class="font1 mb-3">$ <?php echo number_format(($sb / $fee2),0)  ?></p>
      <h6 class="font2">Total interest earned </h6>
      <p class="font1 mb-3">$ <?php echo   number_format(($ti / $fee2),0)   ?></p>
      <h6 class="font2">Maturity date </h6>
      <p class="font1 mb-3"><?php echo $md  ?></p>
      <button class="btn button1 me-2 mt-3 ms-2" disabled="<?php  if($m['intw']=='1'){ echo "true";} else{ echo "false";} ?>">Claim Interest</button> <button class="btn button1 me-2 mt-3" data-bs-toggle="modal" data-bs-target="#exampleModal5">Add to savings</button>
    </div>
  
      
  
    
  </div>
</div>
<h5 class="font2">Deposit history</h5>
<div class="row">
  <div class="col-sm-8">
    <div class="table-responsive">
    <table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">amount</th>
      <th scope="col">Status</th>
     
    </tr>
  </thead>
  <tbody>
    <?php  
while($nnn=mysqli_fetch_array($ghw))
{


?>

<tr>
      
      <td><?php echo $nnn['rdate']; ?></td>
      <td>$ <?php echo number_format(($nnn['amount'] / $fee2),0) ; ?></td>
      <td style="color:limegreen;"><?php echo $nnn['status']; ?></td>
    </tr>

<?php
}
    ?>
    
    
  </tbody>
</table>
</div>
  </div>
</div>
<?php
  }
  
}



}











   if ($type=="save") {
      
$plan=$_POST['plan'];
$amt=$_POST['amt'];
$dur=$_POST['dur'];
$int=$_POST['int'];
$when=$_POST['when'];
$phone=$_SESSION['loggeduser'];
$date=date("Y-m-d h:i:s");
$date2=date('Y-m-d', strtotime($date. ' + '.$dur.' months'));
$query000=mysqli_query($link,"SELECT * FROM balances where balance='nairab' and email='$phone'");
       while ($res000=mysqli_fetch_array($query000)) {
$balance=$res000['amount'];
       }
if ($plan=="student") {
   if ($amt >= 1000 && $amt <= 90000) {
 if ($balance >= $amt) {
   
if (mysqli_query($link,"INSERT INTO savings values('','$plan','$amt','$int','$date2','$phone','In progress','$date','$when')")) {
 mysqli_query($link,"UPDATE balances set amount= amount - $amt where email='$phone' and balance='nairab'");
 if ($plan=="dollar") {
    mysqli_query($link,"UPDATE balances set amount= amount + $amt where email='$phone' and balance='dollar'");
 }
 else{
   mysqli_query($link,"UPDATE balances set amount= amount + $amt where email='$phone' and balance='naira'");
 }
 
 mysqli_query($link,"INSERT INTO transactions values('','$plan','','$amt','sdeposit','success','$phone','$date')");
 if ($when=="1") {
      mysqli_query($link,"UPDATE balances set amount= amount + $int where email='$phone' and balance='nairab'");
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
    echo "Minimum : N 1,000 <br> Maximum : N 90,000 ";
   }
}
else if ($plan=="business") {
   if ($amt >= 91000 && $amt <= 999000) {
 if ($balance >= $amt) {
   
if (mysqli_query($link,"INSERT INTO savings values('','$plan','$amt','$int','$date2','$phone','In progress','$date','$when')")) {
 mysqli_query($link,"UPDATE balances set amount= amount - $amt where email='$phone' and balance='nairab'");
 mysqli_query($link,"UPDATE balances set amount= amount + $amt where email='$phone' and balance='naira'");
 mysqli_query($link,"INSERT INTO transactions values('','$plan','','$amt','sdeposit','success','$phone','$date')");
 if ($when=="1") {
      mysqli_query($link,"UPDATE balances set amount= amount + $int where email='$phone' and balance='nairab'");
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
    echo "Minimum : N 91,000 <br> Maximum : N 999,000 ";
   }
}
else if ($plan=="money") {
   if ($amt >= 1000000 && $amt <= 9000000) {
 if ($balance >= $amt) {
   
if (mysqli_query($link,"INSERT INTO savings values('','$plan','$amt','$int','$date2','$phone','In progress','$date','$when')")) {
 mysqli_query($link,"UPDATE balances set amount= amount - $amt where email='$phone' and balance='nairab'");
 mysqli_query($link,"UPDATE balances set amount= amount + $amt where email='$phone' and balance='naira'");
 mysqli_query($link,"INSERT INTO transactions values('','$plan','','$amt','sdeposit','success','$phone','$date')");
 if ($when=="1") {
      mysqli_query($link,"UPDATE balances set amount= amount + $int where email='$phone' and balance='nairab'");
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
    echo "Minimum : N 1,000,000 <br> Maximum : N 9,000,000 ";
   }
}


else if ($plan=="dollar") {
   if ($amt >= 1000 && $amt <= 9000000) {
 if ($balance >= $amt) {
   
if (mysqli_query($link,"INSERT INTO savings values('','$plan','$amt','$int','$date2','$phone','In progress','$date','$when')")) {
 mysqli_query($link,"UPDATE balances set amount= amount - $amt where email='$phone' and balance='nairab'");
 mysqli_query($link,"UPDATE balances set amount= amount + $amt where email='$phone' and balance='naira'");
 mysqli_query($link,"INSERT INTO transactions values('','$plan','','$amt','sdeposit','success','$phone','$date')");
 if ($when=="1") {
      mysqli_query($link,"UPDATE balances set amount= amount + $int where email='$phone' and balance='nairab'");
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
    echo "Minimum : N 1,000 <br> Maximum : N 9,000,000 ";
   }
}
   }

   if ($type=="wallet") {
   	$phone=$_SESSION['loggeduser'];
   	$query000=mysqli_query($link,"SELECT * FROM balances where balance='nairab' and email='$phone'");
    $query=mysqli_query($link,"SELECT * FROM transactions where name='wallet' and phone='$phone' order by id desc");
       while ($res000=mysqli_fetch_array($query000)) {
$bal=$res000['amount'];
       }

        $query0000=mysqli_query($link,"SELECT * FROM users where  email='$phone'");
       while ($res0000=mysqli_fetch_array($query0000)) {
  $name=$res0000['first_name']." ".$res0000['last_name'];
       }
       $query0001=mysqli_query($link,"SELECT * FROM fees where name='card fee'");
       while ($res0001=mysqli_fetch_array($query0001)) {
 $fee=$res0001['fee'];
    
       }


      $query00011=mysqli_query($link,"SELECT * FROM vaccounts where phone='$phone'");
       while ($res00011=mysqli_fetch_array($query00011)) {
 $num=$res00011['number'];
    
       }
       $kk=mysqli_num_rows($query00011);
   ?>
<input type="hidden" name="" id="cname" value="<?php  echo $name ?>">
<input type="hidden" name="" id="cemail" value="<?php  echo $_SESSION['loggeduser'] ?>">
<input type="hidden" name="" id="cfee" value="<?php  echo $fee; ?>">

<div class="row">
		<h3 class="font2">Wallet</h3>

	</div>
<div class="row mt-5">
	
	<div class="col-sm-2"></div>
	<div class="col-sm-4 p-3">
		<div class="rbox2 mb-4"  style="height:150px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 150px;"></div>
            </div>
             
            <div class="col-10  pt-4" >
              <h6 class="font2 mb-2" style="text-align:center;"> <img src="../images/dep.png" style="max-height:60px" class="me-3"></h6>
       <div class="row p-0">
            <div class="col-1"></div>
            <div class="col-11 ">
            	<center>  <button class="button1 "  role="button" data-bs-toggle="modal" data-bs-target="#exampleModal5">Card Topup</button></center>
             
            </div>
          </div>
            </div>
          </div>
        </div>
<?php  
if ($kk == 0) {
  ?>

<div class="rbox2 mb-4"  style="height:250px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="height: 250px;"></div>
            </div>
             
            <div class="col-10  pt-4" >
              <h6 class="font2 mb-2" style="text-align:left;">Get Ok2save Account</h6>
       <div class="row p-0">
            <div class="col-1"></div>
            <div class="col-11 ">
            <!---  <div class="alert mb-3 alert-info" role="alert" style="font-size:.7em">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>BVN Number (to get your BVN, text *565*0#)
                                                                            </div>-->
              <div class="alert mb-3 alert-info" role="alert" style="font-size:.7em">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>For your security you need to connect your BVN to your Ok2save account to instantly receive your account number
                                                                            </div>
                                                                            <!--<div class="alert mb-3 alert-info" role="alert" style="font-size:.7em">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>
                                                                                To confirm your identity, you need to connect your BVN. This does not give Ok2save any access to your bank information or balances. This just enables Ok2save confirm your identity (real name, phone number & date of birth) from your bank.
                                                                            </div>-->
              <center>  <button class="button1 "  role="button" data-bs-toggle="modal" data-bs-target="#exampleModal580">Add Bvn</button></center>
             
            </div>
          </div>
            </div>
          </div>
        </div>

  <?php
}
if ($kk > 0) {
  ?>

<div class="rbox2 mb-4"  style="height:150px">
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 150px;"></div>
            </div>
             
            <div class="col-10  pt-4" >
              <h6 class="font2 mb-2" style="text-align:left; font-size: .7em;"><span class="iconify me-2" data-icon="cil:bank" style="color: blue; position: relative; top: -2px;" data-width="20"></span> Bank Account  (1% charge)</h6>
       <div class="row p-0">
            <div class="col-1"></div>
            <div class="col-11 ">
              <p class="mb-1 ms-4" style="font-size:.8em;"> Wema Bank</p>
              <p class=" ms-4" style="font-size:.8em;"><b><?php  echo $num ?> <span class="iconify ms-2" data-icon="akar-icons:copy" style="color: blue;" data-width="14"></span></b></p>
             
            </div>
          </div>
            </div>
          </div>
        </div>

  <?php
}


?>

        


	</div>
	<div class="col-sm-4 p-3">
		<div class="rbox2" style="height:150px" >
          <div class="row p-0">
            <div class="col-1 ">
              <div class="rubb" style="max-height: 150px;"></div>
            </div>
             
            <div class="col-10  pt-4" >
              <h6 class="font2 mb-2 " style="text-align:center;"> <img src="../images/with.png" style="max-height:60px" class="me-3"> </h6>
       <div class="row p-0">
            <div class="col-1"></div>
            <div class="col-11 p-0">
            	<center>   <button class="button1 " data-bs-toggle="modal"  data-bs-target="#exampleModal50">Withdraw</button></center>
           
            </div>
          </div>
            </div>
          </div>
        </div>
	</div>
	<div class="col-sm-2"></div>
</div>


<div class="row">
	<div class="col-sm-2"></div>
	<div class="col-sm-8">
		<h5 class="font2 mt-5 ">Wallet history</h5>
    <div class="table-responsive">
		<table class="table">
  <thead>
    <tr>
      <th scope="col">Date</th>
      <th scope="col">Type</th>
      <th scope="col">Amount</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>

    <?php  

while($cv=mysqli_fetch_array($query)){
?>

 <tr>
      <th scope="row"><?php  echo $cv['rdate']; ?></th>
      <td><?php  echo $cv['type']; ?></td>
      <td>N <?php  echo number_format($cv['amount']); ?></td>
      <td><?php  echo $cv['status']; ?></td>
    </tr>


<?php
}



     ?>
    
    
  </tbody>
</table>
</div>
	</div>
</div>
<div class="modal fade bs-example-modal-center11 " id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Add Funds</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              
                                                                             	<label class="mb-2">Amount (N)</label>
                                                                             	<input type="number" name="" class="form-control" id="famt">
                                                                             	<small style="color:crimson;">Minimum : N 1,000</small>
                                                                             </div>
                                                                             <center>   <button class="button1"  id="fbtn">Fund</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>


                                                            <div class="modal fade bs-example-modal-center11 " id="exampleModal580" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Add Bvn</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                          <div class="alert mb-3 alert-info" role="alert" style="font-size:.7em">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>
                                                                                To confirm your identity, you need to connect your BVN. This does not give Ok2save any access to your bank information or balances. This just enables Ok2save confirm your identity (real name, phone number & date of birth) from your bank.
                                                                            </div>
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Bvn</label>
                                                                              <input type="number" name="" class="form-control" id="abvn">
                                                                              <small style="color:crimson; font-size: .7em;">BVN Number (to get your BVN, text *565*0#)</small>
                                                                             </div>
                                                                             <center>   <button class="button1"  id="abvnbtn" onclick="if (document.getElementById('abvn').value !=='') {abvn(document.getElementById('abvn').value,this);}">Add</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

                                                            <div class="modal fade bs-example-modal-center11 " id="exampleModal50" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-lg" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Withdraw Funds</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="col-xl-12 col-xxl-12">
                                            <div class="card  " style="border:none;">
                                                <div class="card-inner border-bottom">
                                                    <div class="card-title-group">
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
                                                <center>  <button class="btn btn-primary mt-3 btn-lg" style="width: 200px; display: block; text-align:center;" disabled="" id="kjh" onclick="sendw(this,document.getElementById('bvc').value); this.innerHTML='Sending ..';" type="button"> <center>Send Withdrawal</center> </button></center>
                                               </div>
                                                   
                                               </form>
                                            </div><!-- .card -->
                                        </div>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

<?php
      }
 if ($type=='verifyacct') {
     
    $bank=$_POST['bank'];
    $acct=$_POST['acct'];
        $email=$_SESSION['loggeduser'];
        $query=mysqli_query($link,"SELECT * FROM users where email='$email'");
        while ($res=mysqli_fetch_array($query)) {
           
        $firstname= $res['first_name'];
        $lastname= $res['first_name'];
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
 mysqli_query($link,"INSERT INTO transactions values('','wallet','','$amt','withdraw','processing','$email','$date')");
mysqli_query($link,"UPDATE balances set amount=amount -$amt where balance='nairab' and email='$email'");
  }

   if ($type=='loans') {
$phone=$_SESSION['loggeduser'];
    
         $query1=mysqli_query($link,"SELECT * FROM users where email='$phone'");
         $query40=mysqli_query($link,"SELECT * FROM loans where phone='$phone'");
         $row1=mysqli_num_rows($query40);
        while ($res1=mysqli_fetch_array($query1)) {
      $id=$res1['id']."__".$res1['jdate'].$res1['email'];
      
        
        }
   $query0=mysqli_query($link,"SELECT * FROM fees where name='Loan'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee=1 + ($res0['fee'] / 100);
       }

       $query00=mysqli_query($link,"SELECT * FROM login where email='$phone'");
       while ($res00=mysqli_fetch_array($query00)) {
       $pin=$res00['password'];
       }
    ?>
    
<div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <h3 class="nk-block-title page-title font2">Loans</h3>
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
                                     <div class="col-sm-6 mb-5">
                                        <div style="background: #E3EBFB; border-radius:10px" class="p-5">
                                            <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>To Loan more than N 100,000 please contact support or visit any of our branch 
                                                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2"> Amount</label>
                                                <input type="number" max="100000" name="" class="form-control" id="amt"
                                                oninput="
                                                document.getElementById('zh').value= Math.round(this.value * <?php echo $fee ?>);
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
                                                <input type="number" name="" class="form-control"   id="rp">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2"> Bvn</label>
                                                <input type="number" name="" class="form-control"  id="bvn">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="mb-2"> Account Password</label>
                                                <input type="password" name="" class="form-control"  id="vvpin">
                                            </div>
                                            <div class="alert mb-3 alert-info" role="alert">
                                                                                <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Approved Loans will be paid to your Ok2save wallet only <br><br> <span class="iconify me-2" data-icon="gg:danger" style="color: crimson;" data-width="12"></span>Loan applications costs N200
                                                                            </div>
                                            <center><button class="btn btn-primary" id="loanbtn" type="button" onclick="
                                                if (document.getElementById('amt').value !=='' && document.getElementById('reason').value !=='' && document.getElementById('address').value !=='' && document.getElementById('bvn').value !==''  && document.getElementById('rp').value !=='' ) {
                                          if (document.getElementById('vvpin').value == '<?php echo $pin ?>') {
                                                                                     loan(document.getElementById('amt').value,document.getElementById('reason').value,document.getElementById('address').value,document.getElementById('bvn').value,document.getElementById('rp').value);
                                                                                  } else{
                                                                                     document.getElementById('failtext').innerHTML='Wrong password';
failm.show();
   
                                                                                }
                                                }
                                                else{
                                                	 document.getElementById('failtext').innerHTML='Input all fields';
failm.show();
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
$query000=mysqli_query($link,"SELECT * FROM balances where balance='nairab' and email='$phone'");
       while ($res000=mysqli_fetch_array($query000)) {
$bal=$res000['amount'];
       }
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
    echo "Insufficient Balance To Apply <br> (Bal :N ".$bal." Fee : N200)";
}
}
else{
     echo "Maximum loan amount is <br> N100,000";
}
}
else{
        echo "Duration can only be <br> between 14 and 180 Days";
}
}

 if ($type=='profile') {
      $phone=$_SESSION['loggeduser'];
     
         $query=mysqli_query($link,"SELECT * FROM users where email='$phone'");
        while ($res=mysqli_fetch_array($query)) {
          
        $firstname= $res['first_name'];
        $lastname= $res['last_name'];
        $email=$res['email'];
        $email1=$res['phone'];
        $api_key=isset($res['api_key']) ? $res['api_key']:'';
        
        
        }
         $query1=mysqli_query($link,"SELECT * FROM login where email='$phone'");
        while ($res1=mysqli_fetch_array($query1)) {
      $passs=$res1['password'];
        
        }

        $query10=mysqli_query($link,"SELECT * FROM users where email='$phone'");
         $query40=mysqli_query($link,"SELECT * FROM referrals where main='$phone'");
         $row1=mysqli_num_rows($query40);
        while ($res10=mysqli_fetch_array($query10)) {
      $id=$res10['id']."__".$res10['jdate'].$res10['email'];
        
        }
      ?>
      <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font2">Profile</h4>
                                    
                                </div>
                            </div>
                        </div>
<input type="hidden" name="" value="<?php echo $passs ?>" id="pass5">
<div class="container-fluid mt-5 mb-5">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                              
                                <div class="nk-block">
                                    <div class="row g-gs">
                                     <div class="col-sm-6">
                                         <form class="card p-5">
                                             <div class="form-group mb-3">
                                                 <label class="mb-3">
                                                     First Name 
                                                 </label>
                                                 <input type="text" name="" class="form-control" value="<?php echo $firstname ?>" id="fn" >
                                             </div>
                                             <div class="form-group mb-3">
                                                 <label class="mb-3">
                                                    Last Name
                                                 </label>
                                                 <input type="text" name="" class="form-control" value="<?php echo $lastname ?>" id="ln"  >
                                             </div>
                                              <div class="form-group mb-3">
                                                 <label class="mb-3">
                                                     Phone
                                                 </label>
                                                 <input type="text" name="" class="form-control" value="<?php echo $email1 ?>" id="ph" >
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

                    <div class="nk-block container">
                                    <div class="row g-gs">
                                     <div class="col-sm-12">
                                        <div class="card p-5">
                                             <h5 class="mb-2">Your Referal Link</h5>
                                             <label>You Get N1 for each friend you refer</label>
                                               <div class="input-group">
     
                                         <input type="text" name=""  id='myInput' readonly=""class="form-control" value="https://ok2save.ng/register.html?ref=<?php  echo $id ?>">        <div class="input-group-append">
            <button class="btn btn-outline-primary btn-dim" onclick='
 
  var copyText = document.getElementById("myInput");
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */
  document.execCommand("copy");
document.getElementById("bv").innerHTML="Copied!";
  
            '><span class="iconify mr-2" data-icon="bx:bxs-copy"></span> <span id="bv">Copy</span></button> <button class="btn btn-outline-primary btn-dim" onclick="
window.location='https://wa.me/?text=<?php echo urlencode("Buy Cheap data, Save money & get Quick loan today . Sign up today and get free ₦5.00  to get started https://ok2save.ng/register.html?ref=".$id); ?>';
            "><span class="iconify mr-2" data-icon="ant-design:share-alt-outlined"></span></button>
        </div>
    </div>
                                        </div>
                                        
                                     </div>
                                    
                                    </div>
                                     <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Referrals</h4>
                                        <div class="table-responsive">
                                            <?php  
                                            if ($row1==0) {
                                                ?>
                                                <center><span class="iconify" data-icon="ps:dropbox" style="color: #adcde5;" data-width="120"></span><p>No referral yet</p></center>
                                                
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
      <?php
  }

   if ($type=='updd') {
     $fname=$_POST['fname'];
    $phone=$_POST['phone'];
    $phone1=$_POST['email'];
    $email=$_SESSION['loggeduser'];
    mysqli_query($link,"UPDATE users set first_name ='$fname',last_name='$phone', email='$phone1' where email='$email'");
  }
  if ($type=='upddd') {
        $email=$_SESSION['loggeduser'];
     $fname=$_POST['fname'];
   
    mysqli_query($link,"UPDATE login set password ='$fname' where email='$email'");
  }



  if ($type=="inv") {
$phone=$_SESSION['loggeduser'];
$query0=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='real estate'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];

$min1=$res0['min'];

$max1=$res0['max'];


$dur1=$res0['duration'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='agriculture'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;

$min2=$res00['min'];

$max2=$res00['max'];


$dur2=$res00['duration'];

       }
       $query000=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='transportation'");
       while ($res000=mysqli_fetch_array($query000)) {
$fee3=$res000['fee'];

$min3=$res000['min'];

$max3=$res000['max'];


$dur3=$res000['duration'];

       }


        $query000w=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='bitcoin'");
       while ($res000w=mysqli_fetch_array($query000w)) {
$fee3w=$res000w['fee'];

$min3w=$res000w['min'];

$max3w=$res000w['max'];


$dur3w=$res000w['duration'];

       }




$query=mysqli_query($link,"SELECT * FROM investments where phone='$phone' and status='active'");
$row=mysqli_num_rows($query);
// 



  	?>
<?php 

if ($row > 0) {
  while ($res=mysqli_fetch_array($query)) {
    $pl=$res['plan'];
$query0=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='$pl'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];
       }
?>

<div class="row mb-4">
  <div class="col-sm-7">
    <div class="p-5" style="border-radius: 10px; background: rgba(232, 255, 245, 1); ">
       <h6 class="font2">Plan</h6>
      <p class="font1 mb-3" style="text-transform: uppercase;"><?php echo $pl  ?></p>
      <h6 class="font2">Balance   <p style="float:right; font-weight:normal; font-size: .9em"><?php echo $fee1 ?>% / mo</p></h6>
      <p class="font1 mb-3">N <?php echo number_format($res['amount'],0)  ?></p>
      <h6 class="font2">Total Deposit</h6>
      <p class="font1 mb-3">N <?php echo number_format($res['amount'],0)  ?></p>
      <h6 class="font2">Total Payout </h6>
      <p class="font1 mb-3">N <?php echo number_format(($res['interest'] ),0)  ?></p>
      <h6 class="font2">Maturity date </h6>
      <p class="font1 mb-3"><?php echo $res['mature']   ?></p>
      
    </div>
  
      
  
    
  </div>
</div>

<?php

  }
  ?>



  <?php
}
else{
  ?>


<div class="row mb-5">
    <h3 class="font2">Investments Packages</h3>

  </div>
  <div class="row mt-5">
    <div class="col-sm-4 p-3">
      <div class="plan">
        <div class="pt p-3 font2 mb-4" style="background: rgba(255, 231, 232, 1); border-radius: 25px 25px 0 0; text-align: center; "><img src="../images/f11.png" height="40px" class="me-3"> Real estate </div>
        <p class="font2" style="font-size:1.2em; text-align: center;"><?php echo $fee1  ?>% ROI</p>
        <p class="font2  text-center">Minimum: N <?php echo number_format($min1,0) ?></p>
        <p class="font2  text-center">Maximum: N <?php echo number_format($max1,0) ?></p>
        <p class="font2  text-center">Duration: <?php echo $dur1 ?> Month</p>

        <div class="pt p-3 font2" style="background: rgba(255, 231, 232, 1); border-radius: 0 0 25px 25px;  text-align: center; position: relative; cursor: pointer;  bottom: 0px;" data-bs-toggle="modal" data-bs-target="#exampleModal5">Select Plan</div>
      </div>
      
    </div>
    <div class="col-sm-4 p-3">
      <div class="plan">
        <div class="pt p-3 mb-4 font2 " style="background: rgba(255, 241, 214, 1); border-radius: 25px 25px 0 0; text-align: center; "><img src="../images/f22.png" height="40px" class="me-3"> Agriculture</div>
        <p class="font2" style="font-size:1.2em; text-align: center;"><?php echo $fee2  ?>% ROI</p>
      <p class="font2  text-center">Minimum: N <?php echo number_format($min2,0) ?></p>
        <p class="font2  text-center">Maximum: N <?php echo number_format($max2,0) ?></p>
        <p class="font2  text-center">Duration: <?php echo $dur2 ?> Month</p>
        <div class="pt p-3 font2" style="background: rgba(255, 241, 214, 1); border-radius: 0 0 25px 25px;  text-align: center; position: relative; cursor: pointer;  bottom: 0px;" data-bs-toggle="modal" data-bs-target="#exampleModal55">Select Plan</div>
      </div>
      
    </div>
    <div class="col-sm-4 p-3">
      <div class="plan">
        <div class="pt p-3 mb-4 font2 " style="background: rgba(232, 255, 245, 1); border-radius: 25px 25px 0 0; text-align: center; "> <img src="../images/f33.png" height="40px" class="me-3"> Transaportation</div>
        <p class="font2" style="font-size:1.2em; text-align: center;"><?php echo $fee3  ?>% ROI</p>
     <p class="font2  text-center">Minimum: N <?php echo number_format($min3,0) ?></p>
        <p class="font2  text-center">Maximum: N <?php echo number_format($max3,0) ?></p>
        <p class="font2  text-center">Duration: <?php echo $dur3 ?> Month</p>
        <div class="pt p-3 font2" style="background: rgba(232, 255, 245, 1); border-radius: 0 0 25px 25px;  text-align: center; position: relative; cursor: pointer;  bottom: 0px;" data-bs-toggle="modal" data-bs-target="#exampleModal555">Select Plan</div>
      </div>
      
    </div>

     <div class="col-sm-4 p-3">
      <div class="plan">
        <div class="pt p-3 mb-4 font2 " style="background: rgba(232, 255, 245, 1); border-radius: 25px 25px 0 0; text-align: center; "> <img src="../images/f44.png" height="40px" class="me-3"> Bitcoin</div>
        <p class="font2" style="font-size:1.2em; text-align: center;"><?php echo $fee3w  ?>% ROI</p>
       <p class="font2  text-center">Minimum: N <?php echo number_format($min3w,0) ?></p>
        <p class="font2  text-center">Maximum: N <?php echo number_format($max3w,0) ?></p>
        <p class="font2  text-center">Duration: <?php echo $dur3w ?> Month</p>
        <div class="pt p-3 font2" style="background: rgba(232, 255, 245, 1); border-radius: 0 0 25px 25px;  text-align: center; position: relative; cursor: pointer;  bottom: 0px;" data-bs-toggle="modal" data-bs-target="#exampleModal5555">Select Plan</div>
      </div>
      
    </div>
  </div>

<div class="modal fade bs-example-modal-center11 " id="exampleModal5" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Real estate Investment</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="camt" oninput=" document.getElementById('ff').innerHTML=Math.round(this.value * <?php  echo (1 + $fee1/100) ?>);" >
                                                                              <small>You Get N <span id="ff" style="color: limegreen; font-weight: bolder;"></span></small><br>
                                                                              <small style="color:crimson;">Min : N <?php echo number_format($min1,0) ?> <br> Max : N <?php echo number_format($max1,0) ?></small>
                                                                             </div>
                                                                             <center>   <button class="button1 btn" onclick="sinv('real estate',document.getElementById('camt').value,document.getElementById('ff').innerHTML,'<?php echo $dur1  ?>')">Start Investment</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>




                                                            <div class="modal fade bs-example-modal-center11 " id="exampleModal55" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Agriculture Investment</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="camt1" oninput=" document.getElementById('ff1').innerHTML=Math.round(this.value * <?php  echo (1 + $fee2/100) ?>);" >
                                                                               <small>You Get N <span id="ff1" style="color: limegreen; font-weight: bolder;"></span></small><br>
                                                                              <small style="color:crimson;">Min : N <?php echo number_format($min2,0) ?> <br> Max : N <?php echo number_format($max2,0) ?></small>
                                                                             </div>
                                                                             <center>   <button class="button1 btn" onclick="sinv('agriculture',document.getElementById('camt1').value,document.getElementById('ff1').innerHTML,'<?php echo $dur2 ?>')">Start Investment</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>




                                                            <div class="modal fade bs-example-modal-center11 " id="exampleModal555" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Transaportation Investment</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="camt2" oninput=" document.getElementById('ff2').innerHTML=Math.round(this.value * <?php  echo (1 + $fee3/100) ?>);" >
                                                                               <small>You Get N <span id="ff2" style="color: limegreen; font-weight: bolder;"></span></small><br>
                                                                               <small style="color:crimson;">Min : N <?php echo number_format($min3,0) ?> <br> Max : N <?php echo number_format($max3,0) ?></small>
                                                                             </div>
                                                                             <center>   <button class="button1 btn" onclick="sinv('transaportation',document.getElementById('camt2').value,document.getElementById('ff2').innerHTML,'<?php echo $dur3 ?>')">Start Investment</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>



                                                              <div class="modal fade bs-example-modal-center11 " id="exampleModal5555" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    
                                                                <div class="modal-dialog modal-dialog-centered modal-sm" >
                                                                    <div class="modal-content p-3" style="border-radius:35px">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title font2">Bitcoin Investment</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                             <div class="form-group mb-5">
                                                                              <label class="mb-2">Amount (N)</label>
                                                                              <input type="number" name="" class="form-control" id="camt3" oninput=" document.getElementById('ff3').innerHTML=Math.round(this.value * <?php  echo (1 + $fee3w/100) ?>);" >
                                                                               <small>You Get N <span id="ff3" style="color: limegreen; font-weight: bolder;"></span></small><br>
                                                                               <small style="color:crimson;">Min : N <?php echo number_format($min3w,0) ?> <br> Max : N <?php echo number_format($max3w,0) ?></small>
                                                                             </div>
                                                                             <center>   <button class="button1 btn" onclick="sinv('transaportation',document.getElementById('camt3').value,document.getElementById('ff3').innerHTML,'<?php  echo $dur3w ?>')">Start Investment</button></center>
                                                                           
                                                                        </div>
                                                                    </div><!-- /.modal-content -->
                                                                </div><!-- /.modal-dialog -->
                                                            </div>

  <?php
}

 ?>

  	<?php
  }
  if ($type=="addss") {

    $phone=$_SESSION['loggeduser'];
    $query000=mysqli_query($link,"SELECT * FROM balances where balance='nairab' and email='$phone'");
       while ($res000=mysqli_fetch_array($query000)) {
$bal=$res000['amount'];
       }
    $name=$_POST['name'];
    $amt=$_POST['amt'];
    $id=$_POST['id'];
    $int=$_POST['int'];
    $date=date("Y-m-d h:i:s");
    if ($bal >= $amt) {


$queryl=mysqli_query($link,"SELECT * FROM savings where phone ='$phone' and plan='$name' order by id desc");

   
    
        while ($res1=mysqli_fetch_array($queryl)) {
    
      $ww=$res1['intw'];
        
        }
        if ($ww=='1') {
          mysqli_query($link,"UPDATE savings set amount=amount + $amt, interest=interest + $int where id='$id'");
        }

      
    mysqli_query($link,"UPDATE balances set amount=amount - $amt where email='$phone' and balance='nairab'");
 mysqli_query($link,"INSERT INTO transactions values('','$name','','$amt','sdeposit','success','$phone','$date')");
 if ($name=="dollar") {
    mysqli_query($link,"UPDATE balances set amount= amount + $amt where email='$phone' and balance='dollar'");
 }
 else{
   mysqli_query($link,"UPDATE balances set amount= amount + $amt where email='$phone' and balance='naira'");
 }



    }
    else{
      echo "Insufficient Balance";
    }

      }

      if ($type=='abvnn') {
          


$phone=$_SESSION['loggeduser'];
 $query000=mysqli_query($link,"SELECT * FROM users where email='$phone'");
       while ($res000=mysqli_fetch_array($query000)) {
 $bvnfn=$res000['first_name'];
    $bvnln=$res000['last_name'];
       }

 $bvn=$_POST['bvn'];
    
    $POST = array(
        'bvn' => $bvn, 
        'first_name' => $bvnfn, 
        'last_name' => $bvnln, 
        
          
        );
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.ufitpay.com/v1/create_bank_account",
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
$stat=$balanceJ["status"];
if ($stat=="success") {
    $bnu=$balanceJ["data"]["account_number"];
    $ban="Wema Bank";
mysqli_query($link,"INSERT INTO vaccounts values('','$phone','$ban','$bnu')");

mysqli_query($link,"UPDATE users set first_name='$bvnfn', last_name='$bvnln' where email='$phone'");
echo "done";
}
else{
    echo $balanceJ["message"];
}
      }
      if ($type=="nbv") {
        $phone=$_SESSION['loggeduser'];
         $query000=mysqli_query($link,"SELECT * FROM users where email='$phone'");
       while ($res000=mysqli_fetch_array($query000)) {
 $bvnfn=$res000['first_name'];
    $bvnln=$res000['last_name'];
       }
       echo "Hi, ".$bvnfn;

      }
      if ($type=="sinv") {
        $phone=$_SESSION['loggeduser'];
        $plan=$_POST['plan'];
        $amt=$_POST['amt'];
         $dur=$_POST['m'];
          $get=$_POST['get'];
        $query000=mysqli_query($link,"SELECT * FROM balances where balance='nairab' and email='$phone'");
       while ($res000=mysqli_fetch_array($query000)) {
$bal=$res000['amount'];
       }
$query0=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='real estate'");
       while ($res0=mysqli_fetch_array($query0)) {
$fee1=$res0['fee'];

$min1=$res0['min'];

$max1=$res0['max'];


$dur1=$res0['duration'];
       }
       $query00=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='agriculture'");
       while ($res00=mysqli_fetch_array($query00)) {
$fee2=$res00['fee'] ;

$min2=$res00['min'];

$max2=$res00['max'];


$dur2=$res00['duration'];

       }
       $query0001=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='transportation'");
       while ($res0001=mysqli_fetch_array($query0001)) {
$fee3=$res0001['fee'];

$min3=$res0001['min'];

$max3=$res0001['max'];


$dur3=$res0001['duration'];

       }


        $query000w=mysqli_query($link,"SELECT * FROM fees where name='investment' and rank='bitcoin'");
       while ($res000w=mysqli_fetch_array($query000w)) {
$fee3w=$res000w['fee'];

$min3w=$res000w['min'];

$max3w=$res000w['max'];


$dur3w=$res000w['duration'];

       }

       $date=date("Y-m-d");
       $m=date('Y-m-d', strtotime($date. ' + '.$dur.' months'));
       if ($plan=="real estate") {
         
              if ($amt > $min1  && $amt < $max1) {
                if ($bal >= $amt) {
                  mysqli_query($link,"INSERT INTO investments values('','$plan','$amt','$get','$m','$phone','active','$date','')");
                  mysqli_query($link,"UPDATE balances set amount= amount + $amt where name='inv'");
                  echo "true";
                }
                else{
                    echo "Insufficient Funds";
                }
              }
              else{
                echo "Min: N ".$min1." <br> Max; N ".$max1."";
              }

       }
       if ($plan=="agriculture") {
         
 if ($amt > $min2  && $amt < $max2) {
                if ($bal >= $amt) {
                  mysqli_query($link,"INSERT INTO investments values('','$plan','$amt','$get','$m','$phone','active','$date','')");
                  mysqli_query($link,"UPDATE balances set amount= amount + $amt where name='inv'");
                  echo "true";
                }
                else{
                    echo "Insufficient Funds";
                }
              }
              else{
                echo "Min: N ".$min2." <br> Max; N ".$max2."";
              }
         
       }
       if ($plan=="transaportation") {
         
 if ($amt > $min3  && $amt < $max3) {
                if ($bal >= $amt) {
                  mysqli_query($link,"INSERT INTO investments values('','$plan','$amt','$get','$m','$phone','active','$date','')");
                  mysqli_query($link,"UPDATE balances set amount= amount + $amt where name='inv'");
                  echo "true";
                }
                else{
                    echo "Insufficient Funds";
                }
              }
              else{
                echo "Min: N ".$min3." <br> Max; N ".$max3."";
              }
         
       }


        if ($plan=="bitcoin") {
 if ($amt > $min3w  && $amt < $max3w) {
                if ($bal >= $amt) {
                  mysqli_query($link,"INSERT INTO investments values('','$plan','$amt','$get','$m','$phone','active','$date','')");
                  mysqli_query($link,"UPDATE balances set amount= amount + $amt where name='inv'");
                  echo "true";
                }
                else{
                    echo "Insufficient Funds";
                }
              }
              else{
                echo "Min: N ".$min3w." <br> Max; N ".$max3w."";
              }
         
       }
      }
      if ($type=="logout") {
        

        session_destroy();
      }

      if ($type=="gco") {
    $email=$_SESSION['loggeduser'];
    
         $query1=mysqli_query($link,"SELECT * FROM users where email='$email'");
        while ($res1=mysqli_fetch_array($query1)) {
      $ver=$res1['emailv'];
      $em=$res1['email'];
      $id=$res1['id'];
      $fn=$res1['first_name'];
      if ($ver=="0") {
$rand=rand(100990,97393999);
$mail = new PHPMailer();    
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = "ok2save.ng";
    $mail->IsHTML(true);
    //Username to use for SMTP authentication
  $mail->Username = 'reset@ok2save.ng';                 // SMTP username
$mail->Password = 'ok2savengg';                           // SMTP password
$mail->Port = 465;  
    //Set who the message is to be sent from
    $mail->setFrom('reset@ok2save.ng','OK2SAVE');
    //Set an alternative reply-to address
    $mail->addReplyTo('reset@ok2save.ng', 'OK2SAVE Support');
    //Set who the message is to be sent to
    $mail->addAddress($em);
    //Set the subject line
    $mail->Subject = 'Ok2Save Registration';
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
if ($type=="vco") {
  
  $email =$_SESSION['loggeduser'];

     mysqli_query($link,"UPDATE users set emailv='1' where email='$email'");
}


if ($type=="fp1") {
$emal=$_POST['email'];
 $query0001=mysqli_query($link,"SELECT * FROM users where email ='$emal'");
 $dd=mysqli_num_rows($query0001);
 if ($dd > 0) {
  
   while ($res0001=mysqli_fetch_array($query0001)) {
    $ran=rand(8888,987678999)."isq".rand(88,9999);
mysqli_query($link,"UPDATE login set password ='$ran' where email='$emal'");
$mail = new PHPMailer();    
    $mail->IsSMTP(); 
    $mail->SMTPAuth = true; 
    $mail->SMTPSecure = 'ssl'; 
    $mail->Host = "ok2save.ng";
    $mail->IsHTML(true);
    //Username to use for SMTP authentication
  $mail->Username = 'reset@ok2save.ng';                 // SMTP username
$mail->Password = 'ok2savengg';                           // SMTP password
$mail->Port = 465;  
    //Set who the message is to be sent from
    $mail->setFrom('reset@ok2save.ng','OK2SAVE');
    //Set an alternative reply-to address
    $mail->addReplyTo('reset@ok2save.ng', 'OK2SAVE Support');
    //Set who the message is to be sent to
    $mail->addAddress($emal);
    //Set the subject line
    $mail->Subject = 'Ok2Save Password reset';
  $mail->Debugoutput = function($str, $level) {echo "debug level $level; message: $str";};
    //Read an HTML message body from an external file, convert referenced images to embedded,
     //Read an HTML message body from an external file, convert referenced images to embedded,
    $searchArr = ["%ada%"];
$replaceArr = [$ran];
$body = file_get_contents('email1.php');
$body = str_replace($searchArr, $replaceArr, $body);
    //convert HTML into a basic plain-text alternative body
    $mail->msgHTML($body);
    //Replace the plain text body with one created manually
    $mail->AltBody = 'This is a plain-text message body';
    //send the message, check for errors
   $mail->Send();
   echo "true";

       }


   }
    
}
}


?>