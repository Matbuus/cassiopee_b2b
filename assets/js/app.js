import Places from 'places.js'

let inputAddress = document.querySelector('#evenement_address')
if( inputAddress !== null){
	let place = Places({
			container: inputAddress
			})
	place.on('change', e => {
		document.querySelector('#evenement_city').value = e.suggestion.city
		document.querySelector('#evenement_postal').value = e.suggestion.postcode
		document.querySelector('#evenement_lat').value = e.suggestion.latlng.lat
		document.querySelector('#evenement_lng').value = e.suggestion.latlng.lng
	})
}
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
console.log("here");

const $ = require('jquery');

//import React, { Component } from 'react';
//import ReactDom from 'react-dom';
//import Test2 from './test2';
//
//
//class Test extends Component {
//
//render(){
//	return ( <Test2 /> );
//}
//
//}
//
//ReactDom.render(<Test />, document.getElementById('root'));