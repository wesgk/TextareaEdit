<?php
session_start();
require_once 'config.php'; // DB connection
require_once 'companies.php'; // Companies class
require_once 'formhandler.php'; // Handles XMLHttpRequest calls
$db_conn = db_connect(); // Open persistent connection
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Descriptions</title>
</head>
<body>

<form name="updateDescriptionForm" id="updateDescriptionForm">
  <center>
  Edit company: 
  <select id="company">
    <option value="">Select a company to edit</option>
  <?php
    $companies = Companies::getAll();
    foreach($companies as $company) {
        print "<option value=".$company['id'].">";
        print $company['name'];
        print "</option>";
    }
  ?>
  </select>
  <br><br>
  <table border="1">
    <tr>
      <td valign="top">
        <label for="description" id="descriptionLabel">
          test1
        </label>
      </td>
      <td><textarea id="description" name="description"></textarea></td>
    </tr>
    <tr>
      <td>Add canned description 1</td>
      <td><img src="pencil.png" class="canned" data-num="1"></td>
    </tr>
    <tr>
      <td>Add canned description 2</td>
      <td><img src="pencil.png" class="canned" data-num="2"></td>
    </tr>
    <tr>
      <td>Add canned description 3</td>
      <td><img src="pencil.png" class="canned" data-num="3"></td>
    </tr>
    <tr>
      <td colspan="2"><center><input type="submit"></center></td>
    </tr>
  </table>
</form>

</body>
<script>

(function(){
  // Define canned & label text
  var cannedText = ['This is an A+ rated company', 'This is a B rated company', 'This is a C rated company'];
  var descriptionLabelText = ['Select a company to edit', 'Edit description for company [companyName]'];

  // Identify elements and variables 
  var id;
  var form = document.getElementById('updateDescriptionForm');
  var company = form.company; // select dropdown 
  var description = form.description; 
  var descriptionLabel = document.getElementById('descriptionLabel');
  var cannedIcons = document.getElementsByClassName('canned');

  // Initialize form label fields and canned text actions
  var initialize = function(){
    populateForm({ label: descriptionLabelText[0], description: '' });
    
    for(i = 0; i < cannedIcons.length; i++) {
        cannedIcons[i].onclick = function(evt) { addCannedText(evt); };
    }
  }

  // Handle on submit event
  form.onsubmit = function(event){ 
    update(event); 
    event.preventDefault();
    return false;
  }

  // Handle downdown change event
  company.onchange = function(){
    id = company.options[company.selectedIndex].value;
    if(id){ // If a company has been selected retrieve company record and populate form
      read(id, function(response){
        var obj = JSON.parse(response);
        populateForm({ label: descriptionLabelText[1].replace('[companyName]', obj.name), description: obj.description });
      });
    }else{ // If the default dropdown option is selected, reset form fields
      initialize();
    }
  };

  function populateForm(obj){
    description.value = obj.description;
    descriptionLabel.innerHTML = obj.label;
  }

  function addCannedText(evt) {
      var num = evt.target.dataset.num - 1; // Decrement value to accompany array stored strings
      var addText = cannedText[num];
      description.value = description.value + " " + addText;
  }

  function update(event){
    post("formhandler.php", "operation=update&id=" + id + "&description=" + description.value + "", function(response){
      console.log(response);
    });
  }

  function read(id, callback){
    post("formhandler.php", "operation=read&id=" + id + "", function(response){
      callback(response);
    });
  }

  function post(url, params, callback){ 
    var http = new XMLHttpRequest();
    http.open("POST", url, true);
    http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    http.onreadystatechange = function () { // Monitor status change
      // When both response is finished (4) && status is OK (200)
      if (http.readyState == 4 && http.status == 200){ 
        callback(http.responseText);
      }
    };
    http.send(params); // Go!
  }

  initialize(); // Set default form field values

})();

</script>
</html>