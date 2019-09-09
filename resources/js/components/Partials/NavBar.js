import React, {Component} from 'react';
import PropTypes from 'prop-types';

class NavBar extends Component {

    render() {

        const {song, switchView, showSearchBox} = this.props;

        return (
            <nav style={{backgroundColor: "transparent"}} className="nav-extended">
                <div className="nav-wrapper">
                    <a href="#" className="brand-logo">Lighthouse</a>
                    <a href="#" data-target="slide-out" className="sidenav-trigger"><i
                        className="material-icons">menu</i></a>
                    <ul id="nav-mobile" className="right hide-on-med-and-down">

                        <li>
                            <a onClick={showSearchBox} role="button" href="#">
                                <i className="material-icons">search</i>
                            </a>
                        </li>

                        <li>
                            <a onClick={() => switchView('create')} role="button" href="#">
                                <i className="material-icons">add</i>
                            </a>
                        </li>


                    </ul>
                </div>
                <div className="nav-content">
                    <ul className="tabs tabs-transparent">

                        <li className="tab">
                            <a onClick={() => switchView('home')} role="button" href="#">Home</a>
                        </li>

                        {!song.isANewSong && <li className="tab">
                            <a onClick={() => switchView('display')} role="button" href="#">Display</a>
                        </li>}

                        {!song.isANewSong && <li className="tab">
                            <a onClick={() => switchView('sync')} role="button" href="#">Sync</a>
                        </li>}

                        {!song.isANewSong && <li className="tab">
                            <a onClick={() => switchView('edit')} role="button" href="#">Edit</a>
                        </li>}

                    </ul>
                </div>
            </nav>
        );
    }
}

NavBar.defaultProps = {
    switchView: () => {
    },
    showSearchBox: () => {
    }
};

NavBar.propTypes = {
    switchView: PropTypes.func.isRequired,
    showSearchBox: PropTypes.func.isRequired,
};

export default NavBar;