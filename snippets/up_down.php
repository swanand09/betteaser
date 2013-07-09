 <!DOCTYPE html>

 <html lang="en">
 <head>
   <title>Pushing elements up and down</title>
   <style>
   /* please externalize this code to an external
      .css file */
   div:first-of-type button.up {
     visibility: hidden;
   }
   div:last-of-type button.down {
     visibility: hidden;
   }
   </style>
 </head>
 <body>

 <h2>Click on the up and down buttons to move the rows</h2>

 <div>
   <button class="up">Up</button>
   <button class="down">Down</button>
   This was initially the first element.
 </div>
 <div>
   <button class="up">Up</button>
   <button class="down">Down</button>
   This was initially the second element.
 </div>
 <div>
   <button class="up">Up</button>
   <button class="down">Down</button>
   This was initially the third element.
 </div>
 <div>
   <button class="up">Up</button>
   <button class="down">Down</button>
   This was initially the fourth element.
 </div>
 <div>
   <button class="up">Up</button>
   <button class="down">Down</button>
   This was initially the fifth element.
 </div>

 <script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

 <script>
 // please externalize this code to an external .js file
 $(document).ready(function() {

   $('.up').click(function() {
   var parent = $(this).parent();
   parent.insertBefore(parent.prev());
   });
   $('.down').click(function() {
   var parent = $(this).parent();
   parent.insertAfter(parent.next());
   });

 });
 </script>
 </body>
</html>