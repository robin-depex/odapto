<div class="section" id="section5">
  <div class="sectionn5">
   <div class="container">
     <div class="row">
       <div class="col-sm-12">
         <div class="col-sm-8 col-sm-offset-2 text-center syns">
             <h2><strong>What are you waiting for?</strong></h2>
             <p class="syns">Sign up for free and become one of the millions of people around
the world who have fallen in love with Odapto. </p>
<div class="col-sm-4 col-sm-offset-4 text-center top">
       <a href="signup.php" class="btn btn-success" style="color: #fff">Sign up It`s Free</a>
       </div>
       <div class="clearfix"></div>
       <h4 class="text-center top">Already use Odapto?<span>
       <a href="login.php" style="color: #000">Log In</a></span></h4>
         </div>
       </div>
     </div>
   </div>
</div>
<div class="footer">
  <div class="container">
     <div class="row">
        <div class="col-sm-12 n-p">
          <div class="col-sm-10 col-sm-offset-1 text-center">
            <ul class="list-inline foot-link">
              <li><a href="https://www.odapto.com/tour.html">Tour</a></li> |
              <li><a href="https://www.odapto.com/pricing.html">Pricing</a></li> |
              <li><a href="#">Apps </a></li> |
              <li><a href="#">Blog </a></li> |
              <li><a href="#">Help</a></li> |
               <li><a href="#">Legal </a></li> 
            </ul>
            <p>© Copyright 2016, Odapto. All rights reserved.</p>
          </div>
        </div>
     </div>
    </div>
   </div>
  </div>  
</div>



<script src="js/wow.js"></script>
<script src="js/script.js"></script>
<script src="js/classie.js"></script>
<script src="js/phoneSlideshow.js"></script>
<script>


wow = new WOW(
{
animateClass: 'animated',
offset:       100,
callback:     function(box) {
console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
}
}
);
wow.init();
document.getElementById('moar').onclick = function() {
var section = document.createElement('section');
section.className = 'section--purple wow fadeInDown';
this.parentNode.insertBefore(section, this);
};



</script>




</body>
</html>