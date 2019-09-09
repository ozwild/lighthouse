import React from 'react';
import PropTypes from 'prop-types';

const ContentSelector = (props) => {
    const options = props.options
        .map(a => <option key={a} value={a}>{a}</option>);
    return (
        <div className="container">
            <select className="browser-default"
                    onChange={props.onSelection}>{options}</select>
        </div>
    );
};

ContentSelector.propTypes = {
    options: PropTypes.array.isRequired,
    onSelection: PropTypes.func.isRequired
};

export default ContentSelector;