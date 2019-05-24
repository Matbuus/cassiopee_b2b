/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
console.log("here");

// const $ = require('jquery');
import React, { Component } from 'react';
import ReactDom from 'react-dom';
import Test2 from './test2';


class Test extends Component {

render(){
	return ( <Test2 /> );
}

}

ReactDom.render(<Test />, document.getElementById('root'));