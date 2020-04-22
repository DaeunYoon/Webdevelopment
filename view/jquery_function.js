function checkpw() {
    var pw = document.getElementById('PW').value;
    var pwch = document.getElementById('PWch').value;
    var ck = 0;
    var ck2 = 0;
    var i = 0;
    
    if (!pw) {
        alert("INPUT PW");
        document.getElementById("PW").focus();
        return false;
    }
    if (pw.length < 8) {
        alert("PW supposed to be from 8 to 15 characters");
        return false;
    }

    for (i = 0; i < pw.length; i++) {
        var c = pw.charAt(i);
        if ((c == '@' || c =='!' || c == '?')) {
            ck = 1;
            break;
        }
    }
    
    for (i = 0; i < pw.length; i++) {
        if ((pw.charCodeAt(i) < 0x5A && pw.charCodeAt(i) > 0x2f)) {
            ck2 = 1;
            break;
        }
    }

    if (ck == 0 || ck2 == 0) {
        alert("PW should has at least one special character( ? ! @ ) and number ");
        return false;
    }

    if (pw != pwch) {
        alert("PW not correct");
        document.getElementById("PW").focus();
        return false;
    } 
    else {
        alert("PW correct");
    }
    
    return true;
}

function ch_email() {
    var exptext = /^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/;
    if (exptext.test(document.getElementById("ID").value) != true) {
        alert('Email form is not correct');
        document.getElementById("ID").focus();
        document.getElementById("ns").value = "0";
        return false;
    }
    else {
        alert('Email form is correct ');
        document.getElementById("ns").value = "1"; //맞으면 1
        return true;
    }
}


function isZip(elem)
{
    if(elem.value === "") {
        alert('Zipcode Required');
        elem.focus();
        return false;
    }

    if(elem.value.match(/^[a-zA-Z]+\s[0-9]+$/)) {
        return true;
    }
    else {
        alert('Zip form is not valid (more than one letter + white space + more than one digit, max length = 5)');
        elem.focus();
        return false;
    }
}

function isString(elem,form)
{
    if(elem.value === ""){
        alert(form + ' Required');
        elem.focus();
        return false;
    }
    if(elem.value.match(/^[a-zA-Z]+$/)) {
        return true;
    }
    else {
        alert('Letters only allowed for ' + form);
        elem.focus();
        return false;
    }
}

function isNum(elem,form)
{
    if(elem.value === ""){
        alert(form + ' Required');
        elem.focus();
        return false;
    }
    if(elem.value.match(/^[0-9]+$/)) {
        return true;
    }
    else {
        alert('Digits only allowed for ' + form);
        elem.focus();
        return false;
    }
}

/*For Join.jsp*/
function validateForm(){

    if(document.getElementById('ns').value == '0') {
        alert('Please click Email check button');
        return false;
    }
    /*
    if(document.getElementById('state').value == '0') {
        alert('Please click PW check button');
        return false;
    }*/

    if(!isString(document.getElementById('name'), 'name'))
        return false;

    if(document.getElementById('addr1').value === "") {
        alert('Street addr1 Required');
        document.getElementById('addr1').focus();
        return false;
    }
    
    if(document.getElementById('addr2').value === "") {
        alert('Street addr2 Required');
        document.getElementById('addr2').focus();
        return false;
    }
    
    if(!isString(document.getElementById('city'), 'city'))
        return false;
    
    if(!isNum(document.getElementById('tel'), 'Telephone Number')) 
        return false;
    
    if(document.getElementsByName('type')[0].checked == false && document.getElementsByName('type')[1].checked == false) {
        alert('Select User type');
        return false;
    }
    

    return true;
}

/*for Sup_New_Posting*/
function isValidPost() 
{
    var a = document.getElementById("max");
    var b = document.getElementById("bedroom");
    var c = document.getElementById("price");
    var ch = true;
    if(isNaN(a.value)) {
        alert("Input Digits only for person");
        ch = false;
    }
    else {
        if(a.value <= 0) {
            alert("Person should bigger than 0 ");
            ch = false;
        }
    }
    if(isNaN(b.value)) {
        alert("Input digits for bed");
        ch = false;
    }
    else {
        if(b.value <= 0) {
            alert("Bed num should bigger than 0 ");
            ch = false;
        }			
    }
    
    if(isNaN(c.value)) {
        alert("Input digits for cost");
        ch = false;
    }
    else {
        if(c.value < 5000) {
            alert("cost should bigger than 5 Euro.");
            ch = false;
        }			
    }
    if(document.getElementById('addr1').value === "") {
        alert('Street addr1 Required');
        document.getElementById('addr1').focus();
        ch = false;
    }
    
    if(document.getElementById('addr2').value === "") {
        alert('Street addr2 Required');
        document.getElementById('addr2').focus();
        ch = false;
    }
    
    if(!isZip(document.getElementById('zip')))
        ch = false;
    
    if(!isString(document.getElementById('city'), 'city'))
        ch = false;
    
    if(ch)
        return true;
    else
        return false;
}

/*For logout*/
function logout()
{
    var conf = confirm("Do you want to logout ? ");
    //확인
    if (conf) {
        location.href = "/../project/controller/LogoutManager.php";
    }
    //취소
    else {
        //이전으로 돌아가기
    }
}