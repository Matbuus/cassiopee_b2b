import Places from 'places.js'
import Map from './modules/map.js'

Map.init()

let inputAddressEvent = document.querySelector('#evenement_address')
if( inputAddressEvent !== null){
	let place = Places({
			container: inputAddressEvent
			})
	place.on('change', e => {
		document.querySelector('#evenement_city').value = e.suggestion.city
		document.querySelector('#evenement_postal').value = e.suggestion.postcode
		document.querySelector('#evenement_lat').value = e.suggestion.latlng.lat
		document.querySelector('#evenement_lng').value = e.suggestion.latlng.lng
	})
}

let inputAddressClient = document.querySelector('#client_address')
if( inputAddressClient !== null){
	let place = Places({
			container: inputAddressClient
			})
	place.on('change', e => {
		document.querySelector('#client_city').value = e.suggestion.city
		document.querySelector('#client_postal').value = e.suggestion.postcode
		document.querySelector('#client_lat').value = e.suggestion.latlng.lat
		document.querySelector('#client_lng').value = e.suggestion.latlng.lng
	})
}

let inputAddressPartenaire = document.querySelector('#partenaire_address')
if( inputAddressPartenaire !== null){
	let place = Places({ container: inputAddressPartenaire })
	place.on('change', e => {
		document.querySelector('#partenaire_city').value = e.suggestion.city
		document.querySelector('#partenaire_postal').value = e.suggestion.postcode
		document.querySelector('#partenaire_lat').value = e.suggestion.latlng.lat
		document.querySelector('#partenaire_lng').value = e.suggestion.latlng.lng
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