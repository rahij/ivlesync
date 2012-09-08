<?php session_start(); 
include 'constants.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>myIVLE</title>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
    var APIDomain = "https://ivle.nus.edu.sg/";
    var APIUrl = APIDomain + "api/lapi.svc/";
    var LoginURL = APIDomain + "api/login/?apikey=ihGIAwinPHivcEbzy7XE2&url=http%3A%2F%2Flocalhost%2Fivle%2Findex.php";

    var myModuleInfo = null;

    //function to get the query string parameters
    var search = function () {
        var p = window.location.search.substr(1).split(/\&/), l = p.length, kv, r = {};
        while (l--) {
            kv = p[l].split(/\=/);
            r[kv[0]] = kv[1] || true; //if no =value just set it as true
        }
        return r;
    } ();


    //variable to store the Authentication Token
    var Token = "";

    //check query string for search token
    if (search.token && search.token.length > 0 && search.token != 'undefined') {
        Token = search.token;
    }

    $(document).ready(function () {
        if (Token.length < 1) {
            window.location = LoginURL;
        }
        else {
            Populate_Module();
        }
    });


    function Populate_Module() {
        var ModuleURL = APIUrl + "Modules?APIKey=" + APIKey + "&AuthToken=" + Token + "&Duration=0&IncludeAllInfo=true&output=json&callback=?";

        //Get all the modules belonging to me
        jQuery.getJSON(ModuleURL, function (data) {
            myModuleInfo = data;


            var lbl_Module = "";
            for (var i = 0; i < data.Results.length; i++) {
                var m = data.Results[i];
                lbl_Module += m.CourseCode + " " + m.CourseAcadYear + " - " + m.CourseName;
                lbl_Module +=  "<br />";
                lbl_Module += m.ID + " ";
                Populate_Module_Timetable(m.ID,m.CourseCode);
            }
                         
        });
    $('body').append("<a href='test.php'>Click here after all your classes are populated</a>");
    }



    function Populate_Module_Timetable(ID,code)
    {
        var TimetableURL = APIUrl + "Timetable_Student_Module?APIKey=" + APIKey + "&AuthToken=" + Token + "&CourseID="+ ID +"&output=json&callback=?";

        jQuery.getJSON(TimetableURL, function (data) {
            
            myTimetableInfo = data;


            var lbl_timetable = "";
            for (var i = 0; i < data.Results.length; i++) {
                var m = data.Results[i];
                console.log(m);
                lbl_timetable += "<br />";
                lbl_timetable += code + " ";
                lbl_timetable += m.DayText + " ";
                lbl_timetable += m.LessonType + " ";
                lbl_timetable += m.StartTime + " ";
                lbl_timetable += m.EndTime + " ";
                lbl_timetable += m.WeekText + " ";

                var ajax_url="session.php?" + "id=" + ID + "&code=" + code + "&ltype=" + m.LessonType +"&week=" + m.WeekCode + "&venue=" + m.Venue + "&day=" + m.DayText
                              +"&startTime=" + m.StartTime + "&endTime=" + m.EndTime;

                  $.ajax({
                        url: ajax_url,
                        success: function(data) {
                          $('body').append(data);
                          }
                    });
                


                }
            $('#lbl_tt').append(lbl_timetable);
        });
    }







</script>

</head>
<body>

<h2>NUS Timetable Sync</h2>

<span id="lbl_tt"></span>
<br />

</body>
</html>