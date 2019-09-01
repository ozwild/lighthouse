import React, {Component} from 'react';
import ReactDOM from 'react-dom';

export default class SelectBox extends Component {
    constructor(props) {
        super(props);
        console.log(props);
    }

    render() {
        return (
            <select name={this.props.name} id={this.props.id}>

            </select>
        );
    }
}

[...document.querySelectorAll('.select-box')]
    .forEach(element => ReactDOM.render(<SelectBox/>, element), (...args)=>console.log(...args));
