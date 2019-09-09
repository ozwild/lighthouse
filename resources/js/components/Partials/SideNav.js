import React, {Component} from 'react';
import PropTypes from 'prop-types';
import M from "materialize-css/dist/js/materialize.min";

class SideNav extends Component {

    instance;

    componentDidMount() {
        this.instance = M.Sidenav.init(document.querySelector('#slide-out'));
    }

    open() {
        this.instance.open();
    }

    close() {
        this.instance.close();
    }

    render() {

        const {song, switchView, showSearchBox} = this.props;

        return (
            <ul className="sidenav" id="slide-out">

                <li>
                    <a className="sidenav-close" href="#!">
                        <i className="material-icons right white-text" style={{margin: 0}}>clear</i>
                    </a>
                </li>

                <li>
                    <a onClick={() => {
                        this.close();
                        showSearchBox();
                    }} role="button" href="#">Search</a>
                </li>

                <li>
                    <a onClick={() => {
                        this.close();
                        switchView('create');
                    }} role="button" href="#">New Song</a>
                </li>

            </ul>
        );
    }

}

SideNav.defaultProps = {
    switchView: () => {
    },
    showSearchBox: () => {
    }
};

SideNav.propTypes = {
    switchView: PropTypes.func.isRequired,
    showSearchBox: PropTypes.func.isRequired,
};

export default SideNav;