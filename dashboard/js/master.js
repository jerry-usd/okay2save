    


     document.getElementById('main').addEventListener("click", close);
function close(){
document.getElementById('left').classList.remove('open'); 
}


     var failm = new bootstrap.Modal(document.getElementById('fail'));
var passm = new bootstrap.Modal(document.getElementById('pass'));

function home (argument) {
    

var data="action=home";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;




     }
    
  xhr.send(data);


    }


    function nbv (argument) {
    

var data="action=nbv";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('nbv').innerHTML=xhr.responseText;




     }
    
  xhr.send(data);


    }
nbv();


function savings (argument) {
    

var data="action=savings";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;
document.getElementById('nsbtn').addEventListener("click", ns1);
document.getElementById('dsbtn').addEventListener("click", ds);



     }
    
  xhr.send(data);


    }


    
function ns1 (){
     var data="action=ns1";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;
document.getElementById('ssbtn').addEventListener("click", ss);
document.getElementById('bsbtn').addEventListener("click", bs);
document.getElementById('msbtn').addEventListener("click", ms);



     }
    
  xhr.send(data);
}
function ds1 (){
     var data="action=ds1";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;
document.getElementById('dsbtn').addEventListener("click", ds);



     }
    
  xhr.send(data);
}
function ss (){
     var data="action=ss";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;




     }
    
  xhr.send(data);
}



function bs (){
     var data="action=bs";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;




     }
    
  xhr.send(data);
}



function ms (){
     var data="action=ms";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;




     }
    
  xhr.send(data);
}



function ds (){
     var data="action=ds";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;




     }
    
  xhr.send(data);
}



function wallet (){
     var data="action=wallet";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;
   
    document.getElementById('fbtn').addEventListener("click", fund);
     



     }
    
  xhr.send(data);
}



function save (plan,amt,dur,int,btn,mm){

 var data="action=save&plan="+plan+"&amt="+amt+"&dur="+dur+"&int="+int+"&when="+mm;

     btn.disabled=true;
     btn.innerHTML='Loading...';
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
if (xhr.responseText=="true") {


document.getElementById('passtext').innerHTML='you have successfully started your savings';
passm.show();
}

else{
document.getElementById('failtext').innerHTML=xhr.responseText;
failm.show();     
     btn.disabled=false;
     btn.innerHTML='Start Savings Plan';
}

     }
    
  xhr.send(data);
}

  function acctv() {
    
var data="action=verifyacct&bank="+document.getElementById('bank').value+"&acct="+document.getElementById('number').value;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
      if (xhr.responseText !='kk') {

          document.getElementById('aname').value=xhr.responseText;
          document.getElementById('with2').style.display='block';
               document.getElementById('widt').innerHTML='Verify';
      }
      else{

          document.getElementById('aname').value='Account Doesnt Match Name';
           document.getElementById('with2').style.display='none';
           document.getElementById('widt').innerHTML='Verify';
           document.getElementById('widt').disabled=false;
      }
console.log(xhr.responseText);
     }
    
  xhr.send(data);
 
 }


  function sendw(g,g1) {
  var bank=document.getElementById('bank').options[document.getElementById('bank').selectedIndex].text;
  var number=document.getElementById('number').value;

var data="action=sendw&bank="+bank+"&num="+number+"&amt="+g1;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {

     document.getElementById('kjh').innerHTML='Request Sent';
     document.getElementById('kjh').disabled=true;
     console.log(xhr.responseText);
     document.getElementById('passtext').innerHTML='Withdrawal request sent';
passm.show();


     }
    
  xhr.send(data);
}
  function bc(gg) {
 

if ( gg <= Number( document.getElementById('cvg').innerHTML) && gg > 0 ) {
  document.getElementById('kjh').disabled=false;
  console.log(gg);
}
else{
   document.getElementById('kjh').disabled=true;
}

}
 function loans (argument) {
    

var data="action=loans";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }


    function logout (argument) {
    

var data="action=logout";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   window.location='../signin.html';
     }
    
  xhr.send(data);


    }



     function inv (argument) {
    

var data="action=inv";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }
     function profile (argument) {
    

var data="action=profile";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }


    function loan(amt,reason,address,bvn,rp) {
 var data="action=loan&amt="+amt+"&reason="+reason+"&address="+address+"&bvn="+bvn+"&rp="+rp;

     document.getElementById('loanbtn').disabled=true;
     document.getElementById('loanbtn').innerHTML='loading...';
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
if (xhr.responseText=="success") {
       document.getElementById('passtext').innerHTML='Your Loan Request has been Submitted!';
passm.show();
    
}   
else{
      document.getElementById('failtext').innerHTML=xhr.responseText;
failm.show();  
     }
     document.getElementById('loanbtn').disabled=false;
     document.getElementById('loanbtn').innerHTML='Apply';
     }
     
    
  xhr.send(data);
}

