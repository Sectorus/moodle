define(['jquery'], function($) {
   return {
        init: function() {
          //Moodle 3.9 compatible
          //$(".aalink").attr("target", "_blank");
          //Moodle 3.8 compatible
          $(".activityinstance").find("a").attr("target", "_blank");
        }
   };
});