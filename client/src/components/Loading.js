import React from 'react';
class Loading extends React.Component {

    constructor(props){
        super(props);
        this.state = {
            style: {
                display : 'block',
                right : '37%',
                top: '14%'
            }
        }
    }

    render() {

        return (
            <div className="row reactLoadingIt" style={this.state.style}>
                <span className="spin right"></span> {this.props.text}
            </div>

        );
    }
};

export default Loading;