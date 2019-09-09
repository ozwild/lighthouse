import React, {Component} from 'react';
import ReactDOM from 'react-dom';
import SongForm from './Songs/SongForm';
import SongSearch from "./Songs/SearchSong";
import SongModel from "../Models/SongModel";
import LyricsDisplay from "./Songs/Display";
import SongService from "../Services/SongService";
import NavBar from "./Partials/NavBar";
import SideNav from "./Partials/SideNav";
import {updateTextFields} from 'materialize-css';

class App extends Component {

    state = {
        song: new SongModel(),
        view: 'home',
        showSearch: false
    };

    constructor(props) {
        super(props);
        this.showSearch = this.showSearch.bind(this);
        this.dismissSearch = this.dismissSearch.bind(this);
        this.switchSong = this.switchSong.bind(this);
        this.switchView = this.switchView.bind(this);
    }

    componentDidUpdate(prevProps, prevState, snapshot) {
        updateTextFields();
        window.scrollTo(0, 0);
    }

    componentDidMount() {
        window.scrollTo(0, 0);

        /**
         * @todo Dev: modify this section to load song from URL query string instead
         */
        SongService.get(1)
            .then(song => this.switchSong(song));
    }

    switchSong(song) {
        if (song) {
            this.setState({song, showSearch: false});
        }
    }

    switchView(view) {
        this.setState({view});
    }

    showSearch() {
        this.setState({
            showSearch: true
        })
    }

    dismissSearch() {
        this.setState({showSearch: false});
    }

    render() {
        const {song, view} = this.state;
        const {switchSong, switchView, showSearch, dismissSearch} = this;
        return (

            <div>

                {/* Search Container */}
                {this.state.showSearch && <SongSearch onSelect={switchSong} onDismiss={dismissSearch}/>}

                <main>

                    {/* NavBar */}
                    <NavBar song={song} showSearchBox={showSearch} switchView={switchView}/>

                    {/* Content Switcher */}
                    {{
                        home: <h1>Lighthouse</h1>,
                        display: <LyricsDisplay song={song}/>,
                        sync: <h1>Lyrics Sync</h1>,
                        create: <SongForm song={new SongModel()} onSave={switchSong}/>,
                        edit: <SongForm song={song} onSave={switchSong}/>,
                    }[view]}

                </main>

                {/* Mobile SideNav */}
                <SideNav song={song} showSearchBox={showSearch} switchView={switchView}/>

            </div>

        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App/>, document.getElementById('app'));
}

export default App;