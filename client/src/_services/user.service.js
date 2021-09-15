import Config from "../components/Config";
import {authHeader, handleResponse, handleLoginResponse} from '../_helpers';

export const userService = {
    getAll,
    login,
    logout,
    getRefreshToken,
    updateUser,
    getUserProfile,
    getAupairs,
    getFamilies
};

function login(email, password) {
    const requestOptions = {
        method: 'POST',
        headers: {'Content-Type': 'application/json', Accept: 'application/json'},
        body: JSON.stringify({email: email, password})
    };

    return fetch(`${Config.serverURL}/team/login`, requestOptions)
        .then(handleLoginResponse)
        .then(user => {
            localStorage.setItem('user', JSON.stringify(user));
            return user;
        });
}

function getRefreshToken() {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${Config.serverURL}/team/token`, requestOptions)
        .then(handleResponse)
        .then(token => {
            return token;
        });
}

function logout() {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${Config.serverURL}/team/logout`, requestOptions)
        .then((data)=>{
            localStorage.removeItem('user');
        });

}

function getAll() {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${Config.serverURL}/users`, requestOptions).then(handleResponse);
}

function getUserProfile() {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${Config.serverURL}/team/member/details`, requestOptions).then(handleResponse);
}
function updateUser(params) {
    const requestOptions = {
        method: 'POST',
        headers: authHeader(),
        body: JSON.stringify(params)
    };

    return fetch(`${Config.serverURL}/team/update/team-admin`, requestOptions)
        .then(handleResponse)
        .then(response => {
            return response;
        });
}

function getAupairs(page,query) {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };
    return fetch(`${Config.serverURL}/team/search-aupair?page=${page}&query=${query}`, requestOptions).then(handleResponse);
}
function getFamilies(page,query) {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };
    return fetch(`${Config.serverURL}/team/search-family?page=${page}&query=${query}`, requestOptions).then(handleResponse);
}