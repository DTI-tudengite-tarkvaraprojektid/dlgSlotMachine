<?php
session_start();

if(!isset($_SESSION["user"])){
    header("Location: login.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"]== "POST"){
    if(isset($_POST["logOut"])){
        $_SESSION["user"] = "";
        session_destroy();
        header("Refresh:0");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION["user"] ?></title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid black;
        padding: 5px;
    }

    th {text-align: left;}
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    let changeQueue = []
    let removeQueue = []

    $(document).ready(function () {
            getAll();
            document.getElementById("saveChangesButton").disabled = true
            document.getElementById("removeButton").disabled = true
        })

    function resizeBox(id){
        let targets = [document.getElementById(id+"slotContent"),document.getElementById(id+"slotDesc"),document.getElementById(id+"slotSentence")]
        if(targets[0].rows == "1" && targets[1].rows == "1" && targets[2].rows == "1"){
            for(let i=0; i<targets.length; i++){

                targets[i].rows = "5"
                targets[i].cols = "35"
            }
        }else{
            for(let i=0; i<targets.length; i++){
                console.log("toSmall")
                targets[i].rows = "1"
                targets[i].cols = "30"
            }
        }
    }

    function apostropheFix(target){
        let result = target
        if(target.includes("'")){
            result = target.replace(/'/g, "''")
            return result
        }else{
            return result
        }
    }

    function activationCheck(id){
        console.log(id)
        let acheck = document.getElementById(id+'active')
        if(acheck.value === 1 || acheck.value === true){
            //acheck.defaultChecked = true
            return true
        }else{
            //acheck.defaultChecked = false
            return false
        }
    }
    
     function getAll(){
         let xhr = new XMLHttpRequest()
         xhr.open("GET", "getAll.php", true)
         xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("recordTable").innerHTML = this.responseText;
            }
        };
         xhr.send()

     }

     function getAllRefresh(){
        $("#recordTable").load(location.href + " #recordTable");
        getAll()
    }

     function search(target){
         let xhr = new XMLHttpRequest()
         xhr.open("GET", "search.php?srch="+target, true)
         xhr.onreadystatechange = function() {
             if(this.readyState == 4 && this.status == 200){
                 document.getElementById("recordTable").innerHTML = this.responseText;
             }
             else{
             }
         }
         xhr.send()
     }

     function sqlDelete(target){
        document.getElementById("removeButton").disabled = true
        console.log(target)
        for(let i=0; i<target.length; i++){
            let xhr = new XMLHttpRequest()
            xhr.open("GET", "delete.php?did="+target[i], true)
            xhr.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200){
                document.getElementById("serverResponse").innerHTML = this.responseText;
                $("#"+target[i]).remove()
                getAllRefresh()
            }
            else{
            }
            }
            xhr.send()
        }
     }

     function activateChange(id){
        activateChButton()
         let match = 0
         for(let i=0; i<changeQueue.length; i++){
             if(changeQueue[i] === id){
                 match += 1
             }
         }
         if(match === 0){
            changeQueue.push(id)
         }
     }

     function activateRemove(id){
        activateReButton()
        let match = 0
        let temp = []
         for(let i=0; i<removeQueue.length; i++){
             if(removeQueue[i] === id){
                match += 1
             }else{
                temp.push(removeQueue[i])
                console.log(temp)
             }
         }
         if(match === 0){
            removeQueue.push(id)
         }else{
            removeQueue = []
            for(let i=0; i<temp.length; i++){
                removeQueue.push(temp[i])
            }
         }
     }
     function activateChButton(){
        document.getElementById("saveChangesButton").disabled = false
     }

     function activateReButton(){
         document.getElementById("removeButton").disabled = false
     }

     function change(id){
        document.getElementById("saveChangesButton").disabled = true
         for(let i = 0; i < id.length; i++){
            let xhr = new XMLHttpRequest()
            let type = document.getElementById(id[i]+"slotType").value
            type = apostropheFix(type)
            let content = document.getElementById(id[i]+"slotContent").value
            content = apostropheFix(content)
            let desc = document.getElementById(id[i]+"slotDesc").value
            desc = apostropheFix(desc)
            let sentence = document.getElementById(id[i]+"slotSentence").value
            sentence = apostropheFix(sentence)
            let active = document.getElementById(id[i]+"active").checked
            console.log(content)
            if(active === true){
                active = 1
            }else{
                active = 0
            }
            xhr.open("GET", "change.php?id="+id[i]+"&type="+type+"&content="+content+"&desc="+desc+"&sent="+sentence+"&active="+active, true)
            xhr.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById("serverResponse").innerHTML = this.responseText;
                    if(active === 1){
                        document.getElementById(id[i]).style = ""
                    }else{
                        document.getElementById(id[i]).style = "background-color: red; opacity: 0.5;"
                    }
                }
                else{
                    console.log(this.responseText)
                }
            }
            xhr.send()
         }
     }
        // Kirjete lisamine
        function add(type, content, desc, sentence){
         if(type === "" || content === "" || desc === "" || sentence === ""){
             alert("Missing data!")
         }else{
            type = apostropheFix(type)
            content = apostropheFix(content)
            desc = apostropheFix(desc)
            sentence = apostropheFix(sentence)
            let xhr = new XMLHttpRequest()
            let active = 1
            xhr.open("GET", "add.php?type="+type+"&content="+content+"&desc="+desc+"&sent="+sentence+"&active="+active, true)
            xhr.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200){
                    document.getElementById("serverResponse").innerHTML = this.responseText;
                    getAllRefresh()
                }
                else{
                    console.log(this.responseText)
                    }
                }
            xhr.send()
            }
        }
    </script>
</head>
<body>
    <div id="serverResponse"></div>
    <div id="UI">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <button type="submit" name="logOut">Log Out</button>
    </form>
    <br>
	<div id="wrap">
      <div class="container">
        <div class="row">
            <form class="form-horizontal" action="import.php" method="post" name="upload_excel" enctype="multipart/form-data">
                
                    <!-- File Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="filebutton">Select File</label>
                        <div class="col-md-4">
                            <input type="file" name="file" id="file" class="input-large">
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                        <div class="col-md-4">
                            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                        </div>
                    </div>
               
            </form>
        </div>
	<br>
    <span>
    <span>
    <p>Title - % - means line break after the word (to separate words on slot)
Uploading the file - ; - between different types</p>
        <select id="typeOption">
	        <option value="">Select type...</option>
	        <option id="type "value="targetGroup">Target</option>
            <option id="type" value="problem">Need</option>
            <option id="type" value="genre">Genre</option>
            <option id="type" value="designElement">Design</option>
	        <option id="type" value="learningMethod">Learning</option>
	    </select>
        <input type="text" id="content" placeholder="Content...">
        <input type="text" id="desc" placeholder="Description...">
        <input type="text" id="sentence" placeholder="Sentence...">
        <button type="submit" onclick="add(document.getElementById('typeOption').value, document.getElementById('content').value, document.getElementById('desc').value, document.getElementById('sentence').value)">Add record</button>
        <br></br>
    </span>
        <input type="text" id="searchText" placeholder="Type, content, descr...">
        <button type="submit" onclick="search(document.getElementById('searchText').value)">Search</button>
        <button type="submit" onclick="getAllRefresh()">Get all</button>
        <button id="saveChangesButton" type="submit" onclick="change(changeQueue)">Save changes</button>
        <button id="removeButton" type="submit" onclick="sqlDelete(removeQueue)">Delete selected</button><br></br>
    </div>
    <div id="recordTable">
    </div>
    
</body>
</html>