function pass() {
 if(document.getElementById('pass5').value == document.getElementById('pass').value){
  document.getElementById('pass').style.borderColor='green';
  if (document.getElementById('pass1').value != "") {
if(document.getElementById('pass1').value == document.getElementById('pass2').value){
document.getElementById('widthh').disabled=false;
document.getElementById('pass1').style.borderColor='green';
document.getElementById('pass2').style.borderColor='green';



}
else{
  document.getElementById('widthh').disabled=true;
  document.getElementById('pass1').style.borderColor='red';
document.getElementById('pass2').style.borderColor='red';
 }
  }


}
else{
  document.getElementById('pass').style.borderColor='red';
}

}
function pass1() {
 var data="action=upddd&fname="+document.getElementById('pass1').value;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {


     }
    
  xhr.send(data);
}




function a2s(name,amt,id,int) {
 var data="action=addss&name="+name+"&amt="+amt+"&id="+id+"&int="+int;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
if (xhr.responseText=="") {
 document.getElementById('passtext').innerHTML='Deposit successful';
passm.show();
}
else{
     document.getElementById('failtext').innerHTML=xhr.responseText;
failm.show();
}
console.log(name+amt+id+int);

     }
    
  xhr.send(data);
}


 function updd() {
  var bank=document.getElementById('fn').value;
  var number=document.getElementById('ln').value;
  var number1=document.getElementById('kj').value;

var data="action=updd&fname="+bank+"&phone="+number+'&email='+number1;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {

     document.getElementById('widt').innerHTML='Updated';
          console.log(xhr.responseText);

     }
    
  xhr.send(data);
}




function abvn(bvn,btn) {
  btn.disabled=true;

var data="action=abvnn&bvn="+bvn;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {

     if (xhr.responseText=='done') {
document.getElementById('passtext').innerHTML='Bvn Added successfully';
passm.show();
 btn.disabled=false;
 btn.innerHTML='Bvn Added';
     }
     else{
          document.getElementById('failtext').innerHTML=xhr.responseText;
failm.show();
 btn.disabled=false;
     }
console.log(xhr.responseText);
     }
    
  xhr.send(data);
}


function fund (){

     if (document.getElementById('famt').value > 999) {
        var amt= document.getElementById('famt').value;
var fee= document.getElementById('cfee').value;
var fam= Number( amt  / (1 + Number(fee/100))) ;

    var rand=Math.floor(Math.random() * 10380);
    initializePayWithUfitPay({
            resource: "paymentlink",
            payer_name: document.getElementById('cname').value, 
            payer_email: document.getElementById('cemail').value,
            amount: fam,
            customer_identifier: "123456",
            reference: "1234"+rand+"bcdef",
            validity: "30",
            service_code: "wallet",
            callback_url: "https://eniw55khswklqp8.m.pipedream.net",
            return_url: "https://example.com/thank_you_page",
            callback_function: "handleCallback"
        });
   }
else{
    document.getElementById('failtext').innerHTML='minimum N1,000';
failm.show();     
}


    
    /* Create a javaScript function to handle callback events */
   
    
}
 function handleCallback(data){
        console.log("Payment reference: "+data.reference+", Payment status: "+data.event+", Status message: "+data.status);
        if(data.event=="completed") {
             document.getElementById('passtext').innerHTML='Deposit successful';
passm.show();
        } else {
          document.getElementById('failtext').innerHTML='something went wrong';
failm.show();  
        }
    }

    function sinv (plan,amt,g,m){

        var data="action=sinv&plan="+plan+"&amt="+amt+"&get="+g+"&m="+m;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../dashboard/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {

                    if (xhr.responseText=="true") {
                         document.getElementById('passtext').innerHTML='Investment started';
passm.show();
                    }
                    else{

                        document.getElementById('failtext').innerHTML=xhr.responseText;
failm.show();  
                    }
     }
    
  xhr.send(data);

    }

