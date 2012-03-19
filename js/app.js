$(document).ready(function(){
 
    var counter = daten;
 
    $("#addButton").click(function () {
 
	if(counter>9){
            alert("Nur 9 Textboxen sind erlaubt!");
            return false;
	}   
 
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);
 
	newTextBoxDiv.html('<label>#'+ counter + ' </label>' + '<input type="text" name="link[]" id="link" value="" size="40" /><br />');
 
	newTextBoxDiv.appendTo("#TextBoxesGroup");
 
	counter++;
     });
 
     $("#removeButton").click(function () {
	if(counter==1){
          alert("Es gibt keine Felder mehr zum Entfernen");
          return false;
       }   
  
	counter--;
 
        $("#TextBoxDiv" + counter ).remove();
        
     });
 
     $("#getButtonValue").click(function () {
 
	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n #" + i + " " + $('#link' + i).val();
	}
    	  alert(msg);
     });
  
  
  
  });
