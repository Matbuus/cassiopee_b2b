import React, { Component } from 'react';
import axios from "axios/index";
import {BrowserRouter, NavLink, Route, Switch} from 'react-router-dom';
console.log("slt");
class ClientList extends Component {


    constructor(props) {
        super(props);
        this.state = {
            clients: [],
        }
        const rep = axios.get('http://localhost:8000/cclient')
            .then(response => {
                this.setState({ clients : response.data.clients });
            }).catch(error => {
                console.log(error);
            });

        //this.clients.forEach((client) => (console.log(client)));

    }

    render(){


        console.log(this.state.clients);
        const table = [];
        const children = [];
        this.state.clients.forEach(
            (client) => (children.push(<tr>
                <td> {client.id }</td>
                <td> {client.nom }</td>
                <td>{ client.prenom }</td>
            </tr>)));

        table.push(
            <table className="table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
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
                <NavLink to="/" className="btn btn-success">Liste des clients</NavLink>

            </div>
        )
    }

}

export default ClientList;