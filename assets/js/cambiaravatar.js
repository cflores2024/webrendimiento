btncambiaravatar.addEventListener("click",() => changeavatar.click());

changeavatar.addEventListener("change",(files)=>
{
    // console.log(files);
    var fileInput = document.getElementById('changeavatar');   
    var filename = fileInput.files[0];
    var id=document.getElementById("idpersona").value;
    var acc="M"; //Modificar imagen
 
    var form_data = new FormData();
    form_data.append("id", id);
    form_data.append("acc", acc);
    form_data.append("file", filename);

    $.ajax({
        url: "foto.php",
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data){
            // alert (data);
            document.getElementById("img1").innerHTML = data; 
            document.getElementById("img2").innerHTML = data; 
        }
    });
     
});

btneliminaravatar.addEventListener("click",()=>eliminaravatar());

function eliminaravatar()
{
   var filename = document.getElementById("imgfoto").value;
   var id=document.getElementById("idpersona").value;
   var acc="B"; //Modificar imagen
 
   //alert (id +"-"+ filename +"-"+ acc);
   //console.log(id +"-"+ filename);
   
   var form_data = new FormData();
       form_data.append("id", id);
       form_data.append("acc", acc);
       form_data.append("srcimg", filename);
   
    $.ajax({
        url: "foto.php",
        dataType: 'script',
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(data){
           // alert (data);
            document.getElementById("img1").innerHTML = data; 
            document.getElementById("img2").innerHTML = data; 
        }
    });
    
}