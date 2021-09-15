import React from 'react';

import { userService, authenticationService } from '../_services';

class Users extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            currentUser: authenticationService.currentUserValue,
            users: null
        };
    }

    componentDidMount() {
        userService.getAll().then(users => this.setState({ users }));
    }

    render() {
        const { users } = this.state;
        return (
            <div>
                <h1>Hi!</h1>
                <p>You're logged in with React & JWT!!</p>
                <h3>Users from secure api end point:</h3>
                {users &&
                <h1>Hi {users.message.first_name}!</h1>
                }
            </div>
        );
    }
}

export { Users };