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

if ( ! defined('ABSPATH') ) {
	exit;
}
?>

<div class="mp-settings">
	<div class="mp-settings-header">
		<img class="mp-settings-header-img"
			src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/header-settings.png', plugin_dir_path(__FILE__))); ?>">
		<img class="mp-settings-header-logo"
			src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/mercadopago-logo.png', plugin_dir_path(__FILE__))); ?>">
		<hr class="mp-settings-header-hr" />
		<p>Aceite <b>pagamentos no ato</b> com<br />
			toda a <b>segurança</b> Mercado Pago</p>
	</div>
	<div class="mp-container">
		<div class="mp-block mp-block-requirements">
			<p class="mp-settings-font-color mp-settings-title-requirements-font-size">Requisitos técnicos</p>
			<div class="mp-inner-container">
				<div>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size">SSL</p>
					<img class="mp-icon"
						src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/icon-info.png', plugin_dir_path(__FILE__))); ?>">
				</div>
				<div>
					<img class="mp-credential-input-success">
				</div>
			</div>
			<hr>
			<div class="mp-inner-container">
				<div>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size">Extensões GD</p>
					<img class="mp-icon"
						src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/icon-info.png', plugin_dir_path(__FILE__))); ?>">
				</div>
				<div>
					<img class="mp-credential-input-success">
				</div>
			</div>
			<hr>
			<div class="mp-inner-container">
				<div>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size">Curl</p>
					<img class="mp-icon"
						src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/icon-info.png', plugin_dir_path(__FILE__))); ?>">
				</div>
				<div>
					<img class="mp-credential-input-success">
				</div>
			</div>
		</div>
		<div class="mp-block mp-block-flex">
			<div class="mp-inner-container-settings">
				<div>
					<p class="mp-settings-font-color mp-settings-title-font-size">Recebimentos e parcelamento</p>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Escolha <b>quando quer receber o dinheiro</b> das vendas e se quer oferecer
						<b>parcelamento sem
							juros</b> aos clientes. </p>
				</div>
				<div>
					<button class="mp-button">Ajustar prazos e taxas </button>
				</div>
			</div>
		</div>
		<div class="mp-block mp-block-flex mp-block-manual">
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
			<p class="mp-settings-font-color mp-settings-title-blocks">1. Insira suas credenciais</p>
			<p class="mp-settings-subtitle">Insira as credenciais e habilite sua loja para testes e vendas</p>
		</div>
		<div>
			<p class="mp-settings-title">Não sabe suas credenciais?</p>
			<p class="mp-settings-subtitle">Você pode conferir suas credenciais na sua conta de vendedor do Mercado.</p>
			<button class="mp-button"> Conferir credenciais </button>
		</div>
		<div class="mp-container">
		<div class="mp-block">
			<p class="mp-settings-title">Credenciais de teste</p>
			<p class="mp-settings-subtitle">Com estas credenciais, você habilita seus checkouts Mercado Pago para poder testar compras na sua loja. </p>
		</div>
		<div class="mp-block">
			<p class="mp-settings-title">Credenciais de produção</p>
			<p class="mp-settings-subtitle">Com estas credenciais, você habilita seus checkouts Mercado Pago para receber pagamentos reais na sua loja.</p>
		</div>
		</div>
		<button class="mp-button"> Salvar e continuar </button>
	</div>
</div>
