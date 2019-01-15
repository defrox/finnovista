<?php
/*
Template Name: Download Page
*/
$custom_logo = get_post_meta(get_the_ID(), '_stag_custom_page_logo', true);
$dfx_title = '';
$file = $_REQUEST['file'];
$return_url = $_REQUEST['return'] ? $_REQUEST['return'] : "thank&#x2d;you";
$lang = $_REQUEST['lang'] ? $_REQUEST['lang'] : false;
$campaign = $_REQUEST['utm_campaign'] ? "<input type='text' style='display:none;' name='utm_campaign' value='" . $_REQUEST['utm_campaign'] . "'/>" : false;

$returnUrl = "http&#x3a;&#x2f;&#x2f;www.finnovista.com&#x2f;$return_url&#x2f;&#x3f;file&#x3d;" . rawurlencode($file) .
    ($campaign ? "&#x26;utm_campaign&#x3d;" . rawurlencode($_REQUEST['utm_campaign']) : "") .
    ($lang ? "&#x26;lang&#x3d;" . rawurlencode($_REQUEST['lang']) : "");
?>
<?php get_header(); ?>
    <script type="text/javascript">
        /*
        jQuery(document).ready(function ($) {
            jQuery('#logo img').each(function () {
                jQuery(this).attr("src", "<?php echo $custom_logo; ?>");
            //jQuery(this).css("margin-top", "10px");
            jQuery(this).parent().parent().find(".subtitle-text").css("display", "none");
        });
        jQuery('#logo a').each(function () {
            jQuery(this).attr("href", "<?php echo site_url() . ($_GET['lang'] != '' ? '?lang=' . $_GET['lang'] : ''); ?>");
        });
    });
    */

    </script>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class='hfeed download-'>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <p class="pubdate"></p>

            <h2 class="entry-title" style="display:none;"><?php the_title(); ?></h2>

            <div class="entry-content clearfix">
                <?php the_content(); ?>
            </div>

            <!-- Note :
               - You can modify the font style and form style to suit your website.
               - Code lines with comments “Do not remove this code”  are required for the form to work properly, make sure that you do not remove these lines of code.
               - The Mandatory check script can modified as to suit your business needs.
               - It is important that you test the modified form before going live.-->
            <div id='crmWebToEntityForm' class="dfxform clearfix">
                <META HTTP-EQUIV='content-type' CONTENT='text/html;charset=UTF-8'>
                <form action='https://crm.zoho.com/crm/WebToLeadForm' name='WebToLeads1481567000002594985' method='POST' onSubmit='javascript:document.charset="UTF-8"; return checkMandatory()'
                      accept-charset='UTF-8'>

                    <!-- Do not remove this code. -->
                    <input type='text' style='display:none;' name='xnQsjsdp' value='5bbd0d7ac19fe8aecff112a37dc69b45ad0f1c849d4db1e9882702c8980a17a0'/>
                    <input type='hidden' name='zc_gad' id='zc_gad' value=''/>
                    <input type='text' style='display:none;' name='xmIwtLD' value='0d6379c70c887ee0371a71992e27b8d968f63e1aa6846f330e0dd96aff7cc5ee'/>
                    <input type='text' style='display:none;' name='actionType' value='TGVhZHM='/>
                    <?php // /**/do_action('google_invre_render_widget_action'); ?>
                    <input type='text' style='display:none;' name='returnURL' value='<?= $returnUrl; ?>'/>
                    <?= $campaign; ?>
                    <!-- Do not remove this code. -->
                    <style>
                        tr, td {
                            padding: 6px;
                            border-spacing: 0px;
                            border-width: 0px;
                        }

                        .hentry {
                            max-width: 1200px !important;
                            position: relative;
                        }

                        .entry-content {
                            float: none;
                            width: 50%;
                        }

                        #crmWebToEntityForm.dfxform {
                            width: 420px;
                            margin: 50px auto auto;
                            float: right;
                            top: 0;
                            right: 0;
                            position: absolute;
                        }

                        .form-text {
                            padding-bottom: 40px;
                            font-size: 24px !important;
                            font-weight: bold;
                            text-align: center;
                        }

                        @media screen and (max-width: 969px) {
                            .entry-content {
                                float: none;
                                margin: auto;
                                max-width: 420px;
                                width: 100%;
                            }

                            #crmWebToEntityForm.dfxform {
                                float: none;
                                max-width: 420px;
                                width: 100%;
                                position: relative;
                                margin: 0 auto 40px auto;
                            }
                        }
                    </style>
                    <table style="margin: 0 20px 20px 0;">
                        <tr>
                            <th class="form-text" colspan="2"><?php echo get_post_meta($post->ID, 'dfx_download_form_text', true); ?></th>
                        </tr>

                        <tr>
                            <td style=""><?php _e('Email'); ?><span style='color:red;'>*</span></td>
                            <td style=""><input type='text' style='width:250px;' maxlength='100' name='Email'/></td>
                        </tr>

                        <tr>
                            <td style=""><?php _e('First Name'); ?><span style='color:red;'>*</span></td>
                            <td style='width:250px;'><input type='text' style='width:250px;' maxlength='40' name='First Name'/></td>
                        </tr>

                        <tr>
                            <td style=""><?php _e('Last Name'); ?><span style='color:red;'>*</span></td>
                            <td style='width:250px;'><input type='text' style='width:250px;' maxlength='80' name='Last Name'/></td>
                        </tr>

                        <tr>
                            <td style=""><?php _e('Company'); ?><span style='color:red;'>*</span></td>
                            <td style='width:250px;'><input type='text' style='width:250px;' maxlength='100' name='Company'/></td>
                        </tr>

                        <tr>
                            <td style=""><?php _e('Title'); ?><span style='color:red;'>*</span></td>
                            <td style='width:250px;'><input type='text' style='width:250px;' maxlength='100' name='Designation'/></td>
                        </tr>

                        <tr>
                            <td style=""><?php _e('Country'); ?><span style='color:red;'>*</span></td>
                            <td style='width:250px;'>
                                <select style='width:250px;' name='LEADCF5'>
                                    <option value='-None-'>-None-</option>
                                    <option value='Afghanistan'>Afghanistan</option>
                                    <option value='Albania'>Albania</option>
                                    <option value='Algeria'>Algeria</option>
                                    <option value='American&#x20;Samoa&#x20;&#x28;USA&#x29;'>American Samoa &#x28;USA&#x29;</option>
                                    <option value='Andorra'>Andorra</option>
                                    <option value='Angola'>Angola</option>
                                    <option value='Anguilla&#x20;&#x28;UK&#x29;'>Anguilla &#x28;UK&#x29;</option>
                                    <option value='Antigua&#x20;and&#x20;Barbuda'>Antigua and Barbuda</option>
                                    <option value='Argentina'>Argentina</option>
                                    <option value='Armenia'>Armenia</option>
                                    <option value='Aruba&#x20;&#x28;Netherlands&#x29;'>Aruba &#x28;Netherlands&#x29;</option>
                                    <option value='Australia'>Australia</option>
                                    <option value='Austria'>Austria</option>
                                    <option value='Azerbaijan'>Azerbaijan</option>
                                    <option value='Bahamas'>Bahamas</option>
                                    <option value='Bahrain'>Bahrain</option>
                                    <option value='Bangladesh'>Bangladesh</option>
                                    <option value='Barbados'>Barbados</option>
                                    <option value='Belarus'>Belarus</option>
                                    <option value='Belgium'>Belgium</option>
                                    <option value='Belize'>Belize</option>
                                    <option value='Benin'>Benin</option>
                                    <option value='Bermuda&#x20;&#x28;UK&#x29;'>Bermuda &#x28;UK&#x29;</option>
                                    <option value='Bhutan'>Bhutan</option>
                                    <option value='Bolivia'>Bolivia</option>
                                    <option value='Bosnia&#x20;and&#x20;Herzegovina'>Bosnia and Herzegovina</option>
                                    <option value='Botswana'>Botswana</option>
                                    <option value='Brazil'>Brazil</option>
                                    <option value='British&#x20;Virgin&#x20;Islands&#x20;&#x28;UK&#x29;'>British Virgin Islands &#x28;UK&#x29;</option>
                                    <option value='Brunei'>Brunei</option>
                                    <option value='Bulgaria'>Bulgaria</option>
                                    <option value='Burkina&#x20;Faso'>Burkina Faso</option>
                                    <option value='Burma'>Burma</option>
                                    <option value='Burundi'>Burundi</option>
                                    <option value='Cambodia'>Cambodia</option>
                                    <option value='Cameroon'>Cameroon</option>
                                    <option value='Canada'>Canada</option>
                                    <option value='Cape&#x20;Verde'>Cape Verde</option>
                                    <option value='Caribbean&#x20;Netherlands&#x20;&#x28;Netherlands&#x29;'>Caribbean Netherlands &#x28;Netherlands&#x29;</option>
                                    <option value='Cayman&#x20;Islands&#x20;&#x28;UK&#x29;'>Cayman Islands &#x28;UK&#x29;</option>
                                    <option value='Central&#x20;African&#x20;Republic'>Central African Republic</option>
                                    <option value='Chad'>Chad</option>
                                    <option value='Chile'>Chile</option>
                                    <option value='China'>China</option>
                                    <option value='Christmas&#x20;Island&#x20;&#x28;Australia&#x29;'>Christmas Island &#x28;Australia&#x29;</option>
                                    <option value='Cocos&#x20;&#x28;Keeling&#x29;&#x20;Islands&#x20;&#x28;Australia&#x29;'>Cocos &#x28;Keeling&#x29; Islands &#x28;Australia&#x29;</option>
                                    <option value='Colombia'>Colombia</option>
                                    <option value='Comoros'>Comoros</option>
                                    <option value='Cook&#x20;Islands&#x20;&#x28;NZ&#x29;'>Cook Islands &#x28;NZ&#x29;</option>
                                    <option value='Costa&#x20;Rica'>Costa Rica</option>
                                    <option value='Croatia'>Croatia</option>
                                    <option value='Cuba'>Cuba</option>
                                    <option value='Curacao&#x20;&#x28;Netherlands&#x29;'>Curacao &#x28;Netherlands&#x29;</option>
                                    <option value='Cyprus'>Cyprus</option>
                                    <option value='Czech&#x20;Republic'>Czech Republic</option>
                                    <option value='Democratic&#x20;Republic&#x20;of&#x20;the&#x20;Congo'>Democratic Republic of the Congo</option>
                                    <option value='Denmark'>Denmark</option>
                                    <option value='Djibouti'>Djibouti</option>
                                    <option value='Dominica'>Dominica</option>
                                    <option value='Dominican&#x20;Republic'>Dominican Republic</option>
                                    <option value='Ecuador'>Ecuador</option>
                                    <option value='Egypt'>Egypt</option>
                                    <option value='El&#x20;Salvador'>El Salvador</option>
                                    <option value='Equatorial&#x20;Guinea'>Equatorial Guinea</option>
                                    <option value='Eritrea'>Eritrea</option>
                                    <option value='Estonia'>Estonia</option>
                                    <option value='Ethiopia'>Ethiopia</option>
                                    <option value='Falkland&#x20;Islands&#x20;&#x28;UK&#x29;'>Falkland Islands &#x28;UK&#x29;</option>
                                    <option value='Faroe&#x20;Islands&#x20;&#x28;Denmark&#x29;'>Faroe Islands &#x28;Denmark&#x29;</option>
                                    <option value='Federated&#x20;States&#x20;of&#x20;Micronesia'>Federated States of Micronesia</option>
                                    <option value='Fiji'>Fiji</option>
                                    <option value='Finland'>Finland</option>
                                    <option value='France'>France</option>
                                    <option value='French&#x20;Guiana&#x20;&#x28;France&#x29;'>French Guiana &#x28;France&#x29;</option>
                                    <option value='French&#x20;Polynesia&#x20;&#x28;France&#x29;'>French Polynesia &#x28;France&#x29;</option>
                                    <option value='Gabon'>Gabon</option>
                                    <option value='Gambia'>Gambia</option>
                                    <option value='Georgia'>Georgia</option>
                                    <option value='Germany'>Germany</option>
                                    <option value='Ghana'>Ghana</option>
                                    <option value='Gibraltar&#x20;&#x28;UK&#x29;'>Gibraltar &#x28;UK&#x29;</option>
                                    <option value='Greece'>Greece</option>
                                    <option value='Greenland&#x20;&#x28;Denmark&#x29;'>Greenland &#x28;Denmark&#x29;</option>
                                    <option value='Grenada'>Grenada</option>
                                    <option value='Guadeloupe&#x20;&#x28;France&#x29;'>Guadeloupe &#x28;France&#x29;</option>
                                    <option value='Guam&#x20;&#x28;USA&#x29;'>Guam &#x28;USA&#x29;</option>
                                    <option value='Guatemala'>Guatemala</option>
                                    <option value='Guernsey&#x20;&#x28;UK&#x29;'>Guernsey &#x28;UK&#x29;</option>
                                    <option value='Guinea'>Guinea</option>
                                    <option value='Guinea-Bissau'>Guinea-Bissau</option>
                                    <option value='Guyana'>Guyana</option>
                                    <option value='Haiti'>Haiti</option>
                                    <option value='Honduras'>Honduras</option>
                                    <option value='Hong&#x20;Kong'>Hong Kong</option>
                                    <option value='Hungary'>Hungary</option>
                                    <option value='Iceland'>Iceland</option>
                                    <option value='India'>India</option>
                                    <option value='Indonesia'>Indonesia</option>
                                    <option value='Iran'>Iran</option>
                                    <option value='Iraq'>Iraq</option>
                                    <option value='Ireland'>Ireland</option>
                                    <option value='Isle&#x20;of&#x20;Man&#x20;&#x28;UK&#x29;'>Isle of Man &#x28;UK&#x29;</option>
                                    <option value='Israel'>Israel</option>
                                    <option value='Italy'>Italy</option>
                                    <option value='Ivory&#x20;Coast'>Ivory Coast</option>
                                    <option value='Jamaica'>Jamaica</option>
                                    <option value='Japan'>Japan</option>
                                    <option value='Jersey&#x20;&#x28;UK&#x29;'>Jersey &#x28;UK&#x29;</option>
                                    <option value='Jordan'>Jordan</option>
                                    <option value='Kazakhstan'>Kazakhstan</option>
                                    <option value='Kenya'>Kenya</option>
                                    <option value='Kiribati'>Kiribati</option>
                                    <option value='Kosovo'>Kosovo</option>
                                    <option value='Kuwait'>Kuwait</option>
                                    <option value='Kyrgyzstan'>Kyrgyzstan</option>
                                    <option value='Laos'>Laos</option>
                                    <option value='Latvia'>Latvia</option>
                                    <option value='Lebanon'>Lebanon</option>
                                    <option value='Lesotho'>Lesotho</option>
                                    <option value='Liberia'>Liberia</option>
                                    <option value='Libya'>Libya</option>
                                    <option value='Liechtenstein'>Liechtenstein</option>
                                    <option value='Lithuania'>Lithuania</option>
                                    <option value='Luxembourg'>Luxembourg</option>
                                    <option value='Macau&#x20;&#x28;China&#x29;'>Macau &#x28;China&#x29;</option>
                                    <option value='Macedonia'>Macedonia</option>
                                    <option value='Madagascar'>Madagascar</option>
                                    <option value='Malawi'>Malawi</option>
                                    <option value='Malaysia'>Malaysia</option>
                                    <option value='Maldives'>Maldives</option>
                                    <option value='Mali'>Mali</option>
                                    <option value='Malta'>Malta</option>
                                    <option value='Marshall&#x20;Islands'>Marshall Islands</option>
                                    <option value='Martinique&#x20;&#x28;France&#x29;'>Martinique &#x28;France&#x29;</option>
                                    <option value='Mauritania'>Mauritania</option>
                                    <option value='Mauritius'>Mauritius</option>
                                    <option value='Mayotte&#x20;&#x28;France&#x29;'>Mayotte &#x28;France&#x29;</option>
                                    <option value='Mexico'>Mexico</option>
                                    <option value='Moldov'>Moldov</option>
                                    <option value='Monaco'>Monaco</option>
                                    <option value='Mongolia'>Mongolia</option>
                                    <option value='Montenegro'>Montenegro</option>
                                    <option value='Montserrat&#x20;&#x28;UK&#x29;'>Montserrat &#x28;UK&#x29;</option>
                                    <option value='Morocco'>Morocco</option>
                                    <option value='Mozambique'>Mozambique</option>
                                    <option value='Namibia'>Namibia</option>
                                    <option value='Nauru'>Nauru</option>
                                    <option value='Nepal'>Nepal</option>
                                    <option value='Netherlands'>Netherlands</option>
                                    <option value='New&#x20;Caledonia&#x20;&#x28;France&#x29;'>New Caledonia &#x28;France&#x29;</option>
                                    <option value='New&#x20;Zealand'>New Zealand</option>
                                    <option value='Nicaragua'>Nicaragua</option>
                                    <option value='Niger'>Niger</option>
                                    <option value='Nigeria'>Nigeria</option>
                                    <option value='Niue&#x20;&#x28;NZ&#x29;'>Niue &#x28;NZ&#x29;</option>
                                    <option value='Norfolk&#x20;Island&#x20;&#x28;Australia&#x29;'>Norfolk Island &#x28;Australia&#x29;</option>
                                    <option value='Northern&#x20;Mariana&#x20;Islands&#x20;&#x28;USA&#x29;'>Northern Mariana Islands &#x28;USA&#x29;</option>
                                    <option value='North&#x20;Korea'>North Korea</option>
                                    <option value='Norway'>Norway</option>
                                    <option value='Oman'>Oman</option>
                                    <option value='Pakistan'>Pakistan</option>
                                    <option value='Palau'>Palau</option>
                                    <option value='Palestine'>Palestine</option>
                                    <option value='Panama'>Panama</option>
                                    <option value='Papua&#x20;New&#x20;Guinea'>Papua New Guinea</option>
                                    <option value='Paraguay'>Paraguay</option>
                                    <option value='Peru'>Peru</option>
                                    <option value='Philippines'>Philippines</option>
                                    <option value='Pitcairn&#x20;Islands&#x20;&#x28;UK&#x29;'>Pitcairn Islands &#x28;UK&#x29;</option>
                                    <option value='Poland'>Poland</option>
                                    <option value='Portugal'>Portugal</option>
                                    <option value='Puerto&#x20;Rico'>Puerto Rico</option>
                                    <option value='Qatar'>Qatar</option>
                                    <option value='Republic&#x20;of&#x20;the&#x20;Congo'>Republic of the Congo</option>
                                    <option value='Reunion&#x20;&#x28;France&#x29;'>Reunion &#x28;France&#x29;</option>
                                    <option value='Romania'>Romania</option>
                                    <option value='Russia'>Russia</option>
                                    <option value='Rwanda'>Rwanda</option>
                                    <option value='Saint&#x20;Barthelemy&#x20;&#x28;France&#x29;'>Saint Barthelemy &#x28;France&#x29;</option>
                                    <option value='Saint&#x20;Helena,&#x20;Ascension&#x20;and&#x20;Tristan&#x20;da&#x20;Cunha&#x20;&#x28;UK&#x29;'>Saint Helena, Ascension and Tristan da Cunha &#x28;UK&#x29;
                                    </option>
                                    <option value='Saint&#x20;Kitts&#x20;and&#x20;Nevis'>Saint Kitts and Nevis</option>
                                    <option value='Saint&#x20;Lucia'>Saint Lucia</option>
                                    <option value='Saint&#x20;Martin&#x20;&#x28;France&#x29;'>Saint Martin &#x28;France&#x29;</option>
                                    <option value='Saint&#x20;Pierre&#x20;and&#x20;Miquelon&#x20;&#x28;France&#x29;'>Saint Pierre and Miquelon &#x28;France&#x29;</option>
                                    <option value='Saint&#x20;Vincent&#x20;and&#x20;the&#x20;Grenadines'>Saint Vincent and the Grenadines</option>
                                    <option value='Samoa'>Samoa</option>
                                    <option value='San&#x20;Marino'>San Marino</option>
                                    <option value='Sao&#x20;Tom&#x20;and&#x20;Principe'>Sao Tom and Principe</option>
                                    <option value='Saudi&#x20;Arabia'>Saudi Arabia</option>
                                    <option value='Senegal'>Senegal</option>
                                    <option value='Serbia'>Serbia</option>
                                    <option value='Seychelles'>Seychelles</option>
                                    <option value='Sierra&#x20;Leone'>Sierra Leone</option>
                                    <option value='Singapore'>Singapore</option>
                                    <option value='Sint&#x20;Maarten&#x20;&#x28;Netherlands&#x29;'>Sint Maarten &#x28;Netherlands&#x29;</option>
                                    <option value='Slovakia'>Slovakia</option>
                                    <option value='Slovenia'>Slovenia</option>
                                    <option value='Solomon&#x20;Islands'>Solomon Islands</option>
                                    <option value='Somalia'>Somalia</option>
                                    <option value='South&#x20;Africa'>South Africa</option>
                                    <option value='South&#x20;Korea'>South Korea</option>
                                    <option value='South&#x20;Sudan'>South Sudan</option>
                                    <option value='Spain'>Spain</option>
                                    <option value='Sri&#x20;Lanka'>Sri Lanka</option>
                                    <option value='Sudan'>Sudan</option>
                                    <option value='Suriname'>Suriname</option>
                                    <option value='Svalbard&#x20;and&#x20;Jan&#x20;Mayen&#x20;&#x28;Norway&#x29;'>Svalbard and Jan Mayen &#x28;Norway&#x29;</option>
                                    <option value='Swaziland'>Swaziland</option>
                                    <option value='Sweden'>Sweden</option>
                                    <option value='Switzerland'>Switzerland</option>
                                    <option value='Syria'>Syria</option>
                                    <option value='Taiwan'>Taiwan</option>
                                    <option value='Tajikistan'>Tajikistan</option>
                                    <option value='Tanzania'>Tanzania</option>
                                    <option value='Thailand'>Thailand</option>
                                    <option value='Timor-Leste'>Timor-Leste</option>
                                    <option value='Togo'>Togo</option>
                                    <option value='Tokelau&#x20;&#x28;NZ&#x29;'>Tokelau &#x28;NZ&#x29;</option>
                                    <option value='Tonga'>Tonga</option>
                                    <option value='Trinidad&#x20;and&#x20;Tobago'>Trinidad and Tobago</option>
                                    <option value='Tunisia'>Tunisia</option>
                                    <option value='Turkey'>Turkey</option>
                                    <option value='Turkmenistan'>Turkmenistan</option>
                                    <option value='Turks&#x20;and&#x20;Caicos&#x20;Islands&#x20;&#x28;UK&#x29;'>Turks and Caicos Islands &#x28;UK&#x29;</option>
                                    <option value='Tuvalu'>Tuvalu</option>
                                    <option value='UAE'>UAE</option>
                                    <option value='Uganda'>Uganda</option>
                                    <option value='UK'>UK</option>
                                    <option value='Ukraine'>Ukraine</option>
                                    <option value='United&#x20;States&#x20;Virgin&#x20;Islands&#x20;&#x28;USA&#x29;'>United States Virgin Islands &#x28;USA&#x29;</option>
                                    <option value='Uruguay'>Uruguay</option>
                                    <option value='USA'>USA</option>
                                    <option value='Uzbekistan'>Uzbekistan</option>
                                    <option value='Vanuatu'>Vanuatu</option>
                                    <option value='Vatican&#x20;City'>Vatican City</option>
                                    <option value='Venezuela'>Venezuela</option>
                                    <option value='Vietnam'>Vietnam</option>
                                    <option value='Wallis&#x20;and&#x20;Futuna&#x20;&#x28;France&#x29;'>Wallis and Futuna &#x28;France&#x29;</option>
                                    <option value='Western&#x20;Sahara'>Western Sahara</option>
                                    <option value='Yemen'>Yemen</option>
                                    <option value='Zambia'>Zambia</option>
                                    <option value='Zimbabwe'>Zimbabwe</option>
                                </select></td>
                        </tr>

                        <tr>
                            <td colspan='2' style='text-align:center; padding-top:15px;'>
                                <input type='submit' value='<?php _e('Download'); ?>'/>
                                <input type='reset' value='<?php _e('Reset'); ?>'/>
                            </td>
                        </tr>
                    </table>
                    <style>
                        .dfx_gotcha {
                            display: none;
                        }
                    </style>
                    <input type='text' name='dfx_gotcha' id='dfx_gotcha' class='dfx_gotcha' value=''/>
                    <script>
                        var mndFileds66 = new Array('Company', 'First Name', 'Last Name', 'Email', 'Designation', 'LEADCF5');
                        var fldLangVal66 = new Array('<?php echo __('Company'); ?>', '<?php echo __('First Name'); ?>', '<?php echo __('Last Name'); ?>', '<?php echo __('Email'); ?>', '<?php echo __('Title'); ?>', '<?php echo __('Country'); ?>.');
                        var name = '';
                        var email = '';

                        function checkMandatory() {
                            if (document.forms['WebToLeads1481567000002594985']['dfx_gotcha'] && document.forms['WebToLeads1481567000002594985']['dfx_gotcha'].value != '') {
                                return false;
                            }
                            for (i = 0; i < mndFileds66.length; i++) {
                                var fieldObj = document.forms['WebToLeads1481567000002594985'][mndFileds66[i]];
                                if (fieldObj) {
                                    if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length == 0) {
                                        if (fieldObj.type == 'file') {
                                            alert('<?php echo __('Please select a file to upload'); ?>');
                                            fieldObj.focus();
                                            return false;
                                        }
                                        alert(fldLangVal66[i] + ' <?php echo __('cannot be empty'); ?>.');
                                        fieldObj.focus();
                                        return false;
                                    } else if (fieldObj.nodeName == 'SELECT') {
                                        if (fieldObj.options[fieldObj.selectedIndex].value == '-None-') {
                                            alert(fldLangVal66[i] + ' <?php echo __('cannot be none'); ?>.');
                                            fieldObj.focus();
                                            return false;
                                        }
                                    } else if (fieldObj.type == 'checkbox') {
                                        if (fieldObj.checked == false) {
                                            alert('<?php echo __('Please accept'); ?>  ' + fldLangVal66[i]);
                                            fieldObj.focus();
                                            return false;
                                        }
                                    }
                                    try {
                                        if (fieldObj.name == 'Last Name') {
                                            name = fieldObj.value;
                                        }
                                    } catch (e) {
                                    }
                                }
                            }
                        }

                    </script>
                </form>
            </div>
        </article>
    </div>
<?php endwhile; ?>
<?php endif; ?>
<?php get_footer(); ?>