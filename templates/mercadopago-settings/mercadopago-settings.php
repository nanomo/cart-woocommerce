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
		<div class="mp-block">
			<h2>Requisitos técnicos</h2>
			<div class="mp-inner-container">
				<div>
					<h4>SSL</h4>
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
					<h4>Extensões GD</h4>
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
					<h4>Curl</h4>
					<img class="mp-icon"
						src="<?php echo esc_url(plugins_url('../assets/images/mercadopago-settings/icon-info.png', plugin_dir_path(__FILE__))); ?>">
				</div>
				<div>
					<img class="mp-credential-input-success">
				</div>
			</div>
		</div>
		<div class="mp-block">
			<div class="mp-inner-container-settings">
				<div>
					<h2>Recebimentos e parcelamento</h2>
					<p>Escolha <span>quando quer receber o dinheiro</span> das vendas e se quer oferecer
						<span>parcelamento sem
							juros</span> aos clientes. </p>
				</div>
				<div>
					<button class="mp-button">Ajustar prazos e taxas </button>
				</div>
			</div>
		</div>
		<div class="mp-block">
			<div class="mp-inner-container-settings">
				<div>
					<h2>Dúvidas?</h2>
					<p>Revise o passo a passo de <span>como integrar o Plugin do Mercado Pago</span> no nosso site de
						desenvolvedores. </p>
				</div>
				<div>
					<button class="mp-button"> Manual do plugin </button>
				</div>
			</div>
		</div>
	</div>
	<hr class="mp-settings-hr" />
	<div class="mp-settings-credentials">
		<div>
			<p class="mp-settings-title">1. Insira suas credenciais</p>
			<p class="mp-settings-subtitle">Insira as credenciais e habilite sua loja para testes e vendas</p>
		</div>
		<div>
			<h2 class="mp-settings-subtitle">Não sabe suas credenciais?</h2>
			<h4 class="mp-settings-subtitle">Você pode conferir suas credenciais na sua conta de vendedor do Mercado.
			</h4>
			<button class="mp-button"> Conferir credenciais </button>
		</div>
		<div class="mp-block">
			<h2 class="mp-settings-subtitle">Não sabe suas credenciais?</h2>
			<h4 class="mp-settings-subtitle">Você pode conferir suas credenciais na sua conta de vendedor do Mercado.
			</h4>
		</div>
		<div class="mp-block">
			<h2 class="mp-settings-subtitle">Não sabe suas credenciais?</h2>
			<h4 class="mp-settings-subtitle">Você pode conferir suas credenciais na sua conta de vendedor do Mercado.
			</h4>
		</div>
		<button class="mp-button"> Salvar e continuar </button>
	</div>
</div>
