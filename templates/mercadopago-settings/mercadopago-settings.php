<?php

/**
 * Part of Woo Mercado Pago Module
 * Author - Mercado Pago
 * Developer
 * Copyright - Copyright(c) MercadoPago [https://www.mercadopago.com]
 * License - https://www.gnu.org/licenses/gpl.html GPL version 2 or higher
 *
 * @package MercadoPago
 */

if (!defined('ABSPATH')) {
	exit;
}
?>

<div class="mp-settings">
	<div class="mp-settings-header">
		<img class="mp-settings-header-img" src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/header-settings.png', plugin_dir_path(__FILE__))); ?>">
		<img class="mp-settings-header-logo" src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/mercadopago-logo.png', plugin_dir_path(__FILE__))); ?>">
		<hr class="mp-settings-header-hr" />
		<p>Aceite <b>pagamentos no ato</b> com<br />
			toda a <b>segurança</b> Mercado Pago</p>
	</div>
	<div class="mp-container">
		<div class="mp-block mp-block-requirements mp-settings-margin-right">
			<p class="mp-settings-font-color mp-settings-title-requirements-font-size">Requisitos técnicos</p>
			<div class="mp-inner-container">
				<div>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size">SSL</p>
					<img class="mp-icon" src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/icon-info.png', plugin_dir_path(__FILE__))); ?>">
				</div>
				<div>
					<img class="mp-credential-input-success">
				</div>
			</div>
			<hr>
			<div class="mp-inner-container">
				<div>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size">Extensões GD</p>
					<img class="mp-icon" src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/icon-info.png', plugin_dir_path(__FILE__))); ?>">
				</div>
				<div>
					<img class="mp-credential-input-success">
				</div>
			</div>
			<hr>
			<div class="mp-inner-container">
				<div>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size">Curl</p>
					<img class="mp-icon" src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/icon-info.png', plugin_dir_path(__FILE__))); ?>">
				</div>
				<div>
					<img class="mp-credential-input-success">
				</div>
			</div>
		</div>
		<div class="mp-block mp-block-flex mp-settings-margin-left mp-settings-margin-right">
			<div class="mp-inner-container-settings">
				<div>
					<p class="mp-settings-font-color mp-settings-title-font-size">Recebimentos e parcelamento</p>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Escolha <b>quando quer receber o dinheiro</b> das vendas e se quer oferecer
						<b>parcelamento sem
							juros</b> aos clientes.
					</p>
				</div>
				<div>
					<button class="mp-button">Ajustar prazos e taxas </button>
				</div>
			</div>
		</div>
		<div class="mp-block mp-block-flex mp-block-manual mp-settings-margin-left">
			<div class="mp-inner-container-settings">
				<div>
					<p class="mp-settings-font-color mp-settings-title-font-size">Dúvidas?</p>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Revise o passo a passo de <span>como integrar o Plugin do Mercado Pago</span> no nosso site de
						desenvolvedores. </p>
				</div>
				<div>
					<button class="mp-button mp-button-light-blue"> Manual do plugin </button>
				</div>
			</div>
		</div>
	</div>
	<hr class="mp-settings-hr" />
	<div class="mp-settings-credentials">
		<div>
			<p class="mp-settings-font-color mp-settings-title-blocks">1. Integre a loja com o Mercado Pago</p>
			<div class="mp-settings-margin-right">
			<p class="mp-settings-subtitle-font-size">Para habilitar e testar e vendas, você deve <b>copiar e colar suas credenciais abaixo.</b></p>
			<button class="mp-button mp-button-light-blue"> Consultar credenciais </button>
		</div>
		<div class="mp-container">
		<div class="mp-block mp-block-flex mp-settings-margin-right">
			<p class="mp-settings-title-font-size"><b>Credenciais de teste</b></p>
			<p class="mp-settings-label">Habilitam os checkouts Mercado Pago para testes de compras na loja.</p>
			<fieldset>
				<legend clas="mp-settings-label">Public Key</legend>
				<input class="mp-settings-input" type="text" placeholder="Cole aqui sua Public Key">
			</fieldset>
			<fieldset>
			<legend clas="mp-settings-label">Access token</legend>
				<input class="mp-settings-input" type="text" placeholder="Cole aqui seu Access Token">
			</fieldset>
		</div>
		<div class="mp-block mp-block-flex mp-settings-margin-left">
			<p class="mp-settings-title-font-size"><b>Credenciais de produção</b></p>
			<p class="mp-settings-label">Habilitam os checkouts Mercado Pago para receber pagamentos reais na loja.</p>
			<fieldset>
			<legend clas="mp-settings-label">Public Key</legend>
				<input class="mp-settings-input" type="text" placeholder="Cole aqui seu Access Token">
			</fieldset>
			<fieldset>
			<legend clas="mp-settings-label">Access token</legend>
			<input class="mp-settings-input" type="text" placeholder="Cole aqui seu Access Token">
			</fieldset>
		</div>
		</div>
		<button class="mp-button"> Salvar e continuar </button>
	</div>

		<p class="mp-settings-font-color mp-settings-title-blocks">2. Personalize seu negócio</p>
		<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Preencha as informações a seguir para ter uma melhor experiência e oferecer mais informações aos clientes</p>

		<div class="mp-container">
			<div class="mp-block mp-block-flex mp-settings-margin-right" style="flex-direction:column; justify-content:space-between">
				<div>
					Informações sobre sua loja
				</div>
				<div>
					<fieldset>

						<legend class="mp-setting-label">Nome da sua loja nas faturas do cliente</legend>
						<input type="text" class="mp-settings-input">

					</fieldset>
				</div>
				<div>
					<fieldset>

						<legend class="mp-setting-label">Nome da sua loja nas faturas do cliente</legend>
						<input type="text" class="mp-settings-input">

					</fieldset>
				</div>
				<div>
					<fieldset>

						<p class="mp-settings-label">Nome da sua loja nas faturas do cliente</p>
						<input type="text" class="mp-settings-input">

					</fieldset>
				</div>
			</div>

			<div class="mp-block mp-block-flex mp-settings-margin-left">
				<div>
					Informações sobre sua loja
				</div>
				<div>
					<fieldset>

						<legend class="mp-setting-label">Nome da sua loja nas faturas do cliente</legend>
						<input type="text" class="mp-settings-input">

					</fieldset>
				</div>
				<div>
					<fieldset>

						<legend class="mp-setting-label">Nome da sua loja nas faturas do cliente</legend>
						<input type="text" class="mp-settings-input">

					</fieldset>
				</div>
				<div>
					<fieldset>

						<legend class="mp-setting-label">Nome da sua loja nas faturas do cliente</legend>
						<input type="text" class="mp-settings-input">

					</fieldset>
				</div>

			</div>
		</div>
	</div>
</div>
