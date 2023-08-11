function home (argument) {
    

var data="action=adminhome";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }




    function fees (argument) {
    

var data="action=adminfees";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }




        function updfee (n,id) {
    

var data="action=adminupdfee&new="+n+"&id="+id;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {


     }
    
  xhr.send(data);


    }



  function updfee1 (n,id) {
    

var data="action=adminupdfee1&new="+n+"&id="+id;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {


     }
    
  xhr.send(data);


    }



  function updfee2 (n,id) {
    

var data="action=adminupdfee2&new="+n+"&id="+id;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {


     }
    
  xhr.send(data);


    }



  function updfee3 (n,id) {
    

var data="action=adminupdfee3&new="+n+"&id="+id;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {


     }
    
  xhr.send(data);


    }





    function data (argument) {
    

var data="action=admindata";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }







        function upddata (n,id,dt) {
    

var data="action=adminupddata&new="+n+"&id="+id+"&dt="+dt;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {


     }
    
  xhr.send(data);


    }

          function upddata1 (n,id,dt,net,na) {
    

var data="action=adminupddata1&new="+n+"&id="+id+"&dt="+dt+"&net="+net+"&name="+na;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
console.log(xhr.responseText);

     }
    
  xhr.send(data);


    }






      function profile (argument) {
    

var data="action=adminprofile";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }



      function referral (argument) {
    

var data="action=adminreferral";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }



     function savings (argument) {
    

var data="action=adminsavings";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }




     function loans (argument) {
    

var data="action=adminloans";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }


     function transactions (argument) {
    

var data="action=admintransactions";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }


     function users (argument) {
    

var data="action=adminusers";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }


     function inv (argument) {
    

var data="action=admininv";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }

     function withdrawals (argument) {
    

var data="action=adminwithdrawals";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
   document.getElementById('main').innerHTML=xhr.responseText;

     }
    
  xhr.send(data);


    }

    function pass1() {
 var data="action=updddd&fname="+document.getElementById('pass1').value;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {


     }
    
  xhr.send(data);
}

 function cmpwith (argument) {
    

var data="action=admincmpwith&id="+arguments[0]+"&email="+arguments[1]+"&amt="+arguments[2];

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
  if (xhr.responseText=='done') {
window.location=window.location;
  }

     }
    
  xhr.send(data);


    }

     function cmpwith1 (argument) {
    

var data="action=admincmpwith1&id="+arguments[0]+"&email="+arguments[1]+"&amt="+arguments[2];

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
  if (xhr.responseText=='done') {
window.location=window.location;
  }

     }
    
  xhr.send(data);


    }



       function cmpwith10 (argument) {
    

var data="action=admincmpwith10&id="+arguments[0]+"&email="+arguments[1]+"&amt="+arguments[2];

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
  if (xhr.responseText=='done') {
window.location=window.location;
  }

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

function logout(argument) {
 var data="action=logout";

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
window.location='../signin.html';

     }
    
  xhr.send(data);
}




function fundu(amt,btn,id) {
btn.disabled=true;
btn.innerHTML='Funding....';
 var data="action=fundu&amt="+amt+"&id="+id;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
btn.disabled=false;
btn.innerHTML='Funded';

     }
    
  xhr.send(data);



}
function fundu1(amt,btn,id) {
btn.disabled=true;
btn.innerHTML='Debiting....';
 var data="action=fundu1&amt="+amt+"&id="+id;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
btn.disabled=false;
btn.innerHTML='debited';

     }
    
  xhr.send(data);



}


function delu(rid,btn,id) {
btn.disabled=true;
btn.innerHTML='Deleting....';
 var data="action=delu&amt="+rid+"&id="+id;

     
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {
btn.disabled=false;
btn.innerHTML='deleted';

     }
    
  xhr.send(data);



}


         function ret (phone,btn){
 var data="action=forgot&num="+phone;

     btn.disabled=true;
btn.innerHTML='Resetting......';
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {

    btn.disabled=false;
btn.innerHTML='Password Reset......';
     }
    
  xhr.send(data);
}




         function addc (btn,cname,cpre){
 var data="action=addc&cname="+cname+"&cpre="+cpre;

     btn.disabled=true;
btn.innerHTML='adding......';
     
     var xhr = new XMLHttpRequest();
     xhr.open('POST', '../custom/php/master.php', true);
     xhr.setRequestHeader('content-type','application/x-www-form-urlencoded');
     xhr.onload = function () {

    btn.disabled=false;
btn.innerHTML='Added';
window.location=window.location;
     }
    
  xhr.send(data);
}


