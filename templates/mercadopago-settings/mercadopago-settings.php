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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="mp-settings">
	<div class="mp-settings-header">
		<div class="mp-settings-header-img"></div>
		<div class="mp-settings-header-logo"></div>
		<hr class="mp-settings-header-hr"/>
		<p>Aceite <b>pagamentos no ato</b> com<br/>
			toda a <b>segurança</b> Mercado Pago</p>
	</div>
	<div class="mp-settings-requirements">
		<div class="mp-container">
			<div class="mp-block mp-block-requirements mp-settings-margin-right">
				<p class="mp-settings-font-color mp-settings-title-requirements-font-size">Requisitos técnicos</p>
				<div class="mp-inner-container">
					<div>
						<p class="mp-settings-font-color mp-settings-subtitle-font-size">SSL</p>
						<label class="mp-settings-icon-info mp-settings-tooltip">
							<span class="mp-settings-tooltip-text"><p class="mp-settings-subtitle-font-size"><b>SSL</b></p>Implementação responsável pela transmissão de dados para o Mercado Pago de maneira segura e criptografada.</span>
						</label>
					</div>
					<div>
						<div id="mp-req-ssl" class="mp-settings-icon-success" style="filter: grayscale(1)"></div>
					</div>
				</div>
				<hr>
				<div class="mp-inner-container">
					<div>
						<p class="mp-settings-font-color mp-settings-subtitle-font-size">Extensões GD</p>
						<label class="mp-settings-icon-info mp-settings-tooltip">
							<span class="mp-settings-tooltip-text"><p class="mp-settings-subtitle-font-size"><b>Extensões GD</b></p>São extensões responsáveis pela implementação e funcionamento do Pix na sua loja.</span>
						</label>
					</div>
					<div>
						<div id="mp-req-gd" class="mp-settings-icon-success" style="filter: grayscale(1)"></div>
					</div>
				</div>
				<hr>
				<div class="mp-inner-container">
					<div>
						<p class="mp-settings-font-color mp-settings-subtitle-font-size">Curl</p>
						<label class="mp-settings-icon-info mp-settings-tooltip">
							<span class="mp-settings-tooltip-text"><p class="mp-settings-subtitle-font-size"><b>Curl</b></p>É uma extensão responsável pela realização de pagamentos via requests do plugin ao Mercado Pago.</span>
						</label>
					</div>
					<div>
						<div id="mp-req-curl" class="mp-settings-icon-success" style="filter: grayscale(1)"></div>
					</div>
				</div>
			</div>
			<div class="mp-block mp-block-flex mp-settings-margin-left mp-settings-margin-right">
				<div class="mp-inner-container-settings">
					<div>
						<p class="mp-settings-font-color mp-settings-title-font-size">Recebimentos e parcelamento</p>
						<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Escolha
							<b>quando quer receber o dinheiro</b> das vendas e se quer oferecer
							<b>parcelamento sem
								juros</b> aos clientes.
						</p>
					</div>
					<div>
					<a target="_blank" href="<?php echo esc_html($links['link_costs']); ?>"><button class="mp-button">Ajustar prazos e taxas</button></a>
					</div>
				</div>
			</div>
			<div class="mp-block mp-block-flex mp-block-manual mp-settings-margin-left">
				<div class="mp-inner-container-settings">
					<div>
						<p class="mp-settings-font-color mp-settings-title-font-size">Dúvidas?</p>
						<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Revise
							o passo a passo de <span>como integrar o Plugin do Mercado Pago</span> no nosso site de
							desenvolvedores. </p>
					</div>
					<div>
					<a target="_blank" href="<?php echo esc_html($links['link_guides_plugin']); ?>"><button class="mp-button mp-button-light-blue"> Manual do plugin</button></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<hr class="mp-settings-hr"/>
	<div class="mp-settings-credentials">
		<div class="mp-settings-title-align">
			<div class="mp-settings-title-container">
				<span class="mp-settings-font-color mp-settings-title-blocks mp-settings-margin-right">1. Integre a loja com o Mercado Pago</span>
				<img class="mp-settings-margin-left mp-settings-margin-right mp-settings-icon-success">
			</div>
			<div class="mp-settings-title-container mp-settings-margin-left">
				<img class="mp-settings-icon-open">
			</div>
		</div>
		<div class="mp-settings-block-align-top">
			<div>
				<p class="mp-settings-subtitle-font-size mp-settings-title-color">Para habilitar e testar e vendas, você
					deve <b>copiar e colar suas credenciais abaixo.</b></p>
			</div>
			<div>
			<a target="_blank" href="<?php echo esc_html($links['link_credentials']); ?>"><button class="mp-button mp-button-light-blue"> Consultar credenciais</button></a>
			</div>
			<div class="mp-container">
				<div class="mp-block mp-block-flex mp-settings-margin-right">
					<p class="mp-settings-title-font-size"><b>Credenciais de teste</b></p>
					<p class="mp-settings-label mp-settings-title-color mp-settings-margin-bottom">Habilitam os
						checkouts Mercado Pago para testes de compras na loja.</p>
					<fieldset class="mp-settings-fieldset">
						<legend class="mp-settings-label mp-settings-font-color">Public Key</legend>
						<input class="mp-settings-input mp-credential-feedback-positive" id="mp-public-key-test" type="text" value="<?php echo esc_html($options_credentials['credentials_public_key_test']); ?>" placeholder="Cole aqui sua Public Key">
					</fieldset>
					<fieldset>
						<legend class="mp-settings-label">Access token</legend>
						<input class="mp-settings-input mp-credential-feedback-positive" id="mp-access-token-test" type="text" value="<?php echo esc_html($options_credentials['credentials_access_token_test']); ?>" placeholder="Cole aqui seu Access Token" >
					</fieldset>
				</div>
				<div class="mp-block mp-block-flex mp-settings-margin-left">
					<p class="mp-settings-title-font-size"><b>Credenciais de produção</b></p>
					<p class="mp-settings-label mp-settings-title-color mp-settings-margin-bottom">Habilitam os
						checkouts Mercado Pago para receber pagamentos reais na loja.</p>
					<fieldset class="mp-settings-fieldset">
						<legend class="mp-settings-label">Public Key</legend>
						<input class="mp-settings-input mp-credential-feedback-positive" id="mp-public-key-prod" type="text" value="<?php echo esc_html($options_credentials['credentials_public_key_prod']); ?>" placeholder="Cole aqui seu Access Token">
					</fieldset>
					<fieldset>
						<legend class="mp-settings-label">Access token</legend>
						<input class="mp-settings-input mp-credential-feedback-positive" id="mp-access-token-prod" type="text" value="<?php echo esc_html($options_credentials['credentials_access_token_prod']); ?>" placeholder="Cole aqui seu Access Token">
					</fieldset>
				</div>
			</div>
			<button class="mp-button" id="mp-btn-credentials" > Salvar e continuar</button>
		</div>
	</div>

	<hr class="mp-settings-hr"/>
	<div class="mp-settings-credentials">
		<div class="mp-settings-title-align">
			<div class="mp-settings-title-container">
				<span class="mp-settings-font-color mp-settings-title-blocks mp-settings-margin-right">2. Personalize seu negócio</span>
				<img class="mp-settings-margin-left mp-settings-margin-right mp-settings-icon-success">
			</div>
			<div class="mp-settings-title-container mp-settings-margin-left">
				<img class="mp-settings-icon-open">
			</div>
		</div>
		<div class="mp-settings-block-align-top">
			<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Preencha as informações a seguir para ter uma melhor experiência e oferecer mais informações aos clientes</p>
			<div class="mp-container mp-settings-flex-start" id="block-two">
				<div class="mp-block mp-block-flex mp-settings-margin-right mp-settings-choose-mode">
					<div>
						<p class="mp-settings-title-font-size"><b>Informações sobre sua loja</b></p>
					</div>
					<div class="mp-settings-standard-margin">
						<fieldset>
							<legend class="mp-settings-label">Nome da sua loja nas faturas do cliente</legend>
							<input type="text" class="mp-settings-input" id="mp-store-identificator" placeholder= "Ex.:Loja da Maria" value="<?php echo esc_html($store_identificator); ?>">
						</fieldset>
						<span class="mp-settings-helper">Se o campo estiver vazio, a compra do cliente será identificada como Mercado Pago.</span>
					</div>
					<div class="mp-settings-standard-margin">
						<fieldset>
							<legend class="mp-settings-label">Identificação em Atividades do Mercado Pago</legend>
							<input type="text" class="mp-settings-input" id="mp-store-category-id" placeholder="Ex.:Loja da Maria" value="<?php echo esc_html($category_id); ?>">
						</fieldset>
						<span class="mp-settings-helper">Nas Ativades voce verá o termo inserido antes do númer o do pedido</span>
					</div>
					<div class="mp-settings-standard-margin">

						<label class="mp-settings-label mp-container">Categoria da loja</label>

						<select name="select" class="mp-settings-select" id="mp-store-categories">

						<?php
						for ( $i = 0; $i < count($categories_store['store_categories_description']); $i++ ) { // phpcs:ignore
								echo "<option value='" . esc_html($categories_store['store_categories_id'][$i])
								. "'" . esc_html(( $category_selected === $categories_store['store_categories_id'][$i] ) ? 'selected' : '' )
								. '>' . esc_html($categories_store['store_categories_description'][$i]) . '</option>';
						}
						?>
						</select>
						<span class="mp-settings-helper">Selecione ”Outro” caso não encontre uma categoria adequada.</span>
					</div>
				</div>

				<div class="mp-block mp-block-flex mp-block-manual mp-settings-margin-left">
					<div>
						<p class="mp-settings-title-font-size"><b>Opções avançadas de integração (opcional)</b></p>
					</div>
					<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">
						Para mais integração da sua loja com o Mercado Pago (IPN, Parceiros Certificados, Modo Debug)
					</p>
					<div>
						<p class="mp-settings-blue-text" id="options">
							Ver opções avançadas
						</p>
						<div class="mp-settings-advanced-options" style="display:none">
							<div class="mp-settings-standard-margin">
								<fieldset>

									<legend class="mp-settings-label">URL para IPN</legend>
									<input type="text" class="mp-settings-input" id="mp-store-url-ipn" placeholder="Ex.: https://examples.com/my-custom-ipn-url" value="<?php echo esc_html($url_ipn); ?>">
									<span class="mp-settings-helper">Insira a URL para receber notificações de pagamento. Confira mais informções nos <span class="mp-settings-blue-text"><a target="_blank" href="<?php echo esc_html($devsite_links['notifications_ipn']); ?>" >manuais.</a></span>
								</fieldset>
							</div>
							<div class="mp-settings-standard-margin">
								<fieldset>

									<legend class="mp-settings-label">integrator_id</legend>
									<input type="text" class="mp-settings-input" id="mp-store-integrator-id" placeholder="Ex.: 14987126498" value="<?php echo esc_html( $integrator_id ); ?>">
									<span class="mp-settings-helper">Se você é Parceiro certificado do Mercado Pago, não esqueça de inserir seu integrator_id.</span><br>
									<span class="mp-settings-helper">Se você não possui o código, <span class="mp-settings-blue-text"><a target="_blank" href="<?php echo esc_html($devsite_links['dev_program']); ?>"> solicite agora<span>.</a></span>

								</fieldset>
							</div>
							<div class="mp-container">
								<!-- Rounded switch -->
								<div>

									<label class="mp-settings-switch">
										<input type="checkbox" value="yes" id="mp-store-debug-mode" <?php echo esc_html(( 'yes' === $debug_mode ) ? 'checked' : ''); ?>>
										<span class="mp-settings-slider mp-settings-round"></span>
									</label>
								</div>
								<div class="mp-settings-margin-left">
									<p class="mp-settings-subtitle-font-size mp-settings-debug">
										Modo debug e log
									</p>
									<p class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color mp-settings-debug">
										Gravamos ações da sua loja para proporcionar melhor suporte.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<button class="mp-button" id="mp-store-info-save"> Salvar e continuar </button>
		</div>
	</div>

	<hr class="mp-settings-hr"/>
	<div class="mp-settings-payment">
		<div class="mp-settings-title-align">
			<div class="mp-settings-title-container">
				<span class="mp-settings-font-color mp-settings-title-blocks mp-settings-margin-right">3. Configure os meios de pagamento</span>
				<img class="mp-settings-margin-left mp-settings-margin-right mp-settings-icon-success">
			</div>

			<div class="mp-settings-title-container mp-settings-margin-left">
				<img class="mp-settings-icon-open">
			</div>
		</div>
		<div class="mp-settings-block-align-top">
			<p class="mp-settings-subtitle-font-size">Selecione um meio de pagamento a seguir para ver mais opções</p>
			<div class="mp-block mp-block-flex mp-settings-payment-block mp-settings-margin-right mp-settings-align-div">
				<div class="mp-settings-align-div">
					<div class="mp-settings-icon mp-settings-icon-mp"></div>
					<span class="mp-settings-subtitle-font-size mp-settings-margin-title-payment"><b>Checkout Pro</b> - Pix, débito, crédito e boleto, no ambiente do Mercado Pago</span>
					<span class="mp-settings-badge-active">Ativado</span>
				</div>
				<div class="mp-settings-title-align">
					<span class="mp-settings-text-payment">Configurar</span>
					<img class="mp-settings-icon-config">
				</div>
			</div>

			<div class="mp-block mp-block-flex mp-settings-payment-block mp-settings-margin-right mp-settings-align-div">
				<div class="mp-settings-align-div">
					<div class="mp-settings-icon mp-settings-icon-card"></div>
					<span class="mp-settings-subtitle-font-size mp-settings-margin-title-payment"><b>Débito e crédito</b> - Checkout Transparente, no ambiente da sua loja</span>
					<span class="mp-settings-badge-active">Ativado</span>
				</div>
				<div class="mp-settings-title-align">
					<span class="mp-settings-text-payment">Configurar</span>
					<img class="mp-settings-icon-config">
				</div>
			</div>
			<div class="mp-block mp-block-flex mp-settings-payment-block mp-settings-margin-right mp-settings-align-div">
				<div class="mp-settings-align-div">
					<div class="mp-settings-icon mp-settings-icon-code"></div>
					<span class="mp-settings-subtitle-font-size mp-settings-margin-title-payment"><b>Boleto e lotérica</b> - Checkout Transparente, no ambiente da sua loja</span>
					<span class="mp-settings-badge-inactive">Inativo</span>
				</div>
				<div class="mp-settings-title-align">
					<span class="mp-settings-text-payment">Configurar</span>
					<img class="mp-settings-icon-config">
				</div>
			</div>
			<div class="mp-block mp-block-flex mp-settings-payment-block mp-settings-margin-right mp-settings-align-div">
				<div class="mp-settings-align-div">
					<div class="mp-settings-icon mp-settings-icon-pix"></div>
					<span class="mp-settings-subtitle-font-size mp-settings-margin-title-payment"><b>Pix</b> - Checkout Transparente, no ambiente da sua loja</span>
					<span class="mp-settings-badge-inactive">Inativo</span>
				</div>
				<div class="mp-settings-title-align">
					<span class="mp-settings-text-payment">Configurar</span>
					<img class="mp-settings-icon-config">
				</div>
			</div>
			<button class="mp-button"> Continuar </button>
		</div>
	</div>
	<hr class="mp-settings-hr" />
	<div class="mp-settings-mode">
		<div class="mp-settings-title-align">
			<div class="mp-settings-title-container">
				<span class="mp-settings-font-color mp-settings-title-blocks mp-settings-margin-right">4. Teste sua loja antes de vender</span>
				<div class="mp-settings-test-mode-alert mp-settings-margin-left mp-settings-margin-right"><span>Loja em modo teste</span></div>
			</div>
			<div class="mp-settings-title-container mp-settings-margin-left">
				<img class="mp-settings-icon-open">
			</div>
		</div>
		<div class="mp-settings-block-align-top ">
			<p class="mp-settings-subtitle-font-size mp-settings-title-color">Teste a experiência no Modo Teste. Depois ative o Modo Vendas (Produção) para fazer vendas.</p>

			<div class="mp-container">
				<div class="mp-block mp-settings-choose-mode">
					<div>
						<p class="mp-settings-title-font-size"><b>Escolha como você quer operar sua loja:</b></p>
					</div>
					<div class="mp-settings-mode-container">
						<div class="mp-settings-mode-spacing">
							<input name="mp-test-prod" type="radio" class="mp-settings-radio-button" value='yes' <?php echo esc_html(( 'yes' === $checkbox_test_mode ) ? 'checked' : ''); ?> >
						</div>
						<div>
							<span class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-font-color">Modo Teste</span><br>

							<span class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Checkouts Mercado Pago inativos para cobranças reais.<span class="mp-settings-blue-text"> Regras do modo teste.<span></span>
						</div>
					</div>
					<div class="mp-settings-mode-container">
						<div class="mp-settings-mode-spacing">
							<input name="mp-test-prod" type="radio" class="mp-settings-radio-button" value='no' <?php echo esc_html(( 'no' === $checkbox_test_mode ) ? 'checked' : ''); ?>>
						</div>
						<div>
							<span class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-font-color">Modo Vendas (Produção)</span><br>

							<span class="mp-settings-font-color mp-settings-subtitle-font-size mp-settings-title-color">Mercado Pago ativos para cobranças reais.</span>
						</div>
					</div>
					<div class="mp-settings-alert-payment-methods">

						<div class="mp-settings-alert-payment-methods-orange"></div>
						<div class=" mp-settings-alert-payment-methods-gray">

							<div class="mp-settings-margin-right mp-settings-mode-style">
								<img class="mp-settings-icon-warning">

							</div>
							<div class="mp-settings-mode-warning">
								<div class="mp-settings-margin-left">
									<div class="mp-settings-alert-mode-title">
										<span>Meios de pagamento Mercado Pago em Modo Teste </span>
									</div>
									<div class="mp-settings-alert-mode-body">
										<span class="mp-settings-blue-text">Visite sua loja</span> para testar compras
									</div>
								</div>

							</div>
						</div>


					</div>
				</div>
			</div>
			<button class="mp-button" id="mp-store-mode-save"> Salvar Mudanças </button>
		</div>


	</div>

</div>
