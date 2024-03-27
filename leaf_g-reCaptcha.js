////Configurações do Google reCaptcha
//A chave pública deve ser inserida no botão <input>, no atributo "data-sitekey"
let ativada=false; //Ativar o Google reCaptcha
let id_form=""; //id do formulário a ser protegido
let ocultar=false; //Mostrar ou ocultar o badge do reCaptcha no site
////
if(ativada==true){
 //Obtém o valor da chave pública inserida em input -> data-sitekey
 let btnEnviar=document.querySelector(".g-recaptcha");
 let chave_publica=btnEnviar.getAttribute("data-sitekey");
 function onSubmit(token) {
  let form=document.getElementById(id_form);
  //Verifica se os campos foram preenchidos corretamente
  if(form.checkValidity()==true){
   form.submit();
  }else{
   grecaptcha.reset();
   form.reportValidity();
   if(ocultar==true){ocultarBadge();}         
  }
 }
}
 function onClick(e) {
   e.preventDefault();
   grecaptcha.ready(function() {
     grecaptcha.execute(chave_publica, {action: 'submit'}).then(function(token) {
       //Insira sua lógica backend aqui
     });
   });
 }
 //Oculta o Badge
 function ocultarBadge(){
   let badge=document.querySelector(".grecaptcha-badge");
   badge.removeAttribute('style');
   badge.removeAttribute('data-style');
   badge.style.display='none';
 }
 function personalizarBadge(){
 //Insira as configurações de estilo para o badge do Google reCaptcha
 let badge=document.querySelector(".grecaptcha-badge");
 badge.removeAttribute('style');
 badge.removeAttribute('data-style');
 }