=== POP – Fatture Elettroniche & Generatore di Documenti Legali per eCommerce (ex-WooPop) ===
Contributors: popdev, Picaland, mirkolofio
Tags: fatturazione elettronica, fattura pdf, fattura elettronica, fattura xml
Requires at least: 4.6
Tested up to: 6.6
Stable tag: 3.3.3
Requires PHP: 5.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Con il plugin POP generi la fattura elettronica in formato XML direttamente da WooCommerce, pronta per il tuo commercialista o per il tuo gestionale.

== Description ==

Con il plugin POP generi la fattura elettronica in formato XML direttamente dal tuo WooCommerce, pronta per il tuo commercialista o per il tuo account su Fatture in Cloud o Aruba Premium.

= Cosa mi permette di fare POP?: =
* Genera gli XML dai tuoi ordini fatti con Woocommerce (fino a 5 nella versione gratuita), l’unico formato essenziale per essere in regola con la fatturazione elettronica;
* Gestisci le fatture elettroniche per clienti in Italia, intra ed extra EU;
* Rendi l’invio al 100% automatico da Woocommerce al tuo account su Fatture in Cloud tramite <a href="https://wp-pop.com/woocommerce-fattureincloud-plugin/?ref=1&wp_free_plugin">l’add-on per fatture in cloud</a>;
* Se hai un account Aruba Premium puoi automatizzare l’invio tramite <a href="https://wp-pop.com/woocommerce-fatture-aruba-plugin//?ref=1&wp_free_plugin">l’addon per Aruba Premium</a>;
* Scegli tu se unificare o mantenere le numerazioni separate tra le fatture di Woocommerce e quelle del tuo gestionale di fatturazione (come Fatture in Cloud);
* Mostra i campi per selezionare il tipo di cliente, P.IVA, Codice Fiscale, Codice Univoco o Email PEC sul tuo sito.

= VERSIONE PREMIUM E ADD-ON: =
* <a href="https://wp-pop.com/woopop-acquista-ora/?ref=1&wp_free_plugin">POP Premium</a>
* <a href="https://wp-pop.com/woocommerce-fattureincloud-plugin/?ref=1&wp_free_plugin">Fatture in Cloud Plugin</a>
* <a href="https://wp-pop.com/woocommerce-fatture-aruba-plugin//?ref=1&wp_free_plugin">Fatture Aruba Premium Plugin</a> (solo per account <a href="https://business.aruba.it/fatturazione-elettronica/account-premium.aspx">Aruba Premium</a> o con delega)

= OPZIONI FATTURA: =
* Prefisso per il numero di fattura.
* Numero di zeri da inserire nel numero di fattura
* Numeratore automatico progressivo fattura
* Suffisso fattura
* Abilita/disabilita il campo PEC/Codice Univoco (solo per Azienda e Persona Fisica titolare di P.IVA)
* Abilita/disabilita il Codice fiscale (solo per Azienda e Persona Fisica titolare di P.IVA)
* Attiva l'invio della fattura PDF via mail ad ordine completato
* Visualizzazione fattura in HTML

= Codici Metodi di pagamento supportati per la fattura: =

* MP01 (Contanti) - payment method: default
* MP05 (Bonifico) - payment method: bacs
* MP02 (Assegno) - payment method: cheque
* MP08 (Carte di pagamento) - payment method: paypal, ppec_paypal, ppcp-gateway, stripe, xpay, soisy, igfs
* MP19 (SEPA Direct Debit) - payment method: stripe_sepa

= FUNZIONALITÀ PREVISTE NELLA VERSIONE PREMIUM =
1. Scaricare le fatture in formato XML senza alcun limite.
2. Generare la fattura elettronica nella sezione "Fatture XML" e in ogni singolo ordine.
3. Scaricare le fatture sul tuo computer singolarmente o in formato .zip
4. Attivare il controllo VIES per i clienti dell'Unione Europea (non Italiani).
5. Inviare le fatture allo SDI direttamente da WooCommerce tramite add-on per Fatture in cloud

= TESTED UP TO/TESTATO FINO ALLE VERSIONI: =
* WooCommerce v. 9.x.x

== Installation ==

Questa sezione descrive come installare il plugin e farlo funzionare.

1. Carica la cartella 'woopop-electronic-invoice-free' nella directory /wp-content/plugins/
2. Attiva <strong>POP – Fatture Elettroniche & Generatore di Documenti Legali per eCommerce (ex-WooPop)</strong> dalla pagina ‘Plugins’ di WordPress.

== Screenshots ==

== Requirements ==

PHP: >= 5.6
WordPress: >= 4.6

== Changelog ==

= 3.3.3 - 28/10/2024 =
Fix: string localization

= 3.3.2 - 11/10/2024 =
Update version

= 3.3.1 - 18/11/2023 =
Fix: toggleBillingCompany (receipt and reset event)

= 3.3.0 - 17/10/2023 =
* Add: XML tag ScontoMaggiorazione for discount
* Add: Support for High-Performance Order Storage
* Fix: choiceType method, icon for receipt (credit note)
* Fix: admin style

= 3.2.2 - 11/09/2023 =
* Fix: checkout validation (conditions)
* Fix: checkout process (conditions)

= 3.2.1 - 08/07/2023 =
* Fix: checkout invoice type empty check
* Fix: tax code billing field validation for association
* Fix: billing fields HTML Injection
* Add: support for WooCommerce 7.8.x

= 3.2.0 - 02/01/2023 =
* Fix: minor fix
* Add: support for WooCommerce 7.2.x
* Improve: moved general invoice options

= 3.1.3 - 28/11/2022 =
* Fix: sprintf() arguments

= 3.1.2 - 27/11/2022 =
* Fix: minor fix
* Add: support for WordPress 6.1.x
* Add: support for WooCommerce 7.1.x

= 3.1.1 - 28/10/2022 =
* Add: support for WooCommerce 7.x.x

= 3.1.0 - 20/10/2022 =
* Fix: wcOrderClassName class name check
* Add: support payment_method igfs Credit Card (PagOnline Imprese)

= 3.0.4 - 10/10/2022 =
* Fix: billing_company required if customer type is "company"
* Dev: Add filter hook invoice Field args "billing_invoice_field_args"

= 3.0.3 - 14/09/2022 =
* Add: support for WooCommerce 6.9.x
* Add: information and controls for the main options to configure

= 3.0.2 - 24/07/2022 =
* Fix: create xml query bug
* Add: support for WooCommerce 6.7.x

= 3.0.1 - 15/07/2022 =
* Fix: create pdf
* Fix: create pdf generate limit

= 3.0.0 - 24/06/2022 =
* Add: support for WordPress 6.0.x
* Add: support for WooCommerce 6.6.x
* Add: Download of XML invoices for the last 5 orders
* Fix: various style fix

= 2.0.4 - 25/05/2022 =
* Fix: list order XmlOrderListTable (unset order) if Invoice order not sent and order total is equal total refunded or order total is zero
* Add: support payment_method soisy
* Add: payment method info in the invoice table

= 2.0.3 - 24/05/2022 =
* Fix: filter_var support for PHP >= 8.1

= 2.0.2 - 22/05/2022 =
* Fix: optimization code and clear unnecessary
* Fix: filter_input, filter_var filter for PHP >= 8.1

= 2.0.1 - 21/05/2022 =
* Fix: Error due to missing file vendor

= 2.0.0 - 20/05/2022 =

* Dev: autoload psr-4
* Update: admin style
* Add: support for WooCommerce 6.5.x
* Add: support for WordPress 5.9.x

= 1.3.3 - 17/11/2021 =

* Fix: minor fix.
* Add: support for WooCommerce 5.9.x
* Add: support for WordPress 5.8.x

= 1.3.2 - 01/09/2021 =

* Add: support for WooCommerce 5.6.x
* Add: support for WordPress 5.8.x

= 1.3.1 - 12/05/2021 =

* Fix: minor fix and update description.

= 1.3.0 - 08/05/2021 =

* Add: support for WooCommerce 5.2.x
* Add: support for WordPress 5.7.x

= 1.2.0 - 30/03/2020 =

* Fix: support for WooCommerce 4.0.0

= 1.1.1 - 05/06/2019 =

* Fix: check on vat if you choose the receipt

= 1.1.0 - 08/05/2019 =

* Add: Receipt PDF template
* Add: Option to choose the type of document (invoice or receipt) in the checkout
* Tweak: Order/invoice list table layout

= 1.0.0 =
* Initial release
