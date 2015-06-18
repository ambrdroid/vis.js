window.setInterval(function(){
      $('.results').html('Particle Size: ' + partMult);
	particleSystem.material.size = partMult;
}, 15);