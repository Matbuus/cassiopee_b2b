import React, { Component } from 'react';
import axios from "axios/index";
import Client from './client';
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

        const table = []
        table.push(
            <table className="table">
                <tbody>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>actions</th>
                </tr>
                </tbody>
            </table>
        );
        this.state.clients.forEach(
            (client) => (table.push(<Client client={client}/>))
        );

        //   for (const client of this.clients) {
        //    console.log(client);
        //  table.push(<Client client={client} />);
        //   }

        return (
            <div>
                {table}
            </div>
        )
    }

}

export default ClientList;