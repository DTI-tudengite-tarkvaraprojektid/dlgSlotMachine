var modal_2 = document.getElementById("imgModal");
var img = document.getElementById("short");
var modalImg = document.getElementById("full");
var span = document.getElementsByClassName("exit")[0]

img.onclick = function(){
	modal_2.style.display = "block";
	modalImg.src = "img/scheme.png";
}
span.onclick = function(){
	modal_2.style.display = "none";
}