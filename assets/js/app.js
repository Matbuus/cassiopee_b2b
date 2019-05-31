import Places from 'places.js';
//import Map from './modules/map.js'
import axios from 'axios';
import {BrowserRouter, NavLink, Route, Switch} from 'react-router-dom';
import React, { Component } from 'react';
import ReactDom from 'react-dom';
import Test2 from './test2';
import ClientList from './client-list';
import EventList from './event-list';

//Map.init()
//yarn add react-router-dom --dev
//yarn add axios
//yarn add @babel/plugin-proposal-class-properties 




class Test extends Component {
constructor(props){
	super(props);

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

    this.handleClick = this.handleClick.bind(this);
}

handleClick () {
  axios.get('http://localhost:8000/cclient')
    .then(response => console.log(response.data))
}

render(){
	return (
        <BrowserRouter>
            <div>
                <button className='button' onClick={this.handleClick}>Click Me</button>
                <ul>
                    <NavLink to="/clients">Liste des clients</NavLink>
                    <NavLink to="/evenements">Liste des evenements</NavLink>
                    <NavLink to="/">Another Page</NavLink>
                </ul>
                <Switch>
                    <Route path="/clients" component={ClientList}/>
                    <Route path="/evenements" component={EventList}/>
                    <Route path="/" component={Test2}/>
                </Switch>
            </div>
        </BrowserRouter>
      );
}

}

ReactDom.render(<Test />, document.getElementById('root'));