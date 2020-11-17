<?php 
/**
 * Plugin Name: My Mortgage Calculator
 * Plugin URI: localhost
 * Description: Adds a simple mortgage calculator via shortcode to posts and pages
 * Author: Erik Jonsberg
 * Author URI: https://www.erikjonsberg.com/
 * Version: 1.0
 * Text Domain: my-mortgage-calculator
 *
 * Copyright: (c) 2020 Erik Jonsberg (ebjonsberg@gmail.com)
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @author    Erik Jonsberg
 * @copyright Copyright (c) 2020, Erik Jonsberg
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 *
 */

defined( 'ABSPATH' ) or exit;



function register_mc_styles() {
    wp_register_style('mc_noUiSlider_style', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.1.0/nouislider.css');
     wp_register_style('mc_ui_css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"');
     wp_register_style('mc_fa_css', 'https://pro.fontawesome.com/releases/v5.10.0/css/all.css"');
    wp_register_style('mc_main_style', plugins_url('my-mortgage-calculator/style.css'));
};
add_action('wp_head', 'register_mc_styles');

function register_mc_scripts() {
    wp_register_script('mc_google_charts', 'https://www.gstatic.com/charts/loader.js', array(), '', true);
    wp_register_script('mc_jqueryUi', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', array('jquery'), '', true); 
    wp_register_script('mc_noUiSlider', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/12.1.0/nouislider.js', array('jquery'), '', true);  
    wp_register_script('mc_main_script', plugins_url('my-mortgage-calculator/mc.js'), array('jquery'), '', true);
};
add_action('wp_enqueue_scripts', 'register_mc_scripts');

function mc_shortcode() {

    wp_enqueue_style( 'mc_noUiSlider_style' );
    wp_enqueue_style( 'mc_ui_css' );
    wp_enqueue_style( 'mc_fa_css' );
    wp_enqueue_style( 'mc_main_style' );

    wp_enqueue_script( 'mc_google_charts' );
    wp_enqueue_script( 'mc_jqueryUi' );
    wp_enqueue_script( 'mc_noUiSlider' );
    wp_enqueue_script( 'mc_main_script' );


?>

    <div id="mc-loan-container" class="mc-grid-container">
        <fieldset id="mc-pane-info" class="mc-pane-box">
            <legend class="mc-heading-title mc-bold">Calculate Your Mortgage</legend>
            <div class="mc-input-row">
                <label>Home Value</label>
                <div class="mc-input-wrap">
                    <div class="mc-code-currency">$</div>
                    <input type="text" type="number" id="txtValue" value="" />
                </div>
            </div>
            <div class="mc-input-row">
                <label>Down Payment</label>
                <div class="mc-input-wrap">
                    <div class="mc-code-currency">$</div>
                    <input type="text" type="number" id="txtDown" value="" />
                </div>
            </div>
            <div class="mc-input-row mc-loan-amount">
                <label>Loan Amount</label>
                <div class="mc-input-wrap">
                    <div class="mc-code-currency">$</div>
                    <input type="text" type="number" id="txtLoan" value="" readonly/>
                </div>
            </div>
            <div class="mc-input-row">
                <label>Interest Rate</label>
                <div class="mc-input-wrap">
                    <div class="mc-code-percentage">%</div>
                    <input type="text" type="number" id="txtInterest" value="8.99" maxlength="5" class="short-input" />
                </div>
            </div>
            <div class="mc-input-row">
                <label>Term</label>
                <div id="yearRange" class="mc-range-slider"></div>
            </div>
            <div class="mc-input-row">
                <div class="mc-button-group">
                    <div class="mc-buttons">
                        <!-- <label>Calculate Payments</label> -->
                        <button id="btnCalculate" data-value="1">Go</button>
                        <!-- </div> -->
                        <!-- <div class="buttons"> -->
                        <!-- <label>Reset Form</label> -->
                        <button id="btnReset" data-value="1"><i class="fas fa-redo"></i></button>
                    </div>
                </div>
            </div>

        </fieldset>

        <fieldset id="mc-pane-graph" class="mc-pane-box">
            <legend class="mc-heading-title mc-bold"> Interest & Payments </legend>
            <div class="mc-grid-inner">
                <div id="repayment-total">
                    <div class="mc-heading-title mc-bold">Total interest</div>
                    <div id="mc-repayment-total-value" class="mc-loan-value">
                        $<span id="interest-total">0</span> over <span class="mc-orange-text"><span id="year-value">5</span> years</span>
                    </div>
                </div>
                <div id="repayment-cycle">
                    <div class="mc-heading-title mc-bold">Payment would be</div>
                    <div id="mc-repayment-cycle-value" class="mc-loan-value">
                        $<span id="repayment-value">0</span> per <span class="mc-orange-text">month</span>
                    </div>
                </div>
            </div>
            <div id="graph-chart"></div>

        </fieldset>
    </div>

    

  <?php 

}

  add_shortcode('mortgage-calc', 'mc_shortcode');
