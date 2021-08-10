// when the JS file loads, it grabs the core JS moodle, jquery, jqueryui, and core ajax
// include these components in a function
require(["core/first","jquery","jqueryui","core/ajax"], function(core,$,bootstrap,ajax) {
    // below logic runs when document done loading
    $(document).ready(function(){
        
        
        // create a object called params that holds all the name-value pairs in the URL
        var params = {};
        window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){
            params[key] = value;
        })
        // if the parameter "month" exists, set the dropdown list to the selected value
        if (params["month"]){
            $("#month option[value=" + params["month"]+"]").attr("selected","selected");
        }
        // same thing for year
        if (params["year"]){
            $("#year option[value=" + params["year"]+"]").attr("selected","selected");
        }
        
        // when search is clicked (id of search), call searchusers()
        $("#search").click(function(){
            searchusers();
        });
        function searchusers(){
            console.log("searching users");
            window.open("/moodle/local/staffmanager/index.php?month=" + $("#month").val() + "&year=" + $("#year").val(), "_self");
        }
    });
});

