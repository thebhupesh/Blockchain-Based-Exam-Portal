// LOGIN FUNCTIONS

function password() {
    var x = document.getElementById("pwd");
    if(x.type === "password") {
        x.type = "text";
    }
    else {
        x.type = "password";
    }
}

function addHyphen(element) {
    let ele = document.getElementById(element.id);
    ele = ele.value.split('-').join('');
    let finalVal = ele.match(/.{1,4}/g).join('-');
    document.getElementById(element.id).value = finalVal;
}

// STUDENT FUNCTIONS

var timeoutHandle;
function counter() {
    var startTime = document.getElementById('timer').innerHTML;
    var pieces = startTime.split(":");
    if(pieces[0] == "00" && pieces[1] == "00" && pieces[2] == "00") {
        alert("Time Out!!!\nSubmitting Answers...");
        finish();
    }
    if(pieces[0] == "00" && pieces[1] == "02" && pieces[2] == "00") {
        alert("You have only 2 minutes left.\nHurry!!!");
    }
    var time = new Date();
    time.setHours(pieces[0]);
    time.setMinutes(pieces[1]);
    time.setSeconds(pieces[2]);
    var timedif = new Date(time.valueOf() - 1000);
    var newtime = timedif.toTimeString().split(" ")[0];
    document.getElementById('timer').innerHTML=newtime;
    timeoutHandle=setTimeout(counter, 1000);
}

var count = '0';
function change(cnt) {
    var xhttp;
    count = cnt;
    if (cnt == "") {
        document.getElementById("question").innerHTML = "";
        return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("question").innerHTML = this.responseText;
            var ques = document.getElementsByName(cnt);
            ques[0].style.backgroundColor = "darkred";
            ques[0].style.color = "#FFFFFF";
            check();
        }
    };
    xhttp.open("GET", "change_ques.php?count="+cnt+"&pid="+pid+"&id="+id, true);
    xhttp.send();
}

var aarr = [];
for(var i=0; i<10; i++) {
    aarr[i] = 0;
}
function submit(){
    var option = document.getElementsByName("option");
    var q, flag = 0;
    for(var i=0; i<option.length; i++) {
        if(option[i].checked == true) {
            var piece = option[i].value.split(":");
            q = piece[0];
            aarr[parseInt(q)] = (parseInt(piece[1])+1);
            console.log(aarr);
            var ques = document.getElementsByName(q);
            ques[0].style.backgroundColor = "darkgreen";
            ques[0].style.color = "#FFFFFF";
            flag = 1;
        }
    }
    if(flag==0) {
        alert("No option selected.");
    }
    if(q!='9' && flag==1) {
        change(parseInt(q)+1);
    }
}

function check() {
    for(var i=0; i<aarr.length; i++) {
        if(i==parseInt(count)) {
            if(aarr[i]===0) {
                break;
            }
            else {
                document.getElementById(aarr[i]-1).checked = true;
                var ques = document.getElementsByName(count);
                ques[0].style.backgroundColor = "darkgreen";
                ques[0].style.color = "#FFFFFF";
            }
        }
    }
    if(count=='9') {
        document.getElementById("finish").disabled = false;
    }
}

function finish() {
    let current = new Date();
    let cDate = current.getFullYear() + '-' + (current.getMonth() + 1) + '-' + current.getDate();
    let cTime = current.getHours() + ":" + current.getMinutes() + ":" + current.getSeconds();
    let dateTime = cDate + ' ' + cTime;
    sendData();
    $.ajax({
        method: "POST",
        url: "answer_submit.php",
        data: {
            pid: pid,
            id: id,
            timeStamp: dateTime
        },
        success: function() {
            alert("Answers Submitted Successfully!!!");
            window.location.href = "login.html";
        }
    });
}

function sendData() {
    var contract;
    $(document).ready(function() {
        web3 = new Web3(web3.currentProvider);
        var address = "0xEE76865461e11f16087C9aD384F4E0Da05B09F09";
        var abi = [
            {
                "inputs": [
                    {
                        "internalType": "string",
                        "name": "_pid",
                        "type": "string"
                    },
                    {
                        "internalType": "string",
                        "name": "_id",
                        "type": "string"
                    }
                ],
                "name": "getAnswer",
                "outputs": [
                    {
                        "internalType": "uint256[]",
                        "name": "temp",
                        "type": "uint256[]"
                    }
                ],
                "stateMutability": "view",
                "type": "function"
            },
            {
                "inputs": [
                    {
                        "internalType": "string",
                        "name": "_pid",
                        "type": "string"
                    },
                    {
                        "internalType": "string",
                        "name": "_id",
                        "type": "string"
                    },
                    {
                        "internalType": "uint256[]",
                        "name": "_arr",
                        "type": "uint256[]"
                    }
                ],
                "name": "submitAnswer",
                "outputs": [],
                "stateMutability": "nonpayable",
                "type": "function"
            }
        ];
        contract = new web3.eth.Contract(abi, address);
        web3.eth.getAccounts().then(function(accounts) {
			var acc = accounts[0];
			return contract.methods.submitAnswer(pid,id,aarr).send({from: acc});
		}).then(function(tx) {
			console.log(tx);
		}).catch(function(tx) {
			console.log(tx);
		})
    })
}

