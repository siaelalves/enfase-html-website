/*Copyright (c) 2024, Siael Alves*/
//
/**Ponteiro para o slide que está sendo exibido no momeneto.*/
let slide=1;
/**Quantidade de slides no site.*/
let slideQt=document.querySelectorAll(".slideIntro").length;
/**Determina se os slides devem ir até o final e depois voltar ao início ou não.*/
let slideLooping=true;
/**Determina se os slides devem avançar automaticamente.*/
let slideAutoPlay=true;
//
/*EVENTOS*/
document.querySelector("#navBtnRight").addEventListener("click",nextSlide);
document.querySelector("#navBtnLeft").addEventListener("click",previousSlide);
//
/*FUNÇÕES*/
/**Avança para o próximo slide.*/
function nextSlide(){ 
 document.querySelector(".bkgColorWhite").style.opacity=1;
 document.querySelector(".bkgColorWhite").style.zIndex=1;

 setTimeout(function(){
  document.querySelector("#slide"+slide).classList.add("inactive");
  if(slide<slideQt){
   slide+=1;
   document.querySelector("#slide"+slide).classList.remove("inactive");

    document.querySelector(".bkgColorWhite").style.opacity=0;
    document.querySelector(".bkgColorWhite").style.zIndex=0;
   return;
  }
  if(slide==slideQt){
   slide=1;
   document.querySelector("#slide"+slide).classList.remove("inactive");
    document.querySelector(".bkgColorWhite").style.opacity=0;
    document.querySelector(".bkgColorWhite").style.zIndex=0;
   return;
  }
 },1000)
}
/**Retorna pra o slide anterior*/
function previousSlide(){
 document.querySelector(".bkgColorWhite").style.opacity=1;
 document.querySelector(".bkgColorWhite").style.zIndex=1;

 setTimeout(function(){
  document.querySelector("#slide"+slide).classList.add("inactive");
  if(slide>1){
   slide-=1;
   document.querySelector("#slide"+slide).classList.remove("inactive");

    document.querySelector(".bkgColorWhite").style.opacity=0;
    document.querySelector(".bkgColorWhite").style.zIndex=0;
   return;
  }
  if(slide==1){
   slide=slideQt;
   document.querySelector("#slide"+slide).classList.remove("inactive");
    document.querySelector(".bkgColorWhite").style.opacity=0;
    document.querySelector(".bkgColorWhite").style.zIndex=0;
   return;
  }
 },1000)
}