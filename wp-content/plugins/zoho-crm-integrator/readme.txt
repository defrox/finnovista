=== CRM Integrator ===
Contributors: wp_candyman
Donate link: http://databytebank.com/
Tags: zoho, crm, contact form 7, contact, contact form, cf7, form, web form,wp contact form,wp form,wordpress form,wordpress contact form, send email, email, feedback, feedback form, short code
Requires at least: 3.2.1
Tested up to: 4.3.1
Stable tag: 1.3.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple wordpress plugin to integrate Wordpress with Zoho CRM. This plugin will help you to insert a pre-built lead form in any page or post.

== Description ==

A simple wordpress plugin to integrate Wordpress with Zoho CRM. This plugin will help you to insert a form in any page or post by inserting a short code "[zoholead]".
Plugin supports the following fields in the form
Company,First Name,Last Name,Email,Title,Phone,Fax,Mobile,Comments.Last Name and Company are mandatory fields as they are required to create the lead in Zoho CRM.

You can use the various attributes in the short code to enable the different features of the plugin.
For example to enable the recaptcha you can write the short code as  [zoholead recaptcha="enable"].

To send the form data to an email you can use the short code [zoholead sendemail="enable" recaptcha="enable"]

By default it will display all the fields in the form. To show only particular fields, you can use the short code  [zoholead sendemail="enable" recaptcha="enable" fields="first_name,last_name,email,phone"] where fields should contain the comma separated list of filed names. The various field names are company,first_name,last_name,email,title,phone,fax,mobile and comments.

 The form data will be used to insert a record into the Zoho CRM Lead. The form fields to display can be set through the shortcode. The plugin supports recaptcha in the form to stop spam and there is an option to send the form data to an email using the php's mail function. The settings page can be accessed on the left side bar. For support <a href="http://databytebank.com/" target="_blank">visit plugin site</a>.

> <strong>Supports Contact Form 7</strong><br>
This plugin can now be integrated with Contact Form 7 plugin. Use the attribute 'contact_form7_id' to show a form done in Contact Form 7. For example [zoholead contact_form7_id="5"] , where 'contact_form7_id' is the id of the form. You can use the field names described above in the form.

Requirements:-

Plugin requires cURL php extension enabled. Plugin will use the php mail function to send emails without authentication.
For integrating with Contact Form 7 you have to install and activate Contact Form 7 plugin.


== Installation ==

1. Upload `zoho-crm-integrator` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the settings page of the plugin by clicking the 'Zoho CRM integrator' link under the wordpress settings menu in the left side bar.
4. Enter the Auth Token for your Zoho CRM account into the text filed provided.
5. You can generate the Auth Token after logging into your Zoho CRM account and visiting the link https://accounts.zoho.com/apiauthtoken/create?SCOPE=ZohoCRM/crmapi
6. You can insert the pre-built lead form into any post or page by inserting the short code '[zoholead]'

== Frequently Asked Questions ==


= What is Auth Token ? =

The Auth Token is user-specific and is a permanent token. It is required to make API calls to the Zoho CRM.


