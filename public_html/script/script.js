window.onload = function () {
//    $("#accordion").accordion({
//        collapsible: true,
//        heightStyle: "content",
//        navigation: false 
//    })

    //$("h4:nth-child(5)").css("border", "3px solid red")
    
//    $("#achievements").hide();
//    $("#qualification").hide();
//    $("#experience").hide();
//    $("#education").hide();
    
    $("#t1").click(function() {
        $("#achievements").toggle("fast");
    });
    
    $("#t2").click(function() {
        $("#qualification").toggle("fast");
    });
    
    $("#t3").click(function() {
        $("#experience").toggle("fast");
    });
    
    $("#t4").click(function() {
        $("#education").toggle("fast");
    });
    
               
//    $(window).scroll(
//    {
//        previousTop: 0
//    }, 
//    function () {
//    var currentTop = $(window).scrollTop();
//        if (currentTop < this.previousTop) {
//            //$(".sidebar em").text("Up");
//            $("#wrapper").show('slow');
//        } else {
//            //$(".sidebar em").text("Down");
//            $("#wrapper").hide('slow');
//        }
//        this.previousTop = currentTop;
//    });
    
//    $("#accordion1 a").click(function() {
//        //$("div p:first-child").css("border", "3px solid red");
//        //$((elem.next()).toggle("fast");
//        $("#accordion1").children().css("border", "3px solid red");
//    });
    $(document).ready(function(){ 
        $('#characterLeft').text('250 characters left');
        $('#message').keydown(function () {
            var max = 250;
            var len = $(this).val().length;
            if (len >= max) {
                $('#characterLeft').text('You have reached the limit');
                $('#characterLeft').addClass('red');
                $('#btnSubmit').addClass('disabled');            
            } 
            else {
                var ch = max - len;
                $('#characterLeft').text(ch + ' characters left');
                $('#btnSubmit').removeClass('disabled');
                $('#characterLeft').removeClass('red');            
            }
        });    
    });
    
    $(document).ready( function () {
        $('#visitors').dataTable( {
            "columns": [
            { "width": "15%" },
            { "width": "10%" },
            { "width": "10%" },
            { "width": "10%" },
            { "width": "10%" },
            { "width": "40%" },
            { "width": "5%" }
          ]
        }                         
    );
    } );
    
    $(document).ready( function () {
        $('#view_documents').dataTable( {
            "columns": [
            { "width": "20%" },
            { "width": "20%" },
            { "width": "30%" },
            { "width": "30%" }
          ]
        }                         
    );
    } );
    
     $(document).ready( function () {
        $('#view_documents2').dataTable( {
            "columns": [
            { "width": "20%" },
            { "width": "50%" },
            { "width": "30%" }
          ]
        }                         
    );
    } );
    
    $(document).ready( function () {
        $('#documents').dataTable( {
            "columns": [
            { "width": "14%" },
            { "width": "20%" },
            { "width": "25%" },
            { "width": "15%" },
            { "width": "5%" },
            { "width": "13%" },
            { "width": "8%" }
          ]
        }
    );
    } );

    $(document).ready( function () {
        $('#descriptionlist').dataTable( {
            "columns": [
            { "width": "5%" },
            { "width": "30%" },
            { "width": "50%" },
            { "width": "15%" }
          ]
        }
    );
    } );
    
    $(document).ready( function () {
        $('#calendar_events').dataTable( {
            "columns": [
            { "width": "10%" },
            { "width": "40%" },
            { "width": "10%" },
            { "width": "15%" },
            { "width": "15%" },
            { "width": "10%" }
          ]
        }
    );
    } );
    
    $(function () {
         $(".input-group.date").datepicker({ autoclose: true, todayHighlight: true });
    });

    function hide_marquee() {
//        $('#alert-marquee').hide();
        //alert('inside script.js hide marquee');
        $('body').css('padding-bottom', '50px');
        //$('.footer').css('color', 'green');
    };
    
    function show_marquee() {
//        $('#alert-marquee').show();
        //alert('inside script.js show marquee');
        $('body').css('padding-bottom', '105px');
        //$('.footer').css('color', 'red');
    };
    
    $('.selectpicker').selectpicker({
      size: 4
    });
    
    $(function() {
        $('#toggle-event').change(function(box) {
            $('#alert-marquee').toggle();
            var $check_parm = "checked="+(this.checked ? 1 : 0);
            if(this.checked) { hide_marquee(); } else { show_marquee(); };
            //alert($check_parm);
            $.ajax({
                type: "GET",
                url: "update_session.php",
                data: $check_parm,
                success: function(response) {}
            });
        })
    });
    
    
    
};