// FACULTY FUNCTIONS

function initiate() {
    for(var i=0; i<10; i++) {
        appendQuestion();
    }
}

var c = 0;
function appendQuestion(){
    c++;
    var div = document.createElement("div");
    var id = "Q"+c.toString();
    div.id = id;
    document.getElementById('form').appendChild(div);
    var br = document.createElement("br");
    document.getElementById(id).appendChild(br);
    var question = document.createElement("p");
    question.id = "title";
    question.innerText = "Question "+c;
    document.getElementById(id).appendChild(question);
    var input = document.createElement("textarea");
    input.className = "w3-input w3-section w3-border";
    input.type = "text";
    input.placeholder = "Enter question "+c;
    input.name = "q"+c.toString();
    input.rows = 2;
    document.getElementById(id).appendChild(input);
    for(var i=0;i<4;i++) {
        var option = document.createElement("textarea");
        option.className = "w3-input w3-section w3-border";
        option.type = "text";
        option.placeholder = "Enter option "+(i+1);
        option.rows = 1;
        option.name = c.toString()+":"+i.toString();
        document.getElementById(id).appendChild(option);
    }
}

function deleteQuestion() {
    if(c==10) {
        alert("Minimum 10 questions needed.");
    }
    else {
        var q = document.getElementById("Q"+c.toString());
        document.getElementById('form').removeChild(q);
        c--;
    }
}

function validateForm() {
    var flag = true;
    for(var i=1; i<=c; i++) {
        var name = "q"+i.toString();
        var x = document.forms["form"][name].value;
        if(x == "") {
            var msg = "Question "+i+" is empty."
            alert(msg);
            flag = false;
            break;
        }
        else {
            for(var j=0; j<4; j++) {
                var name = i.toString()+":"+j.toString();
                var x = document.forms["form"][name].value;
                if(x == "") {
                    var msg = "Option "+(j+1)+" in question "+i+" is empty."
                    alert(msg);
                    flag = false;
                    break;
                }
            }
        }
        if(flag==false) {
            break;
        }
    }
    return flag;    
}

function submitQuestions() {
    var flag = validateForm();
    if(flag==true) {
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = "count";
        input.value = c;
        document.getElementById('form').appendChild(input);
        document.form.submit();
    }
}

function getStudents(pid) {
    var xhttp;
    if (pid == "") {
        document.getElementById("students").innerHTML = "";
        return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("evaluate").style.display = 'block';
            document.getElementById("students").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "evaluate.php?pid="+pid+"&type=initiate", true);
    xhttp.send();
}

var anarr = [];
function answer() {
    var contract;
    $(document).ready(function() {
        web3 = new Web3(web3.currentProvider);
        var address = "0xEE76865461e11f16087C9aD384F4E0Da05B09F09";
        var abi = [
            {
                "inputs": [
                    {
                        "internalType": "string",
                        "name": "_pid",
                        "type": "string"
                    },
                    {
                        "internalType": "string",
                        "name": "_id",
                        "type": "string"
                    }
                ],
                "name": "getAnswer",
                "outputs": [
                    {
                        "internalType": "uint256[]",
                        "name": "temp",
                        "type": "uint256[]"
                    }
                ],
                "stateMutability": "view",
                "type": "function"
            },
            {
                "inputs": [
                    {
                        "internalType": "string",
                        "name": "_pid",
                        "type": "string"
                    },
                    {
                        "internalType": "string",
                        "name": "_id",
                        "type": "string"
                    },
                    {
                        "internalType": "uint256[]",
                        "name": "_arr",
                        "type": "uint256[]"
                    }
                ],
                "name": "submitAnswer",
                "outputs": [],
                "stateMutability": "nonpayable",
                "type": "function"
            }
        ];
        contract = new web3.eth.Contract(abi, address);
        contract.methods.getAnswer(atob(pid),atob(sid)).call().then(function(arr) {
            anarr = arr;
        })
    })
}

function review(val) {
    var xhttp;
    if (val.toString() == "") {
        document.getElementById("question").innerHTML = "";
        return;
    }
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("question").innerHTML = this.responseText;
            setTimeout(()=>{style(val)},100);
        }
    };
    xhttp.open("GET", "question_review.php?pid="+pid+"&sid="+sid+"&c="+val.toString(), true);
    xhttp.send();
}

function style(val) {
    if(anarr[val]!='0') {
        document.getElementById('question').style.backgroundColor = "white";
        document.getElementById('question').style.color = "#0F2653";
        document.getElementById(anarr[val]).style.fontSize = "22px";
        document.getElementById(anarr[val]).style.color = "darkgreen";
        document.getElementById(anarr[val]).style.fontWeight = "bold";
    }
    else {
        document.getElementById('question').style.backgroundColor = "#C70900";
        document.getElementById('question').style.color = "white";
        document.getElementsByName('title')[0].style.color = "white";
    }
}
