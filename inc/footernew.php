<div class="clearfix"></div>
<div class="footerNew">
  <div class="footerover"></div>
   <div class="container">
     <div class="row">
       <div class="col-sm-12">
         <div class="col-sm-4">
           <img class="img-responsive" src="images/logo.png">
           <ul>
          <li> +910000 000 000</li>
          <li> odapto@gmail.com</li>
         </ul>
          </div>
          <div class="col-sm-4">
            <h3>embedded build</h3>
           <ul>
            <li>Sales Managment system</li>
            <li>File Managment system</li>
            <li>Time Managment system</li>
            <li>Process Managment system</li>
            <li>Review Managment system</li>
           </ul> 
          </div>
             <div class="col-sm-3">
            <h3>Use cases</h3>
           <ul>
            <li>Private Bank</li>
            <li>Consulting</li>
            <li> Insurence</li>
             <li>Analytics</li>
            <li>IT Bussiness</li>
           </ul> 
           
          </div>
             <div class="col-sm-1">
            <h3>tour</h3>
           <ul>
            <li><a href="pricing.php">Pricing</a></li>
            <li>Apps</li>
            <li>Blog</li>
             <li>Help</li>
            <li>Legal</li>
            <li><a href="privacy_policy.php">Privacy Policy</a></li>
           </ul> 
           
          </div>
       </div>
     </div>
   </div>
</div>

<style type="text/css">
.atglance{
  position: relative;
  overflow: hidden;
}
div.a1 {
 position: absolute;
 z-index: -1;
 left: 0;
 top: 0;
    
}
div.a {
 position: absolute;
 z-index: -1;
 right: 0;
 bottom: 0;
 width: 100px;
    
}
</style>

<script type="text/javascript">
$(document).ready(function(){
    animateDiv();
    
});

function makeNewPosition(){
    
    // Get viewport dimensions (remove the dimension of the div)
    var h = $(".atglance").height() - 10;
    var w = $(".atglance").width() - 10;
    
    var nh = Math.floor(Math.random() * h);
    var nw = Math.floor(Math.random() * w);
    
    return [nh,nw];    
    
}

function animateDiv(){
    var newq = makeNewPosition();
    var oldq = $('.a').offset();
    var speed = calcSpeed([oldq.top, oldq.left], newq);
    $('.a').animate({ top: newq[0], left: newq[1] }, speed, function(){
      animateDiv();        
    });
    
};

function calcSpeed(prev, next) {
    var x = Math.abs(prev[1] - next[1]);
    var y = Math.abs(prev[0] - next[0]);
    var greatest = x > y ? x : y;
    var speedModifier = 0.2;
    var speed = Math.ceil(greatest/speedModifier);

    return speed;

}
</script>

<script src="js/wow.js"></script>
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