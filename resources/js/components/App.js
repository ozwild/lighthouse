import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import SongCRUD from "./CRUDs/SongCRUD";

class App extends Component {
    constructor(props){
        super(props);
        this.state = {
            breadcrumbs:null,
            sidebar:null,
            content:null
        };
    }
    render() {
        return (
            /*{breadcrumbs}*/
            /*{sidebar}*/
            <main>
                <SongCRUD/>
            </main>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}

export default App;