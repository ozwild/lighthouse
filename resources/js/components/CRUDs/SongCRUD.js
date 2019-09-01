import React, {Component} from 'react';
import SongForm from './Songs/SongForm'

class SongCRUD extends Component {
    constructor(props) {
        super(props);
        this.state = {

        };
    }

    render() {
        return (
            <SongForm/>
        );
    }
}

export default SongCRUD;