<html>
<head>
    <title></title>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

	<script>

$(document).ready(function(){

alert("inicia");
// Serialize the form data
$(':button').click(function(){
    //var formData = $form.serialize();

alert("click");


var dataP = new FormData(); 
dataP.append('img', $("#imagen")[0].files[0]); 

//var dataP = "hola";

//var dataP = $("#imagen")[0].files[0];

    $.ajax({
        url: '/TestServer.php',
        type: 'POST',
        data: dataP,
        cache: false,
	//dataType: "html",
	//contentType: false,
    	//processData: false,
        success: function(data, textStatus, jqXHR)
        {
console.debug(data);
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
        },
        complete: function()
        {
            // STOP LOADING SPINNER
        }
    });
});


});
	</script>
 
<style type="text/css">
    .messages{
        float: left;
        font-family: sans-serif;
        display: none;
    }
    .info{
        padding: 10px;
        border-radius: 10px;
        background: orange;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .before{
        padding: 10px;
        border-radius: 10px;
        background: blue;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .success{
        padding: 10px;
        border-radius: 10px;
        background: green;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
    .error{
        padding: 10px;
        border-radius: 10px;
        background: red;
        color: #fff;
        font-size: 18px;
        text-align: center;
    }
</style>
</head>

<body>
    <!--el enctype debe soportar subida de archivos con multipart/form-data-->
        <label>Subir un archivo</label><br />
        <input name="archivo" type="file" id="imagen" /><br /><br />
        <input type="button" value="Subir imagen" /><br />
    <!--div para visualizar mensajes-->
    <div class="messages"></div><br /><br />
    <!--div para visualizar en el caso de imagen-->
    <div class="showImage"></div>
</body>
</html>
