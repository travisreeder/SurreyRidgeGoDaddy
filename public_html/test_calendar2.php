<!DOCTYPE html>
<html>
<head>
    <title>Minimum Setup</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css" >
    <link rel="stylesheet" href="css/calendar.min.css">
</head>
<body>

    <h1>This is a test</h1>
    <div id="calendar"></div>


   
        
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    
    <script type="text/javascript" src="script/underscore-min.js"></script>
    <script type="text/javascript" src="script/calendar.js"></script>
    <script type="text/javascript" src="script/app.js"></script>
    <script type="text/javascript">
        var calendar = $("#calendar").calendar(
            {
                tmpl_path: "/tmpl/",
                events_source: function () { return []; }
            });         
    </script>
</body>
</html>