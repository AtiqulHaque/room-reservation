import Config from "../components/Config";
import {authHeader, handleResponse} from '../_helpers';

export const contactService = {
    getAll,
    addContact,
    searchContact
};

function getAll(page) {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${Config.serverURL}/team/register/users?query=` + "" + `&page=` + page, requestOptions).then(handleResponse);
}


function addContact(contact_id, user_type) {
    const requestOptions = {
        method: 'POST',
        headers: authHeader(),
        body: JSON.stringify({
            contact_id: contact_id,
            user_type: user_type
        })
    };

    return fetch(`${Config.serverURL}/team/add/users`, requestOptions).then(handleResponse);
}

function searchContact(keyword, page) {
    const requestOptions = {
        method: 'GET',
        headers: authHeader()
    };

    return fetch(`${Config.serverURL}/team/register/users?query=` + keyword + `&page=` + page, requestOptions).then(handleResponse);
}