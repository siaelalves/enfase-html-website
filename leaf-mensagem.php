<?php
////////////////////
//// Este script realiza a verificação do Google reCaptcha para evitar
//// spam nos formulários do site e enviar mensagens para um e-mail
//// especificado. Funciona apenas dentro de um servidor on-line.
//// Também possui um modelo de e-mail embutido.
////////////////////
///////////////////
//// Configurações
$chave_secreta='sua_chave_secreta';//Substituir pela sua chave secreta do Google Recaptcha
$autor_site="";//Será exibido no rodapé do e-mail
$email_destino="";//E-mail de destino para onde será enviada a mensagem do formulário
///////////////////
///////////////////
//// A partir daqui, você precisa configurar as ações de sucesso e falha do Google reCaptcha
//
//
//Verifica o código Captcha
if (isset($_POST['g-recaptcha-response'])) {
	$captcha = $_POST['g-recaptcha-response'];
} else {
	$captcha = false;
}

if (!$captcha) {
	//Ocorreu um erro
	header('Location: index.html#contato?captcha=erro01');
	die();
} else {
	$response=file_get_contents(
					"https://www.google.com/recaptcha/api/siteverify?secret=" . $chave_secreta . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
	);
	//decodificar a resposta
	$response=json_decode($response);
 //
	if($response->success === false){
		//Digite o que fazer caso a verificação falhe
		header('Location: index.html#captcha=erro02');
		die();
	}
}

//Neste ponto, o Captcha funcionou
//Filtrar o spam usando $response->score
if($response->success==true && $response->score <= 0.5){
	//Do something to denied access
	header('Location: index.html#contato?captcha=erro02');
	die();
}
if($response->success==true && $response->score >=0.5){
 ///////////////////
 ///////////////////
 //// A partir daqui, você precisa configurar as ações de sucesso e falha do envio da mensagem
	//Enviar o email
	//Obter os dados do formulário
 $nome = (isset($_POST['nome'])) ? $_POST['nome'] : '';
	$telefone = (isset($_POST['telefone'])) ? $_POST['telefone'] : '';
	$email = (isset($_POST['email'])) ? $_POST['email'] : '';
	$mensagem=(isset($_POST['mensagem'])) ? $_POST['mensagem'] : '';
	//Corpo do e-mail:
	$corpomensagem="
	<html>

 <style>
 @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100;0,9..40,400;0,9..40,700;1,9..40,400&display=swap');
	
	body{
		background-color:#000000;
		border-radius:10px;
	}
	main{
		border-radius:15px;
		border-style:solid;
		border-color:#FFFFFF;
		padding:15px;
	}
	.container{
	 width:100%;
	 height:auto;
	 display:flex;
	 flex-flow:column nowrap;
	 align-items:center;
	 justify-content:center;
	}
	.wrapper{
	 width:480px;
	 height:auto;
	 display:flex;
	 flex-flow:column nowrap;
	 align-items:flex-start;
	 justify-content:center;
	 border-radius: 15px;
	 padding: 12px;
	}
	
	header{
		text-align:center;
		display:flex;
		flex-flow:column nowrap;
		align-content:center;
		justify-content:center;
		align-items: center;
	}
	.logo-titulo{
	 width:100%;
		height:auto;
	}
	.logo{
	 width:40%;
		height:100%;
	}
	h1{
	 font-family: 'Arial Black';
	 font-weight:bolder;
	 font-size:1.6rem;
	 color: #FFFFFF;
	 text-align:center;
	}
	h2{
	 font-family:'Arial';
	 font-weight:bold;
	 color: #FFFFFF;
	 font-size:1.4rem;
	}
	.detalhes p{
	 margin-top:0px;
	}
	p,ul,li{
	 font-family:'Arial';
	 font-size:1.2rem;
	 color: #FFFFFF;
	 line-height:1.6rem;
	}
	ul li{
	 margin-bottom:16px;
	 background-color: #FFFFFF;
	 border-radius: 10px;
	 padding: 15px;
		list-style-type: none;
		color:#000000;
	}
	.logo img{
	 width:100%;
		height:auto;
	}
	
	article{
	 border-color:#FFFFFF;
	 border-width:2px;
	 border-style:solid;
		padding:15px;
	}
	article p{
	 text-indent:24px;
	}
	
	a{
	 text-decoration:none;		
	}
	ul{
		padding:0px;
	}
	ul li a{
	 text-decoration:none;
	 color:#FFFFFF;
	}
	
	footer{
	 padding:10px 0px;
	 width: 100%;
	}
	footer p{
		font-size:0.9rem;
	 color:#FFFFFF;
		text-align:center;
		text-align:center;
  margin:0px;
  line-height:1.3rem;		
	}
	footer a{
	 text-decoration:none;
		color:#7F0000;
	}
	</style>
	<body>
	 <div class='container'>	  
			<div class='wrapper'>			
			 <header>
					<img class='logo' src='assets/logo-02.png'/>
     <h1>VOCÊ RECEBEU UMA NOVA MENSAGEM DO SEU SITE</h1>
				</header>				
				<main>				
					<section>
						<p>Um visitante acessou a sua página de contato e lhe enviou uma mensagem.</p>
						<h2>INFORMAÇÕES DO VISITANTE</h2>
						<ul>
							<li><b>Nome: </b>$nome</li>
							<li><b>Telefone: </b>$telefone</li>
							<li><b>E-mail: </b>$email</li>
						</ul>						
						<p>A mensagem que ele deixou para você foi:</p>						
						<article>
							<p>$mensagem</p>
						</article>						
					</section>
				</main>				
				<footer>
					<p><b><i>Todos os direitos reservados.</i> © Copyright, $autor_site.</b></p>
					<p><b>Telefone: </b>(XX) XXXX-XXXX. <b>E-mail: </b>$email_destino</p>
				</footer>				
			</div>
		</div>
	</body>
</html>
";
	//Variáveis
	$data_envio = date('d/m/Y');
	$hora_envio = date('H:i:s');
	//enviar
	// emails para quem será enviado o formulário
	$emailenviar=$email_destino;	
	$destino = $emailenviar;
	$assunto = $_POST['selAss'] . " - Contato pelo Site";
	// É necessário indicar que o formato do e-mail é html
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
	$headers .= 'From: '.$nome.'<'.$email.'>';	
	//Exibir mensagem de erro ou sucesso
	try{
		$enviaremail = mail($destino, $assunto, $corpomensagem, $headers);
		if($enviaremail==false){
			$confirm=false;
			throw new emailnotsent($enviaremail);
		}else{
			$confirm=true;
			echo 'Mensagem enviada!';
			//Redirecionar para página de contato
			header('Location: index.html#contato?sucesso=true');
			die();
		}
	} catch (Throwable $t){
		$confirm=false;
		echo 'Mensagem não enviada!';
		//Redirecionar para página de contato
		header('Location: index.html#contato?sucesso=false');
		die();
	}
}//if
?>