import Config from "../components/Config";
import { authHeader, handleResponse } from '../_helpers';
export const senderService = {
    loadAllSenders,
    searchSenders
};

function loadAllSenders(page = 1) {
    const requestOptions = {
        method: 'POST',
        headers: authHeader(),
    };

    return fetch(`${Config.serverURL}/team/senders?page=${page}`, requestOptions)
        .then(handleResponse);
}

function searchSenders(keyword, page=1){
    const requestOptions = {
        method: 'GET',
        headers: authHeader(),
    };
    return fetch(`${Config.serverURL}/team/search/sender?query=${keyword}&page=${page}`, requestOptions)
        .then(handleResponse);
}
