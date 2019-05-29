import React, { Component } from 'react';
import ReactDom from 'react-dom';

class Events extends Component {
constructor(props) {
    super(props);
    this.event = this.props.event;
    console.log(this.event);
  }
render(){
	return ( <p>
                { this.event.id }, { this.event.titre } , {this.event.date.date.toString() } , { this.event.type }   
                </p> );
}

}
document.querySelectorAll('span.event-in-list').forEach(function(span) {
	ReactDom.render(<Test event={JSON.parse(span.dataset.event)} />, span);
});

export default Event;