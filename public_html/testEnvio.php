<html>
<head>
<script src="/js/jquery.min.js"></script>
<script>

jso = {pwd : '1algoMAs', id_usuario : 85, usuario: 'nadan'};
 $.ajax({

            url:"https://192.168.15.240/test.php",

            type: "post",

            dataType: "json",

            data:  JSON.stringify(jso),

            cache: false,

            contentType : 'application/json; charset=utf-8'

        }).done(function(res){
		console.debug(res);
alert("listo");
	});

</script>
</head>
<body>
</body>
</html>
