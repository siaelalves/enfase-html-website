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
//
/*FUNÇÕES*/
/**Avança para o próximo slide.*/
function nextSlide(){
 document.querySelectorAll(".backgroundPhoto").forEach(e=>{e.classList.add("scaleDown1")});
 
 document.querySelectorAll(".bkgColorWhite").forEach(e=>{e.style.opacity=1;});
 document.querySelector("#slide"+slide).classList.add("inactive");

 if(slide<slideQt){
  slide+=1;
  document.querySelectorAll(".backgroundPhoto").forEach(e=>{e.classList.remove("scaleDown1")});
  document.querySelectorAll(".bkgColorWhite").forEach(e=>{e.style.opacity=0;});
  document.querySelector("#slide"+slide).classList.remove("inactive");
  return;
 }
 if(slide==slideQt){
  slide=1;
  document.querySelectorAll(".backgroundPhoto").forEach(e=>{e.classList.remove("scaleDown1")});
  document.querySelectorAll(".bkgColorWhite").forEach(e=>{e.style.opacity=0;});
  document.querySelector("#slide"+slide).classList.remove("inactive");
  return;
 }
}