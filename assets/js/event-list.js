import React, { Component } from 'react';
import axios from "axios/index";
console.log("slt");
class EventList extends Component {


    constructor(props) {
        super(props);
        this.state = {
            evenements: [],
        }
        const rep = axios.get('http://localhost:8000/evenement')
            .then(response => {
                this.setState({ evenements : response.data.evenements });
            }).catch(error => {
                console.log(error);
            });

        //this.clients.forEach((client) => (console.log(client)));

    }

    render(){

        //console.log(this.state.evenements);
        const table = [];
        const children = [];

        this.state.evenements.forEach((evenement) => console.log(evenement));

        this.state.evenements.forEach(
            (evenement) => (children.push(<tr>
                <td> {evenement.id }</td>
                <td> { evenement.titre }</td>
                <td>{ evenement.date.date.toString() }</td>
                <td> {evenement.type.nom }</td>
            </tr>)));

        table.push(
            <table className="table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Type</th>
                    <th>actions</th>
                </tr>
                </thead>

                <tbody>
                {children}
                </tbody>
            </table>
        );



        return (
            <div>
                {table}
            </div>
        )
    }

}

export default EventList;