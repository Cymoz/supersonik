/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.scss in this case)
import './styles/app.scss';
import 'bootstrap/dist/js/bootstrap.bundle';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import './change-nav-bar-scroll';
import $ from 'jquery';



window.$ = $;
