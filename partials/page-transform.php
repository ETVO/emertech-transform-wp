<?php
/**
 * Partial for the single transform page
 * 
 * @package Emertech WordPress theme
 */

$transform_title = get_the_title();
$report_title = __('Nova Solicitação de Orçamento');
$fields_title = __('Informações');
$caracters_title = __('Características');
$optionals_title = __('Opcionais Escolhidos');
?>

<div class="transform-wrap">
    <?php 
        if(isset($_POST['submitTransformForm'])) {

            $loading_title = __('Enviando...');
            $loading_text = __('Estamos processando a sua solicitação');
            
            ?> 
            <div class="content col-12 col-sm-10 col-md-9 col-lg-8 col-xl-6 m-auto mb-4">

                <div id="containersArea">
                    <div class="thanks-container text-center">
                        <h2><?php echo $loading_title; ?></h2>
                        <p><?php echo $loading_text; ?></p>
                        <div class="loader m-auto mt-3"></div>
                    </div>
                </div>
            </div>
            <?php
    
            // Send email
                
            $fields = Emertech_Transform_Form::get_fields();
            $selected_optionals = $_POST['optionals'] ?? [];
            $optionals = array();
            
            foreach($selected_optionals as $slug) {
                array_push($optionals, get_term_by('slug', $slug, 'opcional'));
            }

            $optionals = transform_group_optionals($optionals);
            
            $parents = $optionals['parents'];
            $grouped_optionals = $optionals['grouped_optionals'];

            // Create Email to send request 
            
            $request = new Emertech_Email_Request();

            $request->to = 'geral@emertech.pt';
            $request->subject = $report_title .' - '. $transform_title;

            $request->use_html();

            $from_name = __('Solicitação de Orçamento');
            $from_email = 'site@' . $_SERVER['HTTP_HOST'];
            
            $request->headers[] = 'From: ' . $from_name . ' <' . $from_email . '>';
            $request->headers[] = 'Cc: ' . $_POST['email'];

            $message[] = '<h3 style="font-weight: bold">' . $report_title . ' - ' . $transform_title . '</h3>';


            $message[] = '<h4 style="font-weight: bold; text-transform: uppercase;">' 
            . $fields_title . '</h4>';

            foreach($fields as $field) {
                $message[] = '<p><span style="font-weight: bold">' . $field['label'] . ':</span><br>'
                . $_POST[$field['name']] . '</p>';
            }

            $message[] = '<h4 style="font-weight: bold; text-transform: uppercase;">' 
            . $optionals_title . '</h4>';

            $message[] = '<ul>';
        
            foreach($parents as $parent){
                if($parent->slug == '') continue; 

                $parent_optionals = $grouped_optionals[$parent->slug];

                if(count($parent_optionals) > 0) {

                    $message[] = '<li><h4 style="font-weight: bold; margin-bottom: 0; margin-top: 1em;">' 
                    . $parent->name . ' (' . count($parent_optionals) 
                    . ')</h4><ul>';

                    foreach($parent_optionals as $optional) {
                        $message[] = '<li>' . $optional->name . '</li>';
                    }

                    $message[] = '</ul></li>';

                }
            }

            $message = implode('', $message);
            $message = str_replace("\n.", "\n..", $message);

            $request->message = $message;

            $request->send_mail(true);

            // Create hidden input fields to re-submit the report form 
            ?>
            <form action="" method="post" id="showReportForm">
            <?php
            foreach(array_keys($_POST) as $key) {
                if($key == 'submitTransformForm') continue;

                if(is_array($_POST[$key])) {
                    foreach($_POST[$key] as $value) {
                        ?>
                            <input type="hidden" name="<?php echo $key; ?>[]" value="<?php echo $value; ?>">
                        <?php
                    }
                }
                else {
                    ?>
                        <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $_POST[$key]; ?>">
                    <?php
                }
            }

            ?>
                <input type="hidden" name="showTransformReport" value="true">
            </form>

            <script>
                window.onload = function() {
                    try {
                        document.getElementById('showReportForm').submit();
                    }
                    catch(error) {
                        console.error(error);
                    }
                }
            </script>
            <?php
            
        }
        else if(isset($_POST['showTransformReport'])) {

            $thanks_title = __('Agradecemos pela sua solicitação.');
            $thanks_text = __('Contactar-lhe-emos o mais breve possível!');
            
            $print_button = __('Imprimir cópia');
            $back_button = __('Sair');
            $back_confirm = __('Atenção! Se sair desta página não poderá mais imprimir uma cópia da sua solicitação.');
            
            ?> 
            <div class="content col-12 col-sm-10 col-md-9 col-lg-8 col-xl-6 m-auto mb-4">

                <div id="containersArea">
                    <div class="thanks-container text-center">
                        <h2><?php echo $thanks_title; ?></h2>
                        <p><?php echo $thanks_text; ?></p>
                    </div>
    
                    <div class="options-container text-center my-3">
                        <button type="button" id="printButton" class="btn btn-primary">
                            <?php echo $print_button; ?>
                        </button>
                        <!-- <button type="button" id="backButton" data-et-confirm="<?php echo $back_confirm; ?>" data-et-url="<?php echo home_url(); ?>" class="btn btn-secondary">
                            <?php echo $back_button; ?>
                        </button> -->
                        <small class="d-block text-primary pt-2"><?php echo $back_confirm; ?></small>
                    </div>
                </div>

                <div id="printArea" class="p-3 bg-light text-dark rounded"> 
                <?php
                
                $logo = get_theme_mod( 'custom_logo' );
                $logo_src = wp_get_attachment_image_src( $logo , 'full' );
                $logo_url = $logo_src[0];
                
                $fields = Emertech_Transform_Form::get_fields();

                $caracters = get_the_terms( get_the_ID(), 'caracter' ) ?? [];

                $selected_optionals = $_POST['optionals'] ?? [];
                $optionals = array();

                ?> 
                <table class="report-table w-100 text-dark p-3">
                    <tr class="table-headings border-bottom-0">
                        <td>
                            <img src="<?php echo $logo_url; ?>" id="transformPrintLogo" alt="Emertech" width="100px">
                        </td>
                        <td align="right">
                            <a href="<?php echo home_url(); ?>" id="transformPrintHomeUrl">
                                <?php echo home_url(); ?>
                            </a>
                            <a href="mailto:<?php echo get_theme_mod("emertech_footer_email"); ?>" id="transformPrintContact">
                                <?php echo get_theme_mod("emertech_footer_email"); ?>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2">
                            <h5 class="fw-bold"><?php echo $report_title . ' - ' . $transform_title; ?></h5>
                        </th>
                    </tr>

                    <?php if($fields): ?>

                        <tr>
                            <td colspan="2" class="pt-4">
                                <h6 class="text-uppercase fw-bold"><?php echo $fields_title; ?></h6>
                            </td>
                        </tr>

                        <?php
                        
                        foreach($fields as $field) {
                            ?>
                                <tr>
                                    <th class="f-smaller">
                                        <?php echo $field['label']; ?>
                                    </th>
                                    <td class="f-smaller">
                                        <?php echo $_POST[$field['name']] ?>
                                    </td>
                                </tr>
                            <?php 
                        }
                    
                    endif;

                    ?> 
                    
                    <?php if($caracters): ?>

                        <tr>
                            <td colspan="2" class="pt-4">
                                <h6 class="text-uppercase fw-bold"><?php echo $caracters_title; ?></h6>
                            </td>
                        </tr>

                        <?php 

                        foreach($caracters as $caracter) {
                            ?>
                                <tr>
                                    <td colspan="2" class="f-smaller">
                                        <?php echo $caracter->name; ?>
                                    </td>
                                </tr>
                            <?php 
                        }
                    
                    endif;

                    ?> 

                    <?php if($selected_optionals): ?>

                        <tr>
                            <td colspan="2" class="pt-4">
                                <h6 class="text-uppercase fw-bold"><?php echo $optionals_title; ?></h6>
                            </td>
                        </tr>

                        <?php 

                        foreach($selected_optionals as $slug) {
                            array_push($optionals, get_term_by('slug', $slug, 'opcional'));
                        }

                        $optionals = transform_group_optionals($optionals);

                        if($optionals):
                        
                        $parents = $optionals['parents'];
                        $grouped_optionals = $optionals['grouped_optionals'];
                    
                        foreach($parents as $parent){
                            if($parent->slug == '') continue; 

                            $parent_optionals = $grouped_optionals[$parent->slug];


                            if(count($parent_optionals) > 0) {

                                $first = true;

                                foreach($parent_optionals as $optional) {
                            
                                    ?>
                                        <tr>
                                            <?php if($first): $first = false; ?>
                                                <th rowspan="<?php echo count($parent_optionals); ?>">
                                                    <?php echo $parent->name; ?>
                                                </th>
                                            <?php endif; ?>
                                            <td class="f-smaller">
                                                <?php echo $optional->name; ?>
                                            </td>
                                        </tr>
                                    <?php
                                }

                            }
                        }
                        endif;
                        
                    endif;

                    ?>
                </table>
                <?php

                ?> 
                </div>
            </div>
            <?php

        }

        else {
            the_content();
        }
    ?>
</div>

<script src="<?php echo EMERTECH_TRANSFORM_JS_URL . 'page-transform.js' ?>"></script>