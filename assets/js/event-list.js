import React, { Component } from 'react';
import ReactDom from 'react-dom';
console.log("slt");

class EventList extends Component {
constructor(props) {
    super(props);
    this.events = this.props.events;
    console.log(this.events);
  }
render(){
	return ( <p>
                { this.event.id }, { this.event.titre } , {this.event.date.date.toString() } , { this.event.type }   
                </p> );
}

}

export default EventList;