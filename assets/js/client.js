import React, { Component } from 'react';
import ReactDom from 'react-dom';

class Client extends Component {
    constructor(props) {
        super(props);
        this.client = this.props.client;
    }

    render(){
        return ( <table className="table" >
            <tbody>
                <tr>
                    <th>{ this.client.id }</th>
                    <th> { this.client.nom }</th>
                    <th>{this.client.prenom }</th>
                </tr>
            </tbody>
            </table>
        );
    }

}

export default Client